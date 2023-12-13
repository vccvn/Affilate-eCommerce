<?php
$columns = [
    'name'=>'Tên danh mục',
    // 'type' => 'Loại tin bài'
];
extract(get_result_blade_vars('danh mục', (isset($type) && strtolower($type) == 'trash')?'trash':'default'));
$current_page = request()->page;
if(!is_numeric($current_page) || $current_page < 1) $current_page = 1;
$index = ($current_page - 1) * 10 + 1;
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
        <?php if($list_type!='trash'): ?>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="<?php echo e(admin_dynamic_url('categories.create')); ?>" data-toggle="m-tooltip" data-placement="left" title data-original-title="Thêm danh mục" class="ml-3 btn btn-outline-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a>
                </li>
            </ul>
        </div>
        <?php endif; ?>

    </div>
    
    <div class="m-portlet__body">

        <div class="m-section">
            <div class="m-section__sub">
                <?php echo $__env->make($_template.'list-filter',[
                    'sortable'=> array_merge($columns, [
                        'updated_at' => 'Thời gian cập nhật'
                    ]),
                    'searchable' => $columns
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <?php if(isset($results) && count($results)): ?>
        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content crazy-list">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="check-col">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" class="crazy-check-all"> 
                                        <span></span>
                                    </label>
                                </th>
                                
                                <th class="id-col">STT</th>
                                <th>Ảnh</th>
                                <th>Tên danh mục</th>
                                <th>Danh mục cha</th>
                                <th class="min-160">Mô tả</th>
                                <th>Số tin bài</th>
                                <th class="min-100 actions">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                            <tr id="crazy-item-<?php echo e($item->id); ?>" data-name="<?php echo e($item->name); ?>">
                                <td class="check-col">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" name="ids[]" value="<?php echo e($item->id); ?>" data-id="<?php echo e($item->id); ?>" class="crazy-check-item"> 
                                        <span></span>
                                    </label>
                                </td>
                                <td class="id-col"><?php echo e($index); ?></td>
                                <td>
                                    <a style="font-weight:500" href="#">
                                        <img src="<?php echo e($item->getFeaturedImage()); ?>" class="image-thumbnail" alt="<?php echo e($item->name); ?>">
                                    </a>
                                </td>
                                <td><a style="font-weight:500" href="#"><?php echo e($item->name); ?></a></td>
                                <td><?php echo e($item->parent?$item->parent->name:'không'); ?></td>
                                <td class="max-250" class="min-160"><?php echo e($item->getShortDesc(120)); ?></td>
                                <td><?php echo e($item->post_count??0); ?></td>
                                <td class="min-100 actions">

                                    
                                    <a data-toggle="m-tooltip" data-placement="left" title data-original-title="Sửa" href="<?php echo e(admin_dynamic_url('categories.update', ['id'=>$item->id])); ?>" class="text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-edit-1"></i>
                                    </a>
                                    
        
                                    <?php if($list_type=='trash'): ?>
                                    
                                    <a href="javascript:void(0);" data-id="<?php echo e($item->id); ?>" data-toggle="m-tooltip" data-placement="left" data-original-title="Khôi phục" class="btn-restore text-info btn btn-outline-info btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="fa fa-undo"></i>
                                    </a>
                                        
                                    <?php endif; ?>

                                    <a href="javascript:void(0);" data-id="<?php echo e($item->id); ?>" data-toggle="m-tooltip" data-placement="left" data-original-title="<?php echo e($btn_tooltip); ?>" class="<?php echo e($btn_class); ?> text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                                        <i class="flaticon-delete-1"></i>
                                    </a>
                                    
                                </td>
                            </tr>
                            <?php
                                $index++;
                            ?>

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

                        <?php if($list_type=='trash'): ?>
                        
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Khôi phục tất cả" class="crazy-btn-restore-all text-info btn btn-outline-info btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="fa fa-undo"></i>
                        </a>
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa tất cả" class="crazy-btn-delete-all text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="flaticon-delete-1"></i>
                        </a>    
                        <?php else: ?>
                        <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Chuyển tất cả vào thùng rác" class="crazy-btn-move-to-trash-all text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="flaticon-delete-1"></i>
                        </a>    
                        
                        <?php endif; ?>

                        
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
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/posts/categories/templates/results.blade.php ENDPATH**/ ?>