<?php

namespace App\Policies;

use App\Models\User;
use App\Table;
use Illuminate\Auth\Access\HandlesAuthorization;

class TablePolicy
{
    use HandlesAuthorization;
    


    /**
     * Determine whether the user can view the table.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->can('view-tables');
    }

    /**
     * Determine whether the user can update the table.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->can('create-tables');
    }

    /**
     * Determine whether the user can update the table.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function edit(User $user)
    {
        return $user->can('update-tables');
    }

    /**
     * Determine whether the user can update the table.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->can('update-tables');
    }

    /**
     * Determine whether the user can delete the table.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->can('delete-tables');
    }
}
