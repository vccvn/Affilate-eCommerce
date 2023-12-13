<?php
$input = isset($params)? html_input($params) : (isset($input)?$input:crazy_arr());
$attr_id = $input->hidden('id');
$attr_name = $input->name;

$is_variant = $input->hidden('is-variant');

$rname = $is_variant?'variants':$root_name;

$price_type = $input->hidden('price-type');
$input->id = $rname.'-'.$input->name.'-'.$attr_id;

$input->name = $rname.'['.$attr_name.']';
$ns = $input->nameToNamespace();

if($input->hidden('value-type') == 'decimal'){
    $input->step = 0.1;
}
if($errors->has($ns)){
    $input->error = $errors->first($ns);
}
$input->value = old($ns, $input->value);

$input->addClass('form-control m-input attribute-input attribute-input-'.$input->type);
$col_class = 'col-12 col-sm-8 col-md-9 col-lg-10';
$lbl_class = 'col-12 col-sm-4 col-md-3 col-lg-2';
$advance_value_type = $input->hidden('advance-value-type');
$use_thumbnail = $input->hidden('use-thumbnail');

if($is_variant){
    $col_class = 'col-12';
    $lbl_class = 'col-12';
}
elseif ($advance_value_type=='color') {
    $col_class = 'col-12 col-md-9 col-lg-10';
    $lbl_class = 'col-12 col-md-3 col-lg-2';
}
if($input->type=='number'){
    $col_class = 'col-12 col-sm-4 ';
}


?>

