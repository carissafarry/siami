<?php

namespace app\admin\models;

use app\admin\models\auth\DbModel;
use app\admin\models\auth\User;

class Spm extends DbModel
{
    public int $user_id = 0;
    public int $user_type = 1;

    public static function tableName(): string
    {
        return 'SPM';
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
}