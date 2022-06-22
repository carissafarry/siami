<?php

namespace app\admin\models;

use app\admin\models\auth\DbModel;
use app\includes\App;

class ChecklistAuditor extends DbModel
{
    public int $checklist_kriteria_id = 0;
    public int $auditor_id = 0;
    public ?string $waktu_audit = '';
    public ?string $ket_auditor = '';
    public ?string $nilai = '';

    public static function tableName(): string
    {
        return 'CHECKLIST_AUDITOR';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function autoIncrements(): array
    {
        return ['id'];
    }

    public function attributes(): array
    {
        return [
            'id',
            'checklist_kriteria_id',
            'auditor_id',
            'waktu_audit',
            'ket_auditor',
            'nilai',
        ];
    }

    public function sequence(): string
    {
        return 'CHECKLIST_AUDITOR_SEQ';
    }

    public function auditor()
    {
        return self::findOne(['user_id' => $this->auditor_id], 'auditor', Auditor::class);
    }
}