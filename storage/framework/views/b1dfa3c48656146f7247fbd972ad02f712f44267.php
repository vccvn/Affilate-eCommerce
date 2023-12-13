<?php
set_admin_template_data('modals', 'colorpicker-modal');
add_css_link('/static/plugins/coloris/coloris.min.css');
add_js_src('/static/plugins/coloris/coloris.min.js');

add_js_src('/static/features/common/common.js');
add_css_link('/static/features/common/common.min.css');

?>




<?php $__env->startSection('title', 'Danh sách thuộc tính sản phẩm'); ?>


<?php $__env->startSection('module.name', $title = 'Thuộc tính sản phẩm'); ?>

<?php $__env->startSection('content'); ?>

    <?php
	$columns = [
		'name'=>'Tên thuộc tính',
		'label'=>'Nhãn',
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
						<?php echo e($title); ?>

					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					<li class="m-portlet__nav-item">
						<a href="<?php echo e(route($route_name_prefix.'products.attributes.create')); ?>" data-original-title="Thêm thuộc tính" data-toggle="m-tooltip" data-placement="left" title class="ml-3 btn btn-outline-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a>
					</li>
				</ul>
			</div>
			
		</div>
		
		<div class="m-portlet__body">
	
			<div class="m-section">
				<div class="m-section__sub">
					<?php echo $__env->make($_template.'list-filter',[
						'sortable'=> $columns,
						'searchable' => $columns
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
			</div>
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
									<th class="check-col">
										STT
									</th>
									
									<th>Thuộc tính</th>
									<th class="min-160 max-250">Danh mục</th>
									<th>Bắt buộc nhập</th>
									<th>Trong đơn hàng</th>
									<th>Biến thể</th>
									<th>Giá trị</th>
									<th class="min-100 actions">Thao tác</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$request = request();
									$per_page = $request->per_page??10; 
									$page = $request->page??0;
										if(method_exists($results, 'perPage')){
											$per_page = $results->perPage();
										}
										if(method_exists($results, 'currentPage')){
											$page = $results->currentPage();
										}
										
										
									if($page < 1) $page = 1;
									if($per_page < 1) $per_page = 10;
									$itemStart = ($page-1) * $per_page;

								?>
								<?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									
								<tr id="crazy-item-<?php echo e($item->id); ?>" data-name="<?php echo e($item->label??$item->name); ?>">
									<td class="check-col">
										<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="ids[]" value="<?php echo e($item->id); ?>" data-id="<?php echo e($item->id); ?>" class="crazy-check-item"> 
											<span></span>
										</label>
									</td>
									<td class="check-col">
										<?php echo e($loop->index + $itemStart + 1); ?>

									</td>
									
									<td><a href="javascript:void(0);"><?php echo e($item->label??$item->name); ?></a></td>
									<td class="min-160 max-250 attribute-category" data-id="<?php echo e($item->category_id); ?>">
										<?php echo e($item->category_name??"Tất cả"); ?>

									</td>
									<td><?php echo $item->is_required?$checkTag:''; ?></td>
									<td><?php echo $item->is_order_option?$checkTag:''; ?></td>
									<td><?php echo e($item->is_variant?(isset($price_types[$item->price_type])?$price_types[$item->price_type] : 'Không') : 'Không'); ?></td>
									<td>
										<?php if(!$item->is_unique && $item->value_type != 'text'): ?>
											<a href="javascript:void(0);" data-id="<?php echo e($item->id); ?>" class="btn-view-attribute-values">Xem danh sách</a>
										<?php endif; ?>
										
									</td>
									<td class="min-100 actions">
										<a href="<?php echo e(route($route_name_prefix.'products.attributes.update', ['id'=>$item->id])); ?>" data-original-title="Sửa" data-toggle="m-tooltip" data-placement="left" title class="text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
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
						<?php echo e($results->links($_pagination.'default')); ?>

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
				module:"products.attributes",
				title:"<?php echo e($title); ?>",
				urls:{
					delete_url: <?php echo json_encode(route($route_name_prefix.'products.attributes.delete'), 15, 512) ?>
				}
			})
		};

		window.productAttributeInit = function () {
			Product.attributes.init({
				categories: <?php echo json_encode(get_product_category_map(), 15, 512) ?>
			})
		};

		
		window.attributeValuesInit = function () {
			Attribute.values.init({
				urls:{
					attribute_detail_url: <?php echo json_encode(route($route_name_prefix.'products.attributes.detail-values'), 15, 512) ?>,
					add_url: <?php echo json_encode(route($route_name_prefix.'products.attributes.values.store'), 15, 512) ?>,
					update_url: <?php echo json_encode(rtrim(route($route_name_prefix.'products.attributes.values.update'), '/'), 512) ?>,
					detail_url: <?php echo json_encode(rtrim(route($route_name_prefix.'products.attributes.values.detail'), '/'), 512) ?>,
					delete_url: <?php echo json_encode(route($route_name_prefix.'products.attributes.values.delete'), 15, 512) ?>
				}
			})
		};

		
		// khai báo ở dây
	</script>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>
	<script src="<?php echo e(asset('static/crazy/js/items.js')); ?>"></script>
	<script src="<?php echo e(asset('static/manager/js/product.attributes.js')); ?>"></script>
	<script src="<?php echo e(asset('static/manager/js/attribute.values.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout.'main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/products/attributes/list.blade.php ENDPATH**/ ?>