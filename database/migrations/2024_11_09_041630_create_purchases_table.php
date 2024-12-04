<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('plan_name');
            $table->unsignedBigInteger('plan_id');
            $table->enum('type', ['investment', 'staking']);
            $table->string('purchase_id');
            $table->decimal('amount', 10, 2);
            $table->decimal('apr', 10, 2);
            $table->timestamp('duration');
            $table->decimal('total_profit', 10, 2);
            $table->decimal('current_profit', 10, 2);
            $table->string('return_type');
            $table->integer('original_hour');
            $table->integer('progress_counter');
            $table->integer('initial_hour');
            $table->timestamp('next_halving')->nullable();
            $table->enum('status', ['notactive', 'active', 'completed', 'terminated']);
            $table->boolean('is_completed')->default(false);
            $table->boolean('is_refunded')->default(false);
            $table->boolean('is_terminated')->default(false);
            $table->boolean('is_cost_paidback')->default(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('plan_id')->references('id')->on('investments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
