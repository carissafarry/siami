<?php

namespace app\includes;

use app\admin\components\NavItem;

class Component
{
    public static function init()
    {
        return new Component();
    }

    public function navItem($title, $icon)
    {
        return new NavItem($title, $icon);
    }
}