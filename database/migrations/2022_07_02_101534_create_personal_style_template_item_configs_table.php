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
        Schema::create('personal_style_template_item_configs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('config_id')->nullable()->default(0);
            $table->bigInteger('template_id')->nullable()->default(0);
            $table->bigInteger('front_image_id')->nullable()->default(0);
            $table->bigInteger('back_image_id')->nullable()->default(0);
            $table->json('preview_config')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_style_template_item_configs');
    }
};
