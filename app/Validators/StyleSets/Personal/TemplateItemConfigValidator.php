<?php

namespace App\Validators\StyleSets\Personal;

use App\Repositories\Products\CategoryRepository;
use Gomee\Validators\Validator as BaseValidator;

class TemplateItemConfigValidator extends BaseValidator
{
    /**
     * CategoryRepository
     *
     * @var CategoryRepository
     */
    public $categoryRepository = null;
    public function extends()
    {
        $this->categoryRepository = app(CategoryRepository::class);
        $this->addRule('check_preview_config', function($attr, $value){
            if(!$value) return true;
            if(!is_array($value)) return false;

            $listCheck = ['width', 'height', 'top', 'left'];

            foreach ($listCheck as $key) {
                if(array_key_exists($key, $value)){
                    if($value[$key] && (!is_numeric($value[$key]) || (($key == 'height' || $key == 'width') && $value[$key] < 0)))
                    return false;
                }
            }
            return true;
        });

        
        $this->addRule('check_categories', function($prop, $value){
            if(!$value) return true;
            if($value && !is_array($value)) return false;
            return $this->categoryRepository->count(['id' => $value]) == count($value);
        });
        $this->addRule('template_item_unique', function($prop, $value){
            return (!$this->config_id || !$value)? false: (
                !($itemConfig = $this->repository->first(['template_id' => $value, 'config_id' => $this->config_id])) || $itemConfig->id == $this->id
            );
        });
        
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            'config_id' => 'required|exists:personal_style_item_configs,id',
            'template_id' => 'required|exists:personal_style_templates,id|template_item_unique',
            'categories'    => 'check_categories',
            'use_custom_config' => 'check_boolean',
            'preview_config' => 'check_preview_config',

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'config_id.*' => 'ID cấu hình không hợp lệ',
            'template_id.template_item_unique' => 'Item Đã tồn tại',
            'template_id.*' => 'Template không hợp lệ',
            'categories.*'    => 'Danh mục không hợp lệ',
            'use_custom_config' => 'check_boolean',
            'preview_config.*' => 'Tham số xem trước không hợp lệ',


        ];
    }
}