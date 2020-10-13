<?php

namespace App\Models;

use App\Enums\DocumentType;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'document_type',
        'document',
        'user_type'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'document_type' => DocumentType::class,
        'user_type' => UserType::class
    ];

    /**
     * The wallet list that belongs to the user.
     */
    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }
}
