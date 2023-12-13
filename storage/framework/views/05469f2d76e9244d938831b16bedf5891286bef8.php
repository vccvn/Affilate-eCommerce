

    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Thêm Item
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body p-0">

            <!--begin::Section-->
            <div class="m-accordion m-accordion--bordered" id="crazy-menu-detail" role="tablist">

                <?php $__currentLoopData = $itemGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $group_ext = null;
                    $group_type = $type;
                    $form_inputs = $group['inputs'];
                    $hidden = [
                        'name' => 'type',
                        'type' => 'hidden',
                        'value' => $type
                    ];
                    if(is_numeric($type)){
                        $group_type = 'post_category';
                        $group_ext = '-'.$type;

                        $hidden['value'] = 'post_category';
                        $form_inputs['ref'] = [
                            'name' => 'ref',
                            'type' => 'hidden',
                            'value' => 'post_category'
                        ];
                        $form_inputs['ref_id'] = [
                            'name' => 'ref_id',
                            'type' => 'hidden',
                            'value' => $type
                        ];
                    }
                    $form_inputs['type'] = $hidden;
                    $args = [
                        'inputs' => $form_inputs,
                        'data' => [],
                        'errors' => $errors
                    ];
                    $input_options = ['className'=>'form-control m-input'];
                    $form = html_form($args, $input_options, [
                        'method' => 'POST',
                        'action' => route($route_name_prefix . 'menus.items.save', ['menu_id' => $menu->id]),
                        'class' => 'add-menu-item-form'
                    ]);
                    $form->query(['type' => ['radio', 'checkbox', 'crazyselect', 'file', 'hidden']])->map('removeClass', ['form-control', 'm-input']);
                    $form->query(['type' => 'checkbox'])->map('setOption', 'label_class', 'm-checkbox');
                    $form->query(['type' => 'radio'])->map('setOption', 'label_class', 'm-radio');
                    $form->data('prefix', 'add-'.$group_type.$group_ext);
                    // dd($form);
                    $inputs = $form->notInGroup(array_keys($form_inputs))
                    ?>
                <!--begin::Item-->
                <div class="m-accordion__item">
                    <div class="m-accordion__item-head collapsed" role="tab" id="crazy-menu-detail_item_<?php echo e($type); ?>_head" data-toggle="collapse" href="#crazy-menu-detail_item_<?php echo e($type); ?>_body" aria-expanded="false">
                        <span class="m-accordion__item-icon">
                            <i class="fa <?php echo e($group['icon']); ?>"></i>
                        </span>
                        <span class="m-accordion__item-title"><?php echo e($group['text']); ?></span>
                        <span class="m-accordion__item-mode"></span>
                    </div>
                    <div class="m-accordion__item-body collapse" id="crazy-menu-detail_item_<?php echo e($type); ?>_body" class=" " role="tabpanel" aria-labelledby="crazy-menu-detail_item_<?php echo e($type); ?>_head" data-parent="#crazy-menu-detail">
                        <div class="m-accordion__item-content">
                            <form <?php echo $form->attrsToStr(); ?>>
                                <?php echo csrf_field(); ?>
                            
                                <?php $__currentLoopData = $inputs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $input): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($input->hidden): ?>
                                        <?php continue; ?>
                                    <?php endif; ?>
                                    <?php
                                    $g_class = '';
                                    $l_class = '';
                                    $w_class = '';
                                    
                                    $input->id = 'add-'.$group_type.$group_ext . '-'.$input->id;
                                    
                                    ?>
                                    <?php if($input->type=='hidden'): ?>
                                        <?php echo $input; ?>

                                    <?php else: ?>
                                        <div class="mt-1 mb-4 crazy-form-group item-<?php echo e($input->name); ?>-group <?php echo e($g_class); ?> <?php echo e($input->error?'has-danger':''); ?>" id="<?php echo e($input->id); ?>-form-group">
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
                                <div class="buttons">
                                    <button type="submit" class="btn btn-info">Thêm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <!--end::Item-->

            </div>


            <!--end::Section-->
        </div>


        
    </div>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/menus/items/templates/add-form.blade.php ENDPATH**/ ?>