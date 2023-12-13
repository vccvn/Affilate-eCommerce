
<?php
$full_title = get_title_by_breakcrumbs();
?>
<?php if(isset($article) && $article): ?>
    <?php if($full_title): ?>
        <?php $__env->startSection('full_title', $full_title); ?>
    <?php else: ?>
        <?php $__env->startSection('title', $article->getFullTitle()); ?>
    <?php endif; ?>
    <?php $__env->startSection('meta_title', $article->meta_title?$article->meta_title:($full_title??$article->getFullTitle().' | '.$siteinfo->site_name('Gomee Inc'))); ?>
    <?php $__env->startSection('description',$article->getShortDesc(300)); ?>
    <?php $__env->startSection('meta_description',$article->meta_description?$article->meta_description:$article->getShortDesc(300)); ?>
    <?php $__env->startSection('keywords',$article->getSeoKeywords()); ?>
    <?php if($article->featured_image): ?>
        <?php $__env->startSection('image',$article->getFeaturedImage()); ?>
    <?php endif; ?>
    <?php $__env->startSection('page.type','article'); ?>
    <?php if(isset($category) && $category): ?>
        <?php $__env->startSection('article_section',$category->name?$category->name:$category->title); ?>
    <?php elseif($category = $article->category): ?>
        <?php $__env->startSection('article_section',$category->name?$category->name:$category->title); ?>
        
    <?php endif; ?>
    <?php $__env->startSection('published_time',$article->dateFormat('Y-m-d').'T'.$article->dateFormat('H:i:s').'+07:00'); ?>
    <?php $__env->startSection('modified_time',$article->updateTimeFormat('Y-m-d').'T'.$article->updateTimeFormat('H:i:s').'+07:00'); ?>
    <?php $__env->startSection('modified_time',$article->updateTimeFormat('Y-m-d').'T'.$article->updateTimeFormat('H:i:s').'+07:00'); ?>

<?php elseif($active_article = get_active_model('post')??(get_active_model('page')??(get_active_model('product')??(get_active_model('project'))))): ?>
    <?php if($full_title): ?>
        <?php $__env->startSection('full_title', $full_title); ?>
    <?php else: ?>
        <?php $__env->startSection('title', $active_article->getFullTitle()); ?>
    <?php endif; ?>
    <?php $__env->startSection('meta_title', $active_article->meta_title?$active_article->meta_title:($full_title??($active_article->getFullTitle().' | '.$siteinfo->site_name('Gomee Inc')))); ?>
    <?php $__env->startSection('description',$active_article->getShortDesc(300)); ?>
    <?php $__env->startSection('meta_description',$active_article->meta_description?$active_article->meta_description:$active_article->getShortDesc(300)); ?>
    <?php $__env->startSection('keywords',$active_article->getSeoKeywords()); ?>
    <?php if($active_article->featured_image): ?>
        <?php $__env->startSection('image',$active_article->getFeaturedImage('social')); ?>
    <?php endif; ?>
    <?php $__env->startSection('page.type','article'); ?>
    <?php if(isset($category) && $category): ?>
        <?php $__env->startSection('article_section',$category->name?$category->name:$category->title); ?>
    <?php elseif($category = $active_article->category): ?>
        <?php $__env->startSection('article_section',$category->name?$category->name:$category->title); ?>
    <?php endif; ?>
    <?php $__env->startSection('published_time',$active_article->dateFormat('Y-m-d').'T'.$active_article->dateFormat('H:i:s').'+07:00'); ?>
    <?php $__env->startSection('modified_time',$active_article->updateTimeFormat('Y-m-d').'T'.$active_article->updateTimeFormat('H:i:s').'+07:00'); ?>
<?php elseif(($category = get_active_model('post_category')) || ($category = get_active_model('product_category')) || ($category = get_active_model('project_category'))): ?>
    <?php
        $category->applyMeta();

    ?>
    <?php if($category->page_title): ?>
        <?php $__env->startSection('full_title', $category->page_title); ?>
    <?php elseif($full_title): ?>
        <?php $__env->startSection('full_title', $category->page_title??$full_title); ?>
    <?php else: ?>
        <?php $__env->startSection('title', $category->page_title??$category->getFullTitle()); ?>
    <?php endif; ?>
    <?php $__env->startSection('meta_title', $category->meta_title??($full_title??$category->getFullTitle().' | '.$siteinfo->site_name('Gomee Inc'))); ?>
    <?php if($category->featured_image): ?>
        <?php $__env->startSection('image', $category->getFeaturedImage()); ?>
    <?php endif; ?>
    <?php if($category->description): ?>
        <?php $__env->startSection('description', $category->getShortDesc(500)); ?>
    <?php endif; ?>
    <?php if($category->keywords): ?>
        <?php $__env->startSection('keywords', $category->keywords); ?>
    <?php endif; ?>

<?php elseif(isset($page_title)): ?>
    <?php $__env->startSection('title', $page_title); ?>
<?php endif; ?>

<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/client-libs/register-meta.blade.php ENDPATH**/ ?>