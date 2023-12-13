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
        Schema::create('personal_style_item_configs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('priority')->nullable()->default(0);
            $table->json('preview_config')->nullable();

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
        Schema::dropIfExists('personal_style_item_configs');
    }
};
