<?php

namespace App\Operations;

use App\Models\Transaction;
use App\Models\User;
use App\Services\Interfaces\ITransactionAuthorizer;
use App\Exceptions\OperationException;
use App\Jobs\NotifyTransaction;
use App\Operations\Interfaces\IPostTransactionOperation;
use App\UnitOfWork\Interfaces\ITransactionUnitOfWork;

class PostTransactionOperation implements IPostTransactionOperation
{
    /**
     * Class constructor with injected authorizer.
     * 
     * @param ITransactionAuthorizer authorizer The injected authorizer service to user.
     */
    function __construct(ITransactionAuthorizer $authorizer, ITransactionUnitOfWork $unitOfWork)
    {
        $this->authorizer = $authorizer;
        $this->unitOfWork = $unitOfWork;
    }

    /**
     * Process the post transaction operation by requesting an authorizer and then notifying the payee.
     * 
     * @param array payload The request payload to process.
     */
    public function process(array $payload) : Transaction
    {
        if(!$this->authorizer->authorize())
        {
            throw new OperationException('Unauthorized transaction.', 403);
        }

        $payer = $this->unitOfWork->findUserById($payload['payer']);
        $payer->wallet->subtract($payload['value']);

        $payee = $this->unitOfWork->findUserById($payload['payee']);
        $payee->wallet->add($payload['value']);
        
        $transaction = $this->unitOfWork->register($payer, $payee, $payload['value']);
        dispatch(new NotifyTransaction($transaction));

        return $transaction;
    }
}