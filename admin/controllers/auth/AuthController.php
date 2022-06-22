<?php

namespace app\admin\controllers\auth;

use app\admin\form\Login;
use app\admin\models\auth\User;
use app\admin\rules\auth\LoginRule;
use app\admin\rules\auth\UserRule;
use app\includes\App;
use app\includes\Controller;
use app\admin\middleware\AuthMiddleware;
use app\includes\Model;
use app\includes\Request;
use app\includes\Response;
use app\includes\Rule;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(
            new AuthMiddleware([
                'dashboard',
                'profile',
            ])
        );
    }

    public function index(Request $request, Response $response)
    {
        if (App::isGuest()) {
            $response->redirect('/login');
        } else {
            $response->redirect('/dashboard');
        }
    }

    public function login(Request $request, Response $response)
    {
        $loginFormModel = new Login();
        $loginRule = new LoginRule($loginFormModel);

        if ($request->isPost()) {
            $loginFormModel->loadData($request->getBody());
            if ($loginRule->validate() && $this->verify($loginFormModel, $loginRule)) {
                $response->redirect('/dashboard');
                return;
            }
        }

        if (!App::isGuest()){
            $response->redirect('/dashboard');
            return;
        }

        App::setLayout(null);
        return App::view('auth/login', [
            'rule' => $loginRule,
        ]);
    }

    /**
     * Verify if the user account is exist with the valid password
     *
     */
    public function verify(Model $loginModel, Rule $loginRule): bool
    {
//        $user = User::findOne(['email' => $loginModel->email]);
        $user_data_server = User::getUserServerData($loginModel->email, $loginModel->password);
        $user = User::findOne(['net_id' => $user_data_server->netid]);

        if (!$user) {
            $loginRule->addError('email', 'User does not exist with this email address');
            return false;
        }

        //  User data from PENS Server does not require password verify yet
//        if (!password_verify($loginModel->password, $user->password)) {
//            $loginRule->addError('password', 'Password is incorrect');
//            return false;
//        }

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
              $request = $request->getBody();

            //  Using custom request data
//            $request_data = [
//                    'nrp_id' => 2,
//                    'role_id' => 1,
//                    'area_id' => 1,
////                    'email' => $this->randomString() . '@gmail.com',
//                'email' => 'carissafarry3@gmail.com',
//                'password' => 'carissa31',
////                'nip' => $this->randomInteger(10),
////                'nama' => 'Carissa Farry',
//                'foto' => 'rissa.jpg',
//                'telp' => '085784166229',
//                'jabatan' => 'Direktur',
//                'periode' => '2022/2023',
//                'user_type' => 1,
//                'confirmPassword' => 'carissa31'
//            ];
//            $request = $request->getBody($request_data);

            $userModel->loadData($request);

            if ($userRule->validate() && $userModel->save()) {
                App::$app->session->setFlash('success', 'Thanks for registering!');
                App::$app->response->redirect('/login');
            }
        }

        App::setLayout('layout_example');
        return App::view('auth/register', [
            'rule' => $userRule,
        ]);
    }

    public function logout(Request $request, Response $response): void
    {
        App::$app->logout();
        $response->redirect('/login');
    }

    public function profile()
    {
        App::setLayout('layout');
        return App::view('auth/profile');
    }

    public function dashboard()
    {
        App::setLayout('layout');
        return App::view('spm/dashboard');
    }
}