<?php

namespace app\admin\models\auth;

class User extends DbModel
{
    const ROLE_SPM = 0;
    const ROLE_AUDITEE = 1;
    const ROLE_AUDITOR = 2;
    const ROLE_INACTIVE = 3;

    public string $firstname = '';
    public string $lastname = '';

    public int $role_id = self::ROLE_AUDITEE;
    public int $area_id = 1;
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';
    public string $nip = '';
    public string $nama = '';
    public string $foto = '';
    public string $telp = '';
    public string $jabatan = '';
    public string $periode = '';
    public int $user_type = 1;

    public static function tableName(): string
    {
        return 'users';
    }

    public function save(): bool
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function attributes(): array
    {
        return [
            'role_id',
            'area_id',
            'email',
            'password',
            'nip',
            'nama',
            'foto',
            'telp',
            'jabatan',
            'periode'
//            'user_type'
        ];
    }

    public function labels(): array {
        return [
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password',
        ];
    }
}