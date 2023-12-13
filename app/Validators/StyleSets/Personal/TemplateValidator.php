<?php

namespace App\Validators\StyleSets\Personal;

use Gomee\Validators\Validator as BaseValidator;

class TemplateValidator extends BaseValidator
{
    public function extends()
    {
        // Thêm các rule ở đây
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            
            'name'      => 'mixed|max:150',
            'height'    => 'required|numeric|min:200|max:1048',
            'width'     => 'required|numeric|min:200|max:1048',
            'avatar_id' => 'mixed'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            
            'name.required'                    => 'Tên bộ sư tập không được bỏ trống',
            'name.string'                      => 'Tên bộ sư tập không hợp lệ',
            'name.max'                         => 'Tên bộ sư tập hơi... dài!',

        ];
    }
}