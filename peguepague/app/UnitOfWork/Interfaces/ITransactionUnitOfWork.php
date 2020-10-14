<?php

namespace App\UnitOfWork\Interfaces;

use App\Models\Transaction;
use App\Models\User;

interface ITransactionUnitOfWork
{
    /**
     * Register the new transaction.
     * 
     * @param User payer The payer user of the transaction.
     * @param User payee The payee user of the transaction.     
     * @param float value The transaction amount.
     */
    public function register(User $payer, User $payee, float $value) : Transaction;

    /**
     * Reverts the given transaction.
     * 
     * @param Transaction transaction The transaction to reverse.
     */
    public function reverse(Transaction $transaction) : Transaction;

    /**
     * Fetches the user.
     * 
     * @param int id The user id.
     */
    public function findUserById(int $id) : User;
}