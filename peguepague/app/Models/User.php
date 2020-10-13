<?php

namespace App\Models;

use App\Enums\DocumentType;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'document_type',
        'document',
        'user_type'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'document_type' => DocumentType::class,
        'user_type' => UserType::class
    ];

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }
}
