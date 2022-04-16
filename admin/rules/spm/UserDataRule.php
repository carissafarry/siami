<?php

namespace app\admin\rules\spm;

use app\includes\Model;
use app\includes\Rule;

class UserDataRule extends Rule
{
    public Model $model;

    public function rules(): array
    {
        return [
            'role' => [self::RULE_REQUIRED],
            'telp' => [self::RULE_REQUIRED],
            'periode' => [self::RULE_REQUIRED],
        ];
    }
}