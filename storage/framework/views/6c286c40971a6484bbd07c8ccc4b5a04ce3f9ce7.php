<!doctype html>
<html <?php echo $html->getTagAttributeToString('html', ['lang' => 'vi']); ?>>
<head>
    <?php echo $__env->make($_lib.'head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body <?php echo $html->getTagAttributeToString('body'); ?>>

    <?php echo $html->top->embeds; ?>


    <?php echo $__env->yieldContent('body'); ?>

    <?php echo $html->bottom->embeds; ?>

    <?php echo $__env->make($_lib.'js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


</body>
</html><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/client-libs/layout.blade.php ENDPATH**/ ?>