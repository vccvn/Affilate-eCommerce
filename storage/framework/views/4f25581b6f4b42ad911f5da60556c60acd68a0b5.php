

<?php
    $icons = get_js_data('icon_picker_data');
?>
<div class="modal fade icon-picker-modal" id="icon-picker-modal" tabindex="-1" role="dialog" aria-labelledby="icon-picker-modal-title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header custom-style bg-info">
                <h5 class="modal-title" id="icon-picker-modal-title">
                    <i class="fa fa-crow"></i>
                     Icons
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="m-portlet m-portlet--tabs mb-0">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--right" role="tablist">
                            <?php if($icons): ?>
                                <?php $__currentLoopData = $icons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link <?php echo e($loop->index ? '': 'active'); ?>" data-toggle="tab" href="#<?php echo e($key); ?>_tab_content" role="tab">
                                        <?php echo e($item['title']); ?>

                                    </a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link <?php echo e($icons ? '' : 'active'); ?>" data-toggle="tab" href="#fa_tab_content" role="tab">
                                    Fontawesome 5
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#flaticon_tab_content" role="tab">
                                    Flaticon
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#la_tab_content" role="tab">
                                    LineAwesome
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#socicon_tab_content" role="tab">
                                    Socicons
                                </a>
                            </li>

                            
                        </ul>
                    </div>
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <div class="input-group">
                                <input type="search" id="search-icon-picker-input" name="keyword" class="form-control" placeholder="Tìm kiếm...">
                                <div class="btn-append-group">
                                    <button class="btn btn-info btn-search-icon"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <?php if($icons): ?>
                        <?php $__currentLoopData = $icons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="tab-pane <?php echo e($loop->index ? '': 'active'); ?>" id="<?php echo e($key); ?>_tab_content" role="tabpanel">
                            <div class="<?php echo e($key); ?>-icon-list">

                            </div>
                        </div>
                        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                        <div class="tab-pane <?php echo e($icons ? '' : 'active'); ?>" id="fa_tab_content" role="tabpanel">
                            <div class="fa-icon-list">

                            </div>
                        </div>
                        <div class="tab-pane" id="flaticon_tab_content" role="tabpanel">
                            <div class="flaticon-icon-list">

                            </div>
                        </div>
                        <div class="tab-pane" id="la_tab_content" role="tabpanel">
                            <div class="la-icon-list">

                            </div>
                        </div>
                        <div class="tab-pane" id="socicon_tab_content" role="tabpanel">
                            <div class="socicon-icon-list">

                            </div>
                        </div>
                
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-select-icon">Chọn</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                
            </div>
        </div>
    </div>
</div>


<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/_templates/icon-picker-modal.blade.php ENDPATH**/ ?>