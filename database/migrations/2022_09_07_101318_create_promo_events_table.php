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
        Schema::create('promo_events', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->default('Event Name');
            $table->text('description')->nullable();
            $table->string('type')->nullable()->default('order-success');
            $table->string('date_type')->nullable()->default('all');
            $table->string('schedule_type')->nullable()->default('none');
            $table->date('checking_date')->nullable();
            $table->tinyInteger('checking_day')->unsigned()->nullable()->default(0);
            $table->string('coupon_type')->nullable()->default('list');
            $table->string('can_use_type')->nullable()->default('one');
            $table->json('conditions')->nullable();
            $table->json('coupon_data')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('promo_events');
    }
};
