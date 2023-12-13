<?php $__env->startSection('title', 'Danh sách phương thức thanh toán hiện đang có trên website'); ?>


<?php $__env->startSection('module.name', 'Phương thức thanh toán'); ?>


<?php $__env->startSection('content'); ?>
	<?php echo $__env->make($_current.'results', ['type' => 'default'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('jsinit'); ?>
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"payment.methods",
				title:"Phương thức thanh toán",
				urls:{
					move_to_trash_url: <?php echo json_encode(route($route_name_prefix.'payments.methods.move-to-trash'), 15, 512) ?>
				}
			})
		};
		// khai báo ở dây

		window.paymentMethodInit = function () {
			App.payments.methods.init({
				urls:{
					method_inputs: <?php echo json_encode(route($route_name_prefix.'payments.methods.inputs'), 15, 512) ?>,
					ajax_save: <?php echo json_encode(route($route_name_prefix.'payments.methods.ajax.save'), 15, 512) ?>,
					ajax_detail: <?php echo json_encode(route($route_name_prefix.'payments.methods.ajax.detail'), 15, 512) ?>,
					ajax_status: <?php echo json_encode(route($route_name_prefix.'payments.methods.ajax.update-status'), 15, 512) ?>,
					ajax_priority: <?php echo json_encode(route($route_name_prefix.'payments.methods.ajax.update-priority'), 15, 512) ?>
				},
				configMethods: <?php echo json_encode(get_payment_config('methods')); ?>

			})
		};
		// khai báo ở dây

		
	</script>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>

    <script src="<?php echo e(asset('static/manager/assets/vendors/custom/jquery-ui/jquery-ui.bundle.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('static/crazy/js/items.js')); ?>"></script>
	<script src="<?php echo e(asset('static/manager/js/payments.methods.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout.'main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/payments/methods/list.blade.php ENDPATH**/ ?>