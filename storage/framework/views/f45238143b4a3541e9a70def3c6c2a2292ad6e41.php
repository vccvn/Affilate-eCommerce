<div class="page-header container-lg">

    <div class="inner">
        <h2 class="title"><?php echo e($data->title); ?></h2>
        <div class="spactor"></div>

        <?php if($data->sub_title): ?>
            <h3 class="sub-title">
                <?php echo nl2br($data->sub_title); ?>

            </h3>
        <?php endif; ?>
        <div class="description">
            <div class="text">
                <?php echo nl2br($data->description); ?>

            </div>
        </div>
    </div>

</div><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/components/about/widgets/header.blade.php ENDPATH**/ ?>