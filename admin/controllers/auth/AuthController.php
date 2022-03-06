<?php

namespace app\admin\controllers\auth;

use app\admin\rules\auth\RegisterRule;
use app\includes\Controller;
use app\includes\Request;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('layout_example');
        return $this->view('auth/login');
    }

    public function register(Request $request)
    {
        $registerRule = new RegisterRule();

        if ($request->isPost()) {
            $request = $request->getBody();
            $registerRule->loadData($request);

            if ($registerRule->validate() && $registerRule->register()) {
                return 'Success';
            }

            return $this->view('auth/register', [
                'rule' => $registerRule
            ]);
        }

        $this->setLayout('layout_example');
        return $this->view('auth/register', [
            'rule' => $registerRule
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