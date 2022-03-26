<?php

namespace app\includes\handler;

use app\admin\models\auth\User;
use app\includes\Role;

class PermissionHandler
{
    private User $user;
    private Role $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }
}