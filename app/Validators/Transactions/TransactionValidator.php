<?php

namespace App\Validators\Transactions;

use Gomee\Validators\Validator as BaseValidator;

class TransactionValidator extends BaseValidator
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
    
        return [];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [];
    }
}