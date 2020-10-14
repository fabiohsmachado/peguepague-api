<?php

namespace App\UnitOfWork;

use App\Exceptions\ReverseTransactionException;
use App\Models\Transaction;
use App\Models\User;
use App\UnitOfWork\Interfaces\ITransactionUnitOfWork;
use Illuminate\Support\Facades\DB;

class TransactionUnitOfWork implements ITransactionUnitOfWork
{
    /**
     * Register the new transaction.
     * Creates a new transaction in the database and updates its users' wallet.
     * 
     * @param User payer The payer user of the transaction.
     * @param User payee The payee user of the transaction.     
     * @param float value The transaction amount.
     */
    public function register(User $payer, User $payee, float $value) : Transaction
    {
        $transaction =  DB::transaction(
            function() use($payer, $payee, $value) {
                $transaction = Transaction::create([
                    "payer_id" => $payer->id,
                    "payee_id" => $payee->id,
                    "amount" => $value,
                    "reverse" => null
                ]);

                $payer->wallet->update();
                $payee->wallet->update();

                return $transaction;
            }
        );

        return $transaction;
    }

    /**
     * Reverts the given transaction.
     * 
     * @param Transaction transaction The transaction to reverse.
     */
    public function reverse(Transaction $transaction) : Transaction
    {
        if ($transaction->reverse != 0)
        {
            throw new ReverseTransactionException('Transaction already reversed with id ' . $transaction->reverse);
        }
        
        $reversed_transaction = DB::transaction(
            function() use ($transaction) {
                $reversed_transaction = $this->register($transaction->payee, $transaction->payer, $transaction->value);

                $transaction->reverse = $reversed_transaction->id;
                $transaction->save();

                return $reversed_transaction;
            }
        );

        return $reversed_transaction;
    }


    /**
     * Fetches the user.
     * 
     * @param int id The user id.
     */
    public function findUserById(int $id) : User
    {
        return User::find($id);
    }
}