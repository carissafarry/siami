<?php

namespace app\admin\models;

use app\admin\models\auth\DbModel;

class Ami extends DbModel
{
    public int $id = 0;
    public int $spm_id = 0;
    public string $tahun = '';
//    public int $is_tindak_lanjut = 0;
    public string $audit_mulai = '';
    public string $audit_selesai = '';
    public ?string $rtm_mulai = '';
    public ?string $rtm_selesai = '';

    public static function tableName(): string
    {
        return 'AMI';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function autoIncrements(): array
    {
        return [
            'id',
        ];
    }

    public function attributes(): array
    {
        return [
            'id',
            'spm_id',
            'tahun',
//            'is_tindak_lanjut',
            'audit_mulai',
            'audit_selesai',
            'rtm_mulai',
            'rtm_selesai',
        ];
    }

    public function sequence(): string
    {
        return 'AMI_SEQ';
    }

    public function spm()
    {
        return self::findOne(['user_id' => $this->spm_id], 'spm', Spm::class);
    }

    public function checklists($attr=null)
    {
        return self::findAll('checklist', ['ami_id' => $this->id], Checklist::class, null, $attr);
    }
}