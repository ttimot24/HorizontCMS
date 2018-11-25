<?php

namespace App\Providers;

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
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('accessAdminArea',function($user) {
            return $user->isAdmin() && $user->isActive();
        });


        $prefix = \Config::get('horizontcms.backend_prefix');

        if($this->app->request->is($prefix.'*') && !$this->app->request->is($prefix.'/install*') 
                                                && !$this->app->request->is($prefix.'/login*')){

            Gate::define('global-authorization',function($user) use ($prefix) {

                if($this->app->request->segment(2) == null || $this->app->request->is($prefix.'/dashboard*')){
                    return true;
                }


                if(!in_array(str_replace("-","",$this->app->request->segment(2)),$user->role->rights)){
                    return false;
                }

                return true;
            });
        }

    }
}
