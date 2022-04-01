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
        $arguments = [];

        //  Check if route has defined arguments
        if ((strpos($path, '{') !== false) && (strpos($path, '}') !== false)) {
            $main_path = substr(strtok($path, '{'), 0, strrpos(strtok($path, '{'), '/'));
            $this->routes['get'][$main_path] = $callback;

            //  Define arguments as array elements
            preg_match_all('/{(.*?)}/', $path, $matches);
            foreach ($matches[1] as $argument) {
                $arguments[$argument] = null;
            }
            $this->routes['get'][$main_path][] = $arguments;
        } else {
            $this->routes['get'][$path] = $callback;
        }
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
        $method = $this->request->method();
        $path = $this->request->getPath();

        $route_names = array_keys($this->routes[$method]);
        $path_elements = explode("/", $path);
        $fitted_routes = [];

        //  Looking for all routes that fit with requested route
        foreach ($route_names as $route_name) {
            $route_name_elements = explode("/", $route_name);
            foreach ($path_elements as $path_element) {
                if (($path_element !== '') && in_array($path_element, $route_name_elements, true)) {
                    $fitted_routes[] = $route_name;
                }
            }
        }
        //  Looking for fitted routes which has the same route name with the same number of arguments
        $main_path = null;
        $path_arguments = [];
        foreach ($fitted_routes as $route_name) {
            $current_route = $this->routes[$method][$route_name];
            if (isset($current_route[2])) {
                $num_of_args = count($current_route[2]);
                $to_merge_path_element = [];
                $path_arguments[$route_name] = [];
                foreach ($path_elements as $index => $path_element) {
                    if ($index < (count($path_elements) - $num_of_args)) {
                        $to_merge_path_element[] = $path_element;
                    } else {
                        $path_arguments[$route_name][] = $path_element;
                    }
                }
                $main_path = implode("/", $to_merge_path_element);
            } else {
                $main_path = $route_name;
            }
        }

        // Take callback for the given method and path that has been searched, if it exists
        $callback = $this->routes[$method][$main_path] ?? false;
        $arguments = null;
        if (isset($callback[2])) {
            $arguments = array_combine(array_keys($callback[2]), $path_arguments[$main_path]);
        }

        if (!isset($callback[2])) {
            //  If route has no argument, but received arguments
            if ($main_path !== $path) {
                $callback = false;
            }
        } else if ($main_path === $path) {
            //  If route has argument, but there is no argument received
            $callback = false;
        }

        if ($callback === false) {
            $this->response->setStatusCode(404);
            throw new NotFoundException();
        }

        // If it is a string, render as a View
        if (is_string($callback)) {
            return App::view($callback);
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
//        return call_user_func($callback, $this->request, $this->response);
        return call_user_func(
            [$callback[0], $callback[1]],
            $this->request,
            $this->response,
            $arguments
        );
    }
}