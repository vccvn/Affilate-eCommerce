<?php

$def = [];
$options = $input->getInputData();
if(is_array($options) || is_object($options)){
    
    if(is_array($df = $input->defVal())){
        $def = $df;
    }
}
$defaultValues = old($input->name, $def);
$listType = $input->data('list-type') == 'list' ? 'list' : 'inline';
$input->name.='[]';
$disable = is_array($d = $input->hiddenData('disable')) ? $d : [];
// dump($options);

$wrapper = $input->copy();
$wrapper->removeClass()->addClass("m-checkbox-{$listType}");
$wrapper->name = null;
$wrapper->type = null;
$wrapper->placehoder = null;
$wrapper->id = $wrapper->id. '-wrapper';


?>






<div <?php echo $wrapper->attrsToStr(); ?>>
    <?php if(count($options)): ?>
        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <label class="m-checkbox m-checkbox--solid m-checkbox--info">
            <input type="checkbox" class="crazy-checkbox" name="<?php echo e($input->name); ?>" id="<?php echo e($input->id.'-'.str_slug($value)); ?>" value="<?php echo e($value); ?>" <?php if(in_array($value, $disable)): ?> disabled="true" <?php endif; ?> <?php if(in_array($value, $defaultValues)): ?> checked <?php endif; ?>> 
            <?php echo e($text); ?>

            <span></span>
        </label>
    
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    
</div>




<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/templates/checklist.blade.php ENDPATH**/ ?>