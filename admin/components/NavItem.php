<?php

namespace app\admin\components;

use app\includes\App;

class NavItem
{
    public string $title;
    public string $route;
    public string $icon;
    public bool $with_role;

    public function __construct($title, $route, $icon, $with_role=true)
    {
        $this->title = $title;
        $this->route = $route;
        $this->icon = $icon;
        $this->with_role = $with_role;
    }

    public function __toString()
    {
        $is_being_open = App::$app->request->is(($this->with_role ? strtolower(APP_PATH . '/' . App::$app->user->role()->role) : '') . $this->route );

        return sprintf('
            <li class="nav-item">
                <a class="nav-link %s" href= "%s%s">
                    <div class="icon icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center %s">
                        %s
                    </div>
                    <span class="nav-link-text ms-1">%s</span>
                </a>
            </li>
        ',
//            App::$app->request->is(App::$app->user->role->role . '/manajemen-user' ) ? 'active' : '',
            $is_being_open ? 'active' : '',
            $this->with_role ? (APP_PATH . '/' . strtolower(App::$app->user->role()->role)) : APP_PATH,
            $this->route,
            $is_being_open ? 'text-white' : '',
            $this->icon,
            $this->title
        );
    }
}