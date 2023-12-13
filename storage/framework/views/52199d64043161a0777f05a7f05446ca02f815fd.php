<?php
use Gomee\Html\Input;
use Gomee\Helpers\Arr;

add_js_src('static/crazy/js/prop.js');
// $input->type = "text";

$wrapper = $input->copy();

$wrapper->type = "crazyprop";
$wrapper->prepareCrazyInput();

$wrapper->removeClass();
$wrapper->addClass("crazy-prop");
$wrapper->id.='-wrapper';
$wrapper->name.='-wrapper';
$selectData = [
    "text","number","email","textarea","select","radio", "checkbox", "checklist", "switch", "crazyselect", "crazytag", "options", "touchspin", "file", 'media'
];

$data = $input->defval();
if(!is_array($data)) $data = [];
$maxIndex = -1;

?>

<div <?php echo $wrapper->attrsToStr(); ?>>
    <div class="crazy-prop-list">
        <?php if($data): ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $prop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $p = new Arr($prop);
                    $maxIndex = $index;
                    $name = $input->name."[$index]";
                    $type = new Input([
                                'type' => 'select',
                                'name' => $name.'[type]',
                                'data' => $selectData,
                                "data_value_type" => 'value',
                                'class' => 'form-control m-input',
                                'value' => $prop['type']
                            ]);

                    $propList = $p->prop_list;
                    if($propList){
                        if(!is_array($propList)){
                            $propList = json_decode($propList, true);
                        }
                    }else{
                        $propList = [];
                    }
                ?>
                <div class="crazy-prop-item row" id="crazy-prop-item-<?php echo e($index); ?>" data-index="<?php echo e($index); ?>">
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-sm-6 col-md-3 mb-4">
                                <label>Tên trường (field name)</label>
                                <input type="text" name="<?php echo e($name.'[name]'); ?>" class="form-control m-input" placeholder="name" value="<?php echo e($p->name); ?>">
                            </div>
                            <div class="col-sm-6 col-md-3 mb-4">
                                <label>Loại (input type)</label>
                                <?php echo $type; ?>

                            </div>
                            <div class="col-sm-6 col-md-3 mb-4">
                                <label>Nhãn (label)</label><input type="text" name="<?php echo e($name.'[label]'); ?>" class="form-control m-input" placeholder="label (Nhãn)" value="<?php echo e($p->label); ?>">
                            </div>
                            <div class="col-sm-6 col-md-3 mb-4">
                                <label>Validate </label>
                                <input type="text" name="<?php echo e($name.'[validate]'); ?>" class="form-control m-input" placeholder="validate (ví dụ: required|string)" value="<?php echo e($p->validate); ?>">
                            </div>
                            
                            <div class="col-12 mb-xs-4">
                                <label for="">Thuộc tính (dạng key-value): </label> <a href="javascript:void(0);" data-index="<?php echo e($index); ?>" class="crazy-btn-add-prop-key-value text-info"><i class="fa fa-plus"></i> Thêm</a>
                                <div class="prop-list" data-max-index="<?php echo e(count($propList)); ?>">
                                    <?php if($propList): ?>
                                        <?php $__currentLoopData = $propList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $propItem = new Arr($item);
                                            ?>
                                            <div class="row prop-list-item mt-3" id="<?php echo e($input->name.'-'.$index.'-prop-list-'.$loop->index); ?>">
                                                <div class="col-12 col-sm-10 col-md-11">
                                                    <div class="row">
                                                        <div class="col-6 col-sm-5 col-md-4">
                                                            <input type="text" name="<?php echo e($name.'[prop_list]['.$loop->index.'][key]'); ?>" class="form-control m-input" value="<?php echo e($propItem->key); ?>" placeholder="key">
                                                        </div>
                                                        <div class="col-6 col-sm-7 col-md-8">
                                                            <textarea name="<?php echo e($name.'[prop_list]['.$loop->index.'][value]'); ?>" placeholder="value: Có thể nhập json theo cú pháp @[...] hoặc @{...}" cols="30" rows="1" class="form-control m-input auto-height"><?php echo e($propItem->value); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-2 col-md-1 ">
                                                    <a href="javascript:void(0);" data-list-index="<?php echo e($index); ?>" data-item-index="<?php echo e($loop->index); ?>" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa thuộc tính này" class="crazy-btn-delete-prop-data text-warning btn btn-default">
                                                            <span class="fa fa-ban"></span> Xóa
                                                    </a>    
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="buttons">
                                        
                                </div>

                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-1 prop-actions mb-xs-4">
                        <a href="javascript:void(0);" data-index="<?php echo e($index); ?>" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa trường này" class="crazy-btn-delete-prop text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="flaticon-delete-1"></i>
                        </a>    
                    </div>
                    
                    <?php if($errors->has($input->name.'.'.$index)): ?>
                        <div class="col-12 mt-3">
                            <span class="text-danger"><?php echo e($errors->first($input->name.'.'.$index)); ?></span>
                        </div>
                    <?php endif; ?>    
                </div>
                
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>

    <div class="crazy-prop-buttons mt-3 text-right">
        <div class="crazy-btn-add-prop btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
            <span>
                <i class="la la-plus"></i>
                <span>Thêm field</span>
            </span>
        </div>
    </div>

    <div class="crazy-prop-template d-none" style="display: none" data-max-index="<?php echo e($maxIndex); ?>">
            <?php
            $index = '{$index}';
            $name = $input->name."[$index]";

            $type = new Input([
                        'type' => 'select',
                        'name' => $name.'[type]',
                        'data' => $selectData,
                        "data_value_type" => 'value',
                        'class' => 'form-control m-input'
                    ]);
        ?>
        <div class="crazy-prop-item row" id="crazy-prop-item-<?php echo e($index); ?>" data-index="<?php echo e($index); ?>" style="display: none">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-sm-6 col-md-3 mb-4">
                        <label>Tên trường (field name)</label>
                        <input type="text" name="<?php echo e($name.'[name]'); ?>" class="form-control m-input" placeholder="name">
                    </div>
                    <div class="col-sm-6 col-md-3 mb-4">
                        <label>Loại (input type)</label>
                        <?php echo $type; ?>

                    </div>
                    <div class="col-sm-6 col-md-3 mb-4">
                        <label>Nhãn (label)</label><input type="text" name="<?php echo e($name.'[label]'); ?>" class="form-control m-input" placeholder="label (Nhãn)" >
                    </div>
                    <div class="col-sm-6 col-md-3 mb-4">
                        <label>Validate </label>
                        <input type="text" name="<?php echo e($name.'[validate]'); ?>" class="form-control m-input" placeholder="validate (ví dụ: required|string)">
                    </div>
                    
                    <div class="col-12 mb-xs-4">
                        <label for="">Thuộc tính (dạng key-value):</label>  <a href="javascript:void(0);" data-index="<?php echo e($index); ?>" class="crazy-btn-add-prop-key-value text-info"><i class="fa fa-plus"></i> Thêm</a>
                            <div class="prop-list" data-max-index="0">
                                
                            </div>

                    </div>
                    
                </div>
            </div>
            <div class="col-md-1 prop-actions mb-4">
                <a href="javascript:void(0);" data-index="<?php echo e($index); ?>" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa thuộc tính này" class="crazy-btn-delete-prop text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="flaticon-delete-1"></i>
                </a>    
            </div>
            
        </div>
        
    </div>

    <div class="prop-template d-none" style="display: none">
        <div class="row prop-list-item mt-3" id="{$name}-{$index}-prop-list-{$loop_index}">
            <div class="col-12 col-sm-10 col-md-11">
                <div class="row">
                    <div class="col-6 col-sm-5 col-md-4">
                        <input type="text" name="{$name}[{$index}][prop_list][{$loop_index}][key]" class="form-control m-input" placeholder="key">
                    </div>
                    <div class="col-6 col-sm-7 col-md-8">
                        <textarea name="{$name}[{$index}][prop_list][{$loop_index}][value]" placeholder="value: Có thể nhập json theo cú pháp @[...] hoặc @{...}" cols="30" rows="1" class="form-control m-input auto-height"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-2 col-md-1">
                <a href="javascript:void(0);" data-list-index="{$index}" data-item-index="{$loop_index}" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa thuộc tính này" class="crazy-btn-delete-prop-data text-warning btn btn-default">
                        <span class="fa fa-ban"></span> Xóa
                </a>    
            </div>    
        </div>
    </div>
</div><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/templates/crazyprop.blade.php ENDPATH**/ ?>