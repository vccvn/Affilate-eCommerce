<?php
// su dung thu vien
use Gomee\Helpers\Arr;
use Gomee\Html\HTML;
use Gomee\Html\Form;
use Gomee\Html\Input;

// cac bien
// form config
$cfg = new Arr($config??[]);
$args = [
	'inputs' => $inputs??[],
	'data' => $data??[],
	'errors' => $errors
];
$input_options = ['className'=>'form-control m-input'];
$form = new Form($args, $input_options, $attrs??[]);
$form->query(['type' => ['radio', 'checkbox', 'crazyselect', 'file']])->map('removeClass', ['form-control', 'm-input']);
$form->query(['type' => 'checkbox'])->map('setOption', 'label_class', 'm-checkbox');
$form->query(['type' => 'radio'])->map('setOption', 'label_class', 'm-radio');

$layout_column = ($cfg->layout_type == 'column');
?>

<?php $form->addClass('m-form m-form--fit m-form--label-align-left crazy-form');?>
<!--begin::Form-->
<form <?php echo $form->attrsToStr(); ?>>
    <?php echo csrf_field(); ?>
    <!-- <?php echo e($errors->first()); ?> -->
    <?php echo $form->hidden_id; ?>

    <div class="form-inputs">
        <div class="row <?php echo e($cfg->form_group_style ==  'custom' ? '': ' group form-group m-form__group pl-0 pr-0'); ?>">
            <?php if(is_array($cfg->form_groups) && count($cfg->form_groups)): ?>
                <?php $__currentLoopData = $cfg->form_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $group = new Arr($column); ?>
                    <div class="col-12 <?php echo e($group->class); ?>">
                        <?php echo $__env->make($_base.'forms.master-inputs', [
                            'list'=>$form->notInGroup($group->inputs),
                            'group' => $group,
                            'group_title' => $group->title,
                            'layout_type' => $cfg->layout_type,
                            'cfg' => $cfg
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="col-12">
                    <?php echo $__env->make($_base.'forms.master-inputs', [
                        'list'=>$form->notInGroup(),
                        'group' => new Arr(),
                        'layout_type' => $cfg->layout_type,
                        'cfg' => $cfg
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
    <?php if($cfg->button_block_type == 2): ?>
    <div class="row">
        <div class="col-6">
            <button type="submit" class="btn btn-info btn-submit-form">
                <?php echo e($cfg->save_button_text); ?>

            </button>
            
        </div>
        <div class="col-6 text-right">
            <a href="<?php echo e($cfg->cancel_button_url??'#'); ?>" class="btn btn-<?php echo e($cfg->cancel_button_class('secondary')); ?>">
                <?php echo e($cfg->cancel_button_text); ?>

            </a>
        </div>
    </div>
        
    <?php else: ?>
    <div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-info btn-submit-form">
                <?php echo e($cfg->save_button_text); ?>

            </button>
            <?php if(!$cfg->hide_cancel_button): ?>
                
            <a href="<?php echo e($cfg->cancel_button_url??'#'); ?>" class="btn btn-secondary">
                <?php echo e($cfg->cancel_button_text); ?>

            </a>
            <?php endif; ?>
        </div>
        
        
    </div>
        
    <?php endif; ?>
</form><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/form.blade.php ENDPATH**/ ?>