<?php

use App\Http\Controllers\Clients\PostController;
use App\Http\Controllers\Clients\ProductController;
use App\Http\Controllers\Clients\SitemapController;
use App\Http\Controllers\Clients\TagController;
use Gomee\Laravel\Router;
use Illuminate\Support\Facades\Route;

$c = PostController::class;
$route = 'posts.';
$controller = TagController::class;
Route::get('/tags/{tag}.html',                             [$controller,'getPosts']       )->name($route . 'tag');
/**
 * -------------------------------------------------------------------------------------------------------------------------------
 *  Method | URI                                           | Controller @ Nethod         | Route Name               
 * -------------------------------------------------------------------------------------------------------------------------------
 */

Route::get('/danh-muc-{dynamic}/',                          [$c,'viewCategory']                  )->name($route.'categories.view-by-id');


$prefix = '/danh-muc-{dynamic}';
Route::get($prefix.'/{slug}',                           [$c,'viewCategory']            )->name($route.'categories.view-simple');
Route::get($prefix.'/{parent}/{child}/',                    [$c,'viewCategory']            )->name($route.'categories.view-child');
Route::get($prefix.'/{first}/{second}/{third}/',            [$c,'viewCategory']            )->name($route.'categories.view-3-level');
Route::get($prefix.'/{first}/{second}/{third}/{fourth}/',   [$c,'viewCategory']            )->name($route.'categories.view-4-level');



Route::get('/{dynamic}',                                    [$c,'viewDynamicPage']               )->name('posts');
Route::get('/{dynamic}/{post}',                             [$c,'viewPost']                      )->name($route.'view');

Route::get('/{slug}',                                       [$c,'viewDynamicPage']               )->name('pages.view-simple');
Route::get('/{parent}/{child}',                             [$c,'viewPost']                      )->name('pages.view-child');



