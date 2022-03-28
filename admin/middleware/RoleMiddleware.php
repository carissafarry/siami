<?php

namespace app\admin\middleware;

use app\includes\App;
use app\includes\exception\ForbiddenException;
use app\includes\Middleware;

class RoleMiddleware extends Middleware
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
//        if (App::isGuest()) {
//            //  If the middleware works for every action/method OR there is action/method in middleware being executed by the Router
//            if (empty($this->actions) || in_array(App::$app->controller->action, $this->actions)) {
//                throw new ForbiddenException();
//            }
//        }

//        if (App::$app->user->role_id == 1){
//            echo '<pre>';
////            var_dump('SPM');
//            echo '</pre>';
//            exit;
//        } else {
//            echo '<pre>';
////            var_dump('no spm');
//            echo '</pre>';
//            exit;
//        }
    }
}