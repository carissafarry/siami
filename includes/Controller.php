<?php

namespace app\includes;
/*
    * This is the Base Controller
    * Loads the Models
*/

use app\includes\Middleware;

class Controller
{
    public string $action = '';

    /**
     * @var Middleware[]
     */
    protected array $middlewares = [];
    protected array $middlewares_to_run = [];

    /**
     * @return Middleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function getToRunMiddleware(): array
    {
        return $this->middlewares_to_run;
    }

    // Load Model
    public function model($model)
    {
        // Requires Model FIle
        require_once APP_ROOT . '/admin/models/' . $model . '.php';

        // Instantiate Model
        return new $model();
    }

    public function registerMiddleware($middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Generate random string
     *
     */
    public function randomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    /**
     * Generate random integer
     *
     */
    public function randomInteger($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789', ceil($length/strlen($x)) )),1,$length);
    }
}