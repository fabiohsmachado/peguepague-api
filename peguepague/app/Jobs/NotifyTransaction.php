<?php

namespace App\Jobs;

use App\Exceptions\NotifyTransactionException;
use App\Models\Transaction;
use App\Services\Interfaces\ITransactionNotifier;

class NotifyTransaction extends Job
{
    protected $transaction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     * 
     * @param Transaction transaction The transaction to notify.
     *
     * @return void
     */
    public function handle()
    {
        $notifier = app(ITransactionNotifier::class);
        if(!$notifier->notify($this->transaction->payee))
        {
            throw new NotifyTransactionException("Fail to notify user. Attempt: " . $this->attempts() . ".");
        }
        
        $this->transaction->notified = true;
        $this->transaction->update();
    }
}