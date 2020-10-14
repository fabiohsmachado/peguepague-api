<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payer_id',
        'payee_id',
        'amount',
        'reverse',
        'notified'
    ];

    /**
     * The transaction payer.
     */
    public function payer()
    {
        return $this->hasOne(User::class, 'id', 'payer_id');
    }

    /**
     * The transaction payee.
     */
    public function payee()
    {
        return $this->hasOne(User::class, 'id', 'payee_id');
    }
}