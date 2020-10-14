<?php

namespace App\Services\Interfaces;

interface ITransactionAuthorizer
{
    /**
     * Authorizes the given transaction made by the given payer.
     * 
     * @return bool Whther the authorizaton proceeded with success or not.
     */
    public function authorize() : bool;
}