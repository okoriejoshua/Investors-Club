<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('category')->nullable();
            $table->decimal('min_price', 10, 2)->default(0.00);
            $table->decimal('max_price', 10, 2)->default(0.00);
            $table->timestamp('duration')->nullable();
            $table->string('numdays')->nullable();
            $table->enum('return_type', ['hours', 'days'])->default('days');
            $table->enum('status', ['active', 'suspended'])->default('active');
            $table->decimal('profit', 10, 2)->default(0.00);
            $table->tinyInteger('counts')->default(5);
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('investments');
    }
}
