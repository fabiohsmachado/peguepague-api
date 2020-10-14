<?php

namespace App\Providers\Services;

use App\Services\Interfaces\ITransactionAuthorizer;
use App\Services\MockTransactionAuthorizer;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AuthorizerServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the authorizer service to be used by the application.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ITransactionAuthorizer::class, 
            function($app) {
                return new MockTransactionAuthorizer(env('MOCK_AUTHORIZER_URL'));
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
        return [ITransactionAuthorizer::class];
    }
}
