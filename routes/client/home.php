<?php

use Illuminate\Support\Facades\Route;
/*
 |---------------------------------------------------------------------------------------------
 |                                         Route Table
 |---------------------------------------------------------------------------------------------
 | METHOD | URI                           | ACTIOM                        | NAME               
 |---------------------------------------------------------------------------------------------
 */


Route::get('/',                          'getIndexPage')->name('home');
Route::get('/home',                      'getIndexPage');
Route::get('/index.html',                'getIndexPage')->name('client.home');
Route::get('/Default.aspx',              'getIndexPage')->name('client.default');
Route::get('csrf-token',                 'getCSRFToken')->name('client.token');
Route::get('/crawldata',                 'crawlData');