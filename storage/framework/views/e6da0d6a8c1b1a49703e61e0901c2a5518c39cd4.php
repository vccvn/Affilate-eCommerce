<?php $__env->startSection('title', $title = 'Danh mục '.$dynamic->name); ?>


<?php $__env->startSection('module.name', $title); ?>


<?php $__env->startSection('css'); ?>
	
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
admin_action_menu([
	[
		'url' => admin_dynamic_url('categories.trash'),
		'text' => 'Danh mục đã xóa',
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
				module:"posts.categories",
				title:"<?php echo e($title); ?>",
				urls:{
					move_to_trash_url: <?php echo json_encode(admin_dynamic_url('categories.move-to-trash'), 15, 512) ?>
				}
			})
		};
		// khai báo ở dây
	</script>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>
	<script src="<?php echo e(asset('static/crazy/js/items.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout.'main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/posts/categories/list.blade.php ENDPATH**/ ?>