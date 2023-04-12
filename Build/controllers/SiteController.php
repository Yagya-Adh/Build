<?php

namespace app\controllers;


/**
 * 
 * @author Yagya Adhikari
 * @package app\controllers
 */

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;

class SiteController extends Controller
{

    public function home()
    {
        $params = [
            'name' => "Yagya Adhikari",
        ];

        return $this->render('home', $params);
    }


    /* contact page on get or, normal */
    public function contact(Request $request, Response $response)
    {
        $contact = new ContactForm();

        if ($request->isPost()) {
            $contact->loadData($request->getBody());
            if ($contact->validate() && $contact->send()) {

                Application::$app->session->setFlash('success', 'Thanks for contacting us.');
                return $response->redirect('/contact');
            }
        }
        return $this->render('contact', [
            'model' => $contact  //here model is pass to view/contact.php
        ]);
    }
}
