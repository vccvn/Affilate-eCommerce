<?php

namespace App\Validators\StyleSets\Personal;

use App\Models\PersonalStyleSet;
use App\Repositories\Products\AttributeValueRepository;
use App\Repositories\StyleSets\Personal\StyleSampleRepository;
use App\Repositories\StyleSets\Personal\TemplateItemConfigRepository;
use App\Repositories\StyleSets\Personal\TemplateItemRepository;
use App\Repositories\StyleSets\Personal\TemplateRepository;
use Gomee\Validators\Validator as BaseValidator;

/**
 * @property TemplateRepository $templateRepository
 * @property StyleSampleRepository $styleSampleRepository
 * @property TemplateItemConfigRepository $templateItemConfigRepository
 * @property TemplateItemRepository $templateItemRepository
 * @property AttributeValueRepository $attributeValueRepository
 * @property PersonalStyleSet $sample
 * 
 */
class StyleSetValidator extends BaseValidator
{
    public $templateRepository;
    public $styleSampleRepository;
    public $templateItemConfigRepository;
    public $templateItemRepository;
    public $attributeValueRepository;
    public $sample;
   
    public function extends()
    {
        $this->templateRepository = app(TemplateRepository::class);
        $this->templateItemRepository = app(TemplateItemRepository::class);
        $this->attributeValueRepository = app(AttributeValueRepository::class);
        $this->templateItemConfigRepository = app(TemplateItemConfigRepository::class);
        $this->styleSampleRepository = app(StyleSampleRepository::class);
        $this->addRule('check_sample', function ($attr, $value) {
            if($sample = $this->styleSampleRepository->with('items')->first(['id' => $value])){
                $this->sample = $sample;
                return true;
            }
            return false;
        });
        $this->addRule('check_item', function ($attr, $value) {
            return $this->templateItemRepository->count(['template_id' => $this->template_id, 'id' => $value]) == 1;
        });
        $this->addRule('check_items', function ($attr, $value) {
            $config = array_keys($value);
            $items = array_values($value);
            return $this->templateItemConfigRepository->count(['template_id' => $this->template_id]) == count(($config)) &&
                $this->templateItemRepository->count(['template_id' => $this->template_id, 'id' => $items]) == count(($items));
        });
        $this->addRule('check_attributes', function ($attr, $value) {
            $config = array_keys($value);
            return $this->templateItemConfigRepository->count(['template_id' => $this->template_id]) == count(($config));
        });

        $this->addRule('check_attribute_value', function ($attr, $value) {
            if (!$value) return true;
            $ids = array_values($value);
            return count($ids) == $this->attributeValueRepository->count(['id' => $ids]);
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {

        $rules = [
            'template_id' => 'required|exists:personal_style_templates,id',
            'name' => 'required|string|max:150',
            'thumbnail' => 'mimes:jpg,jpeg,png,gif',
            'weight' => 'numeric|min:0',
            'height' => 'numeric|min:0',
            'body_shape_id'=> 'required|exists:body_shapes,id',
            
        ];
        if (!$this->sample_id) {
            $rules = array_merge($rules, [
                'items' => 'required|array|check_items',
                'items.*' => 'required|check_item',
                'attrs' => 'check_attributes',
                'attrs.*' => 'check_attribute_value'
            ]);
        }else{
            $rules = array_merge($rules, [
                'sample_id' => 'check_sample'
            ]);
        }

        return $rules;
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'name.max'                             => 'Tên dài vựa quá số ký tự',
            'name.required'                        => 'Bạn chưa nhập tên',
            'template_id.*'                        => 'Kiểu dáng không hợp lệ',
            'items.check_items'                    => 'Danh sách item không hợp lệ',
            'items.required'                       => 'Item không dược bỏ trống',
            'items.array'                          => 'Danh sách item không hợp lệ',
            'items.*.required'                     => 'Item không dược bỏ trống',
            'items.*.check_item'                   => 'item không hợp lệ',
            'thumbnail.mimes'                      => 'Định đạng file không được hỗ trợ',
            'sample_id.*'                          => 'Kiểu mẫu không hợp lệ',
            'body_shape_id.*'                      => 'Dáng người không hợp lệ',
            'weight.*'                             => 'Cân nặng không hợp lệ',
            'height.*'                             => 'Chiều cao không hợp lệ',
             

        ];
    }
}
