<?php


// $l_type = (isset($layout_type) && in_array($layout_type, ['single', 'column']))?$layout_type:'single';
if(!isset($is_template) || !$is_template) add_js_data('form_setting_groups', 'form-setting-group-'.$index);
// add_js_data('form_setting_groups', $index, $group->all());

?>
    <div class="form-setting-group col-12 <?php echo e($group_class); ?>" id="form-setting-group-<?php echo e($index); ?>" data-class="<?php echo e($group_class); ?>" data-index="<?php echo e($index); ?>">

        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head form-setting-header">
                <div class="m-portlet__head-caption group-title">
                    <div class="m-portlet__head-title setting-group-title">
                        <h3 class="m-portlet__head-text">
                            <a href="javascript:void(0);" class="btn-open-title-form-group mr-3" data-group="<?php echo e($index); ?>">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <span class="title-text">
                                <?php if(isset($group_title)): ?>
                                    <?php echo e($group_title); ?>

                                <?php endif; ?>
                            </span>
                            
                        </h3>
                        
                    </div>
                    <div class="input-group form-setting-group-title d-none">
                        <input type="text" name="groups[<?php echo e($index); ?>][title]" class="form-control group-input-title" value="<?php echo e(isset($group_title)?$group_title:''); ?>" placeholder="Nhãn">
                        
                        <span class="input-group-append">
                            <a href="javascript:void(0);" class="btn-close-title-form-group btn btn-default" data-group="<?php echo e($index); ?>">
                                <i class="fa fa-check text-success"></i>
                            </a>
                        </span>
                    </div>
                    
                </div>
                <div class="group-class">
                    <div class="setting-group-class">
                        <span class="class-text"><?php echo e($group_class); ?></span>
                        <a href="javascript:void(0);" class="btn-open-class-form-group ml-3" data-group="<?php echo e($index); ?>">
                            <i class="fa fa-cog"></i>
                        </a>
                        
                        
                    </div>
                    <div class="input-group form-setting-group-class d-none">
                        <input type="text" name="groups[<?php echo e($index); ?>][class]" class="form-control group-input-class" value="<?php echo e($group_class); ?>" placeholder="className">
                        <span class="input-group-append">
                            <a href="javascript:void(0);" class="btn-close-class-form-group btn btn-default" data-group="<?php echo e($index); ?>">
                                <i class="fa fa-check text-success"></i>
                            </a>
                        </span>
                    </div>
                </div>

            </div>
            <div class="m-portlet__body">
                
                <div class="dd nestable form-inputs" id="form-group-<?php echo e($index); ?>" data-max-depth="1" data-callback="FSetting.nestableUpdaleAll" data-index="<?php echo e($index); ?>">
                    <ol class="dd-list">
                        <?php if((!isset($is_template) || !$is_template) && isset($list) && count($list)): ?>
                            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $namespace => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php 
                                add_js_data('field_list', [$namespace]);
                            ?>
                            <li class="dd-item" data-id="<?php echo e($namespace); ?>">
                                <div class="dd-handle"><?php echo e($item->label); ?></div>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        
                    </ol>
                </div>
                <div class="buttons mt-2 text-right">
                    <a href="javascript:void(0);" class="btn-delete-form-group text-danger" data-group="<?php echo e($index); ?>">
                        <i class="fa fa-trash"></i> Xóa
                    </a>
                </div>
            </div>
        </div>

        <!--end::Portlet-->
    </div>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/config-section.blade.php ENDPATH**/ ?>