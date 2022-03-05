<?php

namespace app\includes;

/*
     *  App Core class
     * Creates URL and loads Controller
     * URL FORMAT  /controller/method/params
*/

class App
{
    public Request $request;
    public Response $response;
    public Controller $controller;
    public Router $router;
    public static App $app;

    protected $controller2 = 'Home';
    protected $method = 'index';
    protected $params = [];
    protected $path = APPROOT . '/admin/controllers/';

    public function __construct()
    {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);        // go check to Router class

        // ! MVC System 1
//        $url = $this->parseURL();
//        $next_url_index = 0;
//
//        if ($url) {
//            $this->path = ($url[0] === 'api') ? $this->path . 'api/' :  $this->path;
//            $next_url_index = ($url[0] === 'api') ? 1 : 0;
//
//            // Check controller
//            if (isset($url[$next_url_index])) {
//                if (file_exists($this->path . ucwords($url[$next_url_index]) . '.php')) {
//                    $this->controller2 = ucwords($url[$next_url_index]);
//                    unset($url[$next_url_index]);
//                }
//            }
//        }
//
//        require_once $this->path . $this->controller2 . '.php';
//        $this->controller2 = new $this->controller2;
//
//        // Check method
//        if (isset($url[$next_url_index + 1])) {
//            if (method_exists($this->controller2, $url[$next_url_index + 1])) {
//                $this->method = $url[$next_url_index + 1];
//                unset($url[$next_url_index + 1]);
//            }
//        }
//
//        // Check params
//        $this->params = $url ? array_values($url) : [];

        // ! Run MVC System 1
        // Call a callback with array of params
        // call_user_func_array([
        //     $this->controller,
        //     $this->method
        // ], $this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return null;
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }
}