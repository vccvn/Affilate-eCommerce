<!DOCTYPE html>

<html lang="vi">

	<!-- begin::Head -->
	<head>
		<?php echo $__env->make($_base.'_meta.info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		
		<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

		<?php echo $__env->make($_template.'css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- BEGIN: Header -->
			<?php echo $__env->yieldContent('content'); ?>
			<!-- begin::Quick Nav -->
			
			<?php echo $__env->make($_template.'modals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		<?php echo $__env->make($_template.'loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>		
		<!--begin::Base Scripts -->
		<?php echo $__env->make($_template.'js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<!--end::Base Scripts -->
		
	</body>

	<!-- end::Body -->
</html><?php /**PATH /Users/doanln/Desktop/Gomee/wisestyle/resources/views/admin/_layouts/auth.blade.php ENDPATH**/ ?>