<?php

namespace app\admin\models\auth;

use app\admin\models\auth\DbModel;
use app\admin\models\auth\User;

class Permission extends DbModel
{
    public int $id;
    public string $permission;
    public string $action = '';
    public string $method = '';
    private array $roles = [];

    public function __construct()
    {
    }

    public static function tableName(): string
    {
        // TODO: Implement tableName() method.
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
    }

    public static function primaryKey(): string
    {
        // TODO: Implement primaryKey() method.
    }

    public function getDisplay(string $attribute): string
    {
        // TODO: Implement getDisplay() method.
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