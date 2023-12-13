<?php
add_js_src('static/crazy/js/tag.js');
$input->type = "crazytag";
$input->removeClass('form-control')->removeClass('m-input');
$input->prepareCrazyInput();

$defaultValues = [];
if(is_array($df = $input->getInputData())){
    $defaultValues = $df;
}


$name = $input->name.'[]';
$items = '';
$valueKey = $input->data('value-key');
$textKey = $input->data('text-key');

?>

					<div <?php echo $input->attrsToStr(); ?> >
						<div class="d-none hidden-input-group">
							<?php if(is_array($defaultValues) && count($defaultValues)): ?>
								<?php $__currentLoopData = $defaultValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e($tag[$valueKey]); ?>" class="crazy-tag-input-<?php echo e($tag[$valueKey]); ?>">
                                    <?php
                                        $items.= "<li class=\"tag-item crazy-tag-item-".$tag[$valueKey]."\" data-id=\"".$tag[$valueKey]."\" data-name=\"".$tag[$textKey]."\"><div class=\"flex-center\"><span>".$tag[$textKey]."</span> <a href=\"javascript:;\" class=\"btn-delete\" data-value=\"".$tag[$valueKey]."\">x</a></div></li>"
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
						</div>
						
						<div class="tag-list-group form-control m-input ">
							<ul class="tag-list">
								<?php echo $items; ?>

								<li class="input-search-group">
									<input type="search" name="tag_str_search" class="input-search" autocomplete="off" placeholder="<?php echo e($input->placeholder?$input->placeholder:'Nhập từ khóa...'); ?>">
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="crazy-text-width-wrapper">
							<div class="crazy-text-width"></div>
						</div>
		
						<div class="tag-live-search">
							<div class="live-search-block">
								<div class="live-search-results m-scrollable" data-scrollable="true">
									
								</div>
								<div class="live-search-message">
									Không có kết quả
								</div>
								<div class="live-search-loading">
									<div class="m-loader m-loader--danger" style="width: 30px; display: inline-block;"></div>
								</div>
								
								<div class="live-search-advance">
									<button type="button" class="btn btn-outline-info btn-block btn-create-tags">Thêm &quot;<span class="keyword"></span>&quot;</button>
								</div>

							</div>
						</div>
                    </div>
                    

<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/templates/crazytag.blade.php ENDPATH**/ ?>