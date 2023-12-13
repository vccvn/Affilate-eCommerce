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
        Schema::table('personal_style_templates', function (Blueprint $table) {
            // 
            $table->decimal('min_weight', 5, 2)->unsigned()->nullable()->default(0)->change();
            $table->decimal('max_weight', 5, 2)->unsigned()->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_style_templates', function (Blueprint $table) {
            // 
            $table->integer('min_weight')->unsigned()->nullable()->default(0)->change();
            $table->integer('max_weight')->unsigned()->nullable()->default(0)->change();
        });
    }
};
