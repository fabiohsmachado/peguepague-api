<?php

namespace App\Http\Controllers;

use App\Enums\DocumentType;
use App\Enums\UserType;
use App\Models\User;
use App\Http\Resources\UserResource;
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
        return UserResource::collection(User::paginate());
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
                'unique:users,email'
            ],
            'password' => 'required',
            'document_type' => [
                'required',
                new EnumValue(DocumentType::class),
                'unique:users,document_type,NULL,NULL,document,' . $request['document'],
            ],
            'document' => [
                'required',
                'unique:users,document,NULL,NULL,document_type,' . $request['document_type'],
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

        User::create($validator->validated());
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        return User::destroy($id);
    }
}
