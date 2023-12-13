

<?php if($is_template): ?>
    <?php echo $__env->make($_base.'forms.templates.'.$input->template, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php elseif($input->type == 'file'): ?>
    <div class="custom-file">
        <?php $input->addClass('custom-file-input'); ?>
        <?php echo $input; ?>

        <label class="custom-file-label selected" for="<?php echo e($input->id); ?>"><?php echo e($input->val()?$input->val():'Chưa có file nào dc chọn'); ?></label>
    </div>
<?php elseif(in_array($type, ['checkbox', 'radio', 'checklist'])): ?>
    
    <div class="checkbox-radio <?php echo e($input->data('display') == 'list'?'display-list':"display-inline"); ?>">
        <?php echo $input; ?>

    </div>
<?php else: ?>
    <?php echo $input; ?>    
<?php endif; ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/form-input.blade.php ENDPATH**/ ?>