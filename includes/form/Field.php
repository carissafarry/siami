<?php

namespace app\includes\form;

use app\includes\Model;
use app\includes\Rule;

class Field
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';

    public string $type;
    public Model $model;
    public Rule $rule;
    public string $attribute;

    /**
     * @param Rule $rule
//     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Rule $rule, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        $this->rule = $rule;
        $this->attribute = $attribute;
    }

    /**
     * Method used to print the object as a string
     */
    public function __toString()
    {
        return sprintf('
            <div class="form-group">
                <label>%s</label>
                <input type="%s" name="%s" value="%s" class="form-control %s">
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ',
            $this->attribute,
            $this->type,
            $this->attribute,

//            $this->rule->{$this->attribute},
            $this->rule->model->{$this->attribute},
            $this->rule->hasError($this->attribute) ? 'is-invalid' : '',
            $this->rule->getFirstError($this->attribute)
        );
    }

    /**
     * Define type of password field
     */
    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
}