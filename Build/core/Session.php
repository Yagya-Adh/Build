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
        foreach ($flashMessages as $key => &$flashMessages) {      ////
            //Marked to be removed
            $flashMessages['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;

        // echo "<pre>";
        // var_dump($_SESSION[self::FLASH_KEY]);
        // echo "</pre>";
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'removed' => false,
            'value' => $message,
        ];
    }


    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function __destruct()
    {
        //Iterate over marked to be removed
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {      ////flash messages
            if ($flashMessage['remove']) {
                unset($flashMessage[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}
