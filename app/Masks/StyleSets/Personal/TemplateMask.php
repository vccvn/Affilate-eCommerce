<?php
namespace App\Masks\StyleSets\Personal;

use App\Masks\Files\FileMask;
use App\Models\PersonalStyleTemplate;
use Gomee\Masks\Mask;

class TemplateMask extends Mask
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
            'itemConfigs' => TemplateItemConfigCollection::class,
            'items' => TemplateItemCollection::class,
            'avatar' => FileMask::class
        ]);
    }

    /**
     * lấy data từ model sang mask
     * @param PersonalStyleTemplate $personalStyleTemplate Tham số không bắt buộc phải khai báo. 
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
        $this->avatar_url = $this->getAvatar();
    }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}