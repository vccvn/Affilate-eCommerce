<?php
namespace App\Masks\Comments;

use Gomee\Masks\MaskCollection;

class CommentCollection extends MaskCollection
{
    /**
     * lấy tên class mask tương ứng
     *
     * @return string
     */
    public function getMask()
    {
        return CommentMask::class;
    }
    // xem Collection mẫu ExampleCollection
}
