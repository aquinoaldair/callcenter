<?php

namespace App\Providers;

use App\Models\Option;
use App\Models\Question;
use App\Models\Script;
use App\Models\User;
use App\Policies\QuestionPolice;
use App\Policies\RolePolicy;
use App\Policies\ScriptPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Role::class     => RolePolicy::class,
        User::class     => UserPolicy::class,
        Script::class   => ScriptPolicy::class,
        Question::class => QuestionPolice::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
        //
    }
}
