<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'balance'];

    /**
     * Add given amount to the wallet's balance.
     * 
     * @param float amount The value to add.
     */
    public function add(float $amount)
    {
        $this->balance += $amount;
    }

    /**
     * Subtract given amount from the wallet's balance.
     * 
     * @param float amount The value to subtract.
     */
    public function subtract(float $amount)
    {
        $this->balance -= $amount;
    }
}
