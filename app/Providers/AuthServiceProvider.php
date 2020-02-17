<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use App\Models\Order;
use App\Policies\OrderPolicy;
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
        Order::class => OrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function (User $user) {
            $ROLE_SUPER_ADMIN = config('constants.ROLE_SUPER_ADMIN');
            if ($user->role_id === $ROLE_SUPER_ADMIN) {
                return true;
            }
        });

        if (! $this->app->runningInConsole()){
            foreach (Permission::all() as $permission) {
                Gate::define($permission->name, function (User $user) use ($permission){
                   return $user->hasPermission($permission);
                });
            }
        }
    }
}
