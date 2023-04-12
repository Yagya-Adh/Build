<?php

namespace app\core\form;

use app\core\Model;

/**
 * 
 * @author 
 * 
 * @package app\core\form
 * 
 * */
class Form
{
    //spirintf()  -go and  look it for 
    public static function begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form(); //instance of Form ?????????
    }


    public  static function end()
    {
        echo '</form>';
    }



    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }
}
