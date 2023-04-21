<?php

namespace App\Providers;

use App\Models\Driver;
use App\Policies\DriverPolicy;
use App\Models\Trip;
use App\Policies\TripPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Driver::class => DriverPolicy::class,
        Trip::class => TripPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        \Gate::define('viewWebSocketsDashboard', function ($user = null) {
            return in_array($user?->email || 'admin@app.com', [
                'admin@app.com',
                'habib@app.com',
                'test@app.com',
            ]);
        });
    }
}
