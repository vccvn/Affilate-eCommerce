<?php
use Gomee\Html\ColumnItem;
use Gomee\Helpers\Arr;
$list_group = isset($list_group) ? strtolower($list_group) : 'default';
extract(get_result_blade_vars($config->name, $list_group));
$btn_m_class = 'btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air';
$columns = $config->get('table.columns');
$resources = new Arr($config->resources??($config->assets??[]));
// $routeParams = is_array()

if($resources->js_data){
    ColumnItem::show($resources, $config, [], $route_name_prefix.$config->package, $_base);

    add_js_data('list_data', ColumnItem::parseTemplateData($resources->js_data));
}
if($resources->js && is_array($resources->js)){
    foreach($resources->js as $js){
        add_js_src($js);
    }
}
if($resources->css && is_array($resources->css)){
    foreach($resources->css as $css){
        add_css_link($css);
    }
}

$mod_title = $list_group == 'trash' ? ($config->titles['trash']??'Danh sach '.$module_name . ' dã xóa') : ($config->titles[$list_group]??($config->titles['default']??'DAnh sach '.$module_name)); 

if ($config->use_trash && $list_group != 'trash'){
	admin_action_menu([
		[
			'url' => route($route_name_prefix.$config->package.'.trash'),
			'text' => ($config->name??$module_name).' đã xóa',
			'icon' => 'fa fa-trash'
		]
	]);
}
if(!$config->use_trash){
    $btn_class = 'btn-delete';
    $btn_tooltip = "Xóa";
}
$can_edit = $config->has('can_edit')?$config->can_edit:true;
$can_edit = $can_edit && check_current_user_permission($route_name_prefix.$config->package.'.update');

$can_delete = $config->can_delete!==false && check_current_user_permission($route_name_prefix.$config->package.'.' . ($list_group == 'trash' ? 'delete' : (!$config->use_trash ? 'delete' : 'move-to-trash')));
$can_restore = ($config->use_trash && $list_group == 'trash' && check_current_user_permission($route_name_prefix.$config->package.'.restore'));

$show_ext_btn = false;
$buttons = [];

if ($btns = $config->get('buttons')){
    
    $show_ext_btn = true;
    // $buttons = $btns;
    foreach ($btns as $key => $button){
        if(array_key_exists('route', $button)){
            $rr = $button['route'];
            if($rr && ($r = substr($rr, 0, 1) == '.' ?$route_name_prefix.$config->package.$rr:$rr)){
                if(check_current_user_permission($r)){
                    $buttons[] = $button;
                }
            }
        }else{
            $buttons[] = $button;
        }
    }
}

$filterForm = $config->filter['form']??null;

$general_columns = $config->filter['general_columns']??[];
$search_columns = array_merge($general_columns, $config->filter['search_columns']??[]);
$sort_columns = array_merge($general_columns, $config->filter['sort_columns']??[]);

if(is_array($config->data)){
    $_d = [];
    foreach ($config->data as $_key => $_value) {
        if(substr($_key, 0, 1)=="@"){
            if(is_string($_value) && is_callable($_value)){
                $a = call_user_func_array($_value, []);
                if(is_array($a)) $_d[substr($_key, 1)] = $a;
            }
            elseif(is_array($_value) && array_key_exists('call', $_value) && is_callable($_value['call'])){
                $a = call_user_func_array($_value['call'], array_key_exists('params', $_value) && is_array($_value['params'])?$_value['params']:(array_key_exists('args', $_value) && is_array($_value['args'])?$_value['args']:[]) );
                if(is_array($a)) $_d[substr($_key, 1)] = $a;
            }
        }
        else{
            $_d[$_key] = $_value;
        }
    }
    $config->data = $_d;

}

if($config->data && is_array($config->data))
    $config->parseData = ColumnItem::parseAttributeData($config->data);
else $config->parseData = [];
$request = request();
$per_page = $request->per_page??10; 
$page = $request->page??0;
if(isset($results) && $results){
    if(method_exists($results, 'perPage')){
        $per_page = $results->perPage();
    }
    if(method_exists($results, 'currentPage')){
        $page = $results->currentPage();
    }
    
    
}
if($page < 1) $page = 1;
if($per_page < 1) $per_page = 10;
$itemStart = ($page-1) * $per_page;

$filterConfig = $resources = new Arr($config->filter);
?>




<?php $__env->startSection('title', $title = $mod_title); ?>


<?php $__env->startSection('module.name', $config->name??$module_name); ?>


