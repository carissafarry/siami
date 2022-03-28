<?php

namespace app\admin\models\auth;

class Permission
{
    public int $id;
    public string $permission;
    private array $roles = [];
}