
<?php $__env->startSection('title', $page_title); ?>
<?php echo $__env->make($_lib . 'register-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('body.class', 'post-page'); ?>
<?php $__env->startSection('content'); ?>

    <div class="post-list-content">
        <?php echo $__env->make($_template . 'page-header', [
            'title' => $page_title,
            'sub_title' => isset($category) && $category->description ? $category->description : $dynamic->description,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="container-lg">
            <div class="row">
                <div class="col-lg-8 col-main">
                    <?php if(count($posts)): ?>

                        <div class="row post-list blog-list posts blogs mien-posts mien-blogs">

                            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-sm-6">
                                    <div class="post-item blog-item">
                                        <div class="item-header">
                                            <h4 class="item-title">
                                                <a href="<?php echo e($u = $post->getViewUrl()); ?>" class="post-link">
                                                    <?php echo e($post->title); ?>

                                                </a>
                                            </h4>
                                            <?php if($cate = $post->category): ?>
                                                <div class="item-cate">
                                                    <a href="<?php echo e($cate->getViewUrl()); ?>" class="post-link">
                                                        <?php echo e($cate->name); ?>

                                                    </a>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                        <div class="item-body">

                                            <a href="<?php echo e($u); ?>" class="item-img">
                                                <img src="<?php echo e($post->getThumbnail()); ?>" alt="<?php echo e($post->title); ?>" class="item-thumbnail">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>

                        <div class="mien-pagination">
                            <?php echo e($posts->links($_template . 'pagination')); ?>

                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">
                            Không tìm thấy kết quả phù hợp!
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-4 col-sidebar mt-30 mt-lg-0">
                    <div class="sidebar">
                        <?php echo $html->sidebar_posts->components; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout . 'master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/modules/posts/list.blade.php ENDPATH**/ ?>