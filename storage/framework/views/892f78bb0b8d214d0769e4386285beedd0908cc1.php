<!DOCTYPE html>

<html lang="vi">

	<!-- begin::Head -->
	<head>
		<?php echo $__env->make($_base.'_meta.info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		
		<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

		<script>
			window.warning = function warning(params) {
				
			};
		</script>
		
		<?php echo $__env->make($_template.'css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<?php
		$headerFixed = $__env->yieldContent('header_fixed');
		$hf = $headerFixed !== '0' && $headerFixed != 'false'? 'm-header--fixed m-header--fixed-mobile': '';
	?>
	<body class="m-page--fluid m--skin- m-content--skin-light2 <?php echo e($hf); ?> m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- BEGIN: Header -->
			
			<?php echo $__env->make($_component.'header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<!-- END: Header -->

			<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

				<!-- BEGIN: Left Aside -->
				<?php echo $__env->make($_component.'sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

				<!-- END: Left Aside -->
				<div class="m-grid__item m-grid__item--fluid m-wrapper">

					<!-- BEGIN: Subheader -->
					<?php echo $__env->make($_component.'subheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

					<!-- END: Subheader -->


					<div class="m-content">
						<?php echo $__env->yieldContent('content'); ?>
						<?php echo $__env->make($_template.'modals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>
				</div>
			</div>

			<!-- end:: Body -->

			<!-- begin::Footer -->
			<?php echo $__env->make($_component.'footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			

			
			<!-- end::Footer -->
		</div>

		<!-- end:: Page -->

		<!-- begin::Quick Sidebar -->
		<?php echo $__env->make($_component.'quick-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<!-- end::Quick Sidebar -->

		<!-- begin::Scroll Top -->
		<?php echo $__env->make($_component.'scroll-top', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<!-- end::Scroll Top -->

		<!-- begin::Quick Nav -->
		<?php echo $__env->make($_component.'quick-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<!-- begin::Quick Nav -->
		<?php echo $__env->make($_template.'loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<!--begin::Base Scripts -->
		<?php echo $__env->make($_template.'js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<!--end::Base Scripts -->
		
	</body>

	<!-- end::Body -->
</html><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/_layouts/main.blade.php ENDPATH**/ ?>