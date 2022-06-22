<?php

namespace app\admin\rules\spm\manajemen_kriteria;

use app\includes\Model;
use app\includes\Rule;

class KriteriaRule extends Rule
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
            'standar_id' => [self::RULE_REQUIRED],
            'kode' => [self::RULE_REQUIRED],
            'kriteria' => [self::RULE_REQUIRED],
            'ket_nilai' => [self::RULE_REQUIRED],
            'tahun' => [self::RULE_REQUIRED],
        ];
    }
}