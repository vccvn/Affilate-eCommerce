
<?php
    $a = $input->area?$input->area:$input->value;
?>
<input type="hidden" name="<?php echo e($input->name); ?>" value="<?php echo e($a); ?>">

<?php if($input->value && $area = get_component_area($a)): ?>

    <?php    
        set_web_data('has_component_area', true);
        add_js_data('nestable_selectors', '#component-area-'.$area->id);
        $title_by = $input->hiddenData('title-by');
        
        $renderComponents = function($components, $render = null) use($title_by){
            $html = '';
            if($components && count($components)){
                foreach($components as $component){
                    $data = $component->data;
                    $html.= '
                    
                    <li class="dd-item" data-id="'.$component->id.'">
                                                        
                        <div class="item-actions">
                            <a href="javascript:void(0);" class="edit btn-edit-item" data-id="'.$component->id.'" data-area-id="'.$component->area_id.'">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a href="javascript:void(0);" class="remove btn-delete-item" data-id="'.$component->id.'" data-area-id="'.$component->area_id.'" data-label="'.$component->label.'">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                        <div class="dd-handle">
                            <span class="component-name">'.(($title_by && isset($data[$title_by])?$data[$title_by]:($component->label?$component->label:($component->name??$component->path)))).'</span>
                        </div>
                        '.($component->children && count($component->children) && is_callable($render)?'<ol class="dd-list">'.$render($component->children, $render).'</ol>':'').'
                    </li>    
                    ';
                }
            }
            return $html;
        };
    ?>
    
<div class="m-area__content">
    <div class="dd nestable component-list-body" id="component-area-<?php echo e($area->id); ?>" data-area-id="<?php echo e($area->id); ?>" data-title-by="<?php echo e($title_by); ?>" data-max-depth="10" data-callback="App.components.sortCallback">
        <ol class="dd-list">

            <?php if(count($area->components)): ?>
                <?php echo $renderComponents($area->components, $renderComponents); ?>

            <?php endif; ?>
            
        </ol>
    </div>

    <div class="text-center">
        <a href="javascript:void(0)" data-area-id="<?php echo e($area->id); ?>" data-toggle="m-tooltip" data-placement="top" title data-original-title="Thêm component" class="btn btn-outline-info btn-add-component btn-sm btn-block"><i class="fa fa-plus"></i> Thêm</a>
    </div>
</div>

<?php endif; ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/templates/area.blade.php ENDPATH**/ ?>