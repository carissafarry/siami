<?php

namespace app\admin\models;

use app\admin\models\auth\DbModel;

class Checklist extends DbModel
{
    public int $id = 0;
    public int $ami_id = 0;
    public int $status_id = 0;
//    public int $area_id = 0;
//    public int $auditee_id = 0;
    public ?int $auditee2_id = 0;
    public $area_id = 0;
    public $auditee_id = 0;
//    public $auditee2_id = 0;
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
            'auditee_id',
            'auditee2_id',
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

    public function auditee2()
    {
        return self::findOne(['user_id' => $this->auditee2_id], 'auditee', Auditee::class);
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
        $auditors = [];
//        $checklistsauditor_auditor_ids =  self::findManyToMany(
//            self::tableName(),
//            ['CHECKLIST.ID' => 'CHECKLIST_HAS_KRITERIA.CHECKLIST_ID'],
//            ['CHECKLIST_HAS_KRITERIA.ID' => 'CHECKLIST_AUDITOR.CHECKLIST_KRITERIA_ID'],
//            ChecklistAuditor::class,
//            ['CHECKLIST.ID' => $this->id],
//            ['CHECKLIST_AUDITOR.AUDITOR_ID',],
//            false,
//            'auditor_id',
//        );

        $sql = "
            SELECT CHECKLIST_AUDITOR.*
              FROM CHECKLIST
                INNER JOIN CHECKLIST_HAS_KRITERIA
                    ON CHECKLIST.ID = CHECKLIST_HAS_KRITERIA.CHECKLIST_ID
                INNER JOIN CHECKLIST_AUDITOR
                    ON CHECKLIST_HAS_KRITERIA.ID = CHECKLIST_AUDITOR.CHECKLIST_KRITERIA_ID 
              WHERE CHECKLIST.ID = :ID
              ORDER BY CHECKLIST_AUDITOR.ID
            ";

        $checklistsauditor_auditor_ids = self::findAll(
            self::tableName(),
            ['ID' => $this->id],
            ChecklistAuditor::class,
            $sql,
            'auditor_id'
        );

        foreach ($checklistsauditor_auditor_ids as $checklist_auditor) {
//                $auditors[] = Auditor::findOne(['user_id' => $checklist_auditor->auditor_id], "auditor", Auditor::class);
            $auditor = Auditor::findOne(['user_id' => $checklist_auditor], "auditor", Auditor::class);
            if ($auditor && !in_array($auditor, $auditors)) {
                 $auditors[] = $auditor;
            }
        }
        return $auditors;
    }

    public function pivot($where=[])
    {
        return self::findAll('checklist_has_kriteria', array_merge(['checklist_id' => $this->id], $where), ChecklistHasKriteria::class);
    }
}