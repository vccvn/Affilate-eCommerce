<?php
use Gomee\Helpers\Arr;
?>
    
    
    
    <div class="col-12 <?php echo e($group_class); ?>" data-class="<?php echo e($group_class); ?>">
<?php
$l_type = (isset($layout_type) && in_array($layout_type, ['single', 'column']))?$layout_type:'single';

// danh sach addon
$input_addons = ['checkbox'];


$class_list = [
    'single' => [
        'from_group' => 'row',
        'label' => 'col-lg-2 col-form-label',
        'wrapper' => 'col-lg-8'
    ],
    'column' => [
        'from_group' => '',
        'label' => '',
        'wrapper' => ''
    ],
];
$lbl_class = isset($label_class)?$label_class:$class_list[$l_type]['label'];
$wrp_class = isset($wrapper_class)?$wrapper_class:$class_list[$l_type]['wrapper'];
$group_class = isset($from_group_class)?$from_group_class:$class_list[$l_type]['from_group'];


// danh sach addon
$input_addons = ['checkbox'];

?>
        <!--begin::Portlet-->
        <div class="m-portlet grid-section">
            <div class="m-portlet__head form-grid-header">
                <div class="m-portlet__head-caption group-title">
                    <div class="m-portlet__head-title grid-group-title">
                        <h3 class="m-portlet__head-text">
                            <span class="title-text">
                                <?php if(isset($group_title)): ?>
                                    <?php echo e($group_title); ?>

                                <?php endif; ?>
                            </span>
                            
                        </h3>
                        
                    </div>
                    
                </div>
                

            </div>
            <div class="m-portlet__body">
                
                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $input): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $type = strtolower($input->type);
                    $g_class = $group_class;
                    $l_class = $lbl_class;
                    $w_class = $wrp_class;
                    if($input->data('group-type') == 'inline'){
                        $g_class = 'row';
                        $l_class = 'col-lg-2 col-form-label';
                        $w_class = 'col-lg-8';
                        
                    }
                    $options = $input->hiddenData('options');
                    if(is_array($options)){
                        $opts = new Arr($options);
                        if($opts->form_group_class){
                            $g_class = $opts->form_group_class;
                        }
                        if($opts->label_class){
                            $l_class = $opts->label_class;
                        }
                        if($opts->wrapper_class){
                            $w_class = $opts->wrapper_class;
                        }
                        
                        
                    }
                    elseif ($input->type=='switch' || $input->template=='switch') {
                        $g_class = 'row';
                        $l_class = 'col-6 col-sm-4 col-md-3 col-lg-2 col-form-label';
                        $w_class = 'col-6 col-sm-2 col-md-3 col-lg-4';
                        if($l_type = 'column'){
                            $l_class = 'col-6 col-form-label';
                            $w_class = 'col-6';
                        
                        }
                    }
                    ?>
                    <?php if($input->type=='hidden'): ?>
                        <?php echo $input; ?>

                    <?php else: ?>
                        <div class="form-group <?php echo e($g_class); ?> <?php echo e($input->error?'has-danger':''); ?>" id="<?php echo e($input->id); ?>-form-group">
                            <label class="<?php echo e($l_class); ?>" for="<?php echo e($input->id); ?>" >
                                <?php echo $input->label; ?>

                                <?php if($input->required && !in_array($input->required, ["0", "false", "no"])): ?>
                                <span class="m-badge m-badge--danger m-badge--dot"></span>
                                <?php endif; ?>
                                
                            </label>
                            <div class="<?php echo e($w_class); ?>">
                
                                <?php
                                    $is_template = is_support_template($input->template, $type, $_base.'form.templates.');
                                    $addon_class = '';
                                    if($is_template){
                                        if($input->template == 'touchspin') $addon_class.= 'bootstrap-touchspin ';
                                    }
                
                                    $dig = $input->data('input-group');
                                    $input_group_class = ($input->prependGroup || $input->prepend_text || $input->append_text || $input->prepend_button || $input->append_button || $input->appendGroup || ($dig && $dig!='false'))?'input-group':'';
                                ?>
                                
                
                                <div class="<?php echo e($input_group_class); ?> <?php echo e($input->type); ?> input-<?php echo e($input->type); ?>-group <?php echo e($addon_class); ?>" id="input-<?php echo $input->id; ?>-group">
                                    
                                    <?php if($input->prependGroup): ?>
                                        <?php $__currentLoopData = $input->prependGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="input-group-prepend">
                                                <?php if(in_array($addon->type, $input_addons)): ?>
                                                    <?php echo $__env->make($_base.'forms.addons.'.$addon->type, ['input'=>$addon], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php elseif(is_support_template($addon->template, $addon->type, $_base.'form.templates.')): ?>
                                                    <?php echo $__env->make($_base.'forms.templates.'.$addon->template, ['input'=>$addon], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php else: ?>
                                                    <?php echo $addon; ?>

                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if($input->prepend_text): ?>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><?php echo $input->prepend_text; ?></span>
                                        </div>
                                    <?php endif; ?>
                
                                    
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
                                    <?php endif; ?>
                
                                    
                                    <?php if($input->append_text): ?>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><?php echo $input->append_text; ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($input->appendGroup): ?>
                                        <?php $__currentLoopData = $input->appendGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="input-group-append">
                                                <?php if(in_array($addon->type, $input_addons)): ?>
                                                    <?php echo $__env->make($_base.'forms.addons.'.$addon->type, ['input'=>$addon], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php elseif(is_support_template($addon->template, $addon->type, $_base.'form.templates.')): ?>
                                                    <?php echo $__env->make($_base.'forms.templates.'.$addon->template, ['input'=>$addon], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php else: ?>
                                                    <?php echo $addon; ?>

                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    
                                </div>
                                <div class="form-control-feedback input-message-alert" id="input-<?php echo $input->id; ?>-message-alert"><?php echo e($input->error); ?></div>    
                                
                                
                            </div>
                            
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!--end::Portlet-->
    </div>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/grid-section.blade.php ENDPATH**/ ?>