<?php

namespace app\admin\models\auth;

use app\includes\App;
use app\includes\Model;

//abstract class DbRule extends Rule
abstract class DbModel extends Model
{
    /**
     * Define the name of table
     *
     */
    abstract public function tableName(): string;

    /**
     * Define attribute of table
     *
     */
    abstract public function attributes(): array;

    /**
     * Save request data to defined database table as attributes defined in child model
     *
     */
    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $statement = oci_parse(
            App::$app->db->getConnection(),
            "INSERT INTO $tableName (".implode(',', $attributes).")
            VALUES(".implode(',', $params).")    
        ");

        foreach ($attributes as $index => $attr_name) {
            oci_bind_by_name($statement, ":$attr_name", $this->{$attr_name});
        }
//        oci_bind_by_name($statement, ":role_id", $this->{'role_id'}, -1, SQLT_INT);
//        oci_bind_by_name($statement, ":area_id", $this->{'area_id'}, -1, SQLT_INT);
//        oci_bind_by_name($statement, ":user_type", $this->{'user_type'}, -1, SQLT_INT);

        oci_execute($statement);
        return True;
    }

    /**
     * Take any input data and assign to property of the Child Model
     *
     */
    public function loadData($data): void
    {
        foreach ($data as $key => $value) {
            //  Check if each property exists, and assigns to properties of the Child Model
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}