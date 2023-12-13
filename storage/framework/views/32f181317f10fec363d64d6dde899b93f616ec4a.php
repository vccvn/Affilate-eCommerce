
<?php
    $webType = get_web_type();
?>

            <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
                <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                    <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                            <i class="m-menu__link-icon flaticon-add"></i>
                            <span class="m-menu__link-text">Truy cập nhanh</span>
                            <i class="m-menu__hor-arrow la la-angle-down"></i>
                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                        </a>
                        <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                            <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                            <ul class="m-menu__subnav">
                                <?php if($webType == 'ecommerce'): ?>
                                    
                                <li class="m-menu__item " aria-haspopup="true">
                                    <a href="<?php echo e(route('admin.products.create')); ?>" class="m-menu__link ">
                                        <i class="m-menu__link-icon flaticon-plus"></i>
                                        <span class="m-menu__link-text">Thêm sản phẩm</span>
                                    </a>
                                </li>
                                <li class="m-menu__item  m-menu__item--submenu" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                                    <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                        <i class="m-menu__link-icon flaticon-business"></i>
                                        <span class="m-menu__link-text">Quản lú đơn hàng</span>
                                        <i class="m-menu__hor-arrow la la-angle-right"></i>
                                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                                    </a>
                                    <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
                                        <span class="m-menu__arrow "></span>
                                        <ul class="m-menu__subnav">

                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="<?php echo e(route('admin.orders.list')); ?>" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Đơn hàng mới</span>
                                                </a>
                                            </li>
                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="<?php echo e(route('admin.orders.list-by-status', ['list' => 'verified'])); ?>" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Đã xác nhận</span>
                                                </a>
                                            </li>
                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="<?php echo e(route('admin.orders.list-by-status', ['list' => 'pending'])); ?>" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Chờ xử lý</span>
                                                </a>
                                            </li>
                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="<?php echo e(route('admin.orders.list-by-status', ['list' => 'processing'])); ?>" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Đang xử lý</span>
                                                </a>
                                            </li>
                                            <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                                <a href="<?php echo e(route('admin.orders.list-by-status', ['list' => 'completed'])); ?>" class="m-menu__link ">
                                                    <span class="m-menu__link-text">Đã hoàn thành</span>
                                                </a>
                                            </li>
                                            
                                            

                                        </ul>
                                    </div>
                                </li>

                                <?php endif; ?>

                                <?php if(count($dynamics = get_dynamics())): ?>
                                    <?php $__currentLoopData = $dynamics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        
                                        <li class="m-menu__item " aria-haspopup="true">
                                            <a href="<?php echo e(route('admin.posts.create', ['dynamic' => $item->slug])); ?>" class="m-menu__link ">
                                                <i class="m-menu__link-icon flaticon-file"></i>
                                                <span class="m-menu__link-text">Thêm <?php echo e($item->name); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                
                            </ul>
                        </div>
                    </li>
                    <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                        <a href="<?php echo e(route('home')); ?>" target="_blank" class="m-menu__link">
                            <i class="m-menu__link-icon fa fa-home"></i>
                            <span class="m-menu__link-text">Xem trang chủ</span>
                        </a>
                    </li>
                </ul>
            </div><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/_components/header-menu.blade.php ENDPATH**/ ?>