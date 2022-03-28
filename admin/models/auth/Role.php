<?php

namespace app\admin\models\auth;

class Role extends DbModel
{
    public int $id;
    public string $role;
    public string $deskripsi;
    public User $user;
    private array $permissions = [];

    public static function tableName(): string
    {
        return 'ROLE';
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

    public function getPermissions()
    {
        return $this->findManyToMany(
            self::tableName(),
            ['ROLE.ID' => 'ROLE_HAS_PERMISSIONS.ROLE_ID'],
            ['ROLE_HAS_PERMISSIONS.PERMISSION_ID' => 'PERMISSION.ID'],
            Permission::class,
            ['ROLE.ID' => $this->id]
        );
    }
}