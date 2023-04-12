<?php

namespace app\core;

use app\core\exception\NotFountException;

/**
 * Router constructor
 * 
 * @param \app\core\Request $request
 * @param \app\core\Request $request
 * 
 */

class Router
{
    public Request $request;
    public Response $response;

    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }


    /* get */

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /* post  */
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }


    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        //now callback
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            throw new NotFountException();
            // return "Not found";
        }


        /* function callback */
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }


        /* array callback */
        if (is_array($callback)) {
            /* creating instance of conrtoller */

            /**  @var app\core\Controller $controller  */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            //middleware start
            foreach ($controller->getMiddleware() as $middleware) {
                $middleware->execute(); // middleware execute here
            }
        }

        return call_user_func($callback, $this->request, $this->response);
    }
}
