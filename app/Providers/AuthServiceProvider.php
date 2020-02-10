<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Table;
use App\Policies\CategoryPolicy;
use App\Policies\ProductPolicy;
use App\Policies\TablePolicy;
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

            $ROLE_MANAGER = config('constants.ROLE_MANAGER');
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
