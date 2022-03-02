<?php

/*
     *  App Core class
     * Creates URL and loads Controller
     * URL FORMAT  /controller/method/params
*/

class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];
    protected $path = APPROOT . '/admin/controllers/';

    public function __construct()
    {
        $url = $this->parseURL();
        $next_url_index = 0;

        if ($url) {
            $this->path = ($url[0] == 'api') ? $this->path . 'api/' :  $this->path;
            $next_url_index = ($url[0] == 'api') ? 1 : 0;

            // Check controller
            if (file_exists($this->path . ucwords($url[$next_url_index]) . '.php')) {
                $this->controller = ucwords($url[$next_url_index]);
                unset($url[$next_url_index]);
            }
        }

        require_once $this->path . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Check method
        if (isset($url[$next_url_index + 1])) {
            if (method_exists($this->controller, $url[$next_url_index + 1])) {
                $this->method = $url[$next_url_index + 1];
                unset($url[$next_url_index + 1]);
            }
        }

        // Check params           
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([
            $this->controller,
            $this->method
        ], $this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}