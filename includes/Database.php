<?php

namespace app\includes;

class Database
{
    protected $connection;

    /**
     * @return oci_resource|false|resource
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Database constructor
     */
    public function __construct($username=DB_USERNAME, $password=DB_PASSWORD, $connection_string='//' . DB_HOST . ':' . DB_PORT . '/' . DB_SERVICE, $characterSet=null, $sessionMode=null)
    {
        //  Connection to PENS Database
        //  $connection = $this->konekDb('PA0004', '473098', "10.252.209.213/orcl.mis.pens.ac.id");

        //  Connection to a local Oracle Database
        $this->connection = $this->konekDb($username, $password, $connection_string, $characterSet, $sessionMode);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(APP_ROOT . '/admin/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once APP_ROOT . '/admin/migrations/' . $migration;

            $className = pathinfo($migration, PATHINFO_FILENAME);

            //  If migration file not using namespace
            //  $instance = new $className();

            //  If migration file using namespace
            $instance_namespace = "app\admin\migrations\\$className";
            $instance = new $instance_namespace();

            $this->log("Apply migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations are applied");
        }
    }

    public function createMigrationsTable()
    {
//        $this->query_insert('
//            CREATE TABLE "MIGRATIONS" (
//                ID INT PRIMARY KEY NOT NULL ,
//                MIGRATION VARCHAR(255),
//                CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//                UPDATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP
//            )
//        ');

        $this->query_insert("
            DECLARE
            v_sql LONG;
            BEGIN
            v_sql:='
                    CREATE TABLE MIGRATIONS (
                     ID INT PRIMARY KEY NOT NULL ,
                     MIGRATION VARCHAR(255),
                     CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                     UPDATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    )
                   ';
            EXECUTE IMMEDIATE v_sql;
            EXCEPTION
                WHEN OTHERS THEN
                    IF SQLCODE = -955 THEN
                        NULL;
                    ELSE
                        RAISE;
                    END IF;
            END;
        ");

//        $this->query_insert('
//            CREATE SEQUENCE "MIGRATION_SEQ" MINVALUE 1 INCREMENT BY 1 START WITH 1 NOCYCLE;
//        ');

        $this->query_insert("
            BEGIN
            EXECUTE IMMEDIATE 'CREATE SEQUENCE MIGRATION_SEQ MINVALUE 1 INCREMENT BY 1 START WITH 1 NOCYCLE';
            EXCEPTION
                WHEN OTHERS THEN
                    IF SQLCODE = -955 THEN
                        NULL;
                    ELSE
                        RAISE;
                    END IF;
            END;
        ");

//        $this->query_insert('
//            CREATE trigger "BI_MIGRATION"
//            before insert on "MIGRATIONS"
//            for each row
//            begin
//                if :NEW."ID" is null then
//                    select "MIGRATION_SEQ".nextval into :NEW."ID" from dual;
//                end if;
//            end;
//        ');

        $this->query_insert("
            DECLARE
            v_sql LONG;
            BEGIN
            v_sql:='
                    CREATE trigger BI_MIGRATION
                    BEFORE INSERT ON MIGRATIONS
                    FOR EACH ROW
                    BEGIN
                        IF :NEW.ID IS NULL THEN
                            SELECT MIGRATION_SEQ.NEXTVAL INTO :NEW.ID FROM DUAL;
                        END IF;
                    END;
                    ';
            EXECUTE IMMEDIATE v_sql;
            EXCEPTION
                WHEN OTHERS THEN
                    IF SQLCODE = -4081 THEN
                        NULL;
                    ELSE
                        RAISE;
                    END IF;
            END;
        ");
    }

    public function getAppliedMigrations()
    {
        $stmt = oci_parse(
            $this->connection,
            "SELECT MIGRATION FROM MIGRATIONS"
        );
        oci_execute($stmt, OCI_DEFAULT);
        $nrows = oci_fetch_all($stmt, $res);
        return $res['MIGRATION'];
    }

    public function saveMigrations(array $migrations)
    {
        //  $str = implode(",", array_map(fn($m) => "('$m')", $migrations));

        foreach ($migrations as $migration => $val) {
            $msg = $this->query_insert("INSERT INTO MIGRATIONS (MIGRATION) VALUES ('$val')");
            echo $msg . " " . $val . PHP_EOL;
        }
    }

    protected function log($message)
    {
        echo '['.date('Y-m-d H:i:s').'] - ' . $message . PHP_EOL;
    }

    public function close()     // belum kepake
    {
        $isSuccess = false;
        if ($this->connection) {
            //  set_error_handler(static::getErrorHandler());
            $isSuccess = oci_close($this->connection);
            restore_error_handler();
        }

        if ($isSuccess) {
            $this->connection = null;
        }

        return $isSuccess;
    }

    /**
     * fungsi untuk mendapat koneksi ke db
     * @param  string $db_user username untuk login db
     * @param  string $db_pass password untuk login db
     * @return oci_resource|false|resource
     */
    function konekDb($db_user, $db_pass, $connection_string='') {
        $con = oci_connect($db_user,$db_pass, $connection_string);

        if (!$con) {
            echo '<b>Connection failed!</b><br>' . PHP_EOL;
//               responseError('ERR-DB');
        } else {
            echo '<b>Oracle DB and PHP Connected!</b><br>' . PHP_EOL;
        }

        return $con;
    }

    function query_select($sql)
    {
        $stmt = oci_parse($this->connection, $sql);
        oci_execute($stmt, OCI_DEFAULT);

        while (oci_fetch($stmt)) {
            echo "    " . oci_result($stmt, "TEST") . "<br>\n";
        }
        echo "----done<br>\n";
    }

    /**
     * eksekusi query db
     * untuk memudahkan penulisan saja
     * karena oracle membutuhkan
     * beberapa langkah
     *
     * @param  oci_resource $con variable koneksi oci
     * @param  string $sql query yang di jalankan
     * @return oci_resource|false|resource
     */
    function query_view($sql, $data)
    {
        $parse = oci_parse($this->connection, $sql);
        foreach ($data as $key => $val) {
            oci_bind_by_name($parse, $key, $data[$key]);
        }
        oci_execute($parse);
        return $parse;
    }

    function query_insert($sql, $data=[])
    {
        $parse = oci_parse($this->connection, $sql);
        if (!$parse) {
            $oerr = oci_error($this->connection);
            echo "Fetch Code 1:". $oerr["message"];
            exit;
        }
        foreach ($data as $key => $val) {
            oci_bind_by_name($parse, $key, $data[$key]);
        }
        oci_execute($parse);
        if (oci_num_rows($parse)>0)
            return "Success Insert";
        else
            return "Failed Insert";
    }

    function query_update($sql, $data)
    {
        $parse = oci_parse($this->connection, $sql);
        foreach ($data as $key => $val) {
            oci_bind_by_name($parse, $key, $data[$key]);
        }
        oci_execute($parse);
        if (oci_num_rows($parse)>0)
            return "Success Update";
        else
            return "Failed Update";
    }

    function query_delete($sql, $data)
    {
        $parse = oci_parse($this->connection, $sql);
        foreach ($data as $key => $val) {
            oci_bind_by_name($parse, $key, $data[$key]);
        }
        oci_execute($parse);
        if (oci_num_rows($parse)>0)
            return "Success Delete";
        else
            return "Failed Delete";
    }

    public function query($sql, $data=[])
    {
        $parse = oci_parse($this->connection, $sql);
        foreach ($data as $key => $val) {
            oci_bind_by_name($parse, $key, $data[$key]);
        }
        oci_execute($parse);
        if (oci_num_rows($parse)>0)
            echo ">=1 rows effected" . PHP_EOL;
        else
            echo "0 row effected" . PHP_EOL;

        return $parse;
    }
}