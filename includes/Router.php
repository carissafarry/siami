<?php

namespace app\includes;

/*
     *  Router class
     *  Manage routing and execute requests
*/

/**
 * @var Controller $controller
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
            $this->routes['get'][APP_PATH . $path] = $callback;

            //  Define arguments as array elements
            preg_match_all('/{(.*?)}/', $path, $matches);

            foreach ($matches[1] as $argument) {
                $arguments[$argument] = null;
            }
            $this->routes['get'][APP_PATH . $path][] = $arguments;
        } else {
            if ($path == '/') {
                $this->routes['get'][APP_PATH] = $callback;
            } elseif ($path == '/root') {
                $this->routes['get']['/'] = $callback;
            } else {
                $this->routes['get'][APP_PATH . $path] = $callback;
            }
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
        $arguments = [];

        //  Check if route has defined arguments
        if ((strpos($path, '{') !== false) && (strpos($path, '}') !== false)) {
            $this->routes['post'][APP_PATH . $path] = $callback;

            //  Define arguments as array elements
            preg_match_all('/{(.*?)}/', $path, $matches);

            foreach ($matches[1] as $argument) {
                $arguments[$argument] = null;
            }
            $this->routes['post'][APP_PATH . $path][] = $arguments;
        } else {
            if ($path == '/') {
                $this->routes['post'][APP_PATH] = $callback;
            } elseif ($path == '/root') {
                $this->routes['post']['/'] = $callback;
            } else {
                $this->routes['post'][APP_PATH . $path] = $callback;
            }
        }
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

        //  Remove trailing slash from path request
        if((($path != APP_PATH) && ($path != '/')) && (substr($path, -1) === '/')) {
            $path = substr($path, 0, -1);
        }

        $routes_result = $this->searchRoutes($method, $path);
        $main_path = $routes_result[0];
        $path_arguments = $routes_result[1];

        //  Take callback for the given method and path that has been searched, if it exists
        $callback = $this->routes[$method][$main_path] ?? false;

        $arguments = null;
        if (isset($callback[2]) && !empty($path_arguments)) {
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

        //  If it is a string, render as a View
        if (is_string($callback)) {
            return App::view($callback);
        }

        //  If it is an array, first array is a controller class, and second is the method inside the controller
        if (is_array($callback)) {
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

        //  If it is a closure/function, execute the callback
        return call_user_func(
            [$callback[0], $callback[1]],
            $this->request,
            $this->response,
            $arguments
        );
    }

    protected function searchRoutes($method, $path): array
    {
        $route_names = array_keys($this->routes[$method]);
        $path_elements = explode("/", $path);
        $match_scores = [];
        $main_path = '';
        $path_arguments = array();

        if (($path !== '') && ($path !== '/')) {
            foreach ($route_names as $route_name) {
                if ($route_name === $path) {
                    if (!isset($match_scores[$route_name])) {
                        $match_scores[$route_name] = 0;
                    }
                    $match_scores[$route_name] = count($path_elements);     // unsure
                    $main_path = $path;
                    break;
                }
                $route_name_elements = explode("/", $route_name);
                foreach ($path_elements as $path_element) {
                    if (($path_element !== '') && in_array($path_element, $route_name_elements, true)) {
                        if (!isset($match_scores[$route_name])) {
                            $match_scores[$route_name] = 0;
                        }
                        $match_scores[$route_name]++;
                    }
                }
            }
        } else {
            $match_scores['/'] = 1;
        }

        array_multisort(array_values($match_scores), SORT_DESC, $match_scores);
        $sorted_match_scores = array_count_values($match_scores);
        $highest_score = array_key_first($sorted_match_scores);

        if ($sorted_match_scores[$highest_score] == 1) {
            $main_path = array_key_first($match_scores);
        } else {
            foreach ($match_scores as $match => $value) {
                if (($value == $highest_score) && (count(explode('/', $match))) == count($path_elements)) {
                    $main_path = $match;
                }
            }
        }
        $main_path_elements = explode("/", $main_path);
        $main_route = $this->routes[$method][$main_path] ?? false;

        if (isset($main_route[2])) {
            $path_arguments[$main_path] = [];
            foreach ($path_elements as $index => $value) {
                if ($value != $main_path_elements[$index]) {
                    $path_arguments[$main_path][] = $value;
                }
            }
        }

        return [$main_path, $path_arguments];
    }
}