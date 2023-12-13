<?php
add_css_link('/static/plugins/coloris/coloris.min.css');
add_js_src('/static/plugins/coloris/coloris.min.js');
add_js_src('/static/features/common/common.js');
add_css_link('/static/features/common/common.min.css');
$input->addClass('coloris');

?>

    <div class="coloris-wrapper <?php echo e($input->hiddenData('preview-type')); ?>">
    
        <?php echo $input; ?>


    </div><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/templates/coloris.blade.php ENDPATH**/ ?>