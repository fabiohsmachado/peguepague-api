<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    public function definition()
    {
        $balance = $this->faker->randomFloat(2);
        return [
            'user_id' => Factory::factoryForModel(User::class),
            'initial_balance' => $balance,
            'balance' => $balance
        ];
    }
}
