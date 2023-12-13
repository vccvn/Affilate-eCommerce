<?php

namespace App\Engines\Payments;

use App\Engines\Helper;
use App\Exceptions\NotReportException;
use Gomee\Files\Filemanager;
use Gomee\Helpers\Arr;

class Momo
{
    protected static $_config = [];
    const PAYMENT_URL = 'https://test-payment.momo.vn/v2/gateway/api/create';
    const VERIFY_URL = 'https://test-payment.momo.vn/v2/gateway/api/query';
    const VERSION = '2.0.0';

    /**
     * cấu hình
     *
     * @param array $config
     * @return $this
     */
    public static function config($config = [])
    {
        static::$_config = $config;
    }

    /**
     * tạo url thanh toám
     *
     * @param array $payment_data
     * @return string duong dan thanh toan vnpay
     */

    public static function create($payment_data = [])
    {
        $d = new Arr(array_merge(static::$_config, $payment_data));
        $partnerCode = $d->get(['partnerCode', 'partner_code', 'momo_partnerCode']); //Mã website tại VNPAY

        $accessKey = $d->get(['accessKey', 'access_key']); //Chuỗi bí mật
        $secretKey = $d->get(['secretKey', 'secret_key']); //Chuỗi hash
        $amount = $d->momo_Amount((int)($d->get(['total', 'money', 'total_money'], 0)));

        $order_id = $d->get(['order_id', 'orderId', 'id']);
       if (!$partnerCode || !$accessKey || !$secretKey || !is_numeric($amount) || !$order_id) abort(402, "Thông tin thanh toán không hợp lệ");

        $momo_Url = static::PAYMENT_URL;

        $momo_OrderInfo = $d->get(["momo_OrderInfo", 'note'], "Thanh toan hoa don so " . $order_id);
        // $vnp_Amount = $amount;
        // $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = [
            "partnerCode" => $partnerCode,
            "requestType" => $d->momo_requestType("captureWallet"),
            "ipnUrl" => $d->get('ipnUrl'),
            "redirectUrl" => $d->get('redirectUrl'),
            "orderId" => $order_id,
            "amount" => $amount,
            "orderInfo" => $momo_OrderInfo,
            "requestId" => $d->momo_RequestId(date('YmdHis')) . $order_id,
            "extraData" => "eyJ1c2VybmFtZSI6ICJtb21vIn0=",
        ];


        $inputData['signature'] = self::generateSignature($inputData, $accessKey, $secretKey);

        $inputData["lang"] = $d->momo_Locale($d->locale('vi'));
        $header = array(
            'Content-Type: application/json'
        );
        $result = [];
        try {
            $result = curl_helper($momo_Url, json_encode($inputData), $header);
            $jsonResult = json_decode($result, true);
            if ($jsonResult['payUrl'] != null) {
                return $jsonResult['payUrl'];
            }
        }catch (\Exception $exception){
            $exception->getMessage();
        }

        return $result;
    }

    public static function generateSignature($inputData, $accessKey, $secretKey)
    {
        $inputData['accessKey'] = $accessKey;

        ksort($inputData);
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
        }

        $sig = hash_hmac('sha256', $hashdata, $secretKey);
        return $sig;
    }

    /**
     * kiểm tra và xử lý giao dịch
     *
     * @param array $data
     * @param \Closure|function[$order_id,$transaction_code,$return_code]|mixed $callback
     * @return array
     */
    public static function check($data = [], $callback = null)
    {
        if (!$data) $data = request()->all();
        $config = static::$_config;
        if (!isset($config['TmnCode']) || !isset($config['HashSecret'])) abort(404);
        // code của vnpay
        $inputData = array();
        $returnData = array();
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $secureHash = hash('sha256', $config['HashSecret'] . $hashData);
        $Status = 0;
        $orderId = $inputData['vnp_TxnRef'];

        // bắt đầu logic
        $orderInfo = isset($inputData['vnp_OrderInfo']) ? $inputData['vnp_OrderInfo'] : 0;
        $rspCode = '99';
        $vnMessage = [
            '00' => 'Success',
            '97' => 'Chu ky khong hop le',
            '01' => 'Order not found',
            '02' => 'Order already confirmed',
            '99' => 'Loi khong xac dinh'
        ];

        try {
            app(Filemanager::class)->append(json_encode($inputData) . "\r\n", storage_path("logs/access/vnp-" . date("Y-m-d") . '.txt'));
            //Check Orderid
            //Kiểm tra checksum của dữ liệu
            if ($secureHash != $vnp_SecureHash) {
                $rspCode = '97';
            } else {
                if (is_callable($callback)) {
                    $rs = call_user_func_array($callback, [
                        $orderId,
                        $vnpTranId,
                        [
                            'success' => '00',
                            'exists' => '01',
                            'paid' => '02',
                            'fail' => '99',
                            'uthor' => '99'
                        ]
                    ]);

                    if (is_bool($rs)) {
                        $rspCode = $rs == true ? '00' : '99';
                    } elseif (is_numeric($rs) || is_string($rs)) {
                        if (array_key_exists($rs, $vnMessage)) {
                            $rspCode = $rs;
                        } else $rspCode = '99';
                    }
                } else {
                    $rspCode = '99';
                }
            }

            $returnData['RspCode'] = $rspCode;
            $returnData['Message'] = $vnMessage[$rspCode];
        } catch (NotReportException $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        //Trả lại VNPAY theo định dạng JSON
        return $returnData;
    }

    public static function status($inputData = [])
    {
        $config = static::$_config;
        dd($config);
//        if (!isset($config['TmnCode']) || !isset($config['HashSecret'])) abort(404);

        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? 'hahaha';
        $vnp_ResponseCode = $inputData['vnp_ResponseCode'] ?? 'sai';
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }

        $secureHash = hash('sha256', $config['HashSecret'] . $hashData);

        if ($secureHash != $vnp_SecureHash) {
            return null;
        } elseif ($vnp_ResponseCode != '00') {
            return false;
        }
        return true;
    }
}
