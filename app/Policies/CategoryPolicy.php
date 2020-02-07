<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->can('view-categories');
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->can('create-categories');
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return mixed
     */
    public function edit(User $user)
    {
        return $user->can('update-categories');
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->can('update-categories');
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return mixed
     */
    public function delete(User $user, Category $category)
    {
        return $user->can('delete-categories');
    }

}
