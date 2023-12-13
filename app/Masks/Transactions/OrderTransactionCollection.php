<?php
namespace App\Masks\Transactions;

use Gomee\Masks\MaskCollection;

class OrderTransactionCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return OrderTransactionMask::class;
    }
    
    
    public function onLoaded()
    {
        $orderIDs = [];
        if(count($this->items)){
            
        }
    }
}
