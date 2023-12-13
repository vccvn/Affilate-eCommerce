<?php
    $html->addTagAttribute('html', 'lang', 'vi-VN');
    $html->addTagAttribute('body', [
        'class' => $__env->yieldContent('body.class')
    ]);
    
?>

<?php $__env->startSection('body'); ?>
    <!-- header start -->
    <?php echo $__env->make($_template . 'header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- header end -->

    <?php echo $__env->yieldContent('content'); ?>

    <!-- footer start -->
    <?php
        $disableFooter = $__env->yieldContent('disable_footer');
    ?>
    <?php if(!$disableFooter): ?>
        <?php echo $__env->make($_template . 'footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <?php echo $__env->make($_template . 'js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($_lib . 'layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/layouts/master.blade.php ENDPATH**/ ?>