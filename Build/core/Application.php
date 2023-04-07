<?php

namespace app\core;

/**
 *
 * @author yagya <yagyaadhikari02@gmail.com>
 * @package   app\core
 */

class Application
{
    public Session $session;

    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;

    public Database $db;

    public static Application $app;
    public Controller $controller;

    public function __construct($rootPath, array $config)
    {

        self::$ROOT_DIR = $rootPath; //rootpath of project

        self::$app = $this; //

        $this->request = new Request();

        $this->response = new Response();

        $this->session = new Session();  ///session

        $this->router = new Router($this->request, $this->response);

        $this->controller = new Controller();

        //Database 
        $this->db = new Database($config['db']);
    }

    public function run()
    {
        echo $this->router->resolve();
    }





    public function getController(\app\core\Controller $controller)
    {
        $this->controller = $controller;
    }


    public function setController(\app\core\Controller $controller): void
    {
        $this->controller = $controller;
    }
}
