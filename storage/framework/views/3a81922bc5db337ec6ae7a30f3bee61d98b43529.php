<?php
set_admin_template_data('modals', 'colorpicker-modal');
$input->type = 'text';
$input->addClass('color-picker form-control colorpicker');
$val = $input->val();
if($val){
    $input->style = "color: $val";
}
?>

    <div class="input-group">
    
        <?php echo $input; ?>

        <div class="input-group-append">
            <button type="button" class="btn btn-info color-picker-btn" data-input-id="<?php echo e($input->id); ?>" data-change-color-selector="#<?php echo e($input->id); ?>" id="button-group-<?php echo e($input->id); ?>"><i class="fa fa-paint-brush"></i></button>
        </div>
    

    </div><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/templates/colorpicker.blade.php ENDPATH**/ ?>