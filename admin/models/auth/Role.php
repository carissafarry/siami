<?php

namespace app\admin\models\auth;

use app\admin\models\auth\DbModel;
use app\admin\models\auth\User;

class Role extends DbModel
{
    public int $id;
    public string $role;
    public string $deskripsi;
    public User $user;
    private array $permissions = [];

    public static function tableName(): string
    {
        return 'role';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'id',
            'role',
            'deskripsi',
        ];
    }

    public function getDisplay(string $attribute): string
    {
        // TODO: Implement getDisplay() method.
    }

    public function setRole(int $role_id): Role
    {
        $this->id = $role_id;
        return $this;
    }

    public function getRole()
    {
        return $this;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function fetchPermissions()
    {
        $query = App::$app->db->query(
            "SELECT * FROM ROLE_HAS_PERMISSIONS WHERE role_id = $this->id",
        );
        $nrows = oci_fetch_all($query, $res);
        foreach ($res['PERMISSION_ID'] as $key => $permission_id) {
            $permission = new Permission();
            $permission->setPermission($permission_id);
            $this->permissions[] = $permission;
        }
    }

    public function newPermission(): void
    {
        $query = App::$app->db->query_insert(
            "SELECT * FROM ROLE_HAS_PERMISSIONS WHERE role_id = $this->id",
        );
        $permission = new Permission();
//        $permission->setPermission();
        $this->permissions[] = $permission;
    }
}