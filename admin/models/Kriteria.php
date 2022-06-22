<?php

namespace app\admin\models;

use app\admin\models\auth\DbModel;

class Kriteria extends DbModel
{
    public int $id = 0;
    public int $standar_id = 0;
    public string $kode = '';
    public string $kriteria = '';
    public string $ket_nilai = '';
    public ?string $catatan = '';
    public ?string $tahun = '';

    public function __construct()
    {
        if (empty($this->tahun)){
            $this->tahun = (string) date('Y');
        }
    }

    public static function tableName(): string
    {
        return 'KRITERIA';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function autoIncrements(): array
    {
        return [
            'id'
        ];
    }

    public function attributes(): array
    {
        return [
            'id',
            'standar_id',
            'kode',
            'kriteria',
            'ket_nilai',
            'catatan',
            'tahun',
        ];
    }

    public function sequence(): string
    {
        return 'KRITERIA_SEQ';
    }

    public function standar()
    {
        return self::findOne(['id' => $this->standar_id], 'standar', Standar::class);
    }

    public function checklists()
    {
        return $this->findManyToMany(
            self::tableName(),
            ['KRITERIA.ID' => 'CHECKLIST_HAS_KRITERIA.KRITERIA_ID'],
            ['CHECKLIST_HAS_KRITERIA.CHECKLIST_ID' => 'CHECKLIST.ID'],
            Checklist::class,
            ['KRITERIA.ID' => $this->id]
        );
    }
}