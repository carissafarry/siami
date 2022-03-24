<?php

namespace app\admin\controllers\auth;

use app\admin\models\auth\LoginForm;
use app\admin\models\auth\User;
use app\admin\rules\auth\LoginRule;
use app\admin\rules\auth\UserRule;
use app\includes\App;
use app\includes\Controller;
use app\includes\middleware\AuthMiddleware;
use app\includes\Model;
use app\includes\Request;
use app\includes\Response;
use app\includes\Rule;

class AuthController extends Controller
{
    public Model $userModel;
    public Rule $userRule;

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function index()
    {
        $this->setLayout('layout_example');
        return $this->view('spm/home');
    }

    public function login(Request $request, Response $response)
    {
        $loginFormModel = new LoginForm();
        $loginRule = new LoginRule($loginFormModel);

        if ($request->isPost()) {
            $loginFormModel->loadData($request->getBody());
            if ($loginRule->validate() && $this->verify($loginFormModel, $loginRule)) {
                $response->redirect('/');
                return;
            }
        }
        $this->setLayout('layout_example');
        return $this->view('auth/login', [
            'rule' => $loginRule,
        ]);
    }

    /**
     * Verify if the user account is exist with the valid password
     *
     */
    public function verify(Model $loginModel, Rule $loginRule)
    {
        $user = User::findOne(['email' => $loginModel->email]);

        if (!$user) {
            $loginRule->addError('email', 'User does not exist with this email address');
            return false;
        }
        if (!password_verify($loginModel->password, $user->password)) {
            $loginRule->addError('password', 'Password is incorrect');
            return false;
        }

        return App::$app->login($user);
    }

    /**
     * Register new user account
     *
     */
    public function register(Request $request)
    {
        $userModel = new User();
        $userRule = new UserRule($userModel);

        if ($request->isPost()) {
            //  Using default request data from GET / POST method
//              $request = $request->getBody();

            //  Using custom request data
            $request_data = [
//                    'role_id' => 1,
//                    'area_id' => 1,
//                    'email' => $this->randomString() . '@gmail.com',
                'email' => 'carissafarry3@gmail.com',
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

            $userModel->loadData($request);

            if ($userRule->validate() && $userModel->save()) {
                App::$app->session->setFlash('success', 'Thanks for registering!');
                App::$app->response->redirect('/');
            }

            return $this->view('auth/register', [
                'rule' => $userRule,
            ]);
        }

        $this->setLayout('layout_example');
        return $this->view('auth/register', [
            'rule' => $this->userRule,
        ]);
    }

    public function logout(Request $request, Response $response): void
    {
        App::$app->logout();
        $response->redirect('/login');
    }

    public function profile()
    {
        $this->setLayout('layout_example');
        return $this->view('auth/profile');
    }

    public function layout1()
    {
        $this->setLayout('layout1');
        return $this->view('spm/dashboard');
    }
}