<?php

namespace app\includes;

class Database
{
    public \PDO $pdo;

    /**
     * Database constructor
     */
    public function __construct()
    {
        $this->pdo = new \PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

}