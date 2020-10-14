<?php

namespace App\Providers\Operations;

use App\Operations\Interfaces\IPostTransactionOperation;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PostTransactionServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the post operation to process transactions.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Operations\Interfaces\IPostTransactionOperation', 'App\Operations\PostTransactionOperation');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [IPostTransactionOperation::class];
    }
}
