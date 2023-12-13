<?php
namespace App\Masks\StyleSets\Personal;

use Gomee\Masks\MaskCollection;

class StyleSetComboCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return StyleSetComboMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
