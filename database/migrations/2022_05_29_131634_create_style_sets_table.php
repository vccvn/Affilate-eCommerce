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
        Schema::create('style_sets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned()->default(0);
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('keywords')->nullable();
            $table->bigInteger('customer_id')->unsigned()->default(0);
            $table->bigInteger('created_by_id')->unsigned()->default(0);
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
        Schema::dropIfExists('style_sets');
    }
};
