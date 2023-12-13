
<?php $__env->startSection('title', $page_title); ?>
<?php echo $__env->make($_lib . 'register-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('body.class', 'product-page'); ?>
<?php $__env->startSection('content'); ?>
    <?php
        $hasPromo = $product->hasPromo();
        // $reviews = $product->getReviewData();
        $hasOption = $product->hasOption();
        $u = $product->getViewUrl();
        $user = $request->user();
        add_product_schema($product);
        
        $reviewAnalytics = $product->getReviewData();
        
    ?>
    <?php
        $thumbnails = $product->getThumbnailOrderOption();
        $thumbnailImages = [];
        if ($thumbnails) {
            foreach ($thumbnails as $thumbAttr) {
                if (is_array($attrValues = $thumbAttr->values) && count($attrValues)) {
                    foreach ($attrValues as $attrVal) {
                        if ($attrVal->thumbnail) {
                            $thumbnailImages[] = $attrVal;
                        }
                    }
                }
            }
        }
    ?>
    <div id="product-container" class="product-container">
        <div id="product-detail" class="product-detail  <?php echo e(parse_classname('product-detail')); ?>">
            <div class="inner-content">
                <div class="row">
                    <div class="col-md-6 col-image">
                        <div class="product-gallery">

                            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper swiper-viewer">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="<?php echo e($product->getImage()); ?>" class="img-fluid blur-up lazyload" alt="<?php echo e($product->name); ?>">
                                    </div>
                                    <?php if($thumbnailImages): ?>
                                        <?php $__currentLoopData = $thumbnailImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="swiper-slide">
                                                <img src="<?php echo e($thumb->thumbnail); ?>" id="pav-thumbnail-<?php echo e($thumb->value_id); ?>" class="img-fluid blur-up lazyload" alt="<?php echo e($thumb->text); ?>">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($product->gallery && count($product->gallery)): ?>
                                        <?php $__currentLoopData = $product->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="swiper-slide">
                                                <img src="<?php echo e($item->url); ?>" class="img-fluid blur-up lazyload" alt="<?php echo e($product->name); ?>">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            <div thumbsSlider="" class="swiper swiper-thumbnails">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="<?php echo e($product->getImage()); ?>" class="img-fluid blur-up lazyload" alt="<?php echo e($product->name); ?>">
                                    </div>
                                    <?php if($thumbnailImages): ?>
                                        <?php $__currentLoopData = $thumbnailImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="swiper-slide">
                                                <img src="<?php echo e($thumb->thumbnail); ?>" id="pav-thumbnail-<?php echo e($thumb->value_id); ?>" class="img-fluid blur-up lazyload" alt="<?php echo e($thumb->text); ?>">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($product->gallery && count($product->gallery)): ?>
                                        <?php $__currentLoopData = $product->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="swiper-slide">
                                                <img src="<?php echo e($item->url); ?>" class="img-fluid blur-up lazyload" alt="<?php echo e($product->name); ?>">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-info">
                        <div class="product-info <?php echo e(parse_classname('product-detail-info', 'product-detail-info-' . $product->id)); ?>" id="product-detail-<?php echo e($product->id); ?>" data-id="<?php echo e($product->id); ?>">
                            <h3 class="product-name"><?php echo e($product->name); ?></h3>
                            <div class="product-price-box">

                                <?php if($hasPromo && $product->price_status > -1): ?>
                                    <span class="old-price">
                                        <?php echo e($product->priceFormat('list')); ?>

                                    </span>
                                    
                                <?php endif; ?>

                                <span class="regular-price  <?php echo e(parse_classname('product-price')); ?>"><?php echo e($product->priceFormat('final')); ?></span>
                            </div>

                            <div class="product-detail-content">
                                <?php echo $product->detail; ?>

                            </div>

                            <?php if($ecommerce->allow_place_order && $product->price_status > 0 && $product->status > 0 && $product->available_in_store): ?>
                                <form action="<?php echo e(route('client.orders.add-to-cart')); ?>" method="post" class="<?php echo e($product->price_status < 0 ? '' : parse_classname('product-order-form')); ?>"data-check-required="<?php echo e($ecommerce->allow_place_order && $product->price_status > 0 && $product->status > 0 && $product->available_in_store ? 'true' : 'false'); ?>">

                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>" class="<?php echo e(parse_classname('product-order-id')); ?>">
                                    <input type="hidden" name="redirect" value="checkout">


                                    <?php echo $product->attributesToHtml([
                                        'section_class' => '',
                                        'attribute_class' => '',
                                        'attribute_name_class' => '',
                                        'value_list_class' => '',
                                        'value_item_class' => '',
                                        'select_class' => '',
                                        'image_class' => '',
                                        'value_text_class' => '',
                                        'radio_class' => '',
                                        'value_label_class' => '',
                                    ]); ?>






                                    <div class="addeffect-section quantity-block">


                                        <h6 class="quantity-label d-block">Số lượng</h6>

                                        <div class="qty-box">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <button type="button" class="btn quantity-left-minus" data-type="minus" data-field="">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="quantity" class="form-control input-number <?php echo e($product->price_status < 0 ? '' : parse_classname('product-order-quantity', 'quantity')); ?>" value="1" min="1" step="1">
                                                <span class="input-group-prepend">
                                                    <button type="button" class="btn quantity-right-plus" data-type="plus" data-field="">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>


                                    </div>
                                    <?php if($product->note): ?>
                                        <div class="product-note">
                                            <?php echo nl2br($product->note); ?>

                                        </div>
                                    <?php endif; ?>
                                    <div class="product-buttons">
                                        <button type="submit" class="btn btn-primary btn-add-to-cart ">
                                            <span class="text">Thêm giỏ hàng</span>
                                        </button>
                                    </div>
                                </form>
                            <?php elseif(!$product->available_in_store): ?>
                                <div class="alert alert-danger">
                                    Sản phẩm tạm hết hàng
                                </div>
                            <?php endif; ?>

                            <ul class="share-buttons">
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e($u); ?>&amp;src=sdkpreparse" target="_blank"><img src="<?php echo e(theme_asset('images/facebook.png')); ?>" alt=""></a></li>
                                <li><a href="javascript:void(0);"><img src="<?php echo e(theme_asset('images/instagram.png')); ?>" alt=""></a></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if(count($list = $product->getRelated([
            '@limit' => 6,
                '@with' => ['gallery', 'promoAvailable'],
                '@withOption' => true
        ]))): ?>
            
            <div class="relative-products">
                <h3 class="list-title">
                    Có thể bạn sẽ thích
                </h3>
                <div class="product-list row">
                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-sm-2 col-lg-4 col-item">
                            <div class="product-item">
                                <?php
                                    $hasPromo = $item->hasPromo();
                                    $reviews = $item->getReviewData();
                                    $hasOption = $item->hasOption();
                                    $u = $item->getViewUrl();
                                    $style_attrs = $item->style_attrs ?? [];
                                    $downPercent = $item->getDownPercent();
                                    $listPrice = $item->priceFormat('list');
                                    $finalPrice = $style_attrs ? get_currency_format($item->checkPrice($item->style_attrs)) : $item->priceFormat('final');
                                ?>
                                <div class="thumbnail">
                                    <a href="<?php echo e($u); ?>">
                                        <img class="product-thumbnail" src="<?php echo e($item->getImage()); ?>" alt="<?php echo e($item->name); ?>">
                                    </a>
                                </div>
                                <?php if($item->labels && count($item->labels)): ?>
                                    <div class="product-labels">
                                        <?php $__currentLoopData = $item->labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="label-item" style="background-color: <?php echo e($label->bg_color??'#000'); ?>; color: <?php echo e($label->text_color??'#fff'); ?>">
                                                <?php echo e($label->title); ?>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="info">
                                    <h4 class="product-name"><a href="<?php echo e($u); ?>"><?php echo e($item->name); ?></a></h4>
                                    <div class="product-price">
                                        <span><?php echo e($finalPrice); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout . 'master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/modules/products/detail.blade.php ENDPATH**/ ?>