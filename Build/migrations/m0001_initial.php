<?php

use app\core\Application;

/**
 * 
 * user:Yagya
 * Date:
 * Time:
 * 
 * 
 */


//class name  cannot start with digit must start with string
class m0001_initial
{

    public function up()
    {
        $db = Application::$app->db;
        //sql create statement
        $SQL = "CREATE TABLE users(
            id INT AUTO_INCREMENT PRIMARY_KEY,
            email VARCHAR(255) NOT NULL,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            status TINYINT NOT_NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;";

        $db->pdo->exec($SQL);
    }



    public function down()
    {
        $db = Application::$app->db;
        //sql drop statement
        $SQL = "DROP TABLE users;";

        $db->pdo->exec($SQL);
    }
}
