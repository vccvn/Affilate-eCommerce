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
        Schema::create('personal_style_template_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->bigInteger('template_item_config_id')->nullable()->default(0);
            $table->bigInteger('front_image_id')->nullable()->default(0);
            $table->bigInteger('back_image_id')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_style_template_items');
    }
};
