<?php

namespace App\Validators\CustomerCentricData;

use Gomee\Validators\Validator as BaseValidator;

class SkinColorValidator extends BaseValidator
{
    public function extends()
    {
        $this->addRule('is_color', function($attr, $value){
            return !$value || preg_match('/^\#[A-f0-9]{3,6}$/i', $value);
        });
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
    
        return [
            
            'name'          => 'required|string|max:150',
            'thumbnail'     => 'mimes:jpg,jpeg,png,gif',
            
            'description'   => 'mixed',
            'color'         => 'required|is_color',

        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên Không được bỏ trống',
            'name.max' => 'Tên Không được dài quá 150 ký tựt',
            'description.mixed' => 'description Không hợp lệ',
            'thumbnail.mimes' => 'Thumbnail Không Đúng định dạng',

            'color.*' => 'Màu Không hợp lệ',

        ];
    }
}