<div class="top-banner">
    <div id="top-banner-sliders" class="carousel slide" data-bs-ride="true">
        <?php if($data->type == 'slider'): ?>
            <?php if(($slider = $helper->getSlider(['id' => $data->slider_id])) && $slider->items): ?>
                <div class="carousel-indicators">
                    <?php $__currentLoopData = $slider->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $i = $loop->index;
                        ?>
                        <button type="button" data-bs-target="#top-banner-sliders" data-bs-slide-to="<?php echo e($i); ?>" class="active" aria-current="true" aria-label="Slide <?php echo e($i + 1); ?>"></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="carousel-inner">
                    <?php $__currentLoopData = $slider->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="carousel-item <?php echo e($loop->index == 0 ? 'active' : ''); ?>">
                            <div class="slide-image">
                                <img src="<?php echo e($item->image_url); ?>" class="d-block w-100" alt="<?php echo e($item->title); ?>">
                            </div>
                            <div class="slide-text">
                                <h3 class="slide-title">
                                    <?php echo nl2br($item->title); ?>

                                </h3>
                                <?php if($item->description): ?>
                                    <div class="slide-description">
                                        <?php echo nl2br($item->description); ?>

                                    </div>
                                <?php endif; ?>

                            </div>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <?php if(isset($children) && ($t = count($children))): ?>

                <div class="carousel-indicators">
                    <?php for($i = 0; $i < $t; $i++): ?>
                        <button type="button" data-bs-target="#top-banner-sliders" data-bs-slide-to="<?php echo e($i); ?>" class="active" aria-current="true" aria-label="Slide <?php echo e($i + 1); ?>"></button>
                    <?php endfor; ?>
                </div>

                <div class="carousel-inner">

                    <?php echo $children ?? ''; ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>
        <button class="carousel-control-prev" type="button" data-bs-target="#top-banner-sliders" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#top-banner-sliders" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/components/home/slider/area.blade.php ENDPATH**/ ?>