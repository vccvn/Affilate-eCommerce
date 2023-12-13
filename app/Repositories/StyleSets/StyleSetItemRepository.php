<?php

namespace App\Repositories\StyleSets;

use Gomee\Repositories\BaseRepository;
/**
 * validator 
 * 
 */
use App\Validators\StyleSets\StyleSetItemValidator;
use App\Masks\StyleSets\StyleSetItemMask;
use App\Masks\StyleSets\StyleSetItemCollection;
use App\Repositories\Products\ProductRepository;
use Gomee\Helpers\Arr;

class StyleSetItemRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = StyleSetItemValidator::class;
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = StyleSetItemMask::class;

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = StyleSetItemCollection::class;

    /**
     * @var \App\Models\StyleSetItem
     */
    static $__Model__;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\StyleSetItem::class;
    }

    
    /**
     * loc và tinh gia tien don hang
     * @param array $items
     */
    public function parseItems(array $item_list = [])
    {
        $items = [];
        $total_money = 0;
        if(count($item_list)){
            $productRepository = new ProductRepository();
            foreach($item_list as $itm){
                $item = new Arr($itm);
                // nếu tìm thấy sản phẩm
                if($product = $productRepository->findBy('id', $item->product_id)){
                    // nạp một số thông tin từ sản phẩm sang 
                    // $item->style_set_id = $style_set_id;
                    $key = $item->product_id;
                    // xử lý thuộc tính nếu có
                    if($item->attr_values){
                        $av = array_values($item->attr_values);
                        sort($av);
                        $item->attr_values = $av;
                        $key .= '.'. implode('-', $av);
                    }
                    // kiểm tra sản phẩm trùng lặp
                    if(array_key_exists($key, $items)){
                        // trong trường hợp item trước đó đã có id thì + quantity vào key trước đó
                        if($items[$key]->id){
                            $items[$key]->quantity+=$item->quantity;
                        }
                        // trường hợp item hiện tại có id thì + quan tity vào item6 hiện tại và thế chỗ cho item trong mảng data
                        elseif ($item->id) {
                            $item->quantity+=$items[$key]->quantity;
                            $items[$key] = $item;
                        }
                        else{
                            $items[$key]->quantity+=$item->quantity;
                        }
                            
                    }
                    // trường hợp mới toanh không có item id thì cộng dồn
                        
                    else{
                        $items[$key] = $item;
                    }                    
                }
            }
        }

        return compact('items', 'total_money');
    }

    /**
     * cập nhật hoặc thêm mới order item
     * @param int $style_set_id Mã đơn hàng
     * @param array $items Danh sách item [['id' => $order_item_id, 'product_id' => $product_id, 'quantity' => $quantity, 'attributes' => []]]
     * 
     * @return bool
     */
    public function saveStyleSetItems(int $style_set_id, array $items = [])
    {
        $ignore = [];
        $data = [];
        if(count($items)){
            foreach ($items as $key => $item) {
                if($item->id){
                    $ignore[] = $item->id;
                }
                $item->style_set_id = $style_set_id;
                $data[$key] = $item;
            }
        }
        if(count($list = $this->getBy('style_set_id', $style_set_id))){
            foreach ($list as $orderItem) {
                if(!in_array($orderItem->id, $ignore)){
                    $orderItem->delete();
                }
            }
        }
        $dataSaved = [];
        if($data){
            foreach ($data as $key => $orderItem) {
                if(!$orderItem->id) $orderItem->remove('id');
                $itemdata = $orderItem->all();

                $dataSaved[] = $this->save($itemdata, $orderItem->id);
            }
        }
        return $dataSaved;
    }

    public function beforeSave($data)
    {
        if(isset($data['attr_values']) && is_array($data['attr_values'])){
            $data['attr_values'] = implode('-', $data['attr_values']);
        }
        return $data;
    }

}