<?php

use App\Engines\ModuleManager;
use App\Http\Controllers\Admin\Ecommerce\CCD\BodyShapeController;
use App\Http\Controllers\Admin\Ecommerce\CCD\SkinColorController;
use Illuminate\Support\Facades\Route;

$master = ModuleManager::addModule('admin', 'custom-centric-data', [
    'name' => 'Dữ liệu hướng người dùng',
    'description' => 'Quản lý dữ liệu người dùng',
    'prefix' => 'admin/custom-centric-data',
    'path' => 'admin.custom-centric-data'
]);

Route::prefix('body-shapes')->as('.body-shapes')->controller(BodyShapeController::class)->group(function() use($master){
    $sub = admin_routes(null, true, true, true, null, 'Quản lý Dáng người', 'Quản lý các Dáng người hiển thị cho chọn Style', $master);
    /**
     * --------------------------------------------------------------------------------------------------------------------
     *              Method | URI                              | Controller @ Nethod                   | Route Name
     * --------------------------------------------------------------------------------------------------------------------
     */
    // $gpi       = Route::get('/get-product-input',             'getProductInput'                       )->name('.get-product-input');
    // $sub->addActionByRouter($gpi, ['view', 'update', 'create']);
    
});

Route::prefix('skin-colors')->as('.skin-colors')->controller(SkinColorController::class)->group(function() use($master){
    $sub = admin_routes(null, true, true, true, null, 'Quản lý Mau2 da', 'Quản lý các mau2 da hiển thị cho chọn Style', $master);
    
});

