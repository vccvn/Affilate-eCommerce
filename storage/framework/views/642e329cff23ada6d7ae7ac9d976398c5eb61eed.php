

        <!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
				google: {
					"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
				},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>

		<!--end::Web font -->

		<!--begin::Base Styles -->
		<link href="<?php echo e(asset('static/manager/assets/vendors/base/vendors.bundle.css')); ?>" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="<?php echo e(asset('static/manager/assets/vendors/base/vendors.bundle.rtl.css')); ?>" rel="stylesheet" type="text/css" />-->
		<link href="<?php echo e(asset('static/manager/assets/demo/default/base/style.bundle.css')); ?>" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="<?php echo e(asset('static/manager/assets/demo/default/base/style.bundle.rtl.css')); ?>" rel="stylesheet" type="text/css" />-->

		<!--end::Base Styles -->
        
        
		<!-- my css -->

		<link rel="stylesheet" href="<?php echo e(asset('static/fonts/fonts.css')); ?>" type="text/css">
		<link rel="stylesheet" href="<?php echo e(asset('static/manager/css/style.min.css')); ?>" type="text/css">
		<link rel="stylesheet" href="<?php echo e(asset('static/manager/css/color.min.css')); ?>" type="text/css">
		<link rel="stylesheet" href="<?php echo e(asset('static/crazy/css/crazy.min.css')); ?>" type="text/css">

		<!-- css croppie -->
		<!-- <link rel="stylesheet" href="<?php echo e(asset('cropie/croppie.css')); ?>" type="text/css"> -->
		<!-- <link rel="stylesheet" href="<?php echo e(asset('cropie/bootstrap.min.css')); ?>" type="text/css"> -->


		


		<?php if($plugin_css = get_html_plugins('css')): ?>
			<?php $__currentLoopData = $plugin_css; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo $__env->make('admin._plugins.'.$f, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
		
		<?php echo $__env->yieldContent('css'); ?>
		
		<?php if($css = get_custom_css()): ?>
			<style>
			<?php echo $css; ?>

			</style>
		<?php endif; ?>

		<?php if($links = get_css_link()): ?>
		
		<?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		
		<link rel="stylesheet" href="<?php echo e($link); ?>">


		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>

<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/_templates/css.blade.php ENDPATH**/ ?>