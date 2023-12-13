<?php

namespace App\Validators\StyleSets\Personal;

use App\Repositories\Tags\TagRepository;
use Gomee\Validators\Validator as BaseValidator;

class TemplateItemValidator extends BaseValidator
{
    /**
     * tagRepository
     *
     * @var TagRepository
     */
    public $tagRepository = null;
    public function extends()
    {
        $this->tagRepository = app(TagRepository::class);
        
        
        $this->addRule('check_tags', function($prop, $value){
            if(!$value) return true;
            if($value && !is_array($value)) return false;
            return $this->tagRepository->count(['id' => $value]) == count($value);
        });
        
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'name'                    => 'required|max:150',
            'front_image_id'          => 'required|exists:files,id',
            'back_image_id'           => 'required|exists:files,id',
            'template_item_config_id' => 'required|exists:personal_style_template_item_configs,id',
            'tags'                    => 'check_tags'

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'name.required'                    => 'Tên item không được bỏ trống',
            'name.string'                      => 'Tên item phẩm không hợp lệ',
            'name.max'                         => 'Tên item phẩm hơi... dài!',
            'front_image_id.required' => 'Chưa chọn ảnh phía trước',
            'front_image_id.exists'   => 'Ảnh phía trước không tồn tại',
            'back_image_id.required'  => 'Chưa chọn ảnh phía sau',
            'back_image_id.exists'    => 'Ảnh phía sau không tồn tại',
            'template_item_config_id.*' => 'Cấu hình khung mẫu không hợp lệ',
            'tags.*'                  => 'Thẻ không hợp lệ'


        ];
    }
}