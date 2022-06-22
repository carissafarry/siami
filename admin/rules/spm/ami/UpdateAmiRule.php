<?php

namespace app\admin\rules\spm\ami;

use app\includes\Model;
use app\includes\Rule;

class UpdateAmiRule extends Rule
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
            'spm_id' => [self::RULE_REQUIRED],
            'tahun' => [self::RULE_REQUIRED],
            'jadwal_mulai' => [self::RULE_REQUIRED],
            'jadwal_selesai' => [self::RULE_REQUIRED],
        ];
    }
}