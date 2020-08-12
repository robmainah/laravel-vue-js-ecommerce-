<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('customerId');
            $table->string('email')->unique();
            $table->string('email_verified_at')->nullable();
            $table->string('phone_number');
            $table->string('idNumber');
            $table->string('address');
            $table->string('gender');
            $table->string('password');
            // $table->string('verifyToken')->nullable();
            $table->enum('active', ['0', '1'])->default('0');
            $table->tinyInteger('roles')->default('1');
            $table->softDeletes();
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
        Schema::dropIfExists('clients');
    }
}