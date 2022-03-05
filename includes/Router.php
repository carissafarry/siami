<?php

namespace app\includes;

/*
     *  Router class
     *  Manage routing and execute requests
*/

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
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();

        // Take callback for the given path and method, if it exists
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setStatusCode(404);
            return $this->render('_404');
        }

        // If it is a string, render as a View
        if (is_string($callback)) {
            return $this->render($callback);
        }

        // If it is an array, first array is a controller class, and second is the method inside the controller
        if (is_array($callback)) {
            //  Create new instance of Controller class from App
            App::$app->controller = new $callback[0]();
            $callback[0] = App::$app->controller;
        }
        
        // If it is a closure/function, execute the callback
        return call_user_func($callback, $this->request);
    }

    /**
     * Looking for the view file, and display it as a view without layout/template
     *
     */
    public function render($view)
    {
        require_once APPROOT . '/views/' . $view . '.php';
    }
}