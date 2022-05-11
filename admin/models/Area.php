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

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function getDisplay(string $attribute): string
    {
        // TODO: Implement getDisplay() method.
        return '';
    }

    public function autoIncrements(): array
    {
        // TODO: Implement autoIncrements() method.
        return [];
    }
}