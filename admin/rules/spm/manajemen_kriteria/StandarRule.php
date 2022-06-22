<?php

namespace app\admin\rules\spm\manajemen_kriteria;

use app\includes\Model;
use app\includes\Rule;

class StandarRule extends Rule
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
            'kode' => [self::RULE_REQUIRED],
            'standar' => [self::RULE_REQUIRED],
            'tahun' => [self::RULE_REQUIRED],
        ];
    }
}