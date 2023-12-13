
<?php $__env->startSection('title', $page_title); ?>
<?php echo $__env->make($_lib . 'register-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('body.class', 'article-page'); ?>
<?php $__env->startSection('content'); ?>

    <?php switch($article->id):
        case ($options->theme->about->about_page_id): ?>
            <div class="post-detail-content article-content about-page">
                <div class="inner-content">
                    <?php echo $html->about_contents->components; ?>

                </div>
            </div>
        <?php break; ?>

        <?php default: ?>
            <div class="post-detail-content article-content single-post">
                <?php echo $__env->make($_template . 'page-header', [
                    'title' => $page_title,
                    'sub_title' => isset($category) ? $category->name : '',
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="container">
                    <div class="single-content">
                        <?php echo $article->content; ?>

                    </div>
                </div>
            </div>
    <?php endswitch; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout . 'master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/modules/pages/detail.blade.php ENDPATH**/ ?>