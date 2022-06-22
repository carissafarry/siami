<?php

namespace app\includes;

use app\admin\components\NavItem;

class Component
{
    public static function init()
    {
        return new Component();
    }

    public function navItem($title, $route, $icon, $with_role=true)
    {
        return new NavItem($title, $route, $icon, $with_role);
    }
}