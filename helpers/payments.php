<?php

use App\Repositories\Payments\MethodRepository;
use Crazy\Helpers\Arr;
use Crazy\Html\Html;

if(!function_exists('get_payment_method_options')){
    /**
     * lấy danh sách phương thức thanh toán đơn hàng
     * @return Arr[]|\App\Models\PaymentMethod[]
     */
    function get_payment_method_options($args = [])
    {
        return (new MethodRepository())->getActivedMethodDetails($args);
    }
}

if(!function_exists('get_payment_method_select_options')){
    /**
     * lấy danh sách phương thức thanh toán đơn hàng
     * @return Arr[]|\App\Models\PaymentMethod[]
     */
    function get_payment_method_select_options($args = [])
    {
        $a = ["" => "Chọn phương thức thanh toán"];

        $methods = get_payment_method_options($args);
        foreach ($methods as $key => $method) {
            $a[$method->value] = $method->name;
        }
        return $a;
    }
}

if(!function_exists('get_payment_method_id_options')){
    /**
     * lấy danh sách phương thức thanh toán đơn hàng
     * @return Arr[]|\App\Models\PaymentMethod[]
     */
    function get_payment_method_id_options($args = [], $defaltText = null)
    {
        $a = $defaltText ? ["" => $defaltText] : [];

        $methods = get_payment_method_options($args);
        foreach ($methods as $key => $method) {
            $a[$method->id] = $method->name;
        }
        return $a;
    }
}



if(!function_exists('get_atm_bank_options')){
    /**
     * lấy danh sách phương thức thanh toán đơn hàng
     * @return array
     */
    function get_atm_bank_options($options, $asset = '')
    {
        $values = [];
        $a = rtrim($asset, '/') . '/';
        foreach ($options as $key => $value) {
            $values[$value->code] = '<span class="text-with-icon">'.
                '<span class="icon">'.
                    '<img class="img-icon" src="'.$a.$value->logo.'" />'.
                '</span>'.
                '<span class="text">'.$value->title.'</span>'.
            '</span>';
        }
        return $values;
    }
}
if(!function_exists('curl_helper')){

    function curl_helper($url, $data, $header){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

}


