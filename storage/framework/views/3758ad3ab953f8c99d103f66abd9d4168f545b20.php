
<?php $__env->startSection('title', 'Thông báo'); ?>
<?php $__env->startSection('meta.robots', 'noindex'); ?>

<?php echo $__env->make($_lib . 'register-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
    <?php
    $type = isset($type) && $type ? $type : (session('type') ? session('type') : 'success');
    $message = isset($message) && $message ? $message : (session('message') ? session('message') : 'Hello World');
    $link = isset($link) ? $link : (session('link') ? session('link') : route('home'));
    $text = isset($text) ? $text : (session('text') ? session('text') : '<i class="fa fa-home"></i> Về trang chủ');
    $title = isset($title) && $title ? $title : (session('title') ? session('title') : null);
    
    ?>


    <div class="slert-page mt-50 mb-50">
        <?php echo $__env->make($_template . 'page-header', [
            'title' => $page_title,
            // 'sub_title' => isset($category) && $category->description ? $category->description : $dynamic->description,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="container">
            <div class="alert alert-<?php echo e($type); ?> text-center">
                <?php echo $message; ?>

            </div>
            <div class="buttons mt-20 text-center">
                <a href="<?php echo e($link); ?>" class="btn btn-primary" data-bs-target="#doneModal" data-bs-dismiss="modal"><?php echo $text; ?></a>
            </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout . 'master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/modules/alert/message.blade.php ENDPATH**/ ?>