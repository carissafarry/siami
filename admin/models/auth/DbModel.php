<?php

namespace app\admin\models\auth;

use app\includes\Model;

//abstract class DbRule extends Rule
abstract class DbModel extends Model
{
    abstract public function tableName(): string;
    abstract public function loadData($data): void;

    abstract public function attributes(): array;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        return True;
        // TODO: Query insert user data to database
    }
}