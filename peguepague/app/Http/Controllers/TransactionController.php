<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Exceptions\OperationException;
use App\Models\Transaction;
use App\Operations\Interfaces\IPostTransactionOperation;
use App\Operations\TransactionOperation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * The class constructor with and injected operation.
     * 
     * @param TransactionOperation  operation
     */
    function __construct()
    {
        $this->validation_rules = [
            'payer' => [
                'required',
                Rule::exists('App\Models\User', 'id')->where(function ($query) {
                    $query->where('user_type', '!=', UserType::Shopkeeper);
                })
            ],
            'payee' => [
                'required', 
                'exists:App\Models\User,id'
            ],
            'value' => 'required',
        ];

        $this->validation_messages = [
            'payer.exists' => 'Payer must exist and cannot be a ' . UserType::Shopkeeper()->description . '.'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Transaction::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, IPostTransactionOperation $operation)
    {
        $validator = Validator::make($request->all(), $this->validation_rules, $this->validation_messages);

        if($validator->fails())
        {
            return Response()->json(['errors' => $validator->errors()], 400);
        };
        
        try
        {
            $payload = $validator->validated();
            $operation->process($payload);
        }
        catch(OperationException $exception)
        {
            return Response()->json(['errors' => $exception->getMessage()], $exception->getCode());
        }
        catch(Exception $exception)
        {
            return Response('', 500);
        }
    }
}