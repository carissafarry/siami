<?php

namespace app\admin\models\auth;

use app\admin\models\Area;

class User extends DbModel
{
    const ROLE_SPM = 0;
    const ROLE_AUDITEE = 1;
    const ROLE_AUDITOR = 2;
    const ROLE_INACTIVE = 3;

    public int $id;
    public string $net_id;
    public int $role_id = self::ROLE_AUDITEE;
    public int $area_id = 1;
    public string $foto = '';
    public string $telp = '';
    public string $jabatan = '';
    public string $periode = '';
    public int $user_type = 1;
    public string $nip = '';
    public string $nama = '';
    public string $status = '';
    public string $group = '';
    public string $password = '';

    public Role $role;
    public Area $area;

    public function __construct()
    {
        $this->setRole();
        $this->setArea();
    }

    public function setRole()
    {
        $this->role = $this->role();
    }

    public function setArea()
    {
        $this->area = $this->area();
    }

    public static function tableName(): string
    {
        return 'USER_DETAILS';
    }

    public static function primaryKey(): string
    {
        return 'net_id';
    }

    public function save(): bool
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
//        return parent::save();
        return $this->create();
    }

    public function attributes(): array
    {
        return [
            'id',
            'net_id',
            'role_id',
            'area_id',
            'foto',
            'telp',
            'jabatan',
            'periode',
            'user_type',
            'nip',
            'nama',
            'status',
            'group',
//            'password',
        ];
    }

    public static function dbAttributes(): array
    {
        return [
            'id',
            'net_id',
            'role_id',
            'area_id',
            'foto',
            'telp',
            'jabatan',
            'periode',
            'user_type',
        ];
    }

    public function labels(): array {
        return [
            'email' => 'Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password',
        ];
    }

    public function getDisplay(string $attribute): string
    {
        return $this->$attribute;
    }

    public function role()
    {
        return self::findOne(['id' => $this->role_id], 'role', Role::class);
    }

    public function area()
    {
        return self::findOne(['id' => $this->area_id], 'area', Area::class);
    }

    public static function getUserServerData(string $email, string $password='')
    {
        $header=array("netid: $email","password: ". base64_encode($password));
        $data = curl_init();
        curl_setopt($data, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($data, CURLOPT_HTTPHEADER, $header);
        curl_setopt($data, CURLOPT_URL, "https://login.pens.ac.id/auth/");
        curl_setopt($data, CURLOPT_TIMEOUT, 9);

        $hasil = curl_exec($data);
        curl_close($data);

//        return json_decode($hasil);

        //  Temporary dummy data
        $hasil = [
            'Name' => 'Idris Winarno',
            'Status' => 'active',
//            'NIP' => '198203082008121001',
            'NIP' => '2103191050',
//            'netid' => 'idris@pens.ac.id',
            'netid' => $email,
            'Group' => '2f40358a-95dd-4e82-94f1-5ffff9ce6710',
        ];

//        $hasil = [
//            'Name' => 'Carissa Farry Hilmi Az Za',
//            'Status' => 'active',
//            'NRP' => '2103191050',
//            'netid' => 'carissafarry@it.student.pens.ac.id',
//            'Group' => '2f40358a-95dd-4e82-94f1-5ffff9ce6710',
//        ];
        return (object) $hasil;
    }
}