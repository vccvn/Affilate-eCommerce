<?php
use Gomee\Html\Input;

$page = request()->page;


$list_config = [
    'default' => [
        'title' => 'Phương thức thanh toán',
        'btn_class' => 'btn-move-to-trash',
        'tooltip' => 'Xóa tạm thời',
    ],
    'trash' => [
        'title' => 'Danh sách tài khoản đã xóa',
        'btn_class' => 'btn-delete',
        'tooltip' => 'Xóa vĩnh viễn',
    ],
];

$list_type = (isset($type) && strtolower($type) == 'trash')?'trash':'default';

$columns = [
    'name'=>'Tên hiển thị',
    'method'=>'Phương thức',
    'description' => 'Mô tả',

];


$title = $list_config[$list_type]['title'];
$btn_class = $list_config[$list_type]['btn_class'];
$btn_tooltip = $list_config[$list_type]['tooltip'];
$method_options = get_payment_select_options();


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
                    
                    <div class="create-button">
                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Thêm Phương Thức
                        </button>
                        <div class="dropdown-menu" x-placement="bottom-start">
                            <?php if(is_array($method_options)): ?>
                                <?php $__currentLoopData = $method_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item btn-create-payment" href="javascript:void(0);" data-method="<?php echo e($value); ?>"><?php echo e($text); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>


                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!--end::Form-->
</div>
<?php if(count($results)): ?>
<div class="row crazy-list" id="m_sortable_portlets">
    <div class="col-lg-12">
        <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(!($methodData = get_payment_method_inputs($item->method))): ?>
                <?php continue; ?>
            <?php endif; ?>
            <?php
                $config = $item->config;
                $inputs = crazy_arr($methodData['inputs'])->copyWithout(['name', 'description', 'method', 'guide', 'icon']);
                
            ?>
            <!--begin::Portlet-->
            <div class="m-portlet method-item m-portlet--collapsed m-portlet--head-sm m-portlet--sortable" data-name="<?php echo e($name = $item->name?$item->name:(isset($method_options[$method->method])?$method_options[$method->method]:$method->method)); ?>" m-portlet="true" id="crazy-item-<?php echo e($item->id); ?>" data-id="<?php echo e($item->id); ?>">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <?php echo $__env->make($_base.'forms.templates.switch', [
                                    'input' => html_input([
                                        'type' => 'checkbox',
                                        'data-method-id' => $item->id,
                                        'name' => 'payment_methods['.$item->id.'][status]',
                                        'id' => 'payment-methods-'.$item->id.'-status',
                                        'value' => $item->status,
                                        '@change' => 'App.payments.methods.changeStatus'

                                    ])
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </span>
                            <h3 class="m-portlet__head-text">
                                <?php echo e($name); ?>

                            </h3>
                        </div>
                    </div>

                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-angle-down" style="transform: rotate(-180deg)"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="javascript:void(0);" data-id="<?php echo e($item->id); ?>" class="m-portlet__nav-link m-portlet__nav-link--icon <?php echo e($btn_class); ?>">
                                    <i class="la la-close"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form method="post" action="<?php echo e(route($route_name_prefix.'payments.methods.ajax.save')); ?>" class="m-form update-payment-method-form">
                        <input type="hidden" name="method" value="<?php echo e($item->method); ?>">
                        <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                        <div class="form-group m-form__group ml-0 mr-0">
                            <label for="name-<?php echo e($item->id); ?>">Tên hiển thị</label>
                            <input type="text" name="name" class="form-control m-input m-input--air" id="<?php echo e($item->id); ?>" value="<?php echo e($name); ?>" placeholder="<?php echo e(isset($methodData['inputs']['name']['placeholder'])?$methodData['inputs']['name']['placeholder']:'Viết gì đó'); ?>">
                        </div>
                        <div class="form-group m-form__group ml-0 mr-0">
                            <label for="icon-<?php echo e($item->id); ?>">Icon</label>
                            <?php echo $__env->make($_base.'forms.templates.file', [
							'input' => new Input([
								'type' => 'file',
								'name' => 'icon',
								'id' => 'icon',
								'value' => $item->icon,
                                "data-on-change" => "App.modal.onPopupFile"
							])
						], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>

                        <div class="form-group m-form__group">
                            <label for="description-<?php echo e($item->id); ?>">Mô tả</label>
                            <textarea class="form-control m-input m-input--air" name="description" id="description-<?php echo e($item->id); ?>" rows="3"><?php echo e($item->description); ?></textarea>
                        </div>

                        <?php if(is_array($config) && $config): ?>
                            <h4>Cấu hình</h4>
                            <div class="table-responsive">
                                <table class="table table-bordere">
                                    <thead>
                                        <tr>
                                            <?php $__currentLoopData = $inputs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $input): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <th><?php echo e($input['label']); ?></th>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php $__currentLoopData = $inputs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $input): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $opt = $input;
                                                    $opt['name'] = $name;
                                                    $opt['value'] = array_key_exists($name, $config) ? $config[$name] : '';

                                                ?>
                                                <td class="pl-0 pr-0">
                                                    <?php echo html_input($opt)->addClass('form-control m-input m-input--air'); ?>

                                                </td>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        <?php endif; ?>

                        <?php if(isset($methodData['inputs']['guide'])): ?>
                        <div class="form-group m-form__group">
                            <label for="guide-<?php echo e($item->id); ?>">Hướng dẫn</label>
                            <textarea class="form-control m-input m-input--air" name="guide" id="guide-<?php echo e($item->id); ?>" rows="3"><?php echo e($item->guide); ?></textarea>
                        </div>


                        <?php endif; ?>
                        <div class="text-center mt-2 buttons">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <button type="button" class="btn btn-secondary">Huỷ bỏ</button>
                        </div>
                    </form>
                </div>

            </div>

            <!--end::Portlet-->

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



        <!-- begin:Empty Portlet: sortable porlet required for each columns! -->
        <div class="m-portlet m-portlet--sortable-empty">
        </div>

        <!--end::Empty Portlet-->
    </div>
</div>
<?php else: ?>

<?php endif; ?>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/payments/methods/results.blade.php ENDPATH**/ ?>