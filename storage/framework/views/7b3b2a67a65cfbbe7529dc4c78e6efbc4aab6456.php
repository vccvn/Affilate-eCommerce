
		<?php if($links = get_css_link()): ?>
		
		<?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		
		<link rel="stylesheet" href="<?php echo e($link); ?>">


		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>

		<script src="<?php echo e(asset('static/manager/assets/vendors/base/vendors.bundle.js')); ?>" type="text/javascript"></script>
		<script src="<?php echo e(asset('static/manager/assets/demo/default/base/scripts.bundle.js')); ?>" type="text/javascript"></script>

		<script src="<?php echo e(asset('static/plugins/axios/axios.min.js')); ?>"></script>

		<script src="<?php echo e(asset('static/manager/js/app.js')); ?>"></script>
		<script src="<?php echo e(asset('static/manager/js/api.js')); ?>"></script>

		<script src="<?php echo e(asset('static/crazy/js/modal.js')); ?>"></script>

		

		<?php echo $__env->make($_template.'js-data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<?php echo $__env->yieldContent('jsinit'); ?>

		

		<script src="<?php echo e(asset('static/manager/js/custom.js')); ?>"></script>

		<?php echo $__env->make($_template.'js-src', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<?php echo $__env->yieldContent('js'); ?>

		
		<?php echo $__env->yieldContent('custom_js'); ?>

		<?php if(($successSession = session('success')) || ($messageSession = session('message'))): ?>
		<script>
			App.Swal.success(<?php echo json_encode($successSession?$successSession:$messageSession, 15, 512) ?>);
		</script>
		<?php elseif($errorSession = session('error')): ?>
		<script>
			App.Swal.error(<?php echo json_encode($errorSession, 15, 512) ?>);
		</script>
		<?php endif; ?><?php /**PATH /Users/doanln/Desktop/Gomee/wisestyle/resources/views/admin/_templates/js.blade.php ENDPATH**/ ?>