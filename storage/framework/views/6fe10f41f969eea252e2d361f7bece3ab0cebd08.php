<?php
$input->type = "crazyselect";
$input->prepareCrazyInput();
$slt = '';

$def = [];
$opts = $input->getInputData();
if(is_array($opts) || is_object($opts)){
    
    $df = $input->defVal();
    $slt = $input->toClientSelectOptions($opts, $df);
    $def = $input->getDefaultOption($opts, $df);
    
}
$select_type = $input->data('select-type');
if(!$select_type){
    $select_type = 'static';
    $input->data('select-type', 'static');
}


$input->data('id', $input->id);
$classNAme = $input->className;

$input->className = "crazy-select $select_type " .($input->hasClass('d-block')?'d-block':'');

?>

    <input type="hidden" name="<?php echo e($input->name); ?>" value="<?php echo e(($def?$def[0]:'')); ?>" id="<?php echo e($input->id); ?>" />

    <?php 
    $id = $input->id;
    $input->tagName = 'div'; 
    $input->id .= '-wrapper';
    
    ?>
    
    <div <?php echo $input->attrsToStr(); ?> >
        <button type="button" class="btn-dropdown-select show-text-value <?php echo e($classNAme); ?>" id="<?php echo e($id); ?>-dropdown" value="<?php echo e(($def?$def[0]:'')); ?>">
            <?php echo ($def?$def[1]:"Chưa chọn giá trị"); ?>

        </button>
        <div class="select-option-menu" data-ref="<?php echo e($id); ?>">
            <div class="search-block p-2">
                <input type="search" data-name="search_options" class="form-control m-input" placeholder="<?php echo e($input->placeholder?$input->placeholder:'Tìm kiếm...'); ?>" />
            </div>
            <div class="message p-2 text-center" style="display:none;">Không có kết quả phù hợp</div>
            <div class="option-list">
    
                <?php echo $slt; ?>

            </div>
            <div class="buttons" style="display:none;">
                <a href="javascript:void(0);" class="btn btn-block m-btn--square btn-outline-info m-btn m-btn--custom crazy-select-asvance-button"><?php echo e($input->data('advance-text')); ?></a>
            </div>
        </div>
    </div>

<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/client-libs/form/crazyselect.blade.php ENDPATH**/ ?>