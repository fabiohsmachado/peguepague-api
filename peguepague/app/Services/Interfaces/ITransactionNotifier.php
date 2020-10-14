<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface ITransactionNotifier
{
    /**
     * Authorizes the given transaction made by the given payer.
     * 
     * @param User $user The user to notify.
     * @return bool Whther the authorizaton proceeded with success or not.
     */
    public function notify(User $user) : bool;
}