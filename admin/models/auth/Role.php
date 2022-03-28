<?php

namespace app\admin\models\auth;

use app\includes\Model;

class Role extends DbModel
{
    public int $id;
    public string $role;
    public string $deskripsi;

    public static function tableName(): string
    {
        return 'role';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'id',
            'role',
            'deskripsi',
        ];
    }

    public function getDisplay(string $attribute): string
    {
        // TODO: Implement getDisplay() method.
    }
}