<?php

namespace App\Validators\StyleSets\Personal;

use Gomee\Validators\Validator as BaseValidator;

class ItemConfigValidator extends BaseValidator
{
    /**
     * CategoryRepository
     *
     * @var CategoryRepository
     */
    public $categoryRepository = null;
    public function extends()
    {
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

        
        // $this->addRule('check_categories', function($prop, $value){
        //     if(!$value) return true;
        //     if($value && !is_array($value)) return false;
        //     return $this->categoryRepository->count(['id' => $value]) == count($value);
        // });
        
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            
            'name' => 'required|max:150',
            // 'categories'    => 'check_categories',
            'preview_config' => 'check_preview_config',

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'name.required'                    => 'Tên không được bỏ trống',
            'name.string'                      => 'Tên không hợp lệ',
            'name.max'                         => 'Tên hơi... dài!',

        ];
    }
}