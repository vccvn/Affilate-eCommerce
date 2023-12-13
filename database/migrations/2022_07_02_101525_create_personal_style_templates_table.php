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
        Schema::create('personal_style_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('use_height')->nullable()->default(false);
            $table->boolean('use_weight')->nullable()->default(false);
            $table->boolean('use_bmi')->nullable()->default(false);
            $table->integer('min_height')->unsigned()->nullable()->default(0);
            $table->integer('max_height')->unsigned()->nullable()->default(0);
            $table->integer('min_weight')->unsigned()->nullable()->default(0);
            $table->integer('max_weight')->unsigned()->nullable()->default(0);
            $table->decimal('min_bmi', 4, 2)->nullable()->default(0);
            $table->decimal('max_bmi', 4, 2)->nullable()->default(0);
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
        Schema::dropIfExists('personal_style_templates');
    }
};
