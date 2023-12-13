<?php
// su dung thu vien
use Gomee\Helpers\Arr;
use Gomee\Html\HTML;
use Gomee\Html\Form;
use Gomee\Html\Input;

// cac bien
// form config
$cfg = new Arr($form_config);
$data = new Arr($form_data);
array_unshift($form_inputs,[
	'namespace' => 'hidden_id',
	'name' => 'id',
	'id' => 'input-hidden-id',
	'type' => 'hidden',
	'value' => $data->id
]);
$args = [
	'inputs' => $form_inputs,
	'data' => $form_data,
	'errors' => $errors
];

$input_options = ['className'=>'form-control m-input'];
$form = new Form($args, $input_options, $form_attrs);
// dd($form);
$form->query(['type' => ['radio', 'checkbox', 'crazyselect', 'file']])->map('removeClass', ['form-control', 'm-input']);
$form->query(['type' => 'checkbox'])->map('setOption', 'label_class', 'm-checkbox');
$form->query(['type' => 'radio'])->map('setOption', 'label_class', 'm-radio');

// dd($form);

if($cfg->can_edit_config){
	admin_action_menu([
		[
			'url' => $cfg->edit_form_config_url,
			'text' => 'Chỉnh sửa form',
			'icon' => 'fa fa-cog'
		]
	]);
}

$layout_column = $cfg->layout_type == 'column';
?>




<?php $__env->startSection('title', $cfg->title?$cfg->title:$module_name); ?>


<?php $__env->startSection('module.name', $module_name?$module_name:$cfg->title); ?>

<?php $__env->startSection('content'); ?>
	<div class="row">
		<div class="col-lg-12">
			<?php if($cfg->layout_type != 'tab'): ?>
				<?php echo $__env->make($_base.'forms.master-single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php elseif($cfg->form_type == 'multiform'): ?>
				<?php echo $__env->make($_base.'forms.master-tab-multiform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		</div>
	</div>
	<?php if($cfg->components): ?>
		<?php if(!is_array($cfg->components)): ?>
			<?php echo $__env->make($_component.$cfg->components, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php else: ?>
			<?php $__currentLoopData = $cfg->components; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo $__env->make($_component.$blade, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	<?php endif; ?>
	<?php if($cfg->templates): ?>
		<?php if(!is_array($cfg->templates)): ?>
			<?php echo $__env->make($_template.$cfg->templates, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php else: ?>
			<?php $__currentLoopData = $cfg->templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo $__env->make($_template.$blade, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	<?php endif; ?>
	<?php if($cfg->includes): ?>
		<?php if(!is_array($cfg->includes)): ?>
			<?php echo $__env->make($_base.$cfg->includes, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php else: ?>
			<?php $__currentLoopData = $cfg->includes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $include): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo $__env->make($_base.$include, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	<?php endif; ?>
	<?php if(get_js_data('crazy_form_data', 'include_modal')): ?>
		<?php echo $__env->make($_base.'forms.modal-tabs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('jsinit'); ?>
	<?php if($cfg->js_vars && is_array($cfg->js_vars)): ?>
		<?php echo '<script>'; ?>

			<?php $__currentLoopData = $cfg->js_vars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(!is_numeric($name) && strlen($name)): ?>
				var {[$name]} = <?php echo is_numeric($value)?$value:json_encode($value); ?>;
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php echo '</script>'; ?>

	<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>
	<?php if(is_array($cfg->css) && count($cfg->css)): ?>
		<?php $__currentLoopData = $cfg->css; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $css_link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<link rel="stylesheet" href="<?php echo e(is_url($css_link)?$css_link:asset($css_link)); ?>">
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>
	
<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>
	<?php if($cfg->js && is_array($cfg->js)): ?>
		<?php $__currentLoopData = $cfg->js; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ja_src): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<script src="<?php echo e(is_url($ja_src)?$ja_src:asset($ja_src)); ?>"></script>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>
	<?php if($errorSession = session('error')): ?>
		<script>
			App.Swal.error(<?php echo json_encode($errorSession, 15, 512) ?>);
		</script>
	<?php elseif($validateError = $errors->first()): ?>
		<script>
			App.Swal.error("Đã có lỗi xảy ra. Vui lòng kiểm tra lại thông tin");
		</script>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout.'main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/master.blade.php ENDPATH**/ ?>