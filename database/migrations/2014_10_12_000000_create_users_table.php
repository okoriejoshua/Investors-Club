<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('type', ['admin', 'user'])->nullable();
            $table->string('photo')->nullable();
            $table->string('phone')->nullable(); 
            $table->string('referee')->nullable();
            $table->enum('status',['active','suspended'])->default('active');
            $table->decimal('bal', 10, 2)->default(0.00);
            $table->decimal('profits', 10, 2)->default(0.00);
            $table->decimal('rewards', 10, 2)->default(0.00);
            $table->enum('role', ['super admin', 'admin'])->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
