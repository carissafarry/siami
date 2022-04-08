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
    public static function findOne($where=null, $table=null, $return_class_type=null, $fetched_data=null)
    {
        $oci_obj = $fetched_data;

        if ($where) {
            $tableName = $table ?: self::getTableName();
            $attributes = array_keys($where);
            $conditions = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));

            $stmt = "SELECT * FROM $tableName WHERE $conditions";
            $query = App::$app->db->query($stmt, $where);
            $oci_obj = oci_fetch_object($query);
        }

        if ($oci_obj) {
            $arr_oci_obj = (array)$oci_obj;
            $called_class = static::class;
            $newObj = $return_class_type ? new $return_class_type() : new $called_class();
            foreach ($arr_oci_obj as $key => $val) {
                $varName = strtolower($key);
                $newObj->{$varName} = $val;
            }

            //  If the object looked for is user, assign user data from server to each user model
            if (get_class($newObj) === User::class) {
                $user_server_data = User::getUserServerData($newObj->net_id);
                $newObj->nip = $user_server_data->NIP;
                $newObj->nama = $user_server_data->Name;
                $newObj->status = $user_server_data->Status;
                $newObj->group = $user_server_data->Group;
            }

            return $newObj;
        }
        return $oci_obj;
    }

    public static function findAll($table=null, $where=null, $return_class_type=null, $sql=null)
    {
        $tableName = $table ?: self::getTableName();

        if ($where) {
            $attributes = array_keys($where);
            $conditions = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        }

        $stmt = "SELECT * FROM $tableName " . ($where ? "WHERE $conditions" : '');
        $query = App::$app->db->query($sql ?: $stmt, $where);

        $oci_obj = oci_fetch_all($query, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $data = [];

        if ($oci_obj) {
            foreach ($res as $row) {
                $data[] = self::findOne(null, $table, $return_class_type, $row);
            }
        }
        return $data;
    }

    /**
     * Find data related with defined table, in many-to-many relationship
     * @param $table String From which table the query will be executed.
     * @param $on_params_with_pivot array Define table and column that will have relation both from first table and pivot table.
     * @param $on_params_with_target array Define table and column that will have relation both from pivot table and target table.
     * @param $return_class_type object Define what type of object/class that will be returned.
     * @param $where array Define conditions that will be used in Where clause.
     * @return array The result of executed query from findAll() function.
     */
    public function findManyToMany($table, $on_params_with_pivot, $on_params_with_target, $return_class_type, $where=null): array
    {
        $tableName = $table;
        $table_on_params = implode(" ON ", array_map(function($val, $key) {
                return "$key = $val";
            }, $on_params_with_pivot, array_keys($on_params_with_pivot)));

        $pivotName = strtok(array_values($on_params_with_pivot)[0], '.');
        $pivot_on_params = implode(" ON ", array_map(function($val, $key) {
            return "$key = $val";
        }, $on_params_with_target, array_keys($on_params_with_target)));

        $targetName = strtok(array_values($on_params_with_target)[0], '.');
        $conditions = '';
        $where_value = null;
        if ($where) {
            $conditions = implode(" AND ", array_map(fn($attr) => "$attr = :" . explode('.',$attr)[1], array_keys($where)));
            foreach ($where as $key => $val) {
                $where_value[explode('.',$key)[1]] = $val;
            }
        }

        $sql = "
          SELECT $targetName.*
          FROM $tableName
            INNER JOIN $pivotName
                ON $table_on_params
            INNER JOIN $targetName
                ON $pivot_on_params 
        " . $where ? " WHERE $conditions" : '';

        return self::findAll($table, $where_value, $return_class_type, $sql);
    }
}