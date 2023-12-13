<?php

/**
 * load tat ca cac file helper
 */
require_once 'constants.php';
require_once 'config.php';
require_once 'theme.php';
require_once 'view.php';
require_once 'general.php';
require_once 'ecommerce.php';
require_once 'payments.php';
require_once 'admin.php';
require_once 'posts.php';
require_once 'urls.php';
require_once 'users.php';
require_once 'routes.php';
if (!function_exists('arr_combine_list')) {

    /**
     * lấy danh sách tổ hợp của các phần tử bên trong các mảng đầu vào
     *
     * @param array<int|string, array<int|string, mixed>> $arrayInput
     * @param array<int|string, array<int|string, mixed>> $arrayTemp
     * @return array<int, mixed>
     */
    function arr_combine_list(array $arrayInput, array $arrayTemp = [])
    {
        $arrayFirst = array_shift($arrayInput);
        $newArrData = [];
        if (is_array($arrayFirst)) {
            if ($arrayTemp) {
                foreach ($arrayTemp as $key => $tempVal) {
                    foreach ($arrayFirst as $fKey => $inpVal) {
                        $a = $tempVal;
                        $a[] = $inpVal;
                        sort($a);
                        $newArrData[] = $a;
                    }
                }
            } else {
                foreach ($arrayFirst as $fKey => $inpVal) {
                    $newArrData[] = [$inpVal];
                }
            }
        } else {
            if ($arrayTemp) {
                foreach ($arrayTemp as $key => $tempVal) {
                    $a = $tempVal;
                    $a[] = $arrayFirst;
                    sort($a);
                    $newArrData[] = $a;
                }
            } else {
                $newArrData[] = [$arrayFirst];
            }
        }
        return count($arrayInput) ? arr_combine_list($arrayInput, $newArrData) : $newArrData;
    }
}