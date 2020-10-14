<?php

namespace App\Http\Controllers;

use App\Enums\DocumentType;
use App\Enums\UserType;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Models\Wallet;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => [
                'required',
                'unique:App\Models\User,email'
            ],
            'password' => 'required',
            'document_type' => [
                'required',
                new EnumValue(DocumentType::class),
                'unique:App\Models\User,document_type,NULL,NULL,document,' . $request['document'],
            ],
            'document' => [
                'required',
                'unique:App\Models\User,document,NULL,NULL,document_type,' . $request['document_type'],
            ],
            'user_type' => [
                'required',
                 new EnumValue(UserType::class)
            ]
        ]);

        if($validator->fails())
        {
            return Response()->json(['errors' => $validator->errors()], 400);
        };

        $user = User::create($validator->validated());
        Wallet::create(['user_id' => $user->id, 'initial_balance' => 1000, 'balance' => 1000]);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = User::find($id);
        if ($user == null)
        {
            return Response('', 404);
        };
        
        return new UserResource($user);
    }
}
