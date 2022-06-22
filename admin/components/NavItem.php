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
        return sprintf('
            <li class="nav-item">
                <a class="nav-link %s" href= "%s%s">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        %s
                    </div>
                    <span class="nav-link-text ms-1">%s</span>
                </a>
            </li>
        ',
//            App::$app->request->is(App::$app->user->role->role . '/manajemen-user' ) ? 'active' : '',
            App::$app->request->is(($this->with_role ? strtolower(App::$app->user->role()->role) : '') . $this->route ) ? 'active' : '',
            $this->with_role ? "/" . strtolower(App::$app->user->role()->role) : '',
            $this->route,
            $this->icon,
            $this->title
        );
    }
}