<?php

$def = $input->defVal();
// $options = $input->data;
$defaultValues = old($input->name, array_merge((array) $input->data, (array) $def));

$wrapper = $input->copy();
$wrapper->removeClass()->addClass("post-config");
$wrapper->name = null;
$wrapper->type = null;
$wrapper->placehoder = null;
$wrapper->id = $wrapper->id. '-wrapper';

$inputGroup = crazy_arr($defaultValues);
?>


<div <?php echo $wrapper->attrsToStr(); ?>>
                
    <div class="form-group">
        <label for="post-config-thumbnail-width" class="form-label">Kích thước thumbail</label>
        <div class="row">
            <div class="col-6">
                <input type="number" id="post-config-thumbnail-width" class="form-control m-input" name="<?php echo e($input->name . '[thumbnail_width]'); ?>" value="<?php echo e($inputGroup->thumbnail_width(400)); ?>" placeholder="Chiều rộng">
            </div>
            <div class="col-6">
                <input type="number" id="post-config-thumbnail-height" class="form-control m-input" name="<?php echo e($input->name . '[thumbnail_height]'); ?>" value="<?php echo e($inputGroup->thumbnail_height(300)); ?>" placeholder="Chiều cao">
            </div>
        </div>
    </div>    

    <div class="form-group">
        <label for="post-config-thumbnail-width" class="form-label">Kích thước Ảnh social</label>
        <div class="row">
            <div class="col-6">
                <input type="number" id="post-config-thumbnail-width" class="form-control m-input" name="<?php echo e($input->name . '[social_width]'); ?>" value="<?php echo e($inputGroup->social_width(600)); ?>" placeholder="Chiều rộng">
            </div>
            <div class="col-6">
                <input type="number" id="post-config-thumbnail-height" class="form-control m-input" name="<?php echo e($input->name . '[social_height]'); ?>" value="<?php echo e($inputGroup->social_height(315)); ?>" placeholder="Chiều cao">
            </div>
        </div>
    </div>    

</div>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/templates/post-config.blade.php ENDPATH**/ ?>