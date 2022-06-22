<?php

namespace app\admin\models;

use app\admin\models\auth\DbModel;
use app\admin\models\auth\User;
use app\includes\App;

class Auditor extends DbModel
{
    public int $user_id = 0;
    public int $user_type = 2;

    public static function tableName(): string
    {
        return 'AUDITOR';
    }

    public static function primaryKey(): string
    {
        return 'user_id';
    }

    public function autoIncrements(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [
            'user_id',
            'user_type',
        ];
    }

    public function sequence(): string
    {
        return '';
    }

    public function user()
    {
        return self::findOne(['id' => $this->user_id], 'user_details', User::class);
    }

    public static function users()
    {
        return self::findAll('user_details', ['user_type' => 2], User::class);
    }

    public function checklists()
    {
        $checklist_kriteria_ids = self::findAll('checklist_auditor', ['auditor_id' => $this->user_id], ChecklistAuditor::class, null, 'checklist_kriteria_id');
        $checklists= [];
        foreach ($checklist_kriteria_ids as $checklist_kriteria_id) {
            $checklist_id = ChecklistHasKriteria::findOne(['id' => $checklist_kriteria_id], "checklist_has_kriteria", null, null, 'checklist_id');
            $checklists[] = Checklist::findOne(['id' => $checklist_id]);
        }
        return $checklists;
    }

    public function checklist_auditors($attr=null)
    {
        return self::findAll('checklist_auditor', ['auditor_id' => $this->user_id], ChecklistAuditor::class, null, $attr);
    }

    public function checklist_has_kriterias($where_checklist_has_kriteria=[])
    {
        $checklist_has_kriteria_ids = $this->checklist_auditors('checklist_kriteria_id');
        $checklist_has_kriterias = [];
        foreach ($checklist_has_kriteria_ids as $checklist_has_kriteria_id) {
            $checklist_has_kriteria = self::findOne(array_merge(['id' => $checklist_has_kriteria_id], $where_checklist_has_kriteria), 'checklist_has_kriteria', ChecklistHasKriteria::class);
            if ($checklist_has_kriteria) {
                $checklist_has_kriterias[] = $checklist_has_kriteria;
            }
        }
        return $checklist_has_kriterias;
    }
}