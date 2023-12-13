<?php
namespace App\Masks\StyleSets\Personal;

use App\Models\PersonalStyleItemConfig;
use Gomee\Masks\Mask;

class ItemConfigMask extends Mask
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
        $this->allow('getPreviewConfigData', 'toFormData');
    }

    /**
     * sẽ được gọi sau khi thiết lập xong
     *
     * @return void
     */
    protected function onLoaded()
    {
        if(!is_array($this->preview_config)) $this->preview_config = $this->getPreviewConfigData();
    }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}