<?php
require_once dirname(__DIR__) . '/admin/init.php';

use app\admin\controllers\auth\AuthController;
use \app\includes\App;

$app = new App();

//$app->router->get('/', function () {
//    return 'Hello World dari router "/"';
//});

$app->router->get('/', [new AuthController(), 'index']);

//$app->router->get('/contact', 'contact');       // use string argument to display directly from a view file
$app->router->get('/login', [new AuthController(), 'login']);
$app->router->post('/login', [new AuthController(), 'login']);
$app->router->get('/register', [new AuthController(), 'register']);
$app->router->post('/register', [new AuthController(), 'register']);
$app->router->get('/layout1', [new AuthController(), 'layout1']);
$app->router->get('/logout', [new AuthController(), 'logout']);
$app->router->get('/profile', [new AuthController(), 'profile']);
$app->router->get('/role', [new AuthController(), 'role']);

$app->run();