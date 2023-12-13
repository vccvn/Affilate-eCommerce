<?php
namespace App\Masks\CustomerCentricData;

use App\Models\BodyShape;
use Gomee\Masks\Mask;

class BodyShapeMask extends Mask
{

    // xem thêm ExampleMask
    /**
     * thêm các thiết lập của bạn
     * ví dụ thêm danh sách cho phép truy cập vào thuộc tính hay gọi phương thức trong model
     * hoặc map vs các quan hệ dữ liệu
     *
     * @return void
     */
    protected function init(){
        $this->allow('getThumbnail');
    }

    /**
     * lấy data từ model sang mask
     * @param BodyShape $bodyShape Tham số không bắt buộc phải khai báo. 
     * Xem thêm ExampleMask
     */
    // public function toMask()
    // {
    //     $data = $this->getAttrData();
    //     // thêm data tại đây.
    //     // Xem thêm ExampleMask
    //     return $data;
        
    // }

    /**
     * sẽ được gọi sau khi thiết lập xong
     *
     * @return void
     */
    protected function onLoaded()
    {
        $this->thumbnail_url = $this->getThumbnail();
    }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}