<?php
namespace App\Masks\StyleSets;

use Gomee\Masks\MaskCollection;

class StyleSetCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return StyleSetMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
