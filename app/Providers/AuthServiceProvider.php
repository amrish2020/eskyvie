<?php

namespace App\Providers;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Schema;
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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Schema::defaultStringLength(191);

        Gate::define('isClientAdmin',function($user){
            return $user->role === 1;
        });
        Gate::define('isAdmin',function($user){
            return $user->role === 1;
        });
        Gate::define('isSalesMgr',function($user){
            return $user->role === 3;
        });
        Gate::define('isSalesExec',function($user){
            return $user->role === 4;
        });
        Gate::define('isMarMgr',function($user){
            return $user->role === 5;
        });
        Gate::define('isMarExec',function($user){
            return $user->role === 6;
        });
        Gate::define('isCustomer',function($user){
            return $user->role == 7;
        });
        Gate::define('isMarExecOrMarMgr',function($user){
            return $user->role == 5 || $user->role == 6;
        });
        Gate::define('isSaleExecOrSaleMgr',function($user){
            return $user->role == 3 || $user->role == 4;
        });

        Passport::routes();
        //
    }
}
