<?php
require_once __DIR__ . '/admin/init.php';

use app\admin\controllers\auth\AuthController;
use app\admin\controllers\spm\ManajemenUserController;
use \app\includes\App;

$app = new App();

//$app->router->get('/', function () {
//    return http_redirect('/login');
//});
$app->router->get('/', [new AuthController(), 'index']);
//$app->router->get('/contact', 'contact');       // use string argument to display directly from a view file

$app->router->get('/login', [new AuthController(), 'login']);
$app->router->post('/login', [new AuthController(), 'login']);
$app->router->get('/register', [new AuthController(), 'register']);
$app->router->post('/register', [new AuthController(), 'register']);
$app->router->get('/logout', [new AuthController(), 'logout']);

$app->router->get('/dashboard', [new AuthController(), 'dashboard']);
$app->router->get('/profile', [new AuthController(), 'profile']);

$app->router->get('/spm/manajemen-user', [new ManajemenUserController(), 'index']);
$app->router->get('/spm/manajemen-user/add', [new ManajemenUserController(), 'add']);
$app->router->get('/spm/manajemen-user/detail/{id}', [new ManajemenUserController(), 'detail']);
$app->router->get('/spm/manajemen-user/update/{id}', [new ManajemenUserController(), 'update']);
$app->router->post('/spm/manajemen-user/update/{id}', [new ManajemenUserController(), 'update']);
$app->router->get('/spm/manajemen-user/save/{id}', [new ManajemenUserController(), 'save']);
$app->router->get('/spm/manajemen-user/delete/{id}', [new ManajemenUserController(), 'delete']);

$app->run();