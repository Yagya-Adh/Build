<?php

/**
 * 
 * User : Yagya
 * @author Yagya
 * @package app\core
 */

namespace app\core\db;

use app\core\Application;
use app\core\Model;

//base active record class 
abstract class DbModel extends Model
{
    abstract public function tableName(): string;
    abstract public function attributes(): array;
    abstract public function primaryKey(): string;


    //trick to insert or, save the data into databse tables
    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn ($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName(" . implode(',', $attributes) . ") 
                VALUES(" . implode(',', $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute}); //
        }
        $statement->execute();
        return true;
    }


    //we can populate prepare statement everywhere now 
    public static function prepare($sql)
    {
        return  Application::$app->db->pdo->prepare($sql);
    }


    public function findOne($where) //where is assoc array  eg:- [email=>yagya@mail.com,firstname=>yagya]
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        //SELECT * FROM tableName WHERE email  = :email AND  firstname = : firstname


        $statement->execute();
        return $statement->fetchObject(static::class);
    }
}

/*
 echo "<pre>";
 var_dump($statement, $params, $attributes);
 echo "<pre>";
 exit;      
 */