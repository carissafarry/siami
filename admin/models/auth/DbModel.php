<?php

namespace app\admin\models\auth;

use app\includes\App;
use app\includes\Model;

abstract class DbModel extends Model
{
    /**
     * Define the name of table
     *
     */
    abstract public static function tableName(): string;

    /**
     * Get table name data as a getter of abstract static function tableName()
     *
     */
    public static function getTableName(): string
    {
        return static::tableName();
    }

    /**
     * Define attribute of table
     *
     */
    abstract public function attributes(): array;

    /**
     * Save request data to defined database table as attributes defined in child model
     * @return bool
     */
    public function save(): bool
    {
        $tableName = $this::getTableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $statement = "INSERT INTO $tableName (".implode(',', $attributes).")
            VALUES(".implode(',', $params).")";

        $data = array_combine(
            $params,
            array_map(fn($attr) => $this->{$attr}, $attributes)
        );

        App::$app->db->query_insert($statement, $data);
        return True;
    }
}