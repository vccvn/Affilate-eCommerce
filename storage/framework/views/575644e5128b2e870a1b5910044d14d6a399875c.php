<?php
// su dung thu vien
use Gomee\Helpers\Arr;
use Gomee\Html\HTML;
use Gomee\Html\Form;
use Gomee\Html\Input;

// cac bien
// form config
$cfg = new Arr($form_config);
$args = [
	'inputs' => $form_inputs,
	'data' => [],
	'errors' => $errors
];
$input_options = ['className'=>'form-control m-input'];

$form = new Form($args, $input_options);

// dd($form);
?>




<?php $__env->startSection('title', $cfg->title?$cfg->title:$module_name); ?>


<?php $__env->startSection('module.name', $module_name?$module_name:$cfg->title); ?>

<?php $__env->startSection('content'); ?>

<form action="" method="post">
	<div class="form-group row">
		<div class="col-md-4">
			<div class="row">
				<label for="layot-type" class="col-sm-4 col-lg-3 col-form-label">Layout type</label>
				<div class="col-sm-8 col-lg-9">
					<select name="layout_type" id="layout-type" class="form-control m-input">
						<?php $__currentLoopData = ['single' => 'Danh sách', 'column' => 'Lưới']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($value); ?>" <?php if($value == $cfg->layout_type): ?> selected <?php endif; ?>><?php echo e($text); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row form-layout-grid">
		<div class="col-md-8 col-lg-10">
			<h4 class="mb-4 text-center">Layout</h4>
			<div class="row">
				<?php if($cfg->layout_type == 'column' && count($cfg->form_groups)): ?>
					<?php $__currentLoopData = $cfg->form_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $fgroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php 
						$group = new Arr($fgroup); 
						?>
						
						<?php echo $__env->make($_base.'forms.config-section', [
							'list'=>$form->notInGroup($group->inputs),
							'group_title' => $group->title,
							'group_class' => $group->class,
							'index' => $index
						], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php else: ?>
					<?php echo $__env->make($_base.'forms.config-section', [
						'list'=>$form->notInGroup(),
						'group_title' => $group->title,
						'group_class' => '',
						'index' => 0
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>
				<div class="col add-group-addon">

					<!--begin::Portlet-->
					<div class="m-portlet">
						<div class="m-portlet__body p-0">
							<a href="javascript:void(0);" class="btn-add-group">
								<i class="fa fa-plus"></i> Thêm group
							</a>
						</div>
					</div>
			
					<!--end::Portlet-->
				</div>
			
			</div>
			<div class="buttons text-center mb-4">
				<a href="javascript:void(0);" class="btn btn-info btn-save-form-setting">
					Lưu
				</a>
				<a href="javascript:void(0);" class="btn btn-default btn-cancel-form-setting">
					Hủy
				</a>
			</div>
		</div>
		<div class="col-md-4 col-lg-2">
			<h4 class="mb-4 text-center">Inputs</h4>
			<div class="dd" id="form-group-inputs" data-max-depth="1">
				<ol class="dd-list">
					<?php
						$names = get_js_data('field_list')??[];
						add_js_data('nestable_selectors', '#form-group-inputs');
					?>
					<?php if(count($list = $form->notInGroup())): ?>
						<?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $namespace => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if(in_array($namespace, $names)): ?>
							<?php continue; ?>
						<?php endif; ?>
						<li class="dd-item" data-id="<?php echo e($namespace); ?>">
							<div class="dd-handle"><?php echo e($item->label); ?></div>
						</li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
					
				</ol>
			</div>
		</div>
	</div>
	
	
</form>
<div class="group-template d-none">
	<?php echo $__env->make($_base.'forms.config-section', [
		'group_title' => '{$title}',
		'group_class' => '{$class}',
		'index' => '{$index}',
		'is_template' => true
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('jsinit'); ?>
	<script>
		var form_setting_submit_url = <?php echo json_encode($submit_url, 15, 512) ?>;
		var delete_form_group_url = <?php echo json_encode($delete_form_group_url, 15, 512) ?>;
	</script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>
	<link rel="stylesheet" href="<?php echo e(asset('static/plugins/nestable2/jquery.nestable.min.css')); ?>">
<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>


<script src="<?php echo e(asset('static/plugins/nestable2/dist/jquery.nestable.min.js')); ?>"></script>
<script src="<?php echo e(asset('static/manager/js/nestable.js')); ?>"></script>
<script src="<?php echo e(asset('static/manager/js/form-setting.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout.'main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/config.blade.php ENDPATH**/ ?>