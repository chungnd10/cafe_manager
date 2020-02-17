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

    public function getAll()
    {
        $users = $this->_model->with('role')->latest('id')->get();
        return $users;
    }
}
