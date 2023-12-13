<?php

namespace App\Repositories\StyleSets\Personal;

use App\Masks\Products\AttributeCollection;
use App\Masks\StyleSets\Personal\TemplateCollection;
use App\Masks\StyleSets\Personal\TemplateMask;
use App\Repositories\Products\AttributeRepository;
use App\Validators\StyleSets\Personal\TemplateValidator;
use Gomee\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * validator 
 * @property-read AttributeRepository $attributeRepository
 */
class TemplateRepository extends BaseRepository
{
    /**
     * class chứ các phương thức để validate dử liệu
     * @var string $validatorClass 
     */
    protected $validatorClass = TemplateValidator::class;
    /**
     * tên class mặt nạ. Thường có tiền tố [tên thư mục] + \ vá hậu tố Mask
     *
     * @var string
     */
    protected $maskClass = TemplateMask::class;

    /**
     * tên collection mặt nạ
     *
     * @var string
     */
    protected $maskCollectionClass = TemplateCollection::class;

    protected $attributeRepository;

    public function init()
    {
        $this->attributeRepository = app(AttributeRepository::class);
        
    }

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\PersonalStyleTemplate::class;
    }

    public function getUrlOptions($routeName, $routeParamKey = 'id')
    {
        $options = [];
        if(count($rs = $this->get())){
            foreach ($rs as $temp) {
                $options[route($routeName, [$routeParamKey=>$temp->{$routeParamKey}])] = $temp->name;
            }
        }
        return $options;
    }

    public function getDataArgs($params = [])
    {
        return array_merge([
            '@withItemConfigs' => [
                '@withItemConfig' => true,
                '@withTemplateItems' => true,
                '@withCategoryRefs' => [
                    '@withCategory' => [
                        '@withParent' => [
                            '@withParent' => [
                                '@withParent' => [
                                    '@withParent' => true
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            '@withAvatar' => true
        ], $params);
    }

    public function getFirstTemplate()
    {
        return $this->mode('mask')->detail($this->getDataArgs());
    }

    public function getTemplateDetail($args = [])
    {
        return $this->mode('mask')->detail($this->getDataArgs($args));
    }



    public function getListWithAttributes($params = [])
    {
        $args = $this->getDataArgs($params);
        $results = $this->mode('mask')->getData($args);
        $categories = [];
        $categoryMap = [];
        
        $itemCateMap = [];
        // cate chưa nhieu item

        $tempItemMap = [];
        // item theo id

        if(count($results)){
            foreach ($results as $i => $temp) {
                if($temp->itemConfigs && count($temp->itemConfigs)){
                    foreach ($temp->itemConfigs as $j => $itemConfig) {
                        $tempItemMap[$itemConfig->id] = $itemConfig;
                        if($itemConfig->category_ids){
                            foreach ($itemConfig->category_ids as $category_id) {
                                if(!in_array($category_id, $categories)) $categories[] = $category_id;
                                if(!array_key_exists($category_id, $itemCateMap)) $itemCateMap[$category_id] = [$itemConfig->id];
                                elseif(!in_array($itemConfig->id, $itemCateMap[$category_id])) $itemCateMap[$category_id][] = $itemConfig->id;
                            }
                        }
                    }
                }
            }
            $attributes = $this->attributeRepository->getAllAttribute($categories);
            
            if(count($attributes)){

                $attributeMap = [
                    'all' => [],
                    'list' => []
                ];
                foreach ($attributes as $key => $attr) {
                    if($attr->category_id == 0){
                        if(!in_array($key, $attributeMap)) 
                        $attributeMap['all'][] = $key;
                    }
                    else{
                        foreach ($attr->category_ids as $category_id) {
                            if(!array_key_exists($category_id, $attributeMap['list'])) $attributeMap['list'][$category_id] = [$key];
                            elseif(!in_array($key, $attributeMap['list'][$category_id])) $attributeMap['list'][$category_id][] = $key;
                        }
                    }
                }

                $itemAttributeMap = [];
                if($attributeMap['all']){
                    foreach ($tempItemMap as $key => $value) {
                        $itemAttributeMap[$key] = $attributeMap['all'];
                    }
                }
                if($attributeMap['list']){
                    foreach ($attributeMap['list'] as $category_id => $keys) {
                        if(array_key_exists($category_id, $itemCateMap)){
                            $items = $itemCateMap[$category_id];
                            foreach ($items as $item_id) {
                                if(!array_key_exists($item_id, $itemAttributeMap)) $itemAttributeMap[$item_id] = $keys;
                                else{
                                    foreach ($keys as $key) {
                                        if(!in_array($key, $itemAttributeMap[$item_id])) $itemAttributeMap[$item_id][] = $key;
                                    }
                                }
                            }
                        }
                    }
                }
                
                if($itemAttributeMap){
                    foreach ($itemAttributeMap as $item_id => $keys) {
                        $arr = [];
                        foreach ($keys as $key) {
                            $arr[] = $attributes[$key];
                        }
                        $collection = new AttributeCollection([], 0);
                        $collection->setITems($arr);
                        $tempItemMap[$item_id]->setRelation('attributes',$collection);
                    }
                }
                
            }
            
            
        }
        return $results;
    }
    
    
}