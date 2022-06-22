<?php

namespace app\admin\models;

use app\admin\models\auth\DbModel;

class Standar extends DbModel
{
    public int $id;
    public string $kode = '';
    public string $standar = '';
    public string $tahun = '';

    public function __construct()
    {
        if (empty($this->tahun)){
            $this->tahun = (string) date('Y');
        }
    }

    public static function tableName(): string
    {
        return 'STANDAR';
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
            'kode',
            'standar',
            'tahun',
        ];
    }

    public function sequence(): string
    {
        return 'STANDAR_SEQ';
    }

    public function kriterias()
    {
        return self::findAll('kriteria', ['standar_id' => $this->id], Kriteria::class);
    }
}