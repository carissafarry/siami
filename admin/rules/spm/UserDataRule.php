<?php

namespace app\admin\rules\spm;

use app\includes\Model;
use app\includes\Rule;

class UserDataRule extends Rule
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
            'area' => [self::RULE_REQUIRED],
            'jabatan' => [self::RULE_REQUIRED],
            'role_id' => [self::RULE_REQUIRED],
            'telp' => [self::RULE_REQUIRED],
            'periode' => [self::RULE_REQUIRED],
        ];
    }
}