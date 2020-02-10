<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view the product.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->can('view-users');
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create-users');
    }

    /**
     * Determine whether the user can update the product.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function edit(User $user)
    {
        return $user->can('update-users');
    }

    /**
     * Determine whether the user can update the product.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->can('update-users');
    }

    /**
     * Determine whether the user can delete the product.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->can('delete-users');
    }

}
