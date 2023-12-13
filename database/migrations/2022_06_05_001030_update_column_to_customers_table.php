<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->bigInteger('region_id')->unsigned()->nullable()->default(0)->change();
            $table->bigInteger('district_id')->unsigned()->nullable()->default(0)->change();
            $table->bigInteger('ward_id')->unsigned()->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->bigInteger('region_id')->unsigned()->default(0)->change();
            $table->bigInteger('district_id')->unsigned()->default(0)->change();
            $table->bigInteger('ward_id')->unsigned()->default(0)->change();
        });
    }
};
