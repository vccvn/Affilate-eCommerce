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
        Schema::table('personal_style_set_items', function (Blueprint $table) {
            // 
            $table->renameColumn('template_item_config_id', 'template_item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_style_set_items', function (Blueprint $table) {
            // 
            
            $table->renameColumn('template_item_id', 'template_item_config_id');
        });
    }
};
