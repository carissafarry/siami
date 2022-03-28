<?php

namespace app\includes;

/*
     *  App Core class
     * Creates URL and loads Controller
     * URL FORMAT  /controller/method/params
*/

use app\admin\models\auth\User;
use CasbinAdapter\LaminasDb\Adapter;
use Casbin\Enforcer;
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
    public Adapter $adapter;
    public Enforcer $e;
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

    /**
     * Create Enforcer Instance for Casbin RBAC Management API
     * @throws \Casbin\Exceptions\CasbinException
     */
    public function createEnforcer()
    {
        //  Create casbin_rule table to store Casbin Policy
        $this->db->query_insert("
            DECLARE
            v_sql LONG;
            BEGIN
            v_sql:='
                    CREATE TABLE casbin_rule (
                        ptype varchar(255) NOT NULL,
                        v0 varchar(255) DEFAULT NULL,
                        v1 varchar(255) DEFAULT NULL,
                        v2 varchar(255) DEFAULT NULL,
                        v3 varchar(255) DEFAULT NULL,
                        v4 varchar(255) DEFAULT NULL,
                        v5 varchar(255) DEFAULT NULL
                    )
                   ';
            EXECUTE IMMEDIATE v_sql;
            EXCEPTION
                WHEN OTHERS THEN
                    IF SQLCODE = -955 THEN
                        NULL;
                    ELSE
                        RAISE;
                    END IF;
            END;
        ");

        //  Create new database adapter for casbin
        $adapter = new Adapter([
            'driver' => 'Oci8', // IbmDb2, Mysqli, Oci8, Pgsql, Sqlsrv, Pdo_Mysql, Pdo_Sqlite, Pdo_Pgsql
            'hostname' => DB_HOST,
            'database' => DB_DATABASE,
            'username' => DB_USERNAME,
            'password' => DB_PASSWORD,
            'port' => DB_PORT,
        ]);
        $this->e = new Enforcer(APP_ROOT . '/admin/rbac/rbac_model.conf', $adapter );
        return $this->e;
//        return new Enforcer(APP_ROOT . '/admin/rbac/rbac_model.conf', $adapter );
    }
}