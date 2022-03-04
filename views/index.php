<?php
require_once dirname(__DIR__) . '/admin/init.php';

use app\admin\controllers\auth\AuthController;
use app\admin\controllers\HomeController;
use \app\includes\App;

$app = new App();
$app->router->get('/', function () {
    return 'Hello World dari router "/"';
});

// $app->router->get('/contact', 'contact');
// $app->router->post('/contact', function () {
//     return 'handling submitted data';
// });
// $app->router->get('/contact', [HomeController::class, 'satu']);
$app->router->get('/contact', [new HomeController(), 'satu']);
$app->router->get('/form', [new HomeController(), 'form']);
$app->router->post('/form', [new HomeController(), 'handleForm']);
$app->router->get('/login', [new AuthController(), 'login']);
$app->router->post('/login', [new AuthController(), 'login']);
$app->router->get('/register', [new AuthController(), 'register']);
$app->router->post('/register', [new AuthController(), 'register']);

$app->run();