<div class="scope-<?php echo e($input->hiddenData('scope')); ?> <?php echo e($input->error?'has-danger':''); ?>" id="<?php echo e($input->id); ?>-form-group">
    <div class="">

        <?php
            $is_template = is_support_template($input->template, $input->type, $_base.'form.templates.');

            $dig = $input->data('input-group');
            $input_group_class = ($input->prepend_text || $input->append_text || ($dig && $dig!='false') || $input->type == 'select')?'input-group':'';


        ?>


        <div class="<?php echo e($input_group_class); ?>" id="attr-input-<?php echo $input->id; ?>-group">
            
            <?php if($is_variant): ?>
                <div id="product-variant-input-<?php echo e($input->hidden('id')); ?>" class="product-variant-input">
                    <?php

                        $def = [];
                        $options = $input->getInputData();
                        if(is_array($options) || is_object($options)){
                            if(is_array($df = $input->defVal())){
                                $def = $df;
                            }
                        }
                        $defaultValues = old($input->name, $def);

                        $name = $input->name.'[]';
                        $values = $input->hidden('values');
                        $oldDefault = old('attribute_default_selected.'.$attr_id);
                        $_i = 0;
                    ?>
                    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $valuedata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            if(!$_i && !$oldDefault){
                                $oldDefault = $value;
                            }
                            $_i ++;
                            $checked = in_array($value, $defaultValues) ? 'checked' : null;
                            $vdata = crazy_arr(isset($values[$value])?$values[$value]:[]);
                            if($vdata->is_default){
                                $oldDefault = $value;
                            }

                        ?>
                        <div id="product-variant-value-<?php echo e($value); ?>" class="variant-attribute-item">
                            <div class="variant-check-block">
                                <label class="m-checkbox m-checkbox--solid m-checkbox--info">
                                    <input
                                        type="checkbox"
                                        class="crazy-checkbox variant-input-checkbox"
                                        data-value="<?php echo e($value); ?>"
                                        data-attribute="<?php echo e($attr_id); ?>"
                                        name="<?php echo e($name); ?>"
                                        id="<?php echo e($input->id.'-'.str_slug($value)); ?>"
                                        value="<?php echo e($value); ?>"
                                        data-on-change="Product.form.onVariantChange"
                                        data-e="0"
                                        <?php echo e($checked); ?>>
                                    <?php echo e($valuedata['text']); ?>

                                    <span></span>
                                </label>
                                <label class="checkbox-label m-radio pull-right">
                                    <input type="radio" class="" name="attribute_default_selected[<?php echo e($attr_id); ?>]" value="<?php echo e($value); ?>" <?php echo e($oldDefault == $value? 'checked': ''); ?>>
                                    <span></span>
                                </label>
                            </div>
                            <div class="variant-option <?php echo e($checked?'show':''); ?>">
                                <?php
                                    $priceError = $errors->first('variant_price.'.$value);
                                ?>
                                <div class="crazy-form-group row <?php echo e($priceError?'has-danger':''); ?>">
                                    <label for="variant-price-<?php echo e($attr_id); ?>-<?php echo e($value); ?>" class="col-12 col-sm-6 col-md-6 col-lg-5 col-form-label">
                                        Giá <?php echo e($price_type?"biến thể": "trị gia tăng"); ?>

                                    </label>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                        <input type="number" name="variant_price[<?php echo e($value); ?>]" id="variant-price-<?php echo e($attr_id); ?>-<?php echo e($value); ?>" class="form-control m-input" value="<?php echo e(old('variant_price.'.$value, $vdata->price)); ?>" placeholder="Nhập giá tiền...">
                                        <div class="form-control-feedback input-message-alert" id="variant-price-<?php echo e($attr_id); ?>-<?php echo e($value); ?>-message-alert"><?php echo e($priceError); ?></div>
                                    </div>
                                </div>
                                <?php if($advance_value_type == 'image'): ?>
                                    <?php
                                        $imgError = $errors->first('variant_images.'.$value);
                                    ?>
                                    <div class="crazy-form-group row mt-2 <?php echo e($imgError?'has-danger':''); ?>">
                                        <label for="variant-images-<?php echo e($attr_id); ?>-<?php echo e($value); ?>" class="col-12 col-sm-6 col-md-6 col-lg-5 col-form-label">
                                            Ảnh đính kèm
                                        </label>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-7">
                                            <?php echo $__env->make($_base.'forms.templates.file', [
                                                'input' => html_input([
                                                    'type' => 'file',
                                                    'name' => 'variant_images['.$value.']',
                                                    'choose_label' => $vdata->advance_value?$vdata->advance_value:($valuedata['advance_value']?$valuedata['advance_value']:'Chưa chọn file nào'),
                                                    'accept' => 'image/*'
                                                ])
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <div class="form-control-feedback input-message-alert" id="variant-price-<?php echo e($attr_id); ?>-<?php echo e($value); ?>-message-alert"><?php echo e($imgError); ?></div>
                                        </div>
                                    </div>

                                <?php elseif($advance_value_type == 'color'): ?>
                                    <?php
                                        $clrError = $errors->first('variant_colors.'.$value);
                                    ?>
                                    <div class="crazy-form-group row mt-2 <?php echo e($clrError?'has-danger':''); ?>">
                                        <label for="variant-color-<?php echo e($attr_id); ?>-<?php echo e($value); ?>" class="col-12 col-sm-6 col-md-6 col-lg-5 col-form-label">
                                            Mã màu
                                        </label>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                            <?php echo $__env->make($_base.'forms.templates.coloris', [
                                                'input' => html_input([
                                                    'type' => 'text',
                                                    'name' => "variant_colors[{$value}]",
                                                    'id' => "variant-colors-{$attr_id}-{$value}",
                                                    'value' => old('variant_colors.'.$value, $vdata->advance_value?$vdata->advance_value:$valuedata['advance_value']),
                                                    'placeholder'=>"Nhập mã màu",
                                                    '@preview-type' => 'circle',
                                                    'wrapper_class'=>"circle",
                                                    "class" => 'form-control m-input'

                                                ])
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <div class="form-control-feedback input-message-alert" id="variant-price-<?php echo e($attr_id); ?>-<?php echo e($value); ?>-message-alert"><?php echo e($clrError); ?></div>
                                        </div>
                                    </div>

                                <?php else: ?>

                                <?php endif; ?>
                                <?php if($use_thumbnail == 1): ?>
                                    <?php
                                        $imgError = $errors->first('variant_thumbnails.'.$value);
                                        
                                    ?>
                                    <div class="crazy-form-group row mt-2 <?php echo e($imgError?'has-danger':''); ?>">
                                        <label for="variant-images-<?php echo e($attr_id); ?>-<?php echo e($value); ?>" class="col-12 col-sm-6 col-md-6 col-lg-5 col-form-label">
                                            Ảnh Thumbnail 
                                        </label>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-7">
                                            <?php echo $__env->make($_base.'forms.templates.file', [
                                                'input' => html_input([
                                                    'type' => 'file',
                                                    'name' => 'variant_thumbnails['.$value.']',
                                                    'choose_label' => $vdata->thumbnail,
                                                    'accept' => 'image/*'
                                                ])
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <div class="form-control-feedback input-message-alert" id="variant-price-<?php echo e($attr_id); ?>-<?php echo e($value); ?>-message-alert"><?php echo e($imgError); ?></div>
                                        </div>
                                    </div>
                                <?php endif; ?>


                            </div>

                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

            
            <?php else: ?>

                
                <?php if($input->prepend_text): ?>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><?php echo $input->prepend_text; ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if($is_template): ?>
                    <?php echo $__env->make($_base.'forms.templates.attribute-'.$input->template, ['input' => $input], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php elseif($input->type == 'file'): ?>
                    <div class="custom-file">
                        <?php $input->addClass('custom-file-input'); ?>
                        <?php echo $input; ?>

                        <label class="custom-file-label selected" for="<?php echo e($input->id); ?>"><?php echo e($input->val()?$input->val():'Chưa có file nào dc chọn'); ?></label>
                    </div>

                <?php elseif(in_array($input->type, ['checkbox', 'radio', 'checklist'])): ?>
                    <div class="checkbox-radio <?php echo e($input->data('display') == 'list'?'display-list':"display-inline"); ?>">
                        <?php echo $input; ?>

                    </div>
                <?php else: ?>

                    <?php echo $input; ?>

                <?php endif; ?>

                <?php if($input->append_text): ?>
                    <div class="input-group-append">
                        <span class="input-group-text"><?php echo $input->append_text; ?></span>
                    </div>
                <?php endif; ?>
                <?php if($input->type == 'select'): ?>
                    <div class="input-group-append">
                        <a href="javascript:void(0);" class="btn-add-attribute-value btn btn-success ref-select"
                            data-id="<?php echo e($input->data('attribute-id')); ?>"
                            data-value-type="<?php echo e($input->data('attribute-value-type')); ?>"
                            data-label="<?php echo e($input->data('attribute-label')); ?>">
                            Thêm
                        </a>
                    </div>
                <?php endif; ?>

            <?php endif; ?>


        </div>
        <div class="form-control-feedback input-message-alert" id="input-<?php echo $input->id; ?>-message-alert"><?php echo e($input->error); ?></div>


    </div>
    
</div>
<?php
    add_css_link('/static/plugins/coloris/coloris.min.css');
add_js_src('/static/plugins/coloris/coloris.min.js');
add_js_src('/static/features/common/common.js');
add_css_link('/static/features/common/common.min.css');

?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/attribute-input.blade.php ENDPATH**/ ?>