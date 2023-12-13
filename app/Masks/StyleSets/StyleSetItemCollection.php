<?php
namespace App\Masks\StyleSets;

use Gomee\Masks\MaskCollection;

class StyleSetItemCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return StyleSetItemMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
