<?php

namespace app\admin\models\auth;

use app\includes\App;
use app\includes\exception\NotFoundException;
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
     * Define primary key of record
     *
     */
    abstract public static function primaryKey(): string;

    /**
     * Define auto incremented attributes of table
     *
     */
    abstract public function autoIncrements(): array;

    /**
     * Define sequence name of table
     *
     */
    abstract public function sequence(): string;

    /**
     * Define attribute of table
     *
     */
    abstract public function attributes(): array;

    /**
     * Get attribute value that will be displayed to the user
     *
     */
//    abstract public function getDisplay(string $attribute): string;
    public function getDisplay(string $attribute) {
        return $this->$attribute;
    }

    /**
     * Create new record from request data using defined attributes in child model
     * @param $attributes
     * @return bool
     */
    public function create($attributes=null): bool
    {
        $sql = "INSERT INTO";
        return $this->query($sql, null, null, $attributes);
    }

    /**
     * Update existing record from request data using defined attributes in child model
     * @return bool
     */
    public function update(): bool
    {
        $primary_key = static::primaryKey();
        $where = [$primary_key => $this->{$primary_key}];
        $clause = 'UPDATE';
        $target_clause = 'SET';
        return $this->query($clause, $target_clause, $where, null, null);
    }

    /**
     * Delete record from request data using defined attributes in child model
     * @param null $where
     * @return bool
     */
    public function delete($where): bool
    {
        $sql = "DELETE FROM";
        return $this->query($sql, null, $where, null, null);
    }

    /**
     * Find single data from records that fulfill specified conditions
     * @param null $where array Define conditions that will be used in Where clause.
     * @param null $table String From which table the query will be executed.
     * @param null $return_class_type object Define what type of object/class that will be returned.
     * @param null $fetched_data If data has been fetched, returns as specific class object.
     * @return object|Model|false
     */
    public static function findOne($where=null, $table=null, $return_class_type=null, $fetched_data=null, $attr=null)
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

            if ($attr) {
                return $newObj->$attr;
            }

            return $newObj;
        }
        return $oci_obj;
    }

    /**
     * Find all data from records that fulfill specified conditions
     * @param $table String From which table the query will be executed.
     * @param $where array Define conditions that will be used in Where clause.
     * @param $return_class_type object Define what type of object/class that will be returned.
     * @param $sql string Give SQL query defined in string.
     *
     */
    public static function findAll($table=null, $where=null, $return_class_type=null, $sql=null, $attr=null): array
    {
        $tableName = $table ?: self::getTableName();

        if ($where) {
            $attributes = array_keys($where);
            $conditions = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        }

        $stmt = "SELECT * FROM $tableName" . ($where ? " WHERE $conditions" : '');
        $query = App::$app->db->query($sql ?: $stmt, $where);

        $res = [];
        $oci_obj = oci_fetch_all($query, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $datas = [];

        if ($oci_obj) {
            foreach ($res as $row) {
                $data = self::findOne(null, $table, $return_class_type, $row);
                if ($attr) {
                    $data = $data->$attr;
                }
                $datas[] = $data;
            }
        }
        return $datas;
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
    public function findManyToMany($table, $on_params_with_pivot, $on_params_with_target, $return_class_type, $where=null, ?array $select_columns=null, bool $distinct=false, $obj_attr=null, $order_by=null): array
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
        $columns_target = $targetName . ".*";
        $conditions = '';
        $where_value = null;
        if ($where) {
            $conditions = implode(" AND ", array_map(fn($attr) => "$attr = :" . explode('.',$attr)[1], array_keys($where)));
            foreach ($where as $key => $val) {
                $where_value[explode('.',$key)[1]] = $val;
            }
        }

        if ($select_columns) {
            $columns_target = implode(', ', $select_columns);
        }

        $sql = "
          SELECT " . (($distinct) ? "DISTINCT " : "") . "$columns_target
          FROM $tableName
            INNER JOIN $pivotName
                ON $table_on_params
            INNER JOIN $targetName
                ON $pivot_on_params 
          WHERE $conditions
        ";

        return self::findAll($table, $where_value, $return_class_type, $sql, $obj_attr);
    }

    /**
     * Find single data or returns fail if data does not exist
     * @return DbModel|object
     * @throws NotFoundException
     */
    public static function findOrFail($where=null, $table=null, $return_class_type=null, $fetched_data=null, $attr=null)
    {
        $result = self::findOne($where, $table, $return_class_type, $fetched_data, $attr);
        if (!$result) {
            throw new NotFoundException();
        }
        return $result;
    }

    /**
     * Query to database using defined params and values from called model attributes
     * @param $clause
     * @param string|null $target_clause
     * @param null $where
     * @param null $param
     * @return bool
     */
    public function query($clause, string $target_clause=null, $where=null, $param=null)
    {
        $called_function = debug_backtrace()[1]['function'];
        $tableName = self::getTableName();
        $attributes = (method_exists(static::class, "dbAttributes")) ? static::dbAttributes() : $this->attributes();
        $fillable_attrs = array_diff($attributes, $this->autoIncrements());
        $query = '';

        switch ($called_function) {
            case "create":
//                $params = array_map(fn($attr) => ":$attr", $attributes);
                $params = array_map(fn($attr) => ":$attr", $fillable_attrs);
//                $statement = "$clause $tableName (" . implode(', ', $attributes) . ") VALUES(" . implode(', ', $params) . ");";
                $statement = "$clause $tableName (" . implode(', ', $fillable_attrs) . ") VALUES(" . implode(', ', $params) . ")";
                $data = array_combine(
//                    array_map(fn($attr) => ":$attr", $attributes),
                    array_map(fn($attr) => ":$attr", $fillable_attrs),
//                    array_map(fn($attr) => $this->{$attr}, $attributes)
                    array_map(fn($attr) => $this->{$attr}, $fillable_attrs)
                );
                echo '<pre>';
                var_dump($statement, $data);
                echo '</pre>';
//                exit();
                $query = App::$app->db->query($statement, $data);
                break;
            case "update":
                $fillable_attrs = $where ? array_diff($fillable_attrs, array_keys($where)) : $fillable_attrs;
//                $params = implode(', ', array_map(fn($attr) => "$attr = '" . (string)$this->{$attr} . "'", $attributes));
                $params = implode(', ', array_map(fn($attr) => "$attr = '" . (string)$this->{$attr} . "'", $fillable_attrs));
                $conditions = $where ? implode(' AND ', array_map(fn($attr) => "$attr = '" . (string)$this->{$attr} . "'", array_keys($where))) : '';
                $statement = "$clause $tableName $target_clause $params" . ($where ? " WHERE $conditions " : ' ');
                $query = App::$app->db->query($statement);
                App::$app->db->commit();
                break;
            case "delete":
                $conditions = $where ? implode(' AND ', array_map(fn($attr) => "$attr = '" . (string)$this->{$attr} . "'", array_keys($where))) : '';
                $statement = "$clause $tableName WHERE $conditions";
                $query = App::$app->db->query($statement);
                App::$app->db->commit();
                break;
        }

        return True;
    }

    public function getCurrentValue()
    {
        $sequence_name = $this->sequence();
        $stmt = 'SELECT "' . $sequence_name . '"' . '.currval from dual';
        $query = App::$app->db->query($stmt);
        $oci_obj = oci_fetch_object($query);
        return $oci_obj->CURRVAL;
    }

    public static function getLastInsertedRow($table=null)
    {
        $tableName = $table ?: self::getTableName();
        $stmt = "SELECT * FROM $tableName WHERE ROWID=(SELECT MAX(ROWID) FROM $tableName)";
        $result = self::findAll(null, null, null, $stmt);
        return $result[0];
    }
}