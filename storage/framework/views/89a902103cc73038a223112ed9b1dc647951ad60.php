<?php
    $tabs = get_product_page_tabs();
    $t = $tab??'all';
?>

<div class="tab-block">
    <div class="row tabs">
        <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-4 tab-item">
                <a href="<?php echo e(route('client.products.'.$key)); ?>" class="tab-link <?php echo e($key == $t ? 'active': ''); ?>"><?php echo e($text); ?></a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/modules/products/templates/tabs.blade.php ENDPATH**/ ?>