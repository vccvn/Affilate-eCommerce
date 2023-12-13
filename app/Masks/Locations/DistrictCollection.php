<?php
namespace App\Masks\Locations;

use Gomee\Masks\MaskCollection;

class DistrictCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return DistrictMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
