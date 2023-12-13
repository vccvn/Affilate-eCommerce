<?php $__env->startSection('title', 'Danh sách item của slider '. $slider->name); ?>


<?php $__env->startSection('module.name', $title = $slider->name); ?>

<?php
        admin_action_menu([
            [
                'url' => admin_slider_item_url('sort.form'),
                'text' => 'Sắp xếp slider',
                'icon' => 'fa fa-sort-amount-down'
            ]
        ]);

?>

<?php $__env->startSection('content'); ?>

    <?php
	$columns = [
		'title'=>'Tiêu đề'
		// 'type' => 'Loại tin bài'
	];

	$price_types = ['Cộng dồn', 'Thay thế giá sản phẩm'];
	$checkTag = '<i class="fa fa-check text-success"></i>';
	?>
	
	<div class="m-portlet">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						<?php echo e('Slider: '.$title); ?>

					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="<?php echo e(admin_slider_item_url('create')); ?>" data-original-title="Thêm item" data-toggle="m-tooltip" data-placement="left" title class="ml-3 btn btn-outline-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a>
					</li>
				</ul>
			</div>
			
		</div>
		
		<div class="m-portlet__body">
	
			<?php if(isset($results) && count($results)): ?>
			<!--begin::Section-->
			<div class="m-section">
				<div class="m-section__content crazy-list">
					<div class="table-responsive">
						<table class="table table-bordered table-striped list-center">
							<thead>
								<tr>
									<th class="check-col">
										<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" class="crazy-check-all"> 
											<span></span>
										</label>
									</th>
									
                                    <th>Ảnh</th>
									<th class="min-160 max-250">Tiêu đề</th>
									<th class="min-160 max-250">Mô tả</th>
									<th class="min-160 max-250">Liên kết</th>
									<th class="min-100 actions">Thao tác</th>
								</tr>
							</thead>
							<tbody>
								<?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									
								<tr id="crazy-item-<?php echo e($item->id); ?>" data-name="<?php echo e($item->label??$item->name); ?>">
									<td class="check-col">
										<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="ids[]" value="<?php echo e($item->id); ?>" data-id="<?php echo e($item->id); ?>" class="crazy-check-item"> 
											<span></span>
										</label>
									</td>
									
									<td>
                                        <a href="<?php echo e($url = admin_slider_item_url('update', ['id'=>$item->id])); ?>">
                                            <img src="<?php echo e($item->getImage()); ?>" class="image-thumbnail" alt="<?php echo e($item->title); ?>">
                                        </a>
                                    </td>
                                    <td class="min-160 max-250"><a href="<?php echo e($url); ?>"><?php echo e($item->title); ?></a></td>
                                    <td class="min-160 max-250"><?php echo e($item->getShortDesc(150)); ?></td>
                                    <td class="min-160 max-250"><a href="<?php echo e($item->link); ?>"><?php echo e($item->link); ?></a></td>
									<td class="min-100 actions">
										<a href="<?php echo e($url); ?>" data-original-title="Sửa" data-toggle="m-tooltip" data-placement="left" title class="text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
											<i class="flaticon-edit-1"></i>
										</a>
										<a href="javascript:void(0);" data-id="<?php echo e($item->id); ?>" data-toggle="m-tooltip" data-placement="left" data-original-title="Xóa" class="btn-delete text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
											<i class="flaticon-delete-1"></i>
										</a>
										
									</td>
								</tr>
	
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<div class="list-toolbar">
				<div class="row">
					<div class="col-12 col-md-6 col-lg-4">
							<a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Chọn tất cả" class="crazy-btn-check-all text-success btn btn-outline-success btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
								<i class="fa fa-check"></i>
							</a>

							<a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa tất cả" class="crazy-btn-delete-all text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
								<i class="flaticon-delete-1"></i>
							</a>
							
					</div>
					<div class="col-12 col-md-6 col-lg-8">
					</div>
				</div>
			</div>
			<!--end::Section-->
	
			<?php else: ?>
				<div class="alert alert-default text-center">Danh sách trống</div>
			<?php endif; ?>
			
		</div>
	
		<!--end::Form-->
	</div>
	
<?php $__env->stopSection(); ?>


<?php $__env->startSection('jsinit'); ?>
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"items",
				title:"Item",
				urls:{
					delete_url: <?php echo json_encode(admin_slider_item_url('delete'), 15, 512) ?>
				}
			})
		};

		
		// khai báo ở dây
	</script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>
	
<?php $__env->stopSection(); ?>




<?php $__env->startSection('js'); ?>
	<script src="<?php echo e(asset('static/crazy/js/items.js')); ?>"></script>
	
<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout.'main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/sliders/items/list.blade.php ENDPATH**/ ?>