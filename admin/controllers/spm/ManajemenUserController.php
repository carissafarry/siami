<?php

namespace app\admin\controllers\spm;

use app\admin\middleware\AuthMiddleware;
use app\admin\models\auth\User;
use app\includes\App;
use app\includes\Controller;
use app\includes\Request;
use app\includes\Response;

class ManajemenUserController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(
            new AuthMiddleware([
                'index',
            ])
        );
    }

    public function index(Request $request, Response $response)
    {
        $res = User::findAll('users',null);
        App::setLayout('layout');
        return App::view('spm/manajemen_user/index', [
            'users' => $res
        ]);
    }

    public function detail(Request $request, Response $response, $param)
    {
        $res = User::findAll('users',null);
        App::setLayout('layout');
        return App::view('spm/manajemen_user/detail', [
            'users' => $res
        ]);
    }

    public function add(Request $request, Response $response, $param)
    {
        $res = User::findAll('users',null);
        App::setLayout('layout');
        return App::view('spm/manajemen_user/add', [
            'users' => $res
        ]);
//        echo '<pre>';
//        var_dump($param['id']);
//        echo '</pre>';
//        exit;
    }
}