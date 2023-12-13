<?php
namespace App\Masks\StyleSets\Personal;

use Gomee\Masks\MaskCollection;

class TemplateCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return TemplateMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
