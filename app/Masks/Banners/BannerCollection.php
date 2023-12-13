<?php
namespace App\Masks\Banners;

use Gomee\Masks\MaskCollection;

class BannerCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return BannerMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
