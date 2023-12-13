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
        Schema::create('product_customer_centric_datas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->nullable()->default(0);
            $table->bigInteger('body_shape_id')->nullable()->default(0);
            $table->bigInteger('skin_color_id')->nullable()->default(0);
            $table->boolean('has_height_limited')->nullable()->default(false);
            $table->boolean('has_weight_limited')->nullable()->default(false);
            $table->boolean('has_bmi_limited')->nullable()->default(false);
            $table->boolean('has_measurement_limited')->nullable()->default(false);
            $table->boolean('has_age_limited')->nullable()->default(false);
            
            $table->integer('min_height')->unsigned()->nullable()->default(0)->comment('unit: cm');
            $table->integer('max_height')->unsigned()->nullable()->default(0)->comment('unit: cm');
            $table->decimal('min_weight', 5, 2)->unsigned()->nullable()->default(0)->comment('unit: kg');
            $table->decimal('max_weight', 5, 2)->unsigned()->nullable()->default(0)->comment('unit: kg');
            $table->decimal('min_bmi', 4, 2)->nullable()->default(0);
            $table->decimal('max_bmi', 4, 2)->nullable()->default(0);
            $table->integer('min_chest')->unsigned()->nullable()->default(0)->comment('unit: cm');
            $table->integer('max_chest')->unsigned()->nullable()->default(0)->comment('unit: cm');
            $table->integer('min_waist')->unsigned()->nullable()->default(0)->comment('unit: cm');
            $table->integer('max_waist')->unsigned()->nullable()->default(0)->comment('unit: cm');
            $table->integer('min_hip')->unsigned()->nullable()->default(0)->comment('unit: cm');
            $table->integer('max_hip')->unsigned()->nullable()->default(0)->comment('unit: cm');
            $table->integer('min_age')->unsigned()->nullable()->default(0);
            $table->integer('max_age')->unsigned()->nullable()->default(0);

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
        Schema::dropIfExists('product_customer_centric_datas');
    }
};
