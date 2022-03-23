<?php

namespace app\admin\rules\auth;

use app\includes\Model;
use app\includes\Rule;

class UserRule extends Rule
{
    public Model $model;

    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function rules(): array
    {
        return [
//            'firstname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE,
                'class' => get_class($this->model),
//                'attribute' => 'firstname'
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
//            'nip' => [self::RULE_UNIQUE],
//            'user_type' => [self::RULE_UNIQUE],
        ];
    }
}