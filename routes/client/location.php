<?php

use Illuminate\Support\Facades\Route;

Route::get('ajax/region-data',                  'getRegionData'          )->name('regions.data');
Route::get('ajax/region-options',               'getRegionOptions'       )->name('regions.options');
Route::get('ajax/district-options',             'getDistrictOptions'     )->name('districts.options');
Route::get('ajax/ward-options',                 'getWardOptions'         )->name('wards.options');


