<?php

namespace App\Providers\UnitOfWork;

use App\UnitOfWork\Interfaces\ITransactionUnitOfWork;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class TransactionUnitOfWorkServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the post operation to process transactions.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\UnitOfWork\Interfaces\ITransactionUnitOfWork', 'App\UnitOfWork\TransactionUnitOfWork');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ITransactionUnitOfWork::class];
    }
}
