<?php

namespace app\admin\models\auth\handler;

use app\admin\models\auth\User;
use app\admin\models\auth\Role;

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