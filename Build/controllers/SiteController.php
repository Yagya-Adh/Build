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
    public function contact()
    {

        return $this->render('contact');
    }

    /* contact page on post or, while button is submited  */

    public function handleContact(Request $request)
    {
        $body = $request->getBody();

        // echo "<pre>";
        // var_dump($body);
        // echo "</pre>";
        // exit;

        return "Hnadle submitted data";
    }
}
