<?php

namespace app\admin\models;

use app\admin\models\auth\DbModel;

class Checklist extends DbModel
{
    public int $id = 0;
    public int $ami_id = 0;
    public int $status_id = 0;
    public int $area_id = 0;
    public int $auditee_id = 0;
    public ?int $auditee2_id = 0;
    public ?string $tgl_terbit = '';
    public ?string $no_identifikasi = '';
    public ?string $no_revisi = '';
    public string $status = 'default status';

    public static function tableName(): string
    {
        return 'CHECKLIST';
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
            'ami_id',
            'status_id',
            'area_id',
            'auditee2_id',
            'auditee_id',
            'tgl_terbit',
            'no_identifikasi',
            'no_revisi',
            'status',
        ];
    }

    public function sequence(): string
    {
        return 'CHECKLIST_SEQ';
    }

    public function ami()
    {
        return self::findOne(['id' => $this->ami_id], 'ami', Ami::class);
    }

    public function status()
    {
        return self::findOne(['id' => $this->status_id], 'status', Status::class);
    }

    public function area()
    {
        return self::findOne(['id' => $this->area_id], 'area', Area::class);
    }

    public function auditee()
    {
        return self::findOne(['user_id' => $this->auditee_id], 'auditee', Auditee::class);
    }

    public function kriterias()
    {
        return self::findManyToMany(
            self::tableName(),
            ['CHECKLIST.ID' => 'CHECKLIST_HAS_KRITERIA.CHECKLIST_ID'],
            ['CHECKLIST_HAS_KRITERIA.KRITERIA_ID' => 'KRITERIA.ID'],
            Kriteria::class,
            ['CHECKLIST.ID' => $this->id]
        );
    }

    public function auditors()
    {
        $checklistsauditor_auditor_ids =  self::findManyToMany(
            self::tableName(),
            ['CHECKLIST.ID' => 'CHECKLIST_HAS_KRITERIA.CHECKLIST_ID'],
            ['CHECKLIST_HAS_KRITERIA.ID' => 'CHECKLIST_AUDITOR.CHECKLIST_KRITERIA_ID'],
            ChecklistAuditor::class,
            ['CHECKLIST.ID' => $this->id],
            ['CHECKLIST_AUDITOR.AUDITOR_ID',],
            true
        );
        $auditors = [];
        foreach ($checklistsauditor_auditor_ids as $checklist_auditor) {
            $auditors[] = Auditor::findOne(['user_id' => $checklist_auditor->auditor_id], "auditor", Auditor::class);
        }
        return $auditors;
    }

    public function pivot($where=[])
    {
        return self::findAll('checklist_has_kriteria', array_merge(['checklist_id' => $this->id], $where), ChecklistHasKriteria::class);
    }
}