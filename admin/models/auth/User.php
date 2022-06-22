<?php

namespace app\admin\models\auth;

use app\admin\models\Area;
use app\admin\models\Auditee;
use app\admin\models\Auditor;
use app\admin\models\Spm;

class User extends DbModel
{
    const ROLE_SPM = 1;
    const ROLE_AUDITEE = 2;
    const ROLE_AUDITOR = 3;
    const ROLE_INACTIVE = 0;

    public int $id=0;
    public string $net_id = '';
    public int $role_id = self::ROLE_SPM;
    public int $area_id = 0;
    public ?string $foto = '';
    public string $telp = '';
    public string $jabatan = '';
    public string $periode = '';
    public int $user_type = 0;
    public string $nip = '';
    public string $nama = '';
    public string $status = '';
    public string $group = '';
    public string $password = '';

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

    public function autoIncrements(): array
    {
        return [
            'id',
        ];
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

    public function sequence(): string
    {
        return 'USER_DETAILS_SEQ';
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

    public function save(): bool
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
//        return parent::save();
        return $this->create();
    }

    public function role()
    {
        return self::findOne(['id' => $this->role_id], 'role', Role::class);
    }

    public function area()
    {
        return self::findOne(['id' => $this->area_id], 'area', Area::class);
    }

    public function auditee()
    {
        return self::findOne(
            [
                'user_type' => 3,
                'user_id' => $this->id,
            ],
            'auditee',
            Auditee::class
        );
    }

    public function auditor()
    {
        return self::findOne(
            [
                'user_type' => 2,
                'user_id' => $this->id,
            ],
            'auditor',
            Auditor::class
        );
    }

    public function child_class()
    {
        switch ($this->user_type) {
            case 1:
                $child_class = Spm::class;
                $child_table = Spm::getTableName();
                break;
            case 2:
                $child_class = Auditor::class;
                $child_table = Auditor::getTableName();
                break;
            case 3:
                $child_class = Auditee::class;
                $child_table = Auditee::getTableName();
                break;
        }

        return self::findOne(
            [
                'user_type' => $this->user_type,
                'user_id' => $this->id,
            ],
            $child_table,
            $child_class
        );
    }

    public static function getUserServerData(string $email, string $password='')
    {
        $header = array("netid: $email","password: ". base64_encode($password));
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
            'Name' => 'Nama ini dari server',
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