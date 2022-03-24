<?php

namespace app\includes\middleware;

use app\includes\App;
use app\includes\exception\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];

    /**
     * @param array $actions
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (App::isGuest()) {
            //  If the middleware works for every action/method OR there is action/method in middleware being executed by the Router
            if (empty($this->actions) || in_array(App::$app->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}