<?php $__env->startSection('content'); ?>

<?php if($filterConfig->type == 'panel' && !$filterConfig->disabled): ?>
    <div class="row">
        <div class="col-md-4 col-xl-3">
            <?php if($filterConfig->include): ?>
                <?php echo $__env->make($_base.$filterConfig->include, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                
            <?php endif; ?>
        </div>

        <div class="col-md-8 col-xl-9">

<?php endif; ?>
<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    <?php echo e($title); ?>

                </h3>
            </div>
        </div>
        <?php if($list_group!='trash' && $config->can_create!==false): ?>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="<?php echo e(route($route_name_prefix.$config->package.'.create')); ?>" data-toggle="m-tooltip" data-placement="left" title data-original-title="Thêm <?php echo e($config->name??$module_name); ?>" class="ml-3 btn btn-outline-primary btn-add-item m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air"><i class="fa fa-plus"></i></a>
                </li>
            </ul>
        </div>
        <?php endif; ?>

    </div>
    
    <div class="m-portlet__body">
        <?php if($filterConfig->type != 'panel' && !$filterConfig->disabled): ?>
        
       
        <div class="m-section filter-section">
            <div class="m-section__sub">
                <?php echo $__env->make($_template.'list-filter'.($filterForm?'-'.$filterForm:''),[
                    'sortable'=> $sort_columns,
                    'searchable' => $search_columns
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <?php endif; ?>
    
        <?php if(isset($results) && count($results)): ?>
        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content crazy-list <?php echo e(str_slug($config->package, '-')); ?>">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped <?php echo e($config->get('table.class')); ?>" data-order-start="<?php echo e($itemStart); ?>">
                        <thead>
                            <tr>
                                <th class="check-col">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" class="crazy-check-all"> 
                                        <span></span>
                                    </label>
                                </th>
                                <?php if($columns): ?>
                                    <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th class="<?php echo e($column['header_class']??$column['class']??''); ?>"><?php echo e($column['title']??'Column'); ?></th>        
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                                
                                <?php endif; ?>
                                <?php if(!$show_ext_btn && !($can_edit!==false) && !($can_delete!==false)): ?>
                                    
                                <?php else: ?>
                                    <th class="min-100 actions">Thao tác</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $index = $itemStart + $loop->index;
                            ?>
                            <tr id="crazy-item-<?php echo e($item->id); ?>" data-name="<?php echo e($item->name??$item->title); ?>">
                                <td class="check-col">
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                        <input type="checkbox" name="ids[]" value="<?php echo e($item->id); ?>" data-id="<?php echo e($item->id); ?>" class="crazy-check-item"> 
                                        <span></span>
                                    </label>
                                </td>
                                <?php if($columns): ?>
                                    <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo ColumnItem::show($item, $config, $column, $route_name_prefix.$config->package, $_base, 'td', $index); ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                                <?php endif; ?>
                                <?php if(!$show_ext_btn && !($can_edit!==false) && !($can_delete!==false)): ?>
                                    
                                <?php else: ?>
                                    <td class="min-120 actions">
                                        <?php if($buttons && $show_ext_btn): ?>
                                            <?php $__currentLoopData = $buttons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $button): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $btnCfg = new Arr(ColumnItem::parseTemplateData($button));
                                                ?>
                                                <a href="<?php echo e($btnCfg->route ? route(substr($btnCfg->route, 0, 1) == '.' ?$route_name_prefix.$config->package.$btnCfg->route:$btnCfg->route, $btnCfg->params??[]  ) : 'javascript:void(0);'); ?>" data-original-title="<?php echo e($btnCfg->title); ?>" data-id="<?php echo e($item->id); ?>"  data-toggle="m-tooltip" data-placement="left" title class="text-<?php echo e($btnCfg->type); ?> <?php echo e($btnCfg->class); ?> <?php echo e($btnCfg->className); ?> btn btn-outline-<?php echo e($btnCfg->type); ?> <?php echo e($btn_m_class); ?>">
                                                    <?php if($btnCfg->icon): ?>
                                                    <i class="<?php echo e($btnCfg->icon); ?>"></i>
                                                    <?php endif; ?> <?php echo e($btnCfg->text); ?>

                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <?php if($can_edit!==false): ?>
                                        <a href="<?php echo e(route($route_name_prefix.$config->package.'.update', ['id'=>$item->id])); ?>" data-id="<?php echo e($item->id); ?>" data-original-title="Sửa"  data-toggle="m-tooltip" data-placement="left" title class="text-accent btn-edit-item btn btn-outline-accent <?php echo e($btn_m_class); ?>">
                                            <i class="flaticon-edit-1"></i>
                                        </a>
                                        <?php endif; ?>
                                        <?php if($list_group=='trash' && $can_restore): ?>
                                        <a href="javascript:void(0);" data-id="<?php echo e($item->id); ?>" data-toggle="m-tooltip" data-placement="left" data-original-title="Khôi phục" class="btn-restore text-info btn btn-outline-info <?php echo e($btn_m_class); ?>">
                                            <i class="fa fa-undo"></i>
                                        </a>
                                        <?php endif; ?>
                                        <?php if($can_delete!==false): ?>
                                            
                                        <a href="javascript:void(0);" data-id="<?php echo e($item->id); ?>" data-toggle="m-tooltip" data-placement="left" data-original-title="<?php echo e($btn_tooltip); ?>" class="<?php echo e($btn_class); ?> text-danger btn btn-outline-danger <?php echo e($btn_m_class); ?>">
                                            <i class="flaticon-delete-1"></i>
                                        </a>
                                        
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
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
                    <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Chọn tất cả" class="crazy-btn-check-all text-success btn btn-outline-success <?php echo e($btn_m_class); ?>">
                        <i class="fa fa-check"></i>
                    </a>
                    <?php if($config->use_trash): ?>
                        <?php if($list_group=='trash'): ?>
                            <?php if($can_restore): ?>
                                <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Khôi phục tất cả" class="crazy-btn-restore-all text-info btn btn-outline-info <?php echo e($btn_m_class); ?>">
                                    <i class="fa fa-undo"></i>
                                </a>
                            <?php endif; ?>
                            <?php if($can_delete): ?>
                                <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa tất cả" class="crazy-btn-delete-all text-danger btn btn-outline-danger <?php echo e($btn_m_class); ?>">
                                    <i class="flaticon-delete-1"></i>
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if($can_delete): ?>
                                <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Chuyển tất cả vào thùng rác" class="crazy-btn-move-to-trash-all text-danger btn btn-outline-danger <?php echo e($btn_m_class); ?>">
                                    <i class="flaticon-delete-1"></i>
                                </a>    
                            <?php endif; ?>
                        <?php endif; ?>    
                    <?php else: ?>
                        <?php if($can_delete): ?>
                            <a href="javascript:void(0);" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa tất cả" class="crazy-btn-delete-all text-danger btn btn-outline-danger <?php echo e($btn_m_class); ?>">
                                <i class="flaticon-delete-1"></i>
                            </a>    
                            
                        <?php endif; ?>
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
<?php if($filterConfig->type == 'panel'): ?>
        </div>
    </div>
<?php endif; ?>

<?php
$extra = [
    'components' => $_component, 
    'templates' => $_template, 
    'modals' => $_base.'_modals.', 
    'views' => $_base
];
?>
<?php $__currentLoopData = $extra; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item => $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($tpl = $config->get('includes.'.$item)): ?>
        <?php if(!is_array($tpl)): ?>
            <?php echo $__env->make($path.$tpl, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php else: ?>
            <?php $__currentLoopData = $tpl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make($path.$blade, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



<?php $__env->stopSection(); ?>


<?php $__env->startSection('jsinit'); ?>
	<?php if($list_group != 'trash'): ?>
		
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"<?php echo e($config->package); ?>",
				title:"<?php echo e($config->name); ?>",
				urls:{
					<?php echo e($config->use_trash?'move_to_trash':'delete'); ?>_url: <?php echo json_encode(route($route_name_prefix.$config->package.'.'.($config->use_trash?'move-to-trash':'delete')), 15, 512) ?>
				}
			})
		};
		// khai báo ở dây
	</script>
	<?php else: ?>
	<script>
		window.crazyItemsInit = function () {
			App.items.init({
				module:"<?php echo e($config->package); ?>",
				title:"<?php echo e($config->name); ?>",
				
				urls:{
					delete_url: <?php echo json_encode(route($route_name_prefix.$config->package.'.delete'), 15, 512) ?>,
					restore_url: <?php echo json_encode(route($route_name_prefix.$config->package.'.restore'), 15, 512) ?>
				}
			})
		};
		// khai báo ở dây
	</script>	
	<?php endif; ?>
	
<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>
	<script src="<?php echo e(asset('static/crazy/js/items.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout.'main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/_module/list.blade.php ENDPATH**/ ?>