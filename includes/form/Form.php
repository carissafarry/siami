<?php

namespace app\includes\form;

use app\includes\Rule;

class Form
{
    public static function begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Rule $rule, $attribute)
    {
        return new Field($rule, $attribute);
    }
}