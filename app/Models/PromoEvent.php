<?php

namespace App\Models;
use Gomee\Models\Model;
class PromoEvent extends Model
{
    public $table = 'promo_events';
    public $fillable = ['name', 'description', 'type', 'date_type', 'schedule_type', 'checking_date', 'checking_day', 'coupon_type', 'can_use_type', 'conditions', 'coupon_data', 'started_at', 'finished_at'];

    protected $deleteMode = 'soft';

    public $casts = [
        'conditions' => 'json',
        'coupon_data' => 'jsom'
    ];
    
}
