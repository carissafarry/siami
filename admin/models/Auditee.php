<?php

namespace app\admin\models;

use app\admin\models\auth\DbModel;
use app\admin\models\auth\User;

class Auditee extends DbModel
{
    public int $user_id = 0;
    public int $user_type = 3;

    public static function tableName(): string
    {
        return 'AUDITEE';
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

    public static function users($where=[])
    {
        return self::findAll('user_details', array_merge(['user_type' => 3], $where), User::class);
    }
}