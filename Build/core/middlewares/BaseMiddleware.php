<?php

namespace app\core\middlewares;

/**
 * @author Yagya
 * @package app\core\middlewares
 * 
 */

abstract class BaseMiddleware
{
    abstract public function execute();
}
