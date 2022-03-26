<?php

namespace app\includes;

use app\admin\models\auth\User;

class Permission
{
    public int $id;
    public string $permission;
    public string $action = '';
    public string $method = '';
    private array $roles = [];

    public function __construct()
    {
    }

    public function setPermission(int $id): Permission
    {
        $this->id = $id;
        return $this;
    }

    public function getPermission()
    {
        return $this->id;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function fetchRoles()
    {
        $query = App::$app->db->query(
            "SELECT * FROM ROLE_HAS_PERMISSIONS WHERE permission_id = $this->id",
        );
        $nrows = oci_fetch_all($query, $res);
        foreach ($res['ROLE_ID'] as $key => $role_id) {
            $role = new Role();
            $role->setRole($role_id);
            $this->roles[] = $role;
        }
    }
}