<?php

namespace App\Models;

use Gomee\Models\Model;

class PaymentMethod extends Model
{
    
    const PAYMENT_COD = 'cod';
    const PAYMENT_TRANSFER = 'transfer';
    const PAYMENT_VNPAY = 'vnpay';
    const PAYMENT_MOMO = 'momo';

    const ACTIVE = 1;
    const DEACTIVE = 0;
    const ALL_STATUS = [self::DEACTIVE, self::ACTIVE];
    const STATUS_LABELS = [
        self::DEACTIVE => 'Không kích hoạt', self::ACTIVE => 'Kích hoạt'
    ];


    public $table = 'payment_methods';
    public $fillable = ['name', 'method', 'config', 'description', 'guide', 'priority', 'status', 'trashed_status'];


    public $casts = [
        'config' => 'json',
    ];

}
