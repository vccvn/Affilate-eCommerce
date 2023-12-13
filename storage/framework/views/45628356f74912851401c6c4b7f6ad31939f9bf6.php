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
    if(!isset($form_inputs['text'])){
        $form_inputs = ['text' => [
            'type' => 'text',
            'name' => 'text',
            'label' => 'Text Hiển thị',
            'placeholder' => 'Nhập text Hiển thị'
        ]] + $form_inputs;
    }
    $args = [
        'inputs' => $form_inputs,
        'data' => [],
        'errors' => $errors
    ];
    $input_options = ['className'=>'form-control m-input'];
    $updateForm = html_form($args, $input_options, [
        'method' => 'POST',
        'action' => route($route_name_prefix . 'menus.items.save', ['menu_id' => $menu->id]),
        'class' => 'update-menu-item-form'
    ]);
    $updateForm->query(['type' => ['radio', 'checkbox', 'crazyselect', 'file']])->map('removeClass', ['form-control', 'm-input']);
    $updateForm->query(['type' => 'checkbox'])->map('setOption', 'label_class', 'm-checkbox');
    $updateForm->query(['type' => 'radio'])->map('setOption', 'label_class', 'm-radio');
    
    $inputList = $updateForm->notInGroup(array_keys($form_inputs));
    // dump($inputList);
    ?>
    <?php echo $__env->make($_current.'templates.modal-form', compact('inputList', 'group_type', 'group_ext'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/menus/items/templates/modals.blade.php ENDPATH**/ ?>