<?php

namespace App\Providers\Services;

use App\Services\Interfaces\ITransactionNotifier;
use App\Services\MockTransactionNotifier;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class TransactionNotifierServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the notifier service to be used by the application.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ITransactionNotifier::class, 
            function($app) {
                return new MockTransactionNotifier(env('MOCK_NOTIFIER_URL'));
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ITransactionNotifier::class];
    }
}
