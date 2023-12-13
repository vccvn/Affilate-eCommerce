
<div class="col-xl-<?php echo e($data->col_xl(2)); ?> col-lg-<?php echo e($data->col_lg(3)); ?> col-md-<?php echo e($data->col_md(4)); ?> col-sm-<?php echo e($data->col_sm(6)); ?> col-sm-<?php echo e($data->col_xs(12)); ?>  <?php echo e($data->class); ?> ">
    <div class="footer-links">
        <?php echo $helper->getCustomMenu(['id' => $data->menu_id], 1, [
                'class' => 'footer-menu '.$data->menu_class
            ])->addAction(function($item, $link){
              $link->rel='nofollow';
            }); ?>

    </div>
</div><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/components/footer/menu.blade.php ENDPATH**/ ?>