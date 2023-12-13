<?php
use Gomee\Html\Input;
use Gomee\Helpers\Arr;

add_js_src('static/crazy/js/attribute.js');
add_css_link('/static/plugins/coloris/coloris.min.css');
add_js_src('/static/plugins/coloris/coloris.min.js');
add_js_src('/static/features/common/common.js');
add_css_link('/static/features/common/common.min.css');

$wrapper = $input->copy();
$wrapper->type = "attribute";
$wrapper->prepareCrazyInput();

$inputParams = $wrapper->getInputData(false);
$attributeGroupLabels = [
    'attributes' => 'Thuộc tính',
    'variants' => 'Biến thể'
];

$wrp = $wrapper->copy();
$wrp->removeClass()->addClass("product-attributes");
$wrp->name = null;
$wrp->id = 'product-attributes';
$wrp->type = null;
$wrp->placeholder = null;
?>



<div <?php echo $wrp->attrsToStr(); ?>>

    <?php $__currentLoopData = $inputParams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $attributes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
    <div class="attr-variants mb-4">
        <h6><?php echo e($attributeGroupLabels[$group]); ?></h6>
            
    
        <?php if($group == 'attributes'): ?>
            <?php if($attributes): ?>
                <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule => $attrs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="m-accordion m-accordion--bordered" id="product-<?php echo e($group); ?>_<?php echo e($rule); ?>" role="tablist">
                        <?php $__currentLoopData = $attrs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!--begin::Item-->
                            <?php
                                $inputParams = $attr->toProductInputParam($wrapper->parent->hidden_id->val());
                                $inp = html_input($inputParams);
                                $attr_name = $inp->name;
                                $is_variant = $inp->hidden('is-variant');
                                $rname = $is_variant?'variants':$wrapper->name;
                                $ns = $rname . '.' . $attr_name;
                                $itemID = 'product-' . ($is_variant?'variants': 'attributes') . ($is_variant?'': '_'. (($attr->is_required?'required':'optional'))) . '_' . $attr_name;
                            ?>
                            <div class="m-accordion__item" id="product-<?php echo e($group); ?>_<?php echo e($rule); ?>_<?php echo e($attr_name); ?>">
                                <div class="m-accordion__item-head collapsed" role="tab" id="<?php echo e($itemID); ?>_head" data-toggle="collapse" href="#<?php echo e($itemID); ?>_body" aria-expanded="false">
                                    
                                    <span class="m-accordion__item-title">
                                        <?php echo e($inputParams['label']??$inputParams['name']); ?>

                                        <?php if(array_key_exists('required', $inputParams) && !in_array($inputParams['required'], ["0", "false"])): ?>
                                            <i class="m-badge m-badge--danger m-badge--dot"></i>
                                        <?php endif; ?>

                                        <?php if($errors->has($ns)): ?>
                                            <i class="ml-3 text-danger">-- <?php echo e($errors->first($ns)); ?></i>
                                        <?php endif; ?>

                                    </span>
                                    
                        
                                    <span class="m-accordion__item-mode"></span>
                                </div>
                                <div class="m-accordion__item-body collapse" id="<?php echo e($itemID); ?>_body" role="tabpanel" aria-labelledby="<?php echo e($itemID); ?>_head" data-parent="#m_accordion_<?php echo e($group); ?>" style="">
                                    <div class="m-accordion__item-content">
                                        
                                                    
                                            <?php echo $__env->make($_base.'forms.attribute-input', [
                                                'root_name' => $wrapper->name,
                                                'input' => $inp
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                
                                        
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php else: ?>
            <div class="m-accordion m-accordion--bordered" id="product-variants" role="tablist">
                <?php if($attributes): ?>
                    <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!--begin::Item-->
                        <?php
                            $inputParams = $attribute->toProductInputParam($wrapper->parent->hidden_id->val());
                            $inp = html_input($inputParams);
                            $attr_name = $inp->name;
                            $is_variant = $inp->hidden('is-variant');
                            $rname = $is_variant?'variants':$wrapper->name;
                            $ns = $rname . '.' . $attr_name;
                            $itemID = 'product-' . ($is_variant?'variants': 'attributes') . ($is_variant?'': '_'. (($attr->is_required?'required':'optional'))) . '_' . $attr_name;
                        ?>
                        <div class="m-accordion__item " id="<?php echo e($itemID); ?>">
                            <div class="m-accordion__item-head collapsed" role="tab" id="<?php echo e($itemID); ?>_head" data-toggle="collapse" href="#<?php echo e($itemID); ?>_body" aria-expanded="false">
                                
                                <span class="m-accordion__item-title">
                                    <?php echo e($inputParams['label']??$inputParams['name']); ?>

                                
                                    <?php if($errors->has($ns)): ?>
                                        <i class="ml-3 text-danger">-- <?php echo e($errors->first($ns)); ?></i>
                                    <?php endif; ?>
                                </span>
                                <span class="m-accordion__item-mode"></span>
                            </div>
                            
                            <div class="m-accordion__item-body collapse" id="<?php echo e($itemID); ?>_body" role="tabpanel" aria-labelledby="<?php echo e($itemID); ?>_head" data-parent="#m_accordion_<?php echo e($group); ?>" style="">
                                <div class="m-accordion__item-content pb-0 pt-0 pl-0 pr-0">
                                                
                                        <?php echo $__env->make($_base.'forms.attribute-input', [
                                            'input' => $inp,
                                            'root_name' => $wrapper->name
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            
                                    
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/templates/attribute.blade.php ENDPATH**/ ?>