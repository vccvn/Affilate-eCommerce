
<?php $__env->startSection('title', $page_title); ?>
<?php echo $__env->make($_lib . 'register-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('body.class', 'product-page'); ?>
<?php $__env->startSection('content'); ?>

    <div class="product-list-content">
        <?php echo $__env->make($_template . 'page-header', [
            'title' => $page_title,
            // 'sub_title' => isset($category) && $category->description ? $category->description : $dynamic->description,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php
            // $tabs = get_product_page_tabs();
            $t = $tab ?? 'all';
        ?>

        <div class="container-lg">
            <div class="row">
                <div class="col-lg-12 col-main">

                    <?php echo $__env->make($_current . 'templates.tabs', ['tab' => $t], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php if($t == 'all' && $html->product_banners && $html->product_banners->getComponents()): ?>
                        <div class="product-banners">
                            <?php echo $html->product_banners->components; ?>

                        </div>
                    <?php endif; ?>

                    <?php if(count($products)): ?>
                        <div class="product-list row">
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-sm-2 col-lg-4 col-item">
                                    <div class="product-item">
                                        <?php
                                            $hasPromo = $product->hasPromo();
                                            $reviews = $product->getReviewData();
                                            $hasOption = $product->hasOption();
                                            $u = $product->getViewUrl();
                                            $style_attrs = $product->style_attrs ?? [];
                                            $downPercent = $product->getDownPercent();
                                            $listPrice = $product->priceFormat('list');
                                            $finalPrice = $style_attrs ? get_currency_format($product->checkPrice($product->style_attrs)) : $product->priceFormat('final');
                                        ?>
                                        <div class="thumbnail">
                                            <a href="<?php echo e($u); ?>">
                                                <img class="product-thumbnail" src="<?php echo e($product->getImage()); ?>" alt="<?php echo e($product->name); ?>">
                                            </a>
                                        </div>
                                        <?php if($product->labels && count($product->labels)): ?>
                                            <div class="product-labels">
                                                <?php $__currentLoopData = $product->labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="label-item" style="background-color: <?php echo e($label->bg_color??'#000'); ?>; color: <?php echo e($label->text_color??'#fff'); ?>">
                                                        <?php echo e($label->title); ?>

                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="info">
                                            <h4 class="product-name"><a href="<?php echo e($u); ?>"><?php echo e($product->name); ?></a></h4>
                                            <div class="product-price">
                                                <span><?php echo e($finalPrice); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="mien-pagination">
                            <?php echo e($products->links($_template . 'pagination')); ?>

                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">
                            Không tìm thấy kết quả phù hợp!
                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout . 'master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/modules/products/list.blade.php ENDPATH**/ ?>