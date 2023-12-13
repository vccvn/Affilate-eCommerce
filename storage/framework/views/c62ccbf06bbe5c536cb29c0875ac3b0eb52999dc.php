
<?php
add_js_src('static/crazy/js/switch.js');
$input->type = "crazyswitch";
$input->removeClass('form-control')->removeClass('m-input');
$input->prepareCrazyInput();
$input->type = "checkbox";

$input->removeClass('m-checkbox')->setOption('is_free', 1);
?>
<span class="m-switch m-switch--outline m-switch--icon m-switch--<?php echo e($input->template_type?$input->template_type:'primary'); ?>">
    <label>
        <?php echo $input; ?>

        <span></span>
        <?php if($input->check_label): ?>
            <i class="ml-2 pt-2 d-inline-block"><?php echo e($input->check_label); ?></i>
        <?php endif; ?>
    </label>
</span>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/templates/switch.blade.php ENDPATH**/ ?>