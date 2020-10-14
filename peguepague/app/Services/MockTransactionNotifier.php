<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\ITransactionNotifier;
use Illuminate\Support\Facades\Http;

class MockTransactionNotifier implements ITransactionNotifier
{
    /**
     * Base class constructor.
     * 
     * @param string url The service url to call.
     */
    function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Simulate the notification by calling the mock service.
     *
     * @param User $user The user to notify.
     * @return bool Wheter the response contains the "Autorizado" message.
     */
    public function notify(User $user) : bool
    {
        return Http::get($this->url)['message'] == 'Enviado';
    }
}