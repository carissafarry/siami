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

    /**
     * fungsi untuk mendapat koneksi ke db
     * @param  string $db_user username untuk login db
     * @param  string $db_pass password untuk login db
     * @return oci_resource|false|resource
     */
    private function konekDb($db_user, $db_pass, $connection_string='', $characterSet=null, $sessionMode=null) {
        $con = oci_connect($db_user,$db_pass, $connection_string, $characterSet, $sessionMode);

        if (!$con) {
            echo '<b>Connection failed!</b><br>' . PHP_EOL;
//               responseError('ERR-DB');
        }
        return $con;
    }

    /**
     * Query to database using defined params and values in string statement
     *
     * @return oci_resource|resource|bool
     */
    public function query($sql, $data=[])
    {
        $parse = oci_parse($this->connection, $sql);
        if ($data) {
            foreach ($data as $key => $val) {
                oci_bind_by_name($parse, $key, $data[$key]);
            }
        }
        oci_execute($parse);
        return $parse;
    }

    public function commit()
    {
        return $this->query('commit');
    }

    public function rollback(): bool
    {
        return oci_rollback($this->connection);
    }

    /**
     * Close database connection
     * @return bool
     */
    public function close(): bool
    {
        $closed = false;
        if ($this->connection) {
            //  set_error_handler(static::getErrorHandler());
            $closed = oci_close($this->connection);
            restore_error_handler();
        }
        if ($closed) {
            $this->connection = null;
        }
        return $closed;
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
//        $this->query('
//            CREATE TABLE "MIGRATIONS" (
//                ID INT PRIMARY KEY NOT NULL ,
//                MIGRATION VARCHAR(255),
//                CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//                UPDATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP
//            )
//        ');

        $this->query("
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

//        $this->query('
//            CREATE SEQUENCE "MIGRATION_SEQ" MINVALUE 1 INCREMENT BY 1 START WITH 1 NOCYCLE;
//        ');

        $this->query("
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

//        $this->query('
//            CREATE trigger "BI_MIGRATION"
//            before insert on "MIGRATIONS"
//            for each row
//            begin
//                if :NEW."ID" is null then
//                    select "MIGRATION_SEQ".nextval into :NEW."ID" from dual;
//                end if;
//            end;
//        ');

        $this->query("
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

    public function saveMigrations(array $migrations): void
    {
        //  $str = implode(",", array_map(fn($m) => "('$m')", $migrations));

        foreach ($migrations as $migration => $val) {
            $msg = $this->query("INSERT INTO MIGRATIONS (MIGRATION) VALUES ('$val')");
            echo $msg . " " . $val . PHP_EOL;
        }
    }

    protected function log($message): void
    {
        echo '['.date('Y-m-d H:i:s').'] - ' . $message . PHP_EOL;
    }
}