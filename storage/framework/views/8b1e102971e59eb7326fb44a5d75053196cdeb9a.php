<?php $__env->startSection('title', "Danh sách menu"); ?>


<?php $__env->startSection('module.name', "Menu"); ?>


<?php $__env->startSection('content'); ?>



<div class="row">
    <div class="col-12 col-md-5 col-xl-4">
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Thêm Menu
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="m-portlet__body">
        
                <!--begin::Section-->
                <div class="m-section">
                    <div class="m-section__content">
                        <?php echo $__env->make($_base.'forms.form', [
                            'inputs' => $inputs,
                            'config' => [
                                'save_button_text' => 'Thêm',
                                'cancel_button_text' => 'Hủy',
                                'form_group_options' => [
                                    'group_class' => '',
                                    'label_class' => '',
                                    'wrapper_class' => ''
                                ],
                                'form_group_style' => 'custom',
                                'log_style' => true,
                            ],
                            'attrs' => [
                                'method' => 'post',
                                'action' => route($route_name_prefix . 'menus.save'),
                                'id' => 'menu-form',
                            ]
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    
                </div>
                
            </div>
        
            <!--end::Form-->
        </div>
        <!--end::Portlet-->
    </div>
    <div class="col-12 col-md-7 col-xl-8">
        
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Danh sách menu
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="<?php echo e(route($route_name_prefix.'menus.create')); ?>" data-toggle="m-tooltip" data-placement="left" title data-original-title="Thêm menu" class="ml-3 btn btn-outline-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a>
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
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="id-col">
                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                    <input type="checkbox" class="crazy-check-all"> 
                                                    <span></span>
                                                </label>
                                            </th>
                                            
                                            <th class="min-160">Tên Menu</th>
                                            <th class="min-100">Loại</th>
                                            <th class="min-100">Vị trí</th>
                                            <th class="min-100 actions">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $types = [
                                            "default"=> "Mặc định",
                                            "product"=> "danh mục sản phâm",
                                            "post"=> "Danh mục bài viết",
                                            "project"=> "Danh mục dự án"
                                        ];
                                        $isMainTexts = ["Không", "Có"];
                                        ?>
                                        <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            
                                        <tr id="crazy-item-<?php echo e($item->id); ?>" data-name="<?php echo e($item->name); ?>" data-parent-id="<?php echo e($item->id); ?>" class="crazy-item-<?php echo e($item->parent_id); ?>">
                                            <td class="check-col">
                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                                    <input type="checkbox" name="ids[]" value="<?php echo e($item->id); ?>" data-id="<?php echo e($item->id); ?>" class="crazy-check-item"> 
                                                    <span></span>
                                                </label>
                                            </td>
                                            
                                            <td class="min-160"><a href="<?php echo e(route($route_name_prefix.'menus.items', ['menu_id' => $item->id])); ?>"><?php echo e($item->name); ?></a></td>
                                            <td class="min-100"><?php echo e($types[$item->type]??'Mặc định'); ?></td>
                                            <td class="min-100"><?php echo e($item->getPositionText()); ?></td>
                                            <td class="min-100 actions">

                                                
                                                <a title data-original-title="Sửa" href="<?php echo e(route($route_name_prefix.'menus.update', ['id' => $item->id])); ?>" data-toggle="m-tooltip" data-placement="left" class="text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                                    <i class="flaticon-edit-1"></i>
                                                </a>
                                                
                    
                                                <a href="javascript:void(0);" data-id="<?php echo e($item->id); ?>" data-toggle="m-tooltip" data-placement="left" data-original-title="Xóa menu" class="btn-delete text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
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
        
        
    </div>
</div>


<?php $__env->stopSection(); ?>



<?php $__env->startSection('jsinit'); ?>
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"menus",
				title:"Menu",
				
				urls:{
					delete_url: <?php echo json_encode(route($route_name_prefix.'menus.delete'), 15, 512) ?>
				}
			})
		};
		// khai báo ở dây
	</script>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('static/crazy/js/items.js')); ?>"></script>
    <script src="<?php echo e(asset('static/manager/js/menu.form.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout.'main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/menus/list.blade.php ENDPATH**/ ?>