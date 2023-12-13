<?php
add_js_src('static/crazy/js/slug.js');
$input->type = "text";


$wrapper = $input->copy();

$wrapper->type = "crazyslug";
$wrapper->prepareCrazyInput();

$cf = $wrapper->data('check-field')??'custom_'.$input->name;
$custom = ($input->parent && $c = $input->parent->get($cf))?$c:(html_input([
    'type' => 'checkbox',
    'name' => $cf,
    'value' => $cf
]));

$wrapper->removeClass();
$wrapper->addClass("input-group crazy-slug");
$wrapper->id.='-wrapper';
$wrapper->name.='-wrapper';
?>

<div <?php echo $wrapper->attrsToStr(); ?>>
    <div class="input-group-prepend">
        <span class="input-group-text check-addon">
            <label class="checkbox-label m-checkbox m-checkbox--solid m-checkbox--primary ">
                <?php echo $custom->raw(); ?>

                <span class="check-spacing"></span> 
                <i class="checkbox-label-span"><?php echo e($custom->check_label??'Tùy chỉnh'); ?></i>
            </label>
        </span>
    </div>

    <?php echo $input; ?>

    <?php if($input->data('extension')): ?>
        
    <div class="input-group-append">
        <span class="input-group-text"><?php echo e($input->data('extension')??'.html'); ?></span>
    </div>

    <?php endif; ?>
</div><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/templates/crazyslug.blade.php ENDPATH**/ ?>