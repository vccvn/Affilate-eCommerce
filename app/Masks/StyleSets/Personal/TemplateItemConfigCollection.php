<?php
namespace App\Masks\StyleSets\Personal;

use Gomee\Masks\MaskCollection;

class TemplateItemConfigCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return TemplateItemConfigMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
