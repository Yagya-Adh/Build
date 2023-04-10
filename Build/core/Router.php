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
            // $this->response->setStatusCode(404);
            //    return "Not found";
            // return $this->renderView("_error");
            throw new NotFountException();
        }


        /* function callback */
        if (is_string($callback)) {
            return $this->renderView($callback);
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
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response);
    }



    /* template engine development part */
    public function renderView($view, $params = [])
    {

        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent); //replaces the {{content}} and renders files like home .php and contact.php soon
    }

    protected function layoutContent()
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();  //cache of outputs
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php"; //thhis is included
        return ob_get_clean();  //returns the outputing to browser and clear the buffer
    }


    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }


        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }



    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
}
