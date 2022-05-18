<?php

namespace app\admin\models;

use app\admin\models\auth\DbModel;

class Spm extends DbModel
{

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
        // TODO: Implement autoIncrements() method.
    }

    public function attributes(): array
    {
        return [
            'user_id',
            'user_type',
        ];
    }
}