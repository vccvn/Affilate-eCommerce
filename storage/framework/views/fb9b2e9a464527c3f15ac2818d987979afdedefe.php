<?php $__env->startSection('title', 'Danh sách '.$dynamic->name); ?>


<?php $__env->startSection('module.name', $title = $dynamic->name); ?>


<?php $__env->startSection('css'); ?>
	
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php
	admin_action_menu([
		[
			'url' => admin_dynamic_url('trash'),
			'text' => $dynamic->name . ' đã xóa',
			'icon' => 'fa fa-trash'
		]
	]);
	?>
    <?php echo $__env->make($_current.'templates.results', ['type' => 'default'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('jsinit'); ?>
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"dynamics",
				title:"<?php echo e($title); ?>",
				urls:{
					move_to_trash_url: <?php echo json_encode(admin_dynamic_url('move-to-trash'), 15, 512) ?>
				}
			})
		};
		// khai báo ở dây
	</script>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>
	<script src="<?php echo e(asset('static/crazy/js/items.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout.'main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/posts/list.blade.php ENDPATH**/ ?>