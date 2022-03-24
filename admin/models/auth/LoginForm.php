<?php

namespace app\admin\models\auth;

use app\includes\App;
use app\includes\Model;

class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';

    public function labels(): array {
        return [
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}