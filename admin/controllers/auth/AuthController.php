<?php

namespace app\admin\controllers\auth;

use app\admin\rules\auth\RegisterRule;
use app\includes\Controller;
use app\includes\Request;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('main');
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

        $this->setLayout('main');
        return $this->view('auth/register', [
            'rule' => $registerRule
        ]);
    }
}