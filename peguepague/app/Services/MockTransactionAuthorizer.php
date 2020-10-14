<?php

namespace App\Services;

use App\Services\Interfaces\ITransactionAuthorizer;
use Illuminate\Support\Facades\Http;

class MockTransactionAuthorizer implements ITransactionAuthorizer
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
     * Simulate the authorization by calling the mock service.
     * 
     * @return bool Wheter the response contains the "Autorizado" message.
     */
    public function authorize() : bool
    {
        return Http::get($this->url)['message'] == 'Autorizado';
    }
}