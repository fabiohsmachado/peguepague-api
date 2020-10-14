<?php

namespace Tests\Unit;

use App\Jobs\NotifyTransaction;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Operations\PostTransactionOperation;
use App\Services\Interfaces\ITransactionAuthorizer;
use App\UnitOfWork\Interfaces\ITransactionUnitOfWork;
use Mockery;
use TestCase;

class PostTransactionOperationTest extends TestCase
{
    protected $authorize_mock;
    protected $uow_mock;


    public function setUp(): void
    {
        parent::setUp();
        $this->authorize_mock = Mockery::mock(ITransactionAuthorizer::class);
        $this->uow_mock = Mockery::mock(ITransactionUnitOfWork::class);
        $this->operation = new PostTransactionOperation($this->authorize_mock, $this->uow_mock);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function test_properly_notifies_and_returns_registered_transaction()
    {
        //Prepare
        $this->authorize_mock->shouldReceive('authorize')->andReturn(true);

        $wallets = Wallet::factory()->makeOne();
        $users = User::factory()->makeOne();
        $users->wallet = $wallets;
        $this->uow_mock->shouldReceive('findUserById')->andReturn($users);

        $payload = ['payer' => 1, 'payee' => 2, 'value' => '10'];
        $uow_transaction = Transaction::factory()->makeOne($payload);
        $this->uow_mock->shouldReceive('register')->andReturn($uow_transaction);
        
        $this->expectsJobs(NotifyTransaction::class);
        
        //Act
        $transaction = $this->operation->process($payload);

        //Assert
        $this->assertEquals($uow_transaction->payee_id, $transaction->payee_id);
        $this->assertEquals($uow_transaction->payer_id, $transaction->payer_id);
        $this->assertEquals($uow_transaction->value, $transaction->value);
    }
}