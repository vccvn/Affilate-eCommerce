<?php echo $__env->make($_lib.'meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<link rel="stylesheet" href="<?php echo e(asset('static/app/css/app.min.css')); ?>">
<?php echo $__env->make($_template.'links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('css'); ?>
<?php if($css = get_custom_css()): ?>

    <style>
    <?php echo $css; ?>

    </style>

<?php endif; ?>
<?php if($links = get_css_link()): ?>

<?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    
    <link rel="stylesheet" href="<?php echo e($link); ?>">

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php echo $html->getAndCleanCss(); ?>

<?php echo $html->head->embeds; ?>

<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/client-libs/head.blade.php ENDPATH**/ ?>