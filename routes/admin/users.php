<?php

use App\Http\Controllers\Admin\General\UserController;
use Illuminate\Support\Facades\Route;



    
Route::controller(UserController::class)->group(function(){
    $master = admin_routes(null, true, true, true, null, "Quản lý Người dùng", "Cho phép thêm / sửa / xóa thông tin người dùng");
    /**
     * ----------------------------------------------------------------------------------------------------------------------------
     *                    Method | URI                           | Nethod                                | Route Name
     * ----------------------------------------------------------------------------------------------------------------------------
     */
    $selectOptions = Route::get('/user-select-options',          'getUserSelectOptions'                  )->name('.select-option');
    $tagData       = Route::get('/user-tag-data',                'getUserTagData'                        )->name('.tag-data');
    $reset2fa      = Route::post('/reset2fa',                    'reset2fa'                              )->name('.reset2fa');

    $master->addActionByRouter($selectOptions, ['view', 'create', 'update', 'refs']);
    $master->addActionByRouter($tagData, ['view', 'create', 'update', 'refs']);
    $master->addActionByRouter($reset2fa, ['update']);
    
});
