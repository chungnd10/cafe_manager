<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Table;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\ProductPolicy;
use App\Policies\TablePolicy;
use App\Policies\UserPolicy;
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
        Category::class => CategoryPolicy::class,
        Product::class => ProductPolicy::class,
        Table::class => TablePolicy::class,
        User::class => UserPolicy::class,
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

            $ROLE_SUPER_ADMIN = config('constants.ROLE_SUPER_ADMIN');
            if ($user->role_id === $ROLE_SUPER_ADMIN) {
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
