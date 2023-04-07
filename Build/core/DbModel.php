<?php

/**
 * 
 * User : Yagya
 * @author Yagya
 * @package app\core
 */

namespace app\core;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;
    abstract public function attributes(): array;

    //trick
    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn ($attr) => ":$attr", $attributes);
        //Dynamic sts
        $statement = self::prepare("INSERT INTO  $tableName(" . implode(',', $attributes) . ") 
                    VALUES(" . implode(',', $params) . ")");


        echo "<pre>";
        var_dump($statement, $params, $attributes);
        echo "<pre>";
        exit;


        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }


    //we can populate prepare everywhere now 
    public static function prepare($sql)
    {
        return  Application::$app->db->pdo->prepare($sql);
    }
}
