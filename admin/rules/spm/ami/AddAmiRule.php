<?php

namespace app\admin\rules\spm\ami;

use app\includes\Model;
use app\includes\Rule;

class AddAmiRule extends Rule
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
//            'spm_id' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => get_class($this->model),]],
            'spm_id' => [self::RULE_REQUIRED],
            'tahun' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => get_class($this->model),]],
            'audit_mulai' => [self::RULE_REQUIRED],
            'audit_selesai' => [self::RULE_REQUIRED],
        ];
    }
}