<?php

namespace app\admin\form;

use app\includes\Model;

class Login extends Model
{
    public string $email = '';
    public string $password = '';

    public function labels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}