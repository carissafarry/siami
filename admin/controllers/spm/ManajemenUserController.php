<?php

namespace app\admin\controllers\spm;

use app\admin\middleware\AuthMiddleware;
use app\admin\models\auth\Role;
use app\admin\models\auth\User;
use app\admin\rules\spm\manajemen_user\AddUserRule;
use app\admin\rules\spm\manajemen_user\UpdateUserRule;
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
        $users = User::findAll();

        App::setLayout('layout');
        return App::view('spm/manajemen_user/index', [
            'users' => $users
        ]);
    }

    public function add(Request $request, Response $response)
    {
        $user = new User();
        $userDataRule = new AddUserRule($user);
        $roles = Role::findAll();

        if ($request->isPost()) {
            $request = $request->getBody();
            $user->loadData($request);

            if ($userDataRule->validate() && $user->create()) {
                App::$app->session->setFlash('success', 'Data berhasil ditambahkan!');
                $response->redirect('/spm/manajemen-user');
            }
        }

        App::setLayout('layout');
        return App::view('spm/manajemen_user/add', [
            'user' => $user,
            'roles' => $roles,
            'rule' => $userDataRule,
        ]);
    }

    public function detail(Request $request, Response $response, $param)
    {
        $user = User::findOrFail($param);

        App::setLayout('layout');
        return App::view('spm/manajemen_user/detail', [
            'user' => $user
        ]);
    }

    /**
     * @throws \app\includes\exception\NotFoundException
     */
    public function update(Request $request, Response $response, $param)
    {
        $user = User::findOrFail($param);
        $userDataRule = new UpdateUserRule($user);
        $roles = Role::findAll();

        if ($request->isPost()) {
            $request = $request->getBody();
            $user->loadData($request);

            if ($userDataRule->validate() && $user->update()) {
                App::$app->session->setFlash('success', 'Data berhasil diupdate!');
                $response->redirect('/spm/manajemen-user');
            }
        }

        App::setLayout('layout');
        return App::view('spm/manajemen_user/update', [
            'user' => $user,
            'roles' => $roles,
            'rule' => $userDataRule,
        ]);
    }

    /**
     * @throws \app\includes\exception\NotFoundException
     */
    public function delete(Request $request, Response $response, $param): void
    {
        $user = $this->repo(User::findOrFail($param));
        if ($user->delete($param)) {
            App::$app->session->setFlash('success', 'Data berhasil dihapus!');
            $response->back();
            return ;
        }
        App::$app->session->setFlash('failed', 'Data gagal dihapus!');
        $response->back();
    }
}