<?php

namespace app\admin\models\auth;

use app\includes\App;
use app\includes\Model;
use phpDocumentor\Reflection\Types\This;

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
     * Define primary key of record
     *
     */
    abstract public static function primaryKey(): string;

    /**
     * Get attribute value that will be displayed to the user
     *
     */
    abstract public function getDisplay(string $attribute): string;

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

    /**
     * Find data from records that fulfill specified conditions
     *
     */
    public static function findOne($where)
    {
        $tableName = self::getTableName();
        $attributes = array_keys($where);
        $conditions = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));

        $stmt = "SELECT * FROM $tableName WHERE $conditions";
        $query = App::$app->db->query($stmt, $where);
        //  return oci_fetch_object($query);

        $oci_obj = oci_fetch_object($query);
        if ($oci_obj) {
            $arr_oci_obj = (array)$oci_obj;
            $userObj = new User();
            //  array_walk($arr_oci_obj, function(&$val, $key) use ($userObj) {
            foreach ($arr_oci_obj as $key => $val) {
                $varName = strtolower($key);
                $userObj->{$varName} = $val;
            }
            return $userObj;
        }
        return $oci_obj;
    }
}