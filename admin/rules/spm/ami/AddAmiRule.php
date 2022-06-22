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
            'spm_id' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => get_class($this->model),]],
            'tahun' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => get_class($this->model),]],
            'jadwal_mulai' => [self::RULE_REQUIRED],
            'jadwal_selesai' => [self::RULE_REQUIRED],
        ];
    }
}