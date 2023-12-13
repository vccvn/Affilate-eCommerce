<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('secret_id')->nullable();
            $table->string('name');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable()->default('male');
            $table->date('birthday')->nullable();
            $table->string('avatar')->nullable();
            $table->string('email');//->unique();
            $table->string('username');//->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->string('type')->nullable()->default('user');
            $table->text('google2fa_secret')->nullable();
            $table->integer('level')->unsigned()->nullable()->default(0);
            $table->integer('status')->default(1);
            $table->rememberToken();
            $table->integer('trashed_status')->default(0);
            $table->softDeletes();
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
};
