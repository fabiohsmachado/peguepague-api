<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wallet::class;

     /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $balance = $this->faker->randomFloat(2);
        return [
            'user_id' => $this->faker->randomNumber(),
            'initial_balance' => $balance,
            'balance' => $balance
        ];
    }
}
