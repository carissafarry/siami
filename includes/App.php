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
    public Session $session;
    public Router $router;
    public Database $db;
    public Controller $controller;
    public static App $app;

    public function __construct()
    {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);        // go check to Router class
        $this->db = new Database();
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

    /**
     * Run the application with defined router links
     *
     */
    public function run()
    {
        echo $this->router->resolve();
    }
}