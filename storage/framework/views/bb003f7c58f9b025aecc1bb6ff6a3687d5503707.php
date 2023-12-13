<?php
    $t = isset($title) && $title ? $title : $__env->yieldContent('page.header.title');
    $st = isset($sub_title) && $sub_title ? $sub_title : (isset($subTitle) && $subTitle ? $subTitle : $__env->yieldContent('page.header.sub-title', $__env->yieldContent('page.header.subTitle')));
?>

<div class="page-header container-lg">

    <div class="inner">
        <h2 class="title"><?php echo e($t ?? ''); ?></h2>
        <div class="spactor"></div>

        <?php if($st): ?>
            <h3 class="sub-title">
                <?php echo nl2br($st); ?>

            </h3>
        <?php endif; ?>
    </div>

</div>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/templates/page-header.blade.php ENDPATH**/ ?>