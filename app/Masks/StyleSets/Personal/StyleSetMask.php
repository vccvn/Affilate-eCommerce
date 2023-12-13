<?php
namespace App\Masks\StyleSets\Personal;

use App\Models\PersonalStyleSet;
use Gomee\Masks\Mask;

class StyleSetMask extends Mask
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
        $this->map([
            'items' => StyleSetItemCollection::class
        ]);
    }

    /**
     * lấy data từ model sang mask
     * @param PersonalStyleSet $personalStyleSet Tham số không bắt buộc phải khai báo. 
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
        if(!is_array($this->set_data)) $this->set_data = json_decode($this->set_data, true);
        if(!$this->set_data) $this->set_data = [];


        $this->product_parameters = $this->getProductParameters();
         
    }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}