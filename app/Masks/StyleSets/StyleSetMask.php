<?php
namespace App\Masks\StyleSets;

use App\Masks\Products\ProductCollection;
use App\Models\StyleSet;
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
        $this->map([
            'products' => ProductCollection::class,
            'productItems' => StyleSetItemCollection::class,
            'items' => StyleSetItemCollection::class
        ]);
        $this->allow(['getFeatureImage', 'hasDiscount','priceFormat']);
    }

    /**
     * lấy data từ model sang mask
     * @param StyleSet $styleSet Tham số không bắt buộc phải khai báo. 
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
        $this->image = $this->getFeaturedImage();
        $this->featured_image = $this->image;
        $this->total = $this->model->total_price;
        $this->discount = $this->model->discount_price;
        $this->down_percent = $this->getDownPercent();
        $this->has_discount = $this->hasDiscount();
        
    }
    
    
    // khai báo thêm các hàm khác bên dưới nếu cần
}