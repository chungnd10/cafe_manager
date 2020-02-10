<?php
namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\EloquentRepository;

class UserRepository extends EloquentRepository
{
    public function getModel()
    {
        return User::class;
    }

    public function datatables()
    {
        $users = User::join('roles', 'roles.id', '=', 'users.role_id')
            ->select(
                'users.id',
                'full_name',
                'avatar',
                'phone_number',
                'roles.name as role_name'
            )
            ->orderBy('id', 'desc')
            ->get();
        return $users;
    }
}
