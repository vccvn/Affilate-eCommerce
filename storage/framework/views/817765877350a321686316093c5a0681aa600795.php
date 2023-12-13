<?php
$sec_class = isset($section_class)?$section_class:null;
$att_class = isset($attribute_class)?$attribute_class:null;
$atn_class = isset($attribute_name_class)?$attribute_name_class:null;
$avl_class = isset($value_list_class)?$value_list_class:null;
$avi_class = isset($value_item_class)?$value_item_class:null;
$sel_class = isset($select_class)?$select_class:null;
$img_class = isset($image_class)?$image_class:null;
$txt_class = isset($value_text_class)?$value_text_class:null;
$rad_class = isset($radio_class)?$radio_class:null;
$lab_class = isset($label_class)?$label_class:(isset($value_label_class)?$value_label_class:null);

$sle_class = isset($select_class)?$select_class:null;
$inputIdPrefix = isset($input_id_prefix)?$input_id_prefix:'product';
?>


<?php if($variant_attributes = $product->getVariantAttributes()): ?>
    <div class="<?php echo e($sec_class); ?> <?php echo e(parse_classname('product-variants')); ?>">
        <?php $__currentLoopData = $variant_attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $avt = $attribute->advance_value_type;
            ?>
        <figure class="<?php echo e($att_class); ?> <?php echo e(parse_classname('product-attribute-item','product-variant-'.$avt,'product-attribute-'.$avt, 'product-'.$attribute->name)); ?>">
            <div>
                <figcaption class="<?php echo e($atn_class); ?> "><?php echo e($attribute->label); ?></figcaption>
                <?php if($avt != 'default'): ?>
                    <ul class="<?php echo e($avl_class); ?> <?php echo e(parse_classname('product-attribute-values', 'product-attribute-'.$avt.'-values')); ?> <?php echo e($attribute->list_class); ?>">

                        <?php
                            $def = null;
                            foreach ($attribute->values as $attr) {
                                if($attr->is_defauly) $def = $attr->value_id;
                            }
                        ?>
                        <?php $__currentLoopData = $attribute->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attrValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="<?php echo e($avi_class); ?> <?php echo e(parse_classname('variant-value-item','product-attribute-value-item', 'pav-item')); ?> <?php echo e($attribute->use_thumbnail && $attrValue->thumbnail?'pav-has-thumbnail': ''); ?>" data-thumbnail="<?php echo e($attrValue->thumbnail); ?>" data-value-id="<?php echo e($attrValue->value_id); ?>">
                                <input type="radio" id="<?php echo e($inputIdPrefix); ?>-variants-<?php echo e($attribute->name); ?>-<?php echo e($attrValue->value_id); ?>" name="attrs[<?php echo e($attribute->name); ?>]" class="<?php echo e($rad_class); ?> <?php echo e(parse_classname('radio-value-input')); ?> <?php echo e($attrValue->item_class); ?>" data-value-id="<?php echo e($attrValue->value_id); ?>" value="<?php echo e($attrValue->value_id); ?>" <?php if(($def && $def == $attrValue->value_id) || (!$def && $loop->index == 0)): ?> checked <?php endif; ?>>
                                <label for="<?php echo e($inputIdPrefix); ?>-variants-<?php echo e($attribute->name); ?>-<?php echo e($attrValue->value_id); ?>" class="<?php echo e($lab_class); ?> " <?php if($avt == "color"): ?> style="background-color:<?php echo e($attrValue->advance_value); ?>" <?php endif; ?>>
                                    <?php if($avt == 'image'): ?>
                                    <img src="<?php echo e($attrValue->advance_value); ?>" alt="<?php echo e($attrValue->text); ?>" title="<?php echo e($attrValue->text); ?>" class="<?php echo e($img_class); ?>">
                                    <?php endif; ?>
                                    <span><?php echo e($attrValue->text); ?></span>
                                </label>
                                <span class="attr-text <?php echo e($txt_class); ?> "><span><?php echo e($attrValue->text); ?></span></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </ul>
                <?php else: ?>
                    <ul class="<?php echo e($avl_class); ?> <?php echo e(parse_classname('product-attribute-values')); ?> <?php echo e($attribute->list_class); ?>">

                        <?php
                            $def = null;
                            foreach ($attribute->values as $attr) {
                                if($attr->is_defauly) $def = $attr->value_id;
                            }
                        ?>
                        <?php $__currentLoopData = $attribute->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attrValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="<?php echo e($avi_class); ?> <?php echo e(parse_classname('variant-value-item','product-attribute-value-item', 'pav-item')); ?>">
                                <input type="radio" id="<?php echo e($inputIdPrefix); ?>-variants-<?php echo e($attribute->name); ?>-<?php echo e($attrValue->value_id); ?>" name="attrs[<?php echo e($attribute->name); ?>]" class="<?php echo e($rad_class); ?> <?php echo e(parse_classname('radio-value-input')); ?> <?php echo e($attrValue->item_class); ?>" data-value-id="<?php echo e($attrValue->value_id); ?>" value="<?php echo e($attrValue->value_id); ?>" <?php if(($def && $def == $attrValue->value_id) || (!$def && $loop->index == 0)): ?> checked <?php endif; ?>>
                                <label for="<?php echo e($inputIdPrefix); ?>-variants-<?php echo e($attribute->name); ?>-<?php echo e($attrValue->value_id); ?>" class="<?php echo e($lab_class); ?> ">
                                    <span><?php echo e($attrValue->text); ?></span>
                                </label>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </ul>
                
                <?php endif; ?>
            </div>
        </figure>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>



