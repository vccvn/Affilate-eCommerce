<?php

use App\Http\Controllers\Admin\General\CommentController;
use Illuminate\Support\Facades\Route;

$controller = CommentController::class;


$listRoute = ['index', 'create', 'update', 'save', 'delete', 'list'];

$moduleRouter = add_web_module_routes($controller, $listRoute, true, 'admin', true, 'comments', "Quản lý Bình luận");

$changeapprove = Route::post('change-approve',[$controller, 'changeApprove'])->name('.change-approve');
$moduleRouter->addActionByRouter($changeapprove, 'extra');