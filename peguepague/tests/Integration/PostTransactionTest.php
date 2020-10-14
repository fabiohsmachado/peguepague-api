<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Wallet;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class PostTransactionTest extends TestCase
{
    use DatabaseMigrations;

    protected User $common_user;
    protected User $shopkeeper;

    public function setUp(): void
    {
        parent::setUp();
        $this->common_user = User::factory()->create(['user_type' => 1]);
        Wallet::factory()->create(['user_id' => $this->common_user->id, 'balance' => 1000]);

        $this->shopkeeper = User::factory()->create(['user_type' => 2]);
        Wallet::factory()->create(['user_id' => $this->shopkeeper->id, 'balance' => 1000]);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_sucessful_post_transaction_operation()
    {
        $payload = [
            'payer' => $this->common_user->id,
            'payee' => $this->shopkeeper->id,
            'value' => 200
        ];

        $response = $this->call('POST', '/api/v1/transaction', $payload);

        $this->assertEquals(200, $response->status());
    }

    public function test_shopkeeper_cant_make_payment()
    {
        $payload = [
            'payer' => $this->shopkeeper->id,
            'payee' => $this->common_user->id,
            'value' => 200
        ];

        $response = $this->call('POST', '/api/v1/transaction', $payload);

        $this->assertEquals(400, $response->status());
    }
}