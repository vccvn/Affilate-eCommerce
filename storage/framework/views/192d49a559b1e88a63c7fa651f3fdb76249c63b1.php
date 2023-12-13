<div class="mien-header header sticky-header">
    <nav class="navbar">
        <div class="container-lg nacbar-inner">
            <a href="javascript:void(0);" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#main-menu-wrapper" aria-controls="main-menu-wrapperß" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </a>
            <a class="navbar-brand" href="/">
                <img src="<?php echo e($siteinfo->logo(theme_asset('images/logo-mien.png'))); ?>" alt="<?php echo e($siteinfo->site_name); ?>" class="d-inline-block align-text-top">

            </a>
            <a href="<?php echo e(route('client.orders.cart')); ?>" class="minicart-btn">
                <span>
                    <i class="pe-7s-shopbag"></i>
                    <div class="notification <?php echo e(parse_classname('cart-quantity')); ?>">0</div>
                </span>
            </a>

            <div class="collapse main-menu-wrapper" id="main-menu-wrapper">
                <?php echo $helper->getCustomMenu('primary', 2, [
                        'class' => 'navbar-nav justify-content-center flex-grow-1'
                    ])
                    // thêm một action khi lặp qua từng menu item
                    ->addAction(function($item, $link, $sub){
                        // $item->removeClass();
                        $link->removeClass();
                        $item->removeClass();
                        $level = $item->getSonLevel();
                        $SubItems = ($hasSub = $item->hasSubMenu()) ? $item->sub->count() : 0;
                        if(!$item->level){
                            $item->addClass('nav-item');
                            $link->addClass('nav-link');
                            if($item->isActive()){
                                // $item->removeClass('active');
                                $link->attr('aria-current',"page");
                            }
                            if($hasSub){
                                $item->sub->addClass('dropdown-menu');
                                $item->addClass('dropdown');
                                $link->addClass('dropdown-toggle');
                                $link->after('<span class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false"></span>');
                            }
                        }
                        else{
                            $link->addClass('dropdown-item');
                                    
                        }                                        
                    }); ?>

            </div>
        </div>
    </nav>
</div><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/templates/header.blade.php ENDPATH**/ ?>