<?php
namespace App\Masks\StyleSets\Personal;

use Gomee\Masks\MaskCollection;

class ItemConfigCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return ItemConfigMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
