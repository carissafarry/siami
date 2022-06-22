<?php

namespace app\admin\models;

use app\admin\models\auth\DbModel;

class ChecklistHasKriteria extends DbModel
{
    public ?int $id = 0;
    public int $checklist_id = 0;
    public int $kriteria_id = 0;
    public ?string $ket_auditee = '';
    public ?string $data_pendukung = '';
    public ?string $nilai_akhir = '';
    public ?string $tindak_lanjut = '';
    public ?string $tinjauan_efektivitas = '';

    public static function tableName(): string
    {
        return 'CHECKLIST_HAS_KRITERIA';
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
            'checklist_id',
            'kriteria_id',
            'ket_auditee',
            'data_pendukung',
            'nilai_akhir',
            'tindak_lanjut',
            'tinjauan_efektivitas',
        ];
    }

    public function sequence(): string
    {
        return 'CHECKLIST_HAS_KRITERIA_SEQ';
    }

    public function kriteria()
    {
        return self::findOne(['id' => $this->kriteria_id], 'kriteria', Kriteria::class);
    }

    public function checklist_auditor($where=[])
    {
        return self::findOne(array_merge(['checklist_kriteria_id' => $this->id], $where), 'checklist_auditor', ChecklistAuditor::class);
    }
}