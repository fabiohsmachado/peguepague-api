<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payer_id')->references('id')->on('users');
            $table->foreignId('payee_id')->references('id')->on('users');
            $table->decimal('amount', 10, 2);
            $table->boolean('notified')->default(false);
            $table->timestamps();
        });

        Schema::table('transactions', function (Blueprint $table) 
        {
            $table->foreignId('reverse')->references('id')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
