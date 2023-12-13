<?php

namespace App\Models;

use Gomee\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    const REF_KEY = 'transaction';
    public $table = 'transactions';
    public $fillable = ['created_id', 'customer_id', 'approved_id', 'type', 'ref', 'ref_id', 'code', 'amount', 'note', 'time', 'status', 'trashed_status'];

    
    /**
     * lay du lieu form
     * @return array
     */
    public function toFormData()
    {
        $data = $this->toArray();
        if($this->bill){
            $data['image'] = $this->bill->original_filename;
        }
        $data['random_number'] = $data['ref_id'];
        if($this->ref == 'order'){
            $order = Order::find($data['ref_id']);
            $data['order_code'] = $order?$order->code:'';
        }
        return $data;
    }

    /**
     * nguoi tao giao dich
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_id', 'id')->select('id','name', 'email', 'avatar');
    }

    /**
     * nguoi tao giao dich
     */
    public function apprevedBy()
    {
        return $this->belongsTo(User::class, 'appreved_id', 'id')->select('id','name', 'email', 'avatar');
    }

    /**
     * nguoi tao giao dich
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->select('id','name', 'email');
    }

    /**
     * nguoi tao giao dich
     */
    public function userCustomer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id')->select('id', 'name', 'email');
    }


    public function bills()
    {
        return $this->hasMany(File::class, 'ref_id', 'id')->where('ref', 'transaction');
    }

    /**
     * Get the bill associated with the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bill(): HasOne
    {
        return $this->hasOne(File::class, 'ref_id', 'id')->where('ref', 'transaction');
    }

      
    /**
     * xóa dữ liệu
     */
    public function beforeDelete()
    {
        // delete bills
        if(count($this->bills)){
            foreach ($this->bills as $bill) {
                $bill->delete();
            }
        }
        
    }

    
}
