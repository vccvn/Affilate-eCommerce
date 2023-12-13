<?php
namespace App\Masks\StyleSets\Personal;

use App\Models\PersonalStyleSetItem;
use Gomee\Masks\Mask;

class StyleSetItemMask extends Mask
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
        $this->map([
            'templateItem' => TemplateItemMask::class
        ]);
        $this->allow('getItemData');

    }

    /**
     * lấy data từ model sang mask
     * @param PersonalStyleSetItem $personalStyleSetItem Tham số không bắt buộc phải khai báo. 
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
        if(!is_array($this->item_data)) $this->item_data = json_decode($this->item_data, true);
        if(!$this->item_data) $this->item_data = [];
    }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}