<?php

namespace app\admin\controllers\auth;

use app\includes\Controller;
use app\includes\Request;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('auth');       // !  masih belum kepake
        return $this->view('auth/login');
    }

    public function register(Request $request)
    {
        if ($request->isPost()) {
            return 'Handle submitted data';
        }
        $this->setLayout('auth');       // !  masih belum kepake
        return $this->view('auth/register');
    }
}