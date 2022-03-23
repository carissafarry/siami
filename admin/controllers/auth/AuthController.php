<?php

namespace app\admin\controllers\auth;

use app\admin\models\auth\User;
use app\admin\rules\auth\UserRule;
use app\includes\App;
use app\includes\Controller;
use app\includes\Model;
use app\includes\Request;
use app\includes\Rule;

class AuthController extends Controller
{
    public Model $userModel;
    public Rule $userRule;

    public function __construct()
    {
        $this->userModel = new User();
        $this->userRule = new UserRule($this->userModel);
    }

    public function index()
    {
        $this->setLayout('layout_example');
        return $this->view('spm/home');
    }

    public function login()
    {
        $this->setLayout('layout_example');
        return $this->view('auth/login');
    }

    public function register(Request $request)
    {
        if ($request->isPost()) {
            //  Using default request data from GET / POST method
//              $request = $request->getBody();

            //  Using custom request data
            $request_data = [
//                    'role_id' => 1,
//                    'area_id' => 1,
//                    'email' => $this->randomString() . '@gmail.com',
                'email' => 'carissafarry2@gmail.com',
                'password' => 'carissa31',
                'nip' => $this->randomInteger(10),
                'nama' => 'Carissa Farry',
                'foto' => 'rissa.jpg',
                'telp' => '085784166229',
                'jabatan' => 'Direktur',
                'periode' => '2022/2023',
                'confirmPassword' => 'carissa31a'
            ];
            $request = $request->getBody($request_data);

            $this->userModel->loadData($request);

            if ($this->userRule->validate() && $this->userModel->save()) {
                App::$app->session->setFlash('success', 'Thanks for registering!');
                App::$app->response->redirect('/');
                //                return 'Success';
            }

            return $this->view('auth/register', [
                'rule' => $this->userRule,
            ]);
        }

        $this->setLayout('layout_example');
        return $this->view('auth/register', [
            'rule' => $this->userRule,
        ]);
    }

    public function layout1()
    {
        $this->setLayout('layout1');
        return $this->view('spm/dashboard');
    }

    public function storage()
    {
        return APP_ROOT;
    }
}