<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Customer;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('completeOrder', function (User $user) {
            return Customer::query()->where('id', '=', $user->id)->first();
        });
        Gate::define('administrate', function (User $user) {
            return $user->user_type == 'A';
        });
        Gate::define('ciente', function (?User $user) {
            return !$user || $user->user_type == 'C';
        });
        Gate::define('cienteNao', function (?User $user) {
            return !$user || $user->user_type != 'C';
        });
        Gate::define('funcionario', function (?User $user) {
            return !$user || $user->user_type != 'E';
        });
    }
}
