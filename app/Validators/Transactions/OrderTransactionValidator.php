<?php

namespace App\Validators\Transactions;

use App\Models\Order;
use Gomee\Validators\Validator as BaseValidator;
use App\Repositories\Orders\OrderRepository;
use App\Validators\Common\CommonMethods;

class OrderTransactionValidator extends BaseValidator
{
    use CommonMethods;
    public function extends()
    {
        // Thêm các rule ở đây
        $this->addRule('check_order', function($prop, $value){
            return ((new OrderRepository())->count([
                'code' => $value, 
                'customer_id' => $this->customer_id
            ]) >= 1);
        });
        $this->addRule('check_type', function($prop, $value){
            return in_array($value, ['payment', 'refund', 'othor']);
        });
        $this->addCheckMoneyRule();



    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {

        return [
            'customer_id'                       => 'required|exists:customers,id',
            'order_code'                        => 'required|check_order',
            'type'                              => 'required|check_type',
            'code'                              => 'required|max:180|unique_prop',
            'amount'                            => 'required|numeric|min:0|check_money',
            'image'                             => 'mimes:jpg,jpeg,png,gif',
            'time'                              => 'required|max:32|strdatetime:string',
            'status'                            => 'check_number:0,1',
            'note'                              => 'mixed|max:300'
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'customer_id.required'              => 'Thông tin sản Khách hàng được bỏ trống',
            'customer_id.ezists'                => 'Khách hàng không tồn tại',
            'ref_id.required'                   => 'Mã đơn hàng không được bỏ trống',
            'ref_id.check_order'                => 'Mã đơn hàng không hợp lệ',
            'type.required'                     => 'Loại phẩn hồi không dược bỏ trống',
            'type.check_type'                   => 'Loại phản hồi không hợp lệ',
            'code.required'                     => 'Mã giao dịch không dược bỏ trống',
            'amount.required'                   => 'Số tiền không dược bỏ trống',
            'amount.numeric'                    => 'Số tiền không hợp lệ',
            'amount.min'                        => 'Số tiền không hợp lệ',
            'amount.check_money'                => 'Số tiền không hợp lệ',
            'image.*'                           => 'File không hợp lệ',
            'time.strdatetime'                  => 'Thời gian không hợp lệ',
            'status.check_number'               => 'Trạng thái không hợp lệ'
        ];
    }
}
