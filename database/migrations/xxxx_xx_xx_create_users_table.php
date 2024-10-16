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
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('phone_number');
            $table->string('email_address')->unique();
            $table->string('address');
            $table->string('license_number');
            $table->date('license_expiry_date');
            $table->string('profile_picture')->nullable();
            $table->string('password');
            $table->string('otp')->nullable();
            $table->boolean('isActive')->default(true);
            $table->string('device_id')->nullable();
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
