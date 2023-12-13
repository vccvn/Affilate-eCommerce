<?php

use App\Engines\ModuleManager;
use App\Http\Controllers\Admin\Ecommerce\PersonalStyleSetConfigController;
use App\Http\Controllers\Admin\Ecommerce\PersonalStyleSetSampleController;
use App\Http\Controllers\Admin\Ecommerce\PersonalStyleSetTemplateController;
use App\Http\Controllers\Admin\Ecommerce\StyleSetController;
use Illuminate\Support\Facades\Route;

$master = admin_routes(
    // khai bao route
    StyleSetController::class, true, true,
    // khai bao module
    true, null, "Quản lý Style Set", "Cho phép xem danh sách, hoặc thêm / sửa / xóa các style set"
);

Route::controller(StyleSetController::class)->group(function() use($master){
    /**
     * --------------------------------------------------------------------------------------------------------------------
     *              Method | URI                              | Controller @ Nethod                   | Route Name
     * --------------------------------------------------------------------------------------------------------------------
     */
    $gpi       = Route::get('/get-product-input',             'getProductInput'                       )->name('.get-product-input');
    $checkSlug = Route::post('/check-slug',                   'checkSlug'                             )->name('.check-slug');
    $getSlug   = Route::get('/get-slug',                      'getSlug'                               )->name('.get-slug');
    $setTags   =  Route::get('/tags',                         'getSetTagData'                         )->name('.tag-data');

    $master->addActionByRouter($gpi, ['view', 'update', 'create']);
    $master->addActionByRouter($checkSlug, ['create', 'update']);
    $master->addActionByRouter($getSlug, ['create', 'update']);
    $master->addActionByRouter($setTags, ['create', 'update', 'refs']);
    
});


Route::prefix('personal')->name('.personal')->group(function() use($master){
    
    Route::prefix('config')->name('.config')->controller(PersonalStyleSetConfigController::class)->group(function() use($master) {
        $index = Route::get('/', 'getStyleConfigForm')->name('');

        
        $save = Route::post('save', 'handle')->name('.save');
        $create = Route::post('create', 'saveItem')->name('.create-item');
        $update = Route::post('update', 'saveItem')->name('.update-item');
        $delete = Route::post('delete', 'delete')->name('.delete-item');

        $sub = $master->addSubByMasterRouter($index, 'Quản lý cấu hình mẫu Style set', 'Cho phép xem và chỉnh các thông số cho khung preview và các item của set');
        $sub->addActionByRouter($save, ['create', 'update'], 'Lưu cấu hình');
        $sub->addActionByRouter($create, ['create'], 'Thêm item');
        $sub->addActionByRouter($update, ['update'], 'Cập nhật item');
        $sub->addActionByRouter($delete, ['delete'], 'Xóa item');

        
        
    });

    
    Route::prefix('templates')->name('.templates')->controller(PersonalStyleSetTemplateController::class)->group(function() use($master) {
        $sub = add_web_module_routes(
            null, ['index','list', 'create', 'update', 'save', 'delete'], true, 'admin', 
            true, null ,  "Quản lý mẫu style cá nhân", "Bao gồm thêm sửa xóa và cấu hình mẫu style", $master);
        
        $detail                = Route::get('detail/{id}.html', 'viewTemplateDetail')->name('.detail');
        $ajaxCreate            = Route::post('CREATE', 'ajaxSave')->name('.ajax-create');
        $ajaxUpdate            = Route::post('UPDATE', 'ajaxSave')->name('.ajax-update');
        

        $sub->addActionByRouter($detail, ['view'], 'Xem Chi tiết');
        $sub->addActionByRouter($ajaxCreate, ['create'], 'Tạo mới');
        $sub->addActionByRouter($ajaxUpdate, ['update'], 'Cập nhật');




        $ajaxCreateItem        = Route::post('CREATE-ITEM', 'createItem')->name('.create-item');
        $ajaxUpdateItem        = Route::post('UPDATE-ITEM', 'updateItem')->name('.update-item');
        $ajaxDeleteItem        = Route::post('DELETE-ITEM', 'deleteItem')->name('.delete-item');
        $ajaxCreateItemConfig  = Route::post('CREATE-ITEM-CONFIG', 'createItemConfig')->name('.create-item-config');
        $ajaxUpdateItemConfig  = Route::post('UPDATE-ITEM-CONFIG', 'updateItemConfig')->name('.update-item-config');
        $ajaxDeleteItemConfig  = Route::post('DELETE-ITEM-CONFIG', 'deleteItemConfig')->name('.delete-item-config');
        


        
        $itemMaster = $sub->addSub('items', [
            'name' => 'Quản lý Item',
            'description' => 'Quản lý danh sách và cấu hình item của các set mẫu của người dùng',
            'path' => 'admin.style-sets.personal.templates.items',
            'route' => 'admin.style-sets.personal.templates.items'
        ]);

        $itemMaster->addActionByRouter($ajaxCreateItem, ['create'], 'Tạo mới');
        $itemMaster->addActionByRouter($ajaxUpdateItem, ['update'], 'Cập nhật');
        $itemMaster->addActionByRouter($ajaxDeleteItem, ['delete'], 'Xóa');


        $itemMaster->addActionByRouter($ajaxCreateItemConfig, ['create'], 'Tạo mới');
        $itemMaster->addActionByRouter($ajaxUpdateItemConfig, ['update'], 'Cập nhật');
        $itemMaster->addActionByRouter($ajaxDeleteItemConfig, ['delete'], 'Xóa');
        
    });

    Route::prefix('samples')->name('.samples')->controller(PersonalStyleSetSampleController::class)->group(function() use($master) {
        $master = admin_routes(null, true, true, true, null, "Style mẫu", "Quản lý danh sách Style mẫu, cho phép thêm sửa xóa Style mẫu...", $master);
    });

});