<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\ForbiddenException\ForbiddenException;

/**
 * @package app\core\middleware
 */


class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];

    /**
     * @param array $actions
     *     
     */

    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }



    public function  execute()
    {
        if (Application::isGuest()) {
            if (empty($this->actions) || is_array(Application::$app->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}
