<div class="custom-file">
    <?php $input->addClass('custom-file-input'); ?>
    <?php echo $input; ?>

    <label class="custom-file-label" for="<?php echo e($input->id); ?>"><?php echo e($input->val()?$input->val():($input->choose_label??'Chưa có file nào được chọn')); ?></label>
</div><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/templates/file.blade.php ENDPATH**/ ?>