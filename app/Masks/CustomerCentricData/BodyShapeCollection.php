<?php
namespace App\Masks\CustomerCentricData;

use Gomee\Masks\MaskCollection;

class BodyShapeCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return BodyShapeMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
