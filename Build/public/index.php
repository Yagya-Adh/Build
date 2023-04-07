<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use app\controllers\SiteController;
use app\controllers\AuthController;
use \app\core\Application;

require_once __DIR__ . '/../vendor/autoload.php';

/* connection of .env  db*/
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [new SiteController(), 'home']);
$app->router->get('/contact', [new SiteController(), 'contact']);
$app->router->post('/contact', [new SiteController(), 'handleContact']);

$app->router->get('/login', [new AuthController(), 'login']);
$app->router->post('/login', [new AuthController(), 'login']);
$app->router->get('/register', [new AuthController(), 'register']);
$app->router->post('/register', [new AuthController(), 'register']);

$app->run();
