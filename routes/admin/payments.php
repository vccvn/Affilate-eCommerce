<?php

use App\Http\Controllers\Admin\Ecommerce\PaymentMethodController;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Route;

Route::prefix('methods')->controller(PaymentMethodController::class)->name('.methods')->group(function () {
    $master = admin_routes(
        // khai bao route
        null, true, true,
        // khai bao module
        true, null, "Quản lý phương thức thanh toán", "Cho phép thêm sửa xóa và thiệt lập cấu hình các phương thức thanh toán"
    );
    /**
     * --------------------------------------------------------------------------------------------------------------------
     *               Method | URI                           | Controller @ Nethod                   | Route Name
     * --------------------------------------------------------------------------------------------------------------------
     */

    
    
    $inputs = Route::post('/inputs',                        'getMethodInputs'                      )->name('.inputs');
    $ajaxSv = Route::post('/ajax-save',                     'ajaxSave'                             )->name('.ajax.save');
    $updStt = Route::post('/update-status',                 'updateStatus'                         )->name('.ajax.update-status');
    $ajDetail=Route::get('/ajax-detail',                    'getMethodDetail'                      )->name('.ajax.detail');
    $priority=Route::post('/update-priority',               'updatePriority'                       )->name('.ajax.update-priority');
    
    $master->addActionByRouter($inputs, ['create', 'update']);
    $master->addActionByRouter($ajaxSv, ['create', 'update']);
    $master->addActionByRouter($updStt, ['create', 'update']);
    $master->addActionByRouter($ajDetail, ['create', 'update']);
    $master->addActionByRouter($priority, ['create', 'update']);
    
});
