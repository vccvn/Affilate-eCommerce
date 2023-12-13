<?php

namespace App\Validators\CustomerCentricData;

use Gomee\Validators\Validator as BaseValidator;

class BodyShapeValidator extends BaseValidator
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
            'name'          => 'required|string|max:150',
            'thumbnail'     => 'mimes:jpg,jpeg,png,gif',
            
            'description' => 'mixed'

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

        ];
    }
}