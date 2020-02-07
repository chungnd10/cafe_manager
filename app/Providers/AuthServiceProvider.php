<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Permission;
use App\Policies\CategoryPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Category::class => CategoryPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user) {

            $ROLE_MANAGER = config('constants.role_manager');
            if ($user->role_id === $ROLE_MANAGER) {
                return true;
            }
        });

        if (! $this->app->runningInConsole()){
            foreach (Permission::all() as $permission) {
                Gate::define($permission->name, function ($user) use ($permission){
                   return $user->hasPermission($permission);
                });
            }
        }
    }
}
