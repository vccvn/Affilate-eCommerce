<div class="contact-us">
    <div class="inner">
        <div class="contact-thumbnail">
            <img src="<?php echo e($data->thumbnail); ?>" alt="<?php echo e($data->title); ?>">
        </div>
        <div class="contact-info">
            <h3 class="contact-title"><?php echo e($data->title); ?></h3>
            <div class="contact-description">
                <?php echo e($data->description); ?>

            </div>
            <?php if($data->phone_number || $data->email || $data->address): ?>
                <ul class="contact-items">
                    <?php if($data->phone_number): ?>
                        <li><a href="tel:<?php echo e($data->phone_number); ?>"><?php echo e($data->phone_number); ?></a></li>
                    <?php endif; ?>
                    <?php if($data->email): ?>
                        <li><a href="mailto:<?php echo e($data->email); ?>"><?php echo e($data->email); ?></a></li>
                    <?php endif; ?>
                    <?php if($data->address): ?>
                        <li><span><?php echo e($data->address); ?></span></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    <div class="buttons">
        <a href="<?php echo e($data->url); ?>" class="mien-button"><?php echo e($data->btn_text); ?></a>
    </div>
</div><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/components/about/widgets/contact-us.blade.php ENDPATH**/ ?>