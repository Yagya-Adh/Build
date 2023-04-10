<?php

/**
 * 
 * Class : Session
 * User : Yagya
 * @author Yagya
 *  @package app\core 
 */

namespace app\core;


class Session
{

    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            //we can take sub array by refrence 
            //Mark to be removed
            $flashMessage['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message,
        ];
    }


    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }


    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }


    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }



    public function __destruct()
    {
        //Iterate over marked to be removed
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {      ////flash messages
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);  //unset() to remove flashmessages
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}
