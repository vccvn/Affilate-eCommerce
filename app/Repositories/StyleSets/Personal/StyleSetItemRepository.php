<?php

namespace App\Repositories\StyleSets\Personal;

use App\Masks\StyleSets\Personal\StyleSetItemCollection;
use App\Masks\StyleSets\Personal\StyleSetItemMask;
use Gomee\Repositories\BaseRepository;
/**
 * validator 
 * 
 */
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
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\PersonalStyleSetItem::class;
    }

    

    /**
     * lấy các item của một ref nào đó
     * @param string $ref
     * @param int $style_set_id
     * @return array
     */
    public function getItemTemplateIDs($style_set_id = 0)
    {
        $data = [];
        if($style_set_id && $products = $this->get(compact('style_set_id'))){
            foreach ($products as $product) {
                $data[] = $product->template_item_id;
            }
        }
        return $data;
    }
    
    /**
     * cập nhật danh sách item
     * @param string $ref
     * @param int $style_set_id
     * @param array $template_item_id_list
     * @return void
     */
    public function updateItems(int $style_set_id, array $template_item_id_list = [])
    {

        $ignore = [];
        $addedData = [];
        if(count($items = $this->get(compact('style_set_id')))){
            foreach ($items as $item) {
                // nếu item nằm trong số id them thì bỏ qua
                if(!in_array($item->template_item_id, $template_item_id_list)) $item->delete();
                // nếu ko thì xóa
                else {
                    // $item_data = $item->getItemData();
                    // $item->item_data = $item_data;
                    // $item->save();
                    $ignore[] = $item->template_item_id;
                    $addedData[] = $item;
                    
                }
            }
        }
        if(count($template_item_id_list)){
            foreach ($template_item_id_list as $template_item_id) {
                if($template_item_id&&!in_array($template_item_id, $ignore)){
                    // nếu ko nằm trong danh sách bỏ qua thì ta thêm mới
                    $addedData[] = $this->save(compact('style_set_id', 'template_item_id'));
                }
            }
        }
        return $addedData;
    }

}