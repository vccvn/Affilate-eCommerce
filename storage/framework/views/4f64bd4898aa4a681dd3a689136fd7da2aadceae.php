
<?php $__env->startSection('title', $page_title); ?>
<?php echo $__env->make($_lib . 'register-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('body.class', 'article-page'); ?>
<?php $__env->startSection('content'); ?>

    <div class="post-detail-content article-content single-post">
        <?php echo $__env->make($_template . 'page-header', [
            'title' => $page_title,
            'sub_title' => isset($category)? $category->name : '',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="container">
            <div class="single-content">
                <?php echo $article->content; ?>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make($_layout . 'master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/modules/posts/detail.blade.php ENDPATH**/ ?>