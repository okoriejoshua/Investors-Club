<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStakingcoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stakingcoins', function (Blueprint $table) {
            $table->id();
            $table->string('coin_name');
            $table->integer('short_duration');
            $table->integer('mid_duration');
            $table->integer('long_duration');
            $table->decimal('short_apr', 10, 2);
            $table->decimal('mid_apr', 10, 2);
            $table->decimal('long_apr', 10, 2);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('stakingcoins');
    }
}
