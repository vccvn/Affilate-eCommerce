<?php
namespace App\Masks\CustomerCentricData;

use Gomee\Masks\MaskCollection;

class ProductCustomerCentricDataCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ProductCustomerCentricDataMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
