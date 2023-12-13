
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
                    
                    <?php if(count($collections)): ?>
                        <div class="product-list row">
                            <?php $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-sm-2 col-lg-4 col-item">
                                    <div class="product-item">
                                        <?php
                                            // $u = $item->getViewUrl();
                                            $u = route('client.products', ['collection' => $item->id]);
                                            // $url.="?collection=" . $item->id;
                                            
                                        ?>
                                        <div class="thumbnail">
                                            <a href="<?php echo e($u); ?>">
                                                <img class="product-thumbnail" src="<?php echo e($item->image); ?>" alt="<?php echo e($item->name); ?>">
                                            </a>
                                        </div>
                                        <div class="info">
                                            <h4 class="product-name"><a href="<?php echo e($u); ?>"><?php echo e($item->name); ?></a></h4>
                                            
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="mien-pagination">
                            <?php echo e($collections->links($_template . 'pagination')); ?>

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

<?php echo $__env->make($_layout . 'master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/modules/products/collections.blade.php ENDPATH**/ ?>