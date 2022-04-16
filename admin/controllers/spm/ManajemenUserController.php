<?php

namespace app\admin\controllers\spm;

use app\admin\middleware\AuthMiddleware;
use app\admin\models\auth\Role;
use app\admin\models\auth\User;
use app\admin\rules\spm\UserDataRule;
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
        $res = User::findAll();

        App::setLayout('layout');
        return App::view('spm/manajemen_user/index', [
            'users' => $res
        ]);
    }

    public function detail(Request $request, Response $response, $param)
    {
        $res = User::findOrFail($param);
        App::setLayout('layout');
        return App::view('spm/manajemen_user/detail', [
            'user' => $res
        ]);
    }

    public function add(Request $request, Response $response, $param)
    {
        App::setLayout('layout');
        return App::view('spm/manajemen_user/add');
    }

    public function update(Request $request, Response $response, $param)
    {
        $user = User::findOrFail($param);
        $roles = Role::findAll();

        if ($request->isPost()) {
            $request = $request->getBody();
            $userDataRule = new UserDataRule($user);
            $user->loadData($request);

            if ($user->update()) {
//                Tampilkan session data berhasil diubah
//                redirect ke halaman sebelumnya
                App::$app->session->setFlash('success', 'Data berhasil diupdate!');
//                App::$app->response->redirect('/login');
                $response->redirect('/spm/manajemen-user');
                return;
            }

            App::setLayout('layout');
            return App::view('spm/manajemen_user/update', [
                'user' => $user
            ]);
        }


        App::setLayout('layout');
        return App::view('spm/manajemen_user/update', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function save(Request $request, Response $response, $param)
    {
//        var_dump($param["id"]);
        $res = User::findOne($param);
        App::setLayout('layout');
        return App::view('spm/manajemen_user/edit', [
            'user' => $res
        ]);
    }

    public function delete(Request $request, Response $response, $param)
    {
        $res = User::findOne($param);
        App::setLayout('layout');
        return App::view('spm/manajemen_user/detail', [
            'user' => $res
        ]);
    }
}