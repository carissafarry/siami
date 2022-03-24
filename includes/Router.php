<?php

namespace app\includes;

/*
     *  Router class
     *  Manage routing and execute requests
*/

use app\includes\exception\NotFoundException;

class Router
{
    public Request $request;
    public Response $response;

    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Assign new routing with get method to array routes
     *
     * @param  string  $path
     * @return void
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * Assign new routing with post method to array routes
     *
     * @param  string  $path
     * @return void
     */
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * Get path and method from URL Request, and Execute request
     *
     * @throws NotFoundException
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();

        // Take callback for the given path and method, if it exists
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setStatusCode(404);
            throw new NotFoundException();
        }

        // If it is a string, render as a View
        if (is_string($callback)) {
            return $this->render($callback);
        }

        // If it is an array, first array is a controller class, and second is the method inside the controller
        if (is_array($callback)) {
            //  Define type of controller
            /** @var Controller $controller */

            //  Create new instance of Controller class from App
            $controller = new $callback[0]();
            App::$app->controller = $controller;

            //  Take the action/method from router callback, and assign to controller
            $controller->action = $callback[1];

            //  Check if user have access to specific action
            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }

            //  Assign instantiated controller back to callback
            $callback[0] = $controller;
        }
        
        // If it is a closure/function, execute the callback
        return call_user_func($callback, $this->request, $this->response);
    }

    /**
     * Looking for the view file, and display it as a view without layout/template
     *
     */
    public function render($view, $data = [])
    {
        extract($data);
        ob_start();
        require_once APP_ROOT . '/views/' . $view . '.php';
        unset($data);
        return ob_get_clean();
    }
}