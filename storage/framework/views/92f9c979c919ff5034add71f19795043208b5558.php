<div class="our-story">
    <div class="row stories">
        <div class="col-10 col-sm-6 ml-auto mr-auto">
            <div class="first-story story">
                <div class="content-box">
                    <h3 class="story-title"><?php echo e($data->first_title); ?></h3>
                    <div class="story-content"><?php echo e($data->first_content); ?></div>
                </div>
                <div class="story-image">
                    <img src="<?php echo e($data->first_image); ?>" alt="<?php echo e($data->first_title); ?>">
                </div>
            </div>

        </div>
        <div class="col-10 col-sm-6 ml-auto mr-auto">
            <div class="second-story story">
                <div class="content-box">
                    <h3 class="story-title"><?php echo e($data->second_title); ?></h3>
                    <div class="story-content"><?php echo e($data->second_content); ?></div>
                </div>
                <div class="story-image">
                    <img src="<?php echo e($data->second_image); ?>" alt="<?php echo e($data->second_title); ?>">
                </div>
            </div>

        </div>
    </div>
    <div class="buttons">
        <a href="<?php echo e($data->url); ?>" class="btn-story mien-button"><?php echo e($data->btn_text('our stories')); ?></a>
    </div>
</div><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/components/about/widgets/our-stories.blade.php ENDPATH**/ ?>