<?php

namespace App\Repositories\Role;

use App\Repositories\EloquentRepository;
use App\Models\Role;

class RoleRepository extends EloquentRepository
{
    /**
     * Get model
     * @return string
     */
    public function getModel()
    {
        return Role::class;
    }

    public function getAll()
    {
        $role_super_admin = config('constants.ROLE_SUPER_ADMIN');
        $roles = $this->_model->where('id', '<>', $role_super_admin)->get();

        return $roles;

    }
}
