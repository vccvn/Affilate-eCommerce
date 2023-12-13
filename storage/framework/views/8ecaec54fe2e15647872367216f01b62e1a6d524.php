<?php
// su dung thu vien
use Gomee\Helpers\Arr;

// layout type chuẩn

$l_type = (isset($layout_type) && in_array($layout_type, ['single', 'column']))?$layout_type:'single';
// class theo layout type
$class_list = [
    'single' => [
        'from_group' => 'row',
        'label' => 'col-lg-3 col-xl-2 col-form-label',
        'wrapper' => 'col-lg-9 col-xl-10'
    ],
    'column' => [
        'from_group' => '',
        'label' => '',
        'wrapper' => ''
    ],
];
// class mặc định
$lbl_class = isset($label_class)?$label_class:$class_list[$l_type]['label'];
$wrp_class = isset($wrapper_class)?$wrapper_class:$class_list[$l_type]['wrapper'];
$group_class = isset($from_group_class)?$from_group_class:$class_list[$l_type]['from_group'];

// danh sach addon
$input_addons = ['checkbox'];
?>

<?php if((isset($group_title) && $group_title) || $l_type != 'single'): ?>

    
    <div class="m-form__heading mt-2 pl-0 pr-0">
        <h3 class="m-form__heading-title">
            <?php if(isset($group_title)): ?>
                <?php echo e($group_title); ?>

            <?php else: ?>
                <span class="text-white">
                    <i class="fa fa-info"></i>
                </span>
            <?php endif; ?>
        </h3>
    </div>

<?php endif; ?>

<?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $input): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($input->hidden): ?>
        <?php continue; ?>
    <?php endif; ?>
    <?php
    $type = strtolower($input->type);
    $g_class = $group_class; // group class
    $l_class = $lbl_class; // label class
    $w_class = $wrp_class; // input wrapper class


    if($group->type == 'inline'){
        $g_class = 'row';
        $l_class = 'col-lg-2 col-form-label';
        $w_class = 'col-lg-10';
        
    }
    if ($cfg->form_group_options) {
        $g = $cfg->form_group_options;
        if(isset($g['group_class'])){
            $g_class = $g['group_class'];
        }
        if(isset($g['label_class'])){
            $l_class = $g['label_class'];
        }
        if(isset($g['wrapper_class'])){
            $w_class = $g['wrapper_class'];
        }
        
        
    }

    if($cfg->lock_style){
        // cha lam gi ca
    }
    elseif($input->data('group-type') == 'metronic'){
        $g_class = 'row';
        $l_class = 'col-lg-2 col-form-label';
        $w_class = 'col-lg-10';
        
    }
    elseif($input->data('group-type') == 'inline'){
        $g_class = 'row';
        $l_class = 'col-lg-2 col-form-label';
        $w_class = 'col-lg-8';
        
    }

    // ghi de
    if($cfg->lock_style){
        // cha lam gi ca
    }
    elseif(is_array($options = $input->hiddenData('options'))){
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
    elseif($input->hiddenData('group-type') == 'metronic'){
        $g_class = 'row';
        $l_class = 'col-lg-2 col-form-label';
        $w_class = 'col-lg-10';
    }
    elseif ($input->type=='switch' || $input->template=='switch') {
        $g_class = 'row';
        $l_class = 'col-6 col-sm-4 col-md-3 col-lg-2 col-form-label';
        $w_class = 'col-6 col-sm-2 col-md-3 col-lg-4';
        if($l_type == 'column'){
            $l_class = 'col-6 col-form-label';
            $w_class = 'col-6';
        
        }
    }
    ?>
    <?php if($input->type=='hidden'): ?>
        <?php echo $input; ?>

    <?php else: ?>
        <div class="mt-1 mb-4 crazy-form-group <?php echo e($g_class); ?> <?php echo e($input->error?'has-danger':''); ?>" id="<?php echo e($input->id); ?>-form-group">
            <label class="<?php echo e($l_class); ?>" for="<?php echo e($input->id); ?>" >
                <?php echo $input->label; ?>

                <?php if(($input->required && !in_array($input->required, ["0", "false"])) || $input->show_required): ?>
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
                    $is_input_columns = ($input->prependColumns || $input->appendColumns)?true:false;
                ?>
                
                <?php if($is_input_columns): ?>
                    <div class="row">
                        <?php if($input->prependColumns): ?>
                            <?php $__currentLoopData = $input->prependColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php 
                            if($addon->error){
                                set_web_data($input->id. '-error', $addon->error);
                            }
                            ?>
                                <div class="col-md">
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
                        <div class="col-md">
                <?php endif; ?>



                <?php if($input_group_class): ?>
                    <?php echo $__env->make($_base.'forms.group-addon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php else: ?>
                    <?php echo $__env->make($_base.'forms.form-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                
                <?php if($is_input_columns): ?>
                        </div>
                    <?php if($input->appendColumns): ?>
                        <?php $__currentLoopData = $input->appendColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php 
                            if($addon->error){
                                set_web_data($input->id. '-error', $addon->error);
                            }
                            ?>
                            <div class="col-md">
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
                <?php endif; ?>
                <div class="form-control-feedback input-message-alert" id="input-<?php echo $input->id; ?>-message-alert"><?php echo e($input->error??(get_web_data($input->id.'-error')??$input->hiddenData('note'))); ?></div>

            </div>
            
        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/master-inputs.blade.php ENDPATH**/ ?>