<?php
namespace App\Masks\StyleSets\Personal;

use Gomee\Masks\MaskCollection;

class TemplateItemCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return TemplateItemMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
