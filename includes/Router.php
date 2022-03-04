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
    //  public Controller $controller;

    protected array $routes = [];

    //  public function __construct(Request $request, Response $response, Controller $controller)
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        //  $this->controller = $controller;
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
             return $this->renderOnlyView('_404');
//            return $this->controller->view('_404');
        }

        // If it is a string, render as a View
        if (is_string($callback)) {
//             return $this->renderView($callback);           // ! seharusnya pake ini, karena pake layout yg bisa direquest
            return $this->renderOnlyView($callback);            // sementara pake ini, yg ga perlu layout + template
//            return $this->controller->view($callback);
        }

        if (is_array($callback)) {
            //  Create new instance of Controller class from App
            App::$app->controller = new $callback[0]();
            $callback[0] = App::$app->controller;
        }
        
        // If it is a closure/function, execute the callback
        return call_user_func($callback, $this->request);
    }

    /**
     * Render view that has been merged with layout template
     *
     */
    public function renderView($view, $params = [])
    {
        // Shift content template in layout with view
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Render small content / string, that merged with certain layout
     *
     */
    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Render main.php as a layout, which later will be used as a template and merged with custom content
     *
     */
    protected function layoutContent()
    {
        $layout = App::$app->controller->layout;
        ob_start();         // start caching the output
        include_once APPROOT . "/views/layouts/$layout.php";       // actual output
        return ob_get_clean();          // return whatever is already buffered, and clears the buffer
    }

    /**
     * Render pure only from a view file
     *
     */
    protected function renderOnlyView($view, $params = [])
    {
//        var_dump($params);
        ob_start();         // start caching the output
        include_once APPROOT . "/views/$view.php";       // actual output
        return ob_get_clean();          // return whatever is already buffered, and clears the buffer
    }
}