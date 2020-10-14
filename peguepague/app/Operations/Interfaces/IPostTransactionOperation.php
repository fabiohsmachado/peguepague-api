<?php

namespace App\Operations\Interfaces;

use App\Models\Transaction;

interface IPostTransactionOperation
{
    /**
     * Process the given payload and returns the created transaction.
     * 
     * @param array payload The request payload to process.
     */
    public function process(array $payload) : Transaction;
}