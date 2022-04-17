<?php

namespace app\includes;
/*
    * This is the Base Controller
    * Loads the Models and Views
*/

use app\admin\repository\BaseRepository;
use app\includes\interfaces\Repository;

class Controller
{
    public string $action = '';
    public Repository $repo;

    /**
     * @var Middleware[]
     */
    protected array $middlewares = [];

    public function repo(Model $model)
    {
        $this->repo = new BaseRepository($model);
        return $this->repo;
    }

    /**
     * @return Middleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function registerMiddleware(Middleware $middleware)
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