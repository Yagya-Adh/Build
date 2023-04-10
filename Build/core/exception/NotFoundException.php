<?php

namespace app\core\exception;

/**
 * 
 * @package app\core\exception
 *  
 */


class NotFountException extends \Exception
{

    protected $message = 'Page not found';
    protected $code = 404;

    public function __construct()
    {
    }
}
