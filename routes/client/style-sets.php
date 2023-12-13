<?php

use App\Http\Controllers\Clients\PersonalStyleSetController;
use Illuminate\Support\Facades\Route;

Route::controller(PersonalStyleSetController::class)->name('style-sets')->group(function(){
    /**
     * -------------------------------------------------------------------------------------------------------------------------------
     *  Method | URI                                           | Controller @ Nethod         | Route Name
     * -------------------------------------------------------------------------------------------------------------------------------
     */

    Route::get('/style-ca-nhan',                                'viewMyStyleList'         )->name("");
    Route::get('/tao-style-ca-nhan',                            'viewCreateForm'          )->name(".create");
    
    Route::post('/luu-style-ca-nhan',                           'saveStyle'               )->name(".save");
    Route::post('/ajax-save-style',                             'saveAjaxStyle'           )->name(".ajax-save");
    Route::post('/xoa-style-ca-nhan/{id?}',                     'deleteStyle'             )->name(".delete");
    
    
    
    
    
    Route::get('style-templates.json',                          'getStyleTemplates'       )->name(".templates");
    Route::get('style-templates/detail/{id?}',                  'getTemplateDetail'       )->name(".templates.detail");
    Route::get('/style-ca-nhan/{id?}',                          'getStyleDetail'          )->name(".detail");
    Route::get('/style-ca-nhan/{id}/cap-nhat',                  'viewUpdateForm'          )->name(".update");
    Route::get('/style-ca-nhan/{id}/suggestions/{tab?}',        'getSuggestProducts'      )->name(".suggest-products");

});