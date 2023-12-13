<?php
$input->prepareCrazyInput();
set_admin_template_data('modals', 'modal-library');

$type = in_array($t = $input->hiddenData('filetype'), ['image', 'video', 'audio', 'all'])?$t:'image';
if($input->value === '<!---DEFAULT--->') $input->value = null;
$file = ($input->value && $f = get_media_file(['id' => $input->value])) ? $f : crazy_arr([
    'filename' => 'Không có file nào được chọn',
    'size' => 0,
    'size_unit' => 'KB',
    'thumbnail' => asset('static/images/default.png'),
    'type' => 'unknow'
]);

$wrapper = $input->copy();

$wrapper->removeClass()->addClass('input-media');
$wrapper->parseDataEvent('change');
?>

<div <?php echo $wrapper->attrsToStr(); ?> data-type="<?php echo e($type); ?>">
    <div class="input-group">
        <input type="hidden" name="<?php echo e($input->name); ?>" id="<?php echo e($input->id?$input->id:$input->name); ?>" value="<?php echo e($input->value); ?>" class="media-input-hidden">
        <div class="input-group-prepend">
            <img src="<?php echo e($file->thumbnail); ?>" alt="<?php echo e($file->filename); ?>" class="media-image-thumbnail">
        </div>
        <input type="text" name="<?php echo e($input->name); ?><?php echo e(count(explode(']', $input->name)) > 1 ? '[text]': '_text'); ?>" value="<?php echo e($file->original_filename); ?>" class="media-input-text form-control m-input" readonly disabled>
        <div class="input-group-append">
            <span class="input-group-text file-size"><?php echo e($input->value?$file->size.$file->size_unit:''); ?></span>
        </div>
    </div>
</div><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/templates/media.blade.php ENDPATH**/ ?>