<?php

namespace App\Validators\StyleSets;

use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Products\AttributeValueRepository;
use App\Repositories\Products\ProductRepository;
use Gomee\Validators\Validator as BaseValidator;

class StyleSetValidator extends BaseValidator
{
    public $attributeValueRepository;
    public $productRepository;

    public function extends()
    {
        $this->attributeValueRepository = new AttributeValueRepository();
        $this->productRepository = new ProductRepository();
        
        $this->addRule('check_customer', function($attr, $value){
            if($value && !app(CustomerRepository::class)->countBy('id', $value) == 1) return false;
            return true;
        });
        // kiểm tra slug xem có trùng lặp hay ko
        $this->addRule('check_slug', function($prop, $value){
            if(is_null($value)) return true;
            if($this->custom_slug){
                return $this->checkUniqueProp($prop, $value);
            }
            return true;
        });

        $this->addRule('check_items', function($prop, $value){
            if(!is_array($value) || !count($value)) return false;
            $item = $value;
            if(!isset($item['product_id']) || !$this->productRepository->findBy('id', $item['product_id']) || !isset($item['quantity']) || !is_numeric($item['quantity']) || $item['quantity'] < 1 || strlen($item['quantity']) > 10) return false;
            if(isset($item['attr_values'])){
                if(is_array($item['attr_values'])){
                    foreach ($item['attr_values'] as $name => $value_id) {
                        if(!$this->attributeValueRepository->checkAttributeValue($name, $value_id, $item['product_id']??0)) return false;
                    }
                }
            }
            return true;
        });
        $this->addRule('check_item_wrapper', function($prop, $value){
            if(!is_array($value) || !count($value)) return false;
            
            return true;
        });

        

        $this->addRule('check_file', function($prop, $value){
            if(!$value) return true;
            if($file = get_media_file(['id' => $value])) return true;
            return false;
        });

    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            
            'name'                             => 'required|string|max:191',
            // 'category_id'                      => 'required|exists:categories,id',
            'slug'                             => 'check_slug',
            'custom_slug'                      => 'mixed',
            'url'                              => 'mixed|max:150',
            'content'                          => 'mixed',
            'description'                      => 'mixed|max:500',
            'keywords'                         => 'mixed|max:180',
            // 'customer_id'                      => 'check_customer',
            'items'                            => 'required|check_item_wrapper',
            'items.*'                          => 'required|check_items',
            'featured_image'                   => 'check_file'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'category_id.mixed' => 'category_id Không hợp lệ',
            'name.mixed' => 'name Không hợp lệ',
            'slug.mixed' => 'slug Không hợp lệ',
            'type.mixed' => 'type Không hợp lệ',
            'description.mixed' => 'description Không hợp lệ',
            'detail.mixed' => 'detail Không hợp lệ',
            'keywords.mixed' => 'keywords Không hợp lệ',
            'customer_id.mixed' => 'customer_id Không hợp lệ',
            'created_by_id.mixed' => 'created_by_id Không hợp lệ'
            ,
            'featured_image.check_file'        => 'File không hợp lệ',

        ];
    }
}