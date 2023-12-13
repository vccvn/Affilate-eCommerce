<?php

use App\Engines\ModuleManager;
use App\Http\Controllers\Admin\General\SettingController;
use App\Http\Controllers\Admin\General\UrlSettingController;
use App\Http\Controllers\Admin\General\WebConfigController;
use Illuminate\Support\Facades\Route;



$master = ModuleManager::addModule('admin', 'settings', [
    'name' => 'Thiết lập',
    'type' => 'module',
    'prefix' => 'admin/settings',
    'path' => 'admin.settings'
]);


Route::prefix('urls')->controller(UrlSettingController::class)->name('.urls')->group(function(){
    // manager_routes($s, $route, true);

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */

    Route::get('/',                               'getUrlSettingForm'                     )->name("");
    Route::get('/{group}.html',                   'getUrlSettingForm'                     )->name('.group');
    Route::post('/{group}/save',                  'saveSettings'                          )->name('.group.save');
    

});






// manager_routes($s, $route, true);

Route::controller(WebConfigController::class)->group(function(){

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */

    Route::get('/webconfig.html',                'getWebConfigForm'                      )->name('.webconfig');
    Route::post('/webconfig/save',               'handle'                                )->name('.webconfig.save');
    
});

Route::controller(SettingController::class)->name('.')->group(function() use($master){
    $update = Route::post('/update',                        'handle'                               )->name('handle');

    $form   = Route::get('/{group}.html',                   'getSettingForm'                       )->name('group.form');
    $save   = Route::post('/{group}/save',                  'handle'                               )->name('group.save');
    $item   = Route::post('/{group}/items/save',            'saveSettingItem'                      )->name('item.save');
    
    $detail = Route::get('{group}/detail-item/{id?}',       'detailItem'                           )->name('item.detail');
    $sortF  = Route::get('{group}/sort.html',               'getSortForm'                          )->name('sort.form');
    $sortS  = Route::post('{group}/sort',                   'sortItems'                            )->name('sort.save');
    $delete = Route::post('{group}/delete',                 'deleteItem'                           )->name('item.delete');

    $master->addActionByRouter($update, ['update'], null, "Cập nhật");
    $master->addActionByRouter($form, ['update', 'view'], null, "Form Cập nhật");
    $master->addActionByRouter($save, ['update'], null, "Cập nhật");
    $master->addActionByRouter($item, ['update'], null, "Save Item");
    $master->addActionByRouter($detail, ['update', 'view'], null, "Chi tiết");
    $master->addActionByRouter($sortF, ['update']);
    $master->addActionByRouter($sortS, ['update'], null, "Save Item");
    $master->addActionByRouter($delete, ['update'], null, "delete");
    
    
});
