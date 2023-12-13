<?php

namespace App\Validators\Banners;

use Gomee\Validators\Validator as BaseValidator;

class BannerValidator extends BaseValidator
{
    public function extends()
    {
    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {

        $rules = [
            'title'    => 'required|string|max:225',
            'type'     => 'required|max:500',
            'url'      => 'required',
            // 'embed_code' => 'required',
            'position' => 'required|max:225',
            'file'     => 'mimes:jpg,jpeg,png,gif',
            'alt'      => 'string|max:300',
        ];

        return $rules;
        // return $this->parseRules($rules);
    }

    public function messages()
    {
        return [
            // 'name.required'               => 'Tên chương trình khuyến mãi không được bỏ trống',
        ];
    }
}