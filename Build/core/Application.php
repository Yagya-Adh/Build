<?php

namespace app\core;

/**
 *
 * @author yagya <yagyaadhikari02@gmail.com>
 * @package   app\core
 */

class Application
{
    public string $layout = 'main';
    public Session $session;
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;

    public Database $db;

    public string $userClass;
    public ?DbModel $user;  //? before any instance or, variavle represents null or, something

    public static Application $app;
    public ?Controller $controller = null;

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

        $this->userClass = $config['userClass'];

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::finfOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }


    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {


            $this->response->setStatusCode($e->getCode());

            echo $this->router->renderView('_error', [
                'exception' => $e
            ]);
        }
    }


    public function getController(\app\core\Controller $controller)
    {
        $this->controller = $controller;
    }


    public function setController(\app\core\Controller $controller): void
    {
        $this->controller = $controller;
    }



    //login
    public function login(DbModel $user)
    {
        //we just into save the user into session 


        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }


    //logout
    public function logout(DbModel $user)
    {
        //we just into save the user into session 


        $this->user = null;
        $this->session->remove('user');
    }
}
