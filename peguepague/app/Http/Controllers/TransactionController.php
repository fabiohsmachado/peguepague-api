<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Transaction::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation_rules = [
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

        $validation_messages = [
            'payer.exists' => 'Payer must exist and cannot be a ' . UserType::Shopkeeper()->description . '.'
        ];
        
        $validator = Validator::make($request->all(), $validation_rules, $validation_messages);

        if($validator->fails())
        {
            return Response()->json(['errors' => $validator->errors()], 400);
        };

        $payload = $validator->validated();

        Transaction::create([
            "payer_id" => $payload['payer'],
            "payee_id" => $payload['payee'],
            "amount" => $payload['value']
        ]);
        $payer_wallet = User::find($payload['payer'])->wallets->first();
        $payer_wallet->subtract($payload['value']);
        
        $payee_wallet = User::find($payload['payee'])->wallets->first();
        $payee_wallet->add($payload['value']);

        $payer_wallet->save();
        $payee_wallet->save();
    }
}