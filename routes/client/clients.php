<?php

use App\Http\Controllers\Clients\CommentController;
use App\Http\Controllers\Clients\ContactController;
use App\Http\Controllers\Clients\LocationController;
use App\Http\Controllers\Clients\PWAController;
use App\Http\Controllers\Clients\SearchController;
use App\Http\Controllers\Clients\SubscribeController;
use App\Http\Controllers\Clients\ThemeController;
use App\Http\Controllers\Clients\VisitorController;
use Illuminate\Support\Facades\Route;

$route = '.';

$c = '';
// $c = 'SearchController@';
// $route = 'client.posts.';
/**
 * ---------------------------------------------------------------------------------------------------------
 *  Method | URI                                   | Controller @ Nethod         | Route Name               
 * ---------------------------------------------------------------------------------------------------------
 */
Route::get('tim-kiem', [SearchController::class, 'search'])->name('search');


// comments
$c = 'CommentController@';
Route::post('ajax/ajax-comment',                         [CommentController::class, 'ajaxSave'])->name('comments.ajax');
Route::post('ajax/post-comment',                         [CommentController::class, 'create'])->name('comments.post');


// contact
$c = ContactController::class;
Route::get('lien-he',                               [$c, 'showForm'])->name('contacts.form');
Route::post('ajax/gui-lien-he',                          [$c, 'sendContact'])->name('contacts.send');
Route::post('ajax/gui-lien-he-bang-ajax',                [$c, 'ajaxSend'])->name('contacts.ajax-send');

// contact
$c = SubscribeController::class;
Route::post('ajax/subscribe',                             [$c, 'save'])->name('subscribe');
Route::post('ajax/subscribe-api',                             [$c, 'ajaxSave'])->name('ajax-subscribe');

$c = ThemeController::class;
Route::get('themes/preview',                        [$c, 'preview'])->name('themes.preview');
Route::get('themes/reset',                          [$c, 'reset'])->name('themes.preview');




// Route::get('crawler',                               'CrawlerController@test'    )->name($route.'crawler.test');


// $c = LocationController::class;
// Route::get('location/region-options',               [$c, 'getRegionOptions'])->name('location.regions.options');
// Route::get('location/district-options',             [$c, 'getDistrictOptions'])->name('location.districts.options');
// Route::get('location/ward-options',                 [$c, 'getWardOptions'])->name('location.wards.options');




$c = VisitorController::class;
Route::get('ajax/check-visitor',                         [$c, 'checkVisitor'])->name('visitors.check');
Route::post('ajax/check-visitor',                        [$c, 'checkVisitor']);

Route::get('manifest.json',                         [PWAController::class, 'showManifest'])->name('manifest');
Route::get('service-worker.js',                     [PWAController::class, 'showSWjs'])->name('SW.js');
