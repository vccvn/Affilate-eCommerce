<?php if($data = get_js_data()): ?>
    <script>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        var <?php echo e($name); ?> = <?php echo json_encode($value, 15, 512) ?>;

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </script>
<?php endif; ?><?php /**PATH /Users/doanln/Desktop/Gomee/wisestyle/resources/views/admin/_templates/js-data.blade.php ENDPATH**/ ?>