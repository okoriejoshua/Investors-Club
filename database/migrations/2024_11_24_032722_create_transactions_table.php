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
            $table->string('from_id')->nullable();
            $table->string('to_id')->nullable();
            $table->enum('type', ['deposit', 'withdraw','reward','transfer']);
            $table->decimal('amount', 10, 2);
            $table->string('asset')->nullable();
            $table->enum('status', ['pending', 'failed', 'successful'])->default('pending');
            $table->string('destination')->nullable();
            $table->string('network')->nullable();
            $table->string('transaction_id');
            $table->string('pop')->nullable();
            $table->string('paymethod')->nullable();
            $table->integer('steps')->default(1);
            $table->timestamps();
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
