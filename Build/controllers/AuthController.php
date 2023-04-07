<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;


class AuthController extends Controller
{


  public function login()
  {
    $this->setLayout('auth');
    return $this->render('login');
  }


  public function register(Request $request)
  {

    $user = new User();

    if ($request->isPost()) {

      $user->loadData($request->getBody());

      if ($user->validate() && $user->save()) {

        //successfull redirect to other page
        // return 'Success';

        Application::$app->session->setFlash('success', 'Thanks for registration');
        Application::$app->response->redirect('/');
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
}
    //How to do  code Refactoring in vscode????
