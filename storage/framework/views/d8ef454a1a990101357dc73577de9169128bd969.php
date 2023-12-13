<?php
    $url = null;
    $args = [
        '@limit' => $data->cate_number ? $data->cate_number : 10,
    ];
    $post_args = [
        '@limit' => $data->post_number ? $data->post_number : 20,
        '@sort' => $data->post_sorttype ? $data->post_sorttype : 1,
    ];
    $title = null;
    if ($data->get_by_dynamic_active && ($active = $helper->getActiveModel('dynamic'))) {
        $args['dynamic_id'] = $active->id;
        $post_args['dynamic_id'] = $active->id;
    } else {
        if ($data->dynamic_id && ($dynamic = $helper->getDynamic(['id' => $data->dynamic_id]))) {
            $args['dynamic_id'] = $data->dynamic_id;
            $post_args['dynamic_id'] = $data->dynamic_id;
        }
        if ($data->category_id && ($category = $helper->getPostCategory(['id' => $data->category_id]))) {
            $args['parent_id'] = $data->category_id;
        }
    }
?>

<div class="widget category-widget">
    <?php if(($categories = $helper->getPostCategories($args)) && is_countable($categories) && $__total = count($categories)): ?>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="category-box box">
                <h3 class="box-title">
                    <a href="<?php echo e($category->getViewUrl()); ?>">
                        <?php echo e($category->name); ?>

                    </a>
                </h3>
                <?php
                    $post_args['category_id'] = $category->id;
                ?>
                <?php if(($posts = $helper->getPosts($post_args)) && is_countable($posts) && $__total = count($posts)): ?>
                    <div class="box-body">
                        <ul class="post-list">

                            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e($item->getViewUrl()); ?>"><?php echo e($item->title); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

</div>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/components/posts/sidebar/category-posts.blade.php ENDPATH**/ ?>