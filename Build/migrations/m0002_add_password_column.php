<?php

use app\core\Application;

/**
 * 
 * User: Yagya
 * 
 * */


class m0002_add_password_column
{
    public function up()
    {
        $db = Application::$app->db;
        $db->pdo->prepare("ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL;")->execute();
    }


    public function down()
    {
        $db = Application::$app->db;
        $db->pdo->prepare("ALTER TABLE users DROP COLUMN password;")->execute();
    }
}
