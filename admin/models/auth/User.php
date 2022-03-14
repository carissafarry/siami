<?php

namespace app\admin\models\auth;

class User extends DbModel
{
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';

    public function tableName(): string
    {
        return 'user';
    }

    public function register()
    {
//        echo 'Creating new user';
        return $this->save();
    }

    /**
     * Take any input data and assign to property of the Child Model
     *
     */
    public function loadData($data): void
    {
        foreach ($data as $key => $value) {
            //  Check if each property exists, and assigns to properties of the Child Model
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function attributes(): array
    {
        return ['firstname', 'lastname', 'email', 'password'];
    }

//    public function rules(): array
//    {
//        return [
//            'firstname' => [self::RULE_REQUIRED],
//            'lastname' => [self::RULE_REQUIRED],
//            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
//            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
//            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
//        ];
//    }
}