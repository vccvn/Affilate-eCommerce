<?php $__env->startSection('title', 'Tùy biến Giao diện | '.$theme->name); ?>

<?php $__env->startSection('module.name', $theme->name); ?>


<?php $__env->startSection('content'); ?>
<?php if($optionGroups): ?>
	<div class="m-portlet m-portlet--tabs" id="theme-tabs-list">
		<div class="m-portlet__head">
			
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3>Cài đặt</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="nav nav-tabs m-tabs-line m-tabs-line--right" role="tablist">
					
					<?php $__currentLoopData = $optionGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link <?php echo e(($tab == $key || (!$tab && !$loop->index))?'active':''); ?>" data-ref="<?php echo e($key); ?>" data-toggle="tab" href="#<?php echo e($key); ?>_tab_content" role="tab">
								<?php echo e($group['label']); ?>

							</a>
						</li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
			<div class="tab-content">
				<?php $__currentLoopData = $optionGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="tab-pane <?php echo e(($tab == $key || (!$tab && !$loop->index))?'active':''); ?>" id="<?php echo e($key); ?>_tab_content" role="tabpanel">
						<div class="<?php echo e($key); ?>-form ">
							<?php
								if(isset($group['config'])){
									if(!is_array($group['config'])){
										$group['config'] = json_decode($group['config'], true);
									}
								}else{
									$group['config'] = [];
								}
								$group['config'] = array_merge($group['config'], [
									'save_button_text' => 'Lưu',
									'cancel_button_text' => 'Hủy'
								]);
								$formConfig = array_merge($group, [
                                'attrs' => [
                                    'method' => 'POST',
                                    'action' => route($route_name_prefix.'themes.options.group.save', ['group' => $group['slug']]),
                                    'id' => 'theme-'.$group['slug'].'-option-form',
                                    'class' => 'crazy-form'
                                ]
							]);
							?>
							<?php echo $__env->make($_base.'forms.form', $formConfig, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						</div>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
		</div>
	</div>
	
	<?php if(get_web_data('has_component_area')): ?>
		<?php echo $__env->make($_base.'html.components.modal-template', ['componentOptions' => get_component_options()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
<?php endif; ?>



<?php $__env->stopSection(); ?>

<?php if(get_web_data('has_component_area')): ?>
	
	
	<?php $__env->startSection('css'); ?>
	<link rel="stylesheet" href="<?php echo e(asset('static/plugins/nestable2/jquery.nestable.min.css')); ?>">
	<?php $__env->stopSection(); ?>

	

	<?php $__env->startSection('jsinit'); ?>
		<script>
			var component_data = {
				urls: <?php echo json_encode([
						'sort' => route('admin.components.sort'),
						'save' => route('admin.components.ajax-save'),
						'delete' => route('admin.components.delete'),
						'detail' => route('admin.components.detail'),
						'inputs' => route('admin.components.inputs'),
						'get_category_url' => route('admin.posts.category-options')
					]); ?>,
				list: <?php echo json_encode([
						'theme' => get_component_options()
					]); ?>

			}
			posts_data = {
				urls: {
					get_category_url: '<?php echo e(route('admin.posts.category-options')); ?>'
				}
			};
		</script>
	<?php $__env->stopSection(); ?>

	<?php if($theme->package && is_array($theme->package) && $package = $theme->package): ?>
		<?php
			if(array_key_exists('icons', $package) && is_array($package['icons'])){
				$icons = [];
				foreach ($package['icons'] as $slug => $iconData) {
					$icon = crazy_arr($iconData);
					if(is_array($icon->style)){
						foreach ($icon->style as $link) {
							$l = str_replace('@assets/', '', $link);
							if($l != $link){
								add_css_link(theme_asset($l));
							}else{
								add_css_link($link);
							}
						}
					}

					if(is_array($icon->list)){
						$listIcons = [];
						foreach ($icon->list as $list) {
							if(is_array($list)){
								if(array_key_exists('items', $list) && is_array($list['items'])){
									$prefix = array_key_exists('prefix', $list) ? $list['prefix'] : '';
									foreach ($list['items'] as $item) {
										$listIcons[] = $prefix.$item;
									}
								}elseif(array_val_type($list, 'string')){
									foreach ($list as $item) {
										$listIcons[] = $item;
									}
								}
							}
						}
						if(count($listIcons)){
							$icons[$icon->key] = [
								'title' => $icon->title,
								'list' => $listIcons
							];
						}
					}
				}
				if($icons){
					add_js_data('icon_picker_data', $icons);
				}
				
			}
			
		?>
	<?php endif; ?>
	<?php $__env->startSection('js'); ?>
		<?php
		add_tinymce_assets();
		add_css_link('/static/plugins/coloris/coloris.min.css');
		add_js_src('/static/plugins/coloris/coloris.min.js');
		add_js_src('/static/features/common/common.js');
		add_css_link('/static/features/common/common.min.css');


		add_js_src('static/crazy/js/tag.js');
		add_js_src('static/plugins/ckeditor5/build/ckeditor.js');
		// add_js_src('https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js');
        add_js_src('static/manager/js/ckeditor.js');
		set_admin_template_data('modals', 'icon-picker-modal');
		add_js_src('static/manager/js/iconpicker.js');
		set_web_data('set_icon_picker_model', true);
		add_js_src('static/crazy/js/select.js');
		set_admin_template_data('modals', 'colorpicker-modal');
        set_admin_template_data('modals', 'modal-library');
		add_js_src('static/manager/js/input.gallery.js');
		add_css_link('static/manager/css/input.gallery.min.css');
		?>
		<script src="<?php echo e(asset('static/plugins/nestable2/jquery.nestable.js')); ?>"></script>
		<script src="<?php echo e(asset('static/manager/js/nestable.js')); ?>"></script>
		<script src="<?php echo e(asset('static/manager/js/components.js')); ?>"></script>
	<?php $__env->stopSection(); ?>

<?php endif; ?>
<?php echo $__env->make($_layout.'main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/themes/option.blade.php ENDPATH**/ ?>