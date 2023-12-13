    
    <div class="modal fade menu-item-modal" id="menu-item-modal-<?php echo e($group_type); ?><?php echo e($group_ext); ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo e($group_type); ?><?php echo e($group_ext); ?>-item-modal-title">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="<?php echo e(route($route_name_prefix.'menus.items.save', ['menu_id' => $menu->id])); ?>" method="POST" class="update-menu-item-form" data-prefix="<?php echo e($group_type); ?><?php echo e($group_ext); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" id="<?php echo e($group_type); ?><?php echo e($group_ext); ?>-id" value="">
    
                    <div class="modal-header custom-style bg-info">
                        <h5 class="modal-title" id="<?php echo e($group_type); ?><?php echo e($group_ext); ?>-item-modal-title">
                            <i class="fa fa-info-circle"></i>
                            <span>Cập nhật item</span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php $__currentLoopData = $inputList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $input): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($input->hidden): ?>
                            <?php continue; ?>
                        <?php endif; ?>
                        <?php
                            $g_class = 'form-group row';
                            $l_class = 'col-md-4 col-lg-3 col-form-label';
                            $w_class = 'col-md-8 col-lg-9';
                            $intype = strtolower($input->type);
                            $input->id = $group_type.$group_ext . '-'.$input->id;
                            if($input->name == 'icon'){
                                $input->attr('data-modal-id', 'menu-item-modal-'.$group_type.$group_ext);
                            }
                        ?>
                        <?php if($input->type=='hidden'): ?>
                            <?php echo $input; ?>

                        <?php else: ?>
                            <div class="mt-1 mb-4 crazy-form-group item-<?php echo e($input->name); ?>-group <?php echo e($g_class); ?> <?php echo e($input->error?'has-danger':''); ?>" id="<?php echo e($input->id); ?>-form-group" data-modal-id="menu-item-modal-<?php echo e($group_type); ?><?php echo e($group_ext); ?>">
                                <label class="<?php echo e($l_class); ?>" for="<?php echo e($input->id); ?>" >
                                    <?php echo e($input->label); ?>

                                    <?php if($input->required && !in_array($input->required, ["0", "false"])): ?>
                                    <span class="m-badge m-badge--danger m-badge--dot"></span>
                                    <?php endif; ?>
                                    
                                </label>
                                <div class="<?php echo e($w_class); ?>">

                                    <?php
                                        $is_template = is_support_template($input->template, $input->type);
                                        $addon_class = '';
                                        if($is_template){
                                            if($input->template == 'touchspin') $addon_class.= 'bootstrap-touchspin ';
                                        }

                                        $dig = $input->data('input-group');
                                        $input_group_class = ($input->prependGroup || $input->prepend_text || $input->append_text || $input->prepend_button || $input->append_button || $input->appendGroup || ($dig && $dig!='false'))?'input-group':'';
                                        $is_input_columns = ($input->prependColumns || $input->appendColumns)?true:false;
                                    ?>
                                    
                                    <?php if($is_input_columns): ?>
                                        <div class="row">
                                            <?php if($input->prependColumns): ?>
                                                <?php $__currentLoopData = $input->prependColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php 
                                                if($addon->error){
                                                    set_web_data($input->id. '-error', $addon->error);
                                                }
                                                ?>
                                                    <div class="col-md">
                                                        <?php if(in_array($addon->type, $input_addons)): ?>
                                                            <?php echo $__env->make('admin.forms.addons.'.$addon->type, ['input'=>$addon], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <?php elseif(is_support_template($addon->template, $addon->type)): ?>
                                                            <?php echo $__env->make('admin.forms.templates.'.$addon->template, ['input'=>$addon], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <?php else: ?>
                                                            <?php echo $addon; ?>

                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                            <div class="col-md">
                                    <?php endif; ?>



                                    <?php if($input_group_class): ?>
                                        <?php echo $__env->make('admin.forms.group-addon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php else: ?>
                                        <?php echo $__env->make('admin.forms.form-input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endif; ?>
                                    
                                    <?php if($is_input_columns): ?>
                                            </div>
                                        <?php if($input->appendColumns): ?>
                                            <?php $__currentLoopData = $input->appendColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php 
                                                if($addon->error){
                                                    set_web_data($input->id. '-error', $addon->error);
                                                }
                                                ?>
                                                <div class="col-md">
                                                    <?php if(in_array($addon->type, $input_addons)): ?>
                                                        <?php echo $__env->make('admin.forms.addons.'.$addon->type, ['input'=>$addon], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    <?php elseif(is_support_template($addon->template, $addon->type)): ?>
                                                        <?php echo $__env->make('admin.forms.templates.'.$addon->template, ['input'=>$addon], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    <?php else: ?>
                                                        <?php echo $addon; ?>

                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-control-feedback input-message-alert" id="input-<?php echo $input->id; ?>-message-alert"><?php echo e($input->error??(get_web_data($input->id.'-error')??$input->hiddenData('note'))); ?></div>

                                </div>
                                
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Lưu</button>
                        <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/menus/items/templates/modal-form.blade.php ENDPATH**/ ?>