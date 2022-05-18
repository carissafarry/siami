<?php

namespace app\admin\models;

use app\admin\models\auth\DbModel;

class Ami extends DbModel
{
    public int $id = 0;
    public int $spm_id = 0;
    public string $tahun = '';
    public string $jadwal_mulai = '';
    public string $jadwal_selesai = '';
    public int $is_tindak_lanjut = 0;

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
            'jadwal_mulai',
            'jadwal_selesai',
            'is_tindak_lanjut',
        ];
    }

    public function spm()
    {
        return self::findOne(['user_id' => $this->spm_id], 'spm', Spm::class);
    }
}