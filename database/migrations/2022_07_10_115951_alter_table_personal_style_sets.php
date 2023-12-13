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
        Schema::table('personal_style_sets', function (Blueprint $table) {
            // 
            $table->bigInteger('template_id')->nullable()->default(0);
            $table->string('thumbnail_image')->nullable();
            $table->json('set_data')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_style_sets', function (Blueprint $table) {
            // 
            
            $table->dropColumn('template_id');
            $table->dropColumn('thumbnail_image');
            $table->dropColumn('set_data');

        });
    }
};
