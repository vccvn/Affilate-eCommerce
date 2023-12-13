<?php 
    $site_name = $siteinfo->site_name('Gomee Inc'); 
    $web_title = ($full_title = $__env->yieldContent('full_title'))?$full_title:(
        ($short_title = $__env->yieldContent('title'))?$short_title.' | '.$site_name : $siteinfo->title('Trang chủ'.' | '.$site_name)
    );
    
    

?>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">


    <?php if($__env->yieldContent('meta.robots') == 'noindex'): ?>
    <meta name="robots" content="noindex,follow"/>
    <meta name="googlebot" content="noindex" />
    <?php endif; ?>
    
    
    
    <title><?php echo $__env->yieldContent('meta_title', $web_title); ?></title>
    <meta property="og:site_name" content="<?php echo e($site_name); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
   
    <!-- http-equive -->
    <meta http-equiv="Content-Language" content=”vi”>
    <meta http-equiv="Content-Type" content=”text/html; charset=utf-8″>
    <meta http-equiv="description" content="<?php echo $__env->yieldContent('meta_description', $__env->yieldContent('description', $siteinfo->meta_description)); ?>" />
    <meta http-equiv="keywords" content="<?php echo $__env->yieldContent('keywords', $siteinfo->keywords); ?>">
    <!-- /http-equive -->


    <meta name="title" content="<?php echo $__env->yieldContent('meta_title', $web_title); ?>">
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', $__env->yieldContent('description', $siteinfo->meta_description)); ?>">
    <meta name="keywords" content="<?php echo $__env->yieldContent('keywords', $siteinfo->keywords); ?>">
    <meta name="image" content="<?php echo $__env->yieldContent('image', $siteinfo->web_image); ?>">

    
    
    <?php echo $html->getHeadElements(); ?>

    
    <?php
        $canonical = $__env->yieldContent('canonical');
        if(!$canonical){
            $fu = url()->full();
            $a = explode('?', $fu);
            $canonical = $a[0];
        }
    ?>
    <!-- seo -->
    <link rel="canonical" href="<?php echo e($full_url = str_replace('http://', 'https://', $canonical)); ?>" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="<?php echo $__env->yieldContent('page.type', 'website'); ?>" />
    <meta property="og:title" content="<?php echo $__env->yieldContent('meta_title', $web_title); ?>" />
    <meta property="og:description" content="<?php echo $__env->yieldContent('meta_description', $__env->yieldContent('description', $siteinfo->meta_description)); ?>" />
    <meta property="og:url" content="<?php echo e($full_url); ?>" />
    <meta property="og:site_name" content="<?php echo e($siteinfo->site_name); ?>" />

    <?php if($__env->yieldContent('page.type') == 'article'): ?>

    <meta property="article:publisher" content="<?php echo e($siteinfo->facebook); ?>" />
    <meta property="article:section" content="<?php echo $__env->yieldContent('article_section', 'Tin tức'); ?>" />
    <meta property="article:published_time" content="<?php echo $__env->yieldContent('published_time','2018-04-22T19:48:13+07:00'); ?>" />
    <meta property="article:modified_time" content="<?php echo $__env->yieldContent('modified_time','2018-04-22T19:48:13+07:00'); ?>" />
    <meta property="og:updated_time" content="<?php echo $__env->yieldContent('modified_time','2018-04-22T19:48:13+07:00'); ?>" />
    
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="315" />
    <?php endif; ?>
    
    <meta property="og:image" content="<?php echo $__env->yieldContent('image', $siteinfo->web_image); ?>" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="<?php echo $__env->yieldContent('description', $siteinfo->description); ?>" />
    <meta name="twitter:title" content="<?php echo $__env->yieldContent('meta_title', $web_title); ?>" />
    <meta name="twitter:image" content="<?php echo $__env->yieldContent('image', $siteinfo->web_image); ?>" />
    <meta name="twitter:site" content="<?php echo $__env->yieldContent('twitter_site', $siteinfo->twitter_site); ?>" />
    <meta name="twitter:creator" content="<?php echo $__env->yieldContent('twitter_site', $siteinfo->twitter_creator); ?>" />


    <script type="application/ld+json"><?php echo json_encode($helper->getBreadcrumbSchemaJson()); ?>

    </script>

    <!-- / SEO  -->

    



    <!-- Icons -->
    
    <?php
        $apple_sizes = [57, 114, 72, 144, 60, 120, 76, 152];
        $favicos = [196, 96, 32, 16, 128];
    ?>
    <?php $__currentLoopData = $apple_sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($apple_touch_icon = $__env->yieldContent('apple.touch.icon.'. $size .'x' . $size, $favicons->get('apple_touch_icon_'. $size .'x' . $size))): ?><link rel="apple-touch-icon-precomposed" sizes="<?php echo e($size . 'x' . $size); ?>" href="<?php echo e($apple_touch_icon); ?>" /><?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = $favicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($favicon = $__env->yieldContent('favicon.'. $size .'x' . $size, $favicons->get('favicon_'. $size .'x' . $size))): ?><link rel="icon" type="image/png" sizes="<?php echo e($size . 'x' . $size); ?>" href="<?php echo e($favicon); ?>" /><?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <meta name="application-name" content="<?php echo e($siteinfo->site_name); ?>"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />

    <?php if($favicon = $__env->yieldContent('mstile.144x144', $favicons->mstile_144x144)): ?>
        <meta name="msapplication-TileImage" content="<?php echo e($favicon); ?>" />
    <?php endif; ?>
    <?php if($favicon = $__env->yieldContent('mstile.70x70', $favicons->mstile_70x70)): ?>
        <meta name="msapplication-square70x70logo" content="<?php echo e($favicon); ?>" />
    <?php endif; ?>
    <?php if($favicon = $__env->yieldContent('mstile.150x150', $favicons->mstile_150x150)): ?>
        <meta name="msapplication-square150x150logo" content="<?php echo e($favicon); ?>" />
    <?php endif; ?>
    <?php if($favicon = $__env->yieldContent('mstile.310x150', $favicons->mstile_310x150)): ?>
        <meta name="msapplication-square150x150logo" content="<?php echo e($favicon); ?>" />
        <meta name="msapplication-wide310x150logo" content="<?php echo e($favicon); ?>" />
    <?php endif; ?>
    <?php if($favicon = $__env->yieldContent('mstile.310x310', $favicons->mstile_310x310)): ?>
        <meta name="msapplication-square310x310logo" content="<?php echo e($favicon); ?>" />
    <?php endif; ?>
    
    <!-- / Icons -->

    <?php if(($pwa = get_option('settings')->pwa) && $pwa->active): ?>
    
    <meta name="theme-color" media="(prefers-color-scheme: light)" content="white">
    <meta name="theme-color" media="(prefers-color-scheme: dark)"  content="black">
    <link rel="manifest" href="/manifest.json">
    <style>
            
    .hidden {
        display: none !important;
    }

    #installContainer {
        position: absolute;
        bottom: 1em;
        display: flex;
        justify-content: center;
        width: 100%;
    }

    #installContainer button {
        background-color: inherit;
        border: 1px solid white;
        color: white;
        font-size: 1em;
        padding: 0.75em;
    }
    </style>
    
    <?php endif; ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/client-libs/meta.blade.php ENDPATH**/ ?>