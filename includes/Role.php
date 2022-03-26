<?php

namespace app\includes;

class Role
{
    public int $id;
    public string $role;
    private array $permissions = [];

    public function __construct()
    {

    }

    public function setRole(int $role_id): Role
    {
        $this->id = $role_id;
        return $this;
    }

    public function getRole(): int
    {
        return $this->id;
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

//    abstract public function setPermission(int $id);
}