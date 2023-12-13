<?php if($plugin_javascript = get_html_plugins('javascript')): ?>
<?php $__currentLoopData = $plugin_javascript; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make('admin._plugins.'.$f, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if($data = get_js_src()): ?>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $src): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <script src="<?php echo e($src); ?>"></script>
    <!-- <?php echo e($src); ?> -->
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/_templates/js-src.blade.php ENDPATH**/ ?>