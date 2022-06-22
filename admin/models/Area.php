<?php

namespace app\admin\models;

use app\admin\models\auth\DbModel;

class Area extends DbModel
{
    public int $id;
    public string $nama = '';
    public ?int $is_prodi = null;

    public static function tableName(): string
    {
        return 'AREA';
    }

    public function attributes(): array
    {
        return [
            'id',
            'nama',
            'is_prodi'
        ];
    }

    public function sequence(): string
    {
        return 'AREA_SEQ';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function autoIncrements(): array
    {
        return ['id'];
    }
}