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
        Schema::table('personal_style_template_item_configs', function (Blueprint $table) {
            // 
            $table->boolean('use_custom_config')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_style_template_item_configs', function (Blueprint $table) {
            // 
            $table->dropColumn('use_custom_config');
        });
    }
};
