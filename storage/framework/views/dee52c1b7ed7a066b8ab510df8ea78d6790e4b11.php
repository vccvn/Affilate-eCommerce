<?php $__env->startSection('title', 'Danh sách các Giao diện'); ?>


<?php $__env->startSection('module.name', $title = 'Giao diện'); ?>


<?php $__env->startSection('css'); ?>
	
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make($_current.'templates.results', ['type' => 'default'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('jsinit'); ?>
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"theme",
				title:"<?php echo e($title); ?>",
				urls:{
					move_to_trash_url: <?php echo json_encode(route('themes.move-to-trash'), 15, 512) ?>
				}
			})
		};
		window.crazyThemeInit = function () {
			App.theme.init({
				urls:{
					extract: <?php echo json_encode(route('themes.extract'), 15, 512) ?>
				}
			})
		};
		// khai báo ở dây
	</script>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>
	<script src="<?php echo e(asset('static/crazy/js/items.js')); ?>"></script>
	<script src="<?php echo e(asset('static/manager/js/theme.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout.'main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/themes/list.blade.php ENDPATH**/ ?>