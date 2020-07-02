<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
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
        //Passport::routes();
        Passport::tokensCan([
          'view-orders' => 'View orders',
          'view-users' => 'View users',
        ]);
        Passport::setDefaultScope([
            'view-users',
        ]);

        Gate::define('isAdmin', function($user){
          return $user->type==='admin';
        });

        Gate::define('isBooster', function($user){
          return $user->type==='booster';
        });

        Gate::define('isCoach', function($user){
          return $user->type==='coach';
        });

        Gate::define('isBoosterOrCoach', function($user){
          return $user->type==='coach' || $user->type==='booster';
        });

        Gate::define('isWorkerOrAdmin', function($user){
          return $user->type==='coach' || $user->type==='booster' || $user->type==='admin';
        });

        Gate::define('isClient', function($user){
          return $user->type==='client';
        });


        Passport::routes();
        Passport::enableImplicitGrant();
        //
    }
}
