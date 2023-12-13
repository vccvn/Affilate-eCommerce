<?php

use App\Http\Controllers\Admin\General\BannerController;

admin_routes(BannerController::class, true, true, true, null, 'Quản lý banner', 'Quản lý các banner hiển thị trên trang web');

