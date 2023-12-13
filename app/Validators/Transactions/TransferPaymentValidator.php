<?php

namespace App\Validators\Transactions;

use App\Models\Order;
use App\Models\PaymentMethod;
use App\Repositories\Orders\OrderRepository;
use App\Repositories\Payments\MethodRepository;
use Gomee\Validators\Validator as BaseValidator;
class TransferPaymentValidator extends BaseValidator
{
    /**
     * order repo
     *
     * @var \App\Repositories\Orders\OrderRepository
     */
    protected $orderRepository;
    public function extends()
    {
        $this->orderRepository = new OrderRepository();
        // Thêm các rule ở đây
        $this->addRule('check_order', function($prop, $value){
            
            $order = $this->orderRepository->detail(['payment_status' => Order::PAYMENT_PENDING, 'code' => $value]);
            if($order && ($paymentMethod = (new MethodRepository)->first(['id' => $order->payment_method_id, 'method'=>'transfer']))){
                return true;
            }
            return false;
        });

    }

    /**
     * ham lay rang buoc du lieu
     */
    public function rules()
    {
        return [
            'order_code'                        => 'required|check_order',
            'image'                             => 'required|mimes:jpg,jpeg,png,gif',
        ];
    }

    /**
     * các thông báo
     */
    public function messages()
    {
        return [
            'order_id.required'                 => 'Mã đơn hàng không được bỏ trống',
            'order_id.check_order'              => 'Mã đơn hàng không hợp lệ',
            'image.mimes'                       => 'File không hợp lệ',
            'image.required'                    => 'File ảnh không được bỏ trống',
            

        ];
    }
}