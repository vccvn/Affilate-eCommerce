<?php
namespace App\Masks\CustomerCentricData;

use Gomee\Masks\MaskCollection;

class SkinColorCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return SkinColorMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
