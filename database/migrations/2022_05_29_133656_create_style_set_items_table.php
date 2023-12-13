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
        Schema::create('style_set_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('style_set_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->longText('attr_values')->nullable();
            $table->integer('quantity')->unsigned()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('style_set_items');
    }
};
