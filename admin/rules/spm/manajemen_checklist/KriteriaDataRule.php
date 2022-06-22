<?php

namespace app\admin\rules\spm\manajemen_checklist;

use app\includes\Model;
use app\includes\Rule;

class KriteriaDataRule extends Rule
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
            'kriteria' => [self::RULE_REQUIRED],
        ];
    }
}