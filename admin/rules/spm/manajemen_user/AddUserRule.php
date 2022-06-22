<?php

namespace app\admin\rules\spm\manajemen_user;

use app\includes\Model;
use app\includes\Rule;

class AddUserRule extends Rule
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
            'net_id' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => get_class($this->model),]],
            'area_id' => [self::RULE_REQUIRED],
            'jabatan' => [self::RULE_REQUIRED],
            'role_id' => [self::RULE_REQUIRED],
            'telp' => [self::RULE_REQUIRED],
            'periode' => [self::RULE_REQUIRED],
        ];
    }
}