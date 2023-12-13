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
        Schema::table('permission_modules', function (Blueprint $table) {
            // 
            $table->string('slug')->nullable();
            $table->string('route')->nullable();
            $table->string('prefix')->nullable();
            $table->string('path')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_modules', function (Blueprint $table) {
            // 
            $table->dropColumn('slug');
            $table->dropColumn('route');
            $table->dropColumn('prefix');
            $table->dropColumn('path');
            
        });
    }
};
