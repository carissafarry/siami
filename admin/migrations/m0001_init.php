<?php

namespace app\admin\migrations;

use app\includes\App;

class m0001_init {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        echo 'Applying migration' . PHP_EOL;
        $db = App::$app->db;
        $db->query('
            CREATE TABLE "USERS2" (	
                ID NUMBER,
                ROLE_ID NUMBER, 
                AREA_ID NUMBER, 
                EMAIL VARCHAR2(255 BYTE), 
                PASSWORD VARCHAR2(255 BYTE), 
                NIP VARCHAR2(255 BYTE), 
                NAMA VARCHAR2(255 BYTE), 
                FOTO VARCHAR2(255 BYTE), 
                TELP VARCHAR2(255 BYTE), 
                JABATAN VARCHAR2(255 BYTE), 
                PERIODE VARCHAR2(255 BYTE), 
                CREATED_AT TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
                UPDATED_AT TIMESTAMP (6) WITH LOCAL TIME ZONE DEFAULT CURRENT_TIMESTAMP, 
                USER_TYPE NUMBER
           )
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        echo 'Down migrate' . PHP_EOL;
        $db = App::$app->db;
        $db->query('
            DROP TABLE "USERS2"
        ');
    }
}
