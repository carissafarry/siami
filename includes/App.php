<?php

namespace app\includes;

/*
     *  App Core class
     * Creates URL and loads Controller
     * URL FORMAT  /controller/method/params
*/

use app\admin\models\auth\User;
use Exception;

class App
{
    public Request $request;
    public Response $response;
    public Session $session;
    public Router $router;
    public Database $db;
    public View $view;

    public Controller $controller;
    public ?User $user;
    public static App $app;

    public string $userClass;

    public function __construct()
    {
        $this->userClass = USER_CLASS;
        self::$app = $this;
        $this->view = new View();
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);        // go check to Router class
        $this->db = new Database();

        $this->fetchUser();
    }

    /**
     * Fetch the user data with session
     *
     */
    public function fetchUser()
    {
        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue[0]]);
        } else {
            $this->user = null;
        }
    }

    /**
     * Parse the URL from request
     *
     */
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
     * Run the application with defined router links or display error page
     *
     * @throws Exception
     */
    public function run(): void
    {
        try {
            echo $this->router->resolve();
        } catch (Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo self::view('_error', [
                'exception' => $e
            ]);
        }
    }

    /**
     * Main app login method and set user session
     *
     */
    public function login(User $user): bool
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);     // create user session using user id from PK
        return true;
    }

    public function logout(): void
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest(): bool
    {
        return !self::$app->user;
    }

    /**
     * Render given View file from view instance of App
     * @return View|array|false|string|string[]|void
     */
    public static function view($data, $param = [])
    {
        return self::$app->view->view($data, $param);
    }

    /**
     * Set layout of new view file that will be rendered from view instance of App
     *
     */
    public static function setLayout($layout)
    {
        return self::$app->view->setLayout($layout);
    }
}