<?php if($order_options = $product->getOrderAttributes()): ?>
    <div class="<?php echo e($sec_class); ?>  <?php echo e(parse_classname('product-attributes')); ?>">

        <?php
        $def = null;
        foreach ($order_options as $attr) {
            if($attr->is_defauly) $def = $attr->value_id;
        }
    ?>
        <?php $__currentLoopData = $order_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $avt = $attribute->advance_value_type;
            ?>
            <figure class="<?php echo e($att_class); ?> <?php echo e(parse_classname('product-attribute-item', 'product-attribute-'.$avt, 'product-'.$attribute->name)); ?>">
                <div>
                    <figcaption class="<?php echo e($atn_class); ?> "><?php echo e($attribute->label); ?></figcaption>
                    <?php if($avt != 'default'): ?>
                        <ul class="<?php echo e($avl_class); ?> <?php echo e(parse_classname('product-attribute-values', 'product-attribute-'.$avt.'-values')); ?> <?php echo e($attribute->list_class); ?>">

                            <?php $__currentLoopData = $attribute->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attrValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="<?php echo e($avi_class); ?> <?php echo e(parse_classname('variant-value-item','product-attribute-value-item', 'pav-item')); ?>">
                                    <input type="radio" id="<?php echo e($inputIdPrefix); ?>-attribute-<?php echo e($attribute->name); ?>-<?php echo e($attrValue->value_id); ?>" name="attrs[<?php echo e($attribute->name); ?>]" class="<?php echo e($rad_class); ?> <?php echo e(parse_classname('radio-value-input')); ?> <?php echo e($attrValue->item_class); ?>" data-value-id="<?php echo e($attrValue->value_id); ?>" value="<?php echo e($attrValue->value_id); ?>" <?php if(($def && $def == $attrValue->value_id) || (!$def && $loop->index == 0)): ?> checked <?php endif; ?>>
                                    <label for="<?php echo e($inputIdPrefix); ?>-attribute-<?php echo e($attribute->name); ?>-<?php echo e($attrValue->value_id); ?>" class="<?php echo e($lab_class); ?> " <?php if($avt == "color"): ?> style="background-color:<?php echo e($attrValue->advance_value); ?>" <?php endif; ?>>
                                        <?php if($avt == 'image'): ?>
                                        <img src="<?php echo e($attrValue->advance_value); ?>" alt="<?php echo e($attrValue->text); ?>" title="<?php echo e($attrValue->text); ?>" class="<?php echo e($img_class); ?>">
                                        <?php endif; ?>
                                        <span><?php echo e($attrValue->text); ?></span>
                                    </label>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </ul>
                    
                    <?php else: ?>
                        <ul class="<?php echo e($avl_class); ?> <?php echo e(parse_classname('product-attribute-values')); ?> <?php echo e($attribute->list_class); ?>">

                            <?php
                                $def = null;
                                foreach ($attribute->values as $attr) {
                                    if($attr->is_defauly) $def = $attr->value_id;
                                }
                            ?>
                            <?php $__currentLoopData = $attribute->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attrValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="<?php echo e($avi_class); ?> <?php echo e(parse_classname('variant-value-item','product-attribute-value-item', 'pav-item')); ?>">
                                    <input type="radio" id="<?php echo e($inputIdPrefix); ?>-variants-<?php echo e($attribute->name); ?>-<?php echo e($attrValue->value_id); ?>" name="attrs[<?php echo e($attribute->name); ?>]" class="<?php echo e($rad_class); ?> <?php echo e(parse_classname('radio-value-input')); ?> <?php echo e($attrValue->item_class); ?>" data-value-id="<?php echo e($attrValue->value_id); ?>" value="<?php echo e($attrValue->value_id); ?>" <?php if(($def && $def == $attrValue->value_id) || (!$def && $loop->index == 0)): ?> checked <?php endif; ?>>
                                    <label for="<?php echo e($inputIdPrefix); ?>-variants-<?php echo e($attribute->name); ?>-<?php echo e($attrValue->value_id); ?>" class="<?php echo e($lab_class); ?> ">
                                        <span><?php echo e($attrValue->text); ?></span>
                                    </label>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </ul>

                    <?php endif; ?>
                </div>
            </figure>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/client-libs/templates/product-order-attributes.blade.php ENDPATH**/ ?>