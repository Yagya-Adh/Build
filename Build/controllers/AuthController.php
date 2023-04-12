<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;


class AuthController extends Controller
{

  public function __construct()
  {
    $this->registerMiddleware(new AuthMiddleware(['profile']));    //middleware , to restric profile only
  }

  public function login(Request $request, Response $response)
  {
    $loginForm = new LoginForm();
    if ($request->isPost()) {
      $loginForm->loadData($request->getBody());
      if ($loginForm->validate() && $loginForm->login()) {

        $response->redirect('/');
        return;
      }
    }

    $this->setLayout('auth');
    return $this->render('login', [
      'model' => $loginForm
    ]);
  }


  public function register(Request $request)
  {

    $user = new User();

    //if success return success message also
    if ($request->isPost()) {
      $user->loadData($request->getBody());
      if ($user->validate() && $user->save()) {
        Application::$app->session->setFlash('success', 'Thanks for registration');
        Application::$app->response->redirect('/');
        exit;
      }


      // echo "<pre>";
      // print_r($user->errors);
      // echo "</pre>";
      // exit; 

      /* else display register form  */
      return $this->render('register', [
        'model' => $user
      ]);
    }

    $this->setLayout('auth'); // wants to render auth layout 
    return $this->render('register', [
      'model' => $user
    ]);
  }


  public function logout(Request $request, Response $response)
  {
    Application::$app->logout(); ///attribute should me present
    $response->redirect('/');
  }




  public function profile()
  {
    return $this->render('profile');
  }
}
