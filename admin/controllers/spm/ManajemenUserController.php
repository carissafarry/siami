<?php

namespace app\admin\controllers\spm;

use app\admin\middleware\AuthMiddleware;
use app\admin\models\Area;
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
                'add',
                'detail',
                'update',
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
        $areas = Area::findAll();

        if ($request->isPost()) {
            $request = $request->getBody();

            //  TODO validate wether inputted net_id exists in server database
//            $user_server_data = User::getUserServerData($request['net_id'], '');
//            $user_data = User::findOne(['net_id' => $user_server_data->netid]);
//
//            if (!$user_data) {
//                $userDataRule->addError('net_id', 'User with this Net ID does not exist!');
//            }

            $request['user_type'] = $request['role_id'];
            $user->loadData($request);

            if ($userDataRule->validate() && $user->create()) {
                $child_user_table_name = ucwords(Role::findOne(['id' => $request['role_id']])->role);
                $child_user_table_name = "\app\admin\models\\$child_user_table_name";

                $child_table_class = new $child_user_table_name();
                $child_table_class->user_id = $user->getCurrentValue();
                if($child_table_class->create()) {
                    App::$app->session->setFlash('success', 'Data berhasil ditambahkan!');
                    $response->redirect('/spm/manajemen-user');
                }
            }
        }

        App::setLayout('layout');
        return App::view('spm/manajemen_user/add', [
            'user' => $user,
            'roles' => $roles,
            'areas' => $areas,
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
        $areas = Area::findAll();

        if ($request->isPost()) {
            $request = $request->getBody();
            $request['user_type'] = $request['role_id'];
            $prev_child_user = $user->child_class();
            $user->loadData($request);

            //  If there is no new child class in new request data
            if (!$user->child_class()) {
                if ($prev_child_user->delete(['user_id' => $user->id])) {
                    $child_user_table_name = ucwords(Role::findOne(['id' => $request['role_id']])->role);
                    $child_user_table_name = "\app\admin\models\\$child_user_table_name";

                    $child_table_class = new $child_user_table_name();
                    $child_table_class->user_id = $user->id;
                }
            }

            if ($userDataRule->validate() && $user->update()) {
                if (!$user->child_class()) {
                    $child_table_class->create();
                }
                App::$app->session->setFlash('success', 'Data berhasil diupdate!');
                $response->redirect('/spm/manajemen-user');
            }
        }

        App::setLayout('layout');
        return App::view('spm/manajemen_user/update', [
            'user' => $user,
            'roles' => $roles,
            'areas' => $areas,
            'rule' => $userDataRule,
        ]);
    }

    /**
     * @throws \app\includes\exception\NotFoundException
     */
    public function delete(Request $request, Response $response, $param): void
    {
        $user = User::findOrFail($param);
        $user_child_class = $user->child_class();

        if ($user_child_class->delete(['user_id' => $user->id]) && $user->delete($param)) {
            App::$app->session->setFlash('success', 'Data berhasil dihapus!');
            $response->back();
        }
    }
}