<?php

namespace app\admin\models;

use app\admin\models\auth\DbModel;

class Status extends DbModel
{
    public int $id = 0;
    public string $status = '';

    public static function tableName(): string
    {
        return 'STATUS';
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
            'status',
        ];
    }

    public function sequence(): string
    {
        return 'STATUS_SEQ';
    }
}