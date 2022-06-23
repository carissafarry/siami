<?php

namespace app\admin\rules\spm\manajemen_checklist;

use app\includes\Model;
use app\includes\Rule;

class AddChecklistRule extends Rule
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
            'ami_id' => [self::RULE_REQUIRED],
            'status_id' => [self::RULE_REQUIRED],
            'tgl_terbit' => [self::RULE_REQUIRED],
            'no_identifikasi' => [self::RULE_REQUIRED],
            'no_revisi' => [self::RULE_REQUIRED],
            'area_id' => [self::RULE_REQUIRED],
            'auditee_id' => [self::RULE_REQUIRED],
            'auditor1_id' => [self::RULE_REQUIRED],
            'auditor2_id' => [self::RULE_REQUIRED],
        ];
    }
}