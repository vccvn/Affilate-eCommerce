<?php

namespace App\Validators\StyleSets\Personal;

use App\Repositories\Products\AttributeValueRepository;
use App\Repositories\StyleSets\Personal\TemplateItemConfigRepository;
use App\Repositories\StyleSets\Personal\TemplateItemRepository;
use App\Repositories\StyleSets\Personal\TemplateRepository;
use Gomee\Validators\Validator as BaseValidator;

/**
 * @property TemplateRepository $templateRepository
 * @property TemplateItemConfigRepository $templateItemConfigRepository
 * @property TemplateItemRepository $templateItemRepository
 * @property AttributeValueRepository $attributeValueRepository
 */
class StyleSampleValidator extends BaseValidator
{
    public function extends()
    {
        $this->templateRepository = app(TemplateRepository::class);
        $this->templateItemRepository = app(TemplateItemRepository::class);
        $this->attributeValueRepository = app(AttributeValueRepository::class);
        $this->templateItemConfigRepository = app(TemplateItemConfigRepository::class);
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

        return [
            'template_id' => 'required|exists:personal_style_templates,id',
            'name' => 'required|string|max:150',
            'items' => 'required|array|check_items',
            'items.*' => 'required|check_item',
            'attrs' => 'check_attributes',
            'attrs.*' => 'check_attribute_value',
            'thumbnail' => 'mimes:jpg,jpeg,png,gif',
        ];
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

        ];
    }
}
