<?php

namespace app\core;

use app\core\Application;
use app\core\middlewares\BaseMiddleware;

class Controller
{
    public string $layout = 'main';

    public string $action = '';

    /**
     * @var app\core\middlewares\BaseMiddleware[]
     */


    protected array $middleware = [];

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }


    /* render */
    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }



    //middleware
    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middleware[] = $middleware;
    }



    public function getMiddleware(): array
    {
        return $this->middleware;
    }
}
