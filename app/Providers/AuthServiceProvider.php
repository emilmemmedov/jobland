<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('add-category',function (User $user){
            if($user->getAttribute('user_type') === User::USER_TYPE_ADMIN){
                return true;
            }
            else{
                return false;
            }
        });
        Gate::define('create-vacation',function (User $user){
            if($user->getAttribute('user_type') === User::USER_TYPE_BUSINESSMAN){
                return true;
            }
            else{
                return false;
            }
        });

        Gate::define('create-assignment',function (User $user){
            if($user->getAttribute('user_type') === User::USER_TYPE_BUSINESSMAN){
                return true;
            }
            else{
                return false;
            }
        });
    }
}
