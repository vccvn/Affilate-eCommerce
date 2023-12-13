<?php if($paginator->hasPages()): ?>
    <?php
    $itemClass = 'page-item';
    $activeClass = 'active';
    $prevItemClass = $itemClass;
    $nextItemClass = $itemClass;
    $activeItemClass = $itemClass . ' active';
    
    $linkClass = 'page-link';
    $prevLinkClass = $linkClass; // . ' prev';
    $nextLinkClass = $linkClass; // . ' next';
    $activeLinkClass = ' active';
    
    ?>

    <nav aria-label="Page navigation example" class="page-section">

        <ul class="pagination">

            
            <?php if($paginator->onFirstPage()): ?>
                <li class="<?php echo e($prevItemClass); ?> disabled">
                    <a class="<?php echo e($prevLinkClass); ?>" href="javascript:void(0)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php else: ?>
                <?php
                    $html->addToHead('link', [
                        'data-rh' => 'true',
                        'rel' => 'previous',
                        'href' => $paginator->previousPageUrl(),
                    ]);
                ?>
                <li class="<?php echo e($prevItemClass); ?>">
                    <a class="<?php echo e($prevLinkClass); ?>" href="<?php echo e($paginator->previousPageUrl()); ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            
            <?php
                $l = false;
                $r = false;
                $l2 = false;
                $r2 = false;
                $mp = 0;
                $cp = $paginator->currentPage();
                $t = $paginator->lastPage();
                
            ?>
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                    <?php if(!$l && !$l2 && $mp < $cp): ?>
                        <?php
                            $l = true;
                            $l2 = true;
                        ?>
                        <li class="<?php echo e($itemClass); ?>"><a class="<?php echo e($linkClass); ?> dots" href="javascript:void(0)"><span><?php echo e($element); ?></span></a></li>
                    <?php elseif(!$r && !$r2 && $mp > $cp): ?>
                        <li class="<?php echo e($itemClass); ?>"><a class="<?php echo e($linkClass); ?> dots" href="javascript:void(0)"><span><?php echo e($element); ?></span></a></li>
                        <?php
                            $r = true;
                            $r2 = true;
                        ?>
                    <?php endif; ?>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $mp++; ?>
                        <?php if($page == 1 || ($page >= $cp - 2 && $page <= $cp + 2) || $page == $t): ?>
                            <?php if($page == $paginator->currentPage()): ?>
                                <li class="<?php echo e($activeItemClass); ?>"><a class="<?php echo e($activeLinkClass); ?> <?php echo e($linkClass); ?>" href="javascript:void(0)"><?php echo e($page); ?></a></li>
                            <?php else: ?>
                                <li class="<?php echo e($itemClass); ?>"><a class="<?php echo e($linkClass); ?>" href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                            <?php endif; ?>
                        <?php elseif($page < $cp - 2 && $page > 1 && !$l): ?>
                            <?php $l = true; ?>
                            <li class="<?php echo e($itemClass); ?>"><span class="<?php echo e($linkClass); ?> dots">...</span></li>
                        <?php elseif($page > $cp + 2 && $page < $t && !$r): ?>
                            <?php $r = true; ?>
                            <li class="<?php echo e($itemClass); ?>"><span class="<?php echo e($linkClass); ?> dots">...</span></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <?php
                    $html->addToHead('link', [
                        'data-rh' => 'true',
                        'rel' => 'next',
                        'href' => $paginator->nextPageUrl(),
                    ]);
                ?>

                <li class="<?php echo e($nextItemClass); ?>">
                    <a class="<?php echo e($nextLinkClass); ?>" href="<?php echo e($paginator->nextPageUrl()); ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php else: ?>
                <li class="<?php echo e($nextItemClass); ?> disabled">
                    <a class="<?php echo e($nextLinkClass); ?>" href="javascript:void(0)" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <!--/.pagination -->
    </nav>
<?php endif; ?>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/templates/pagination.blade.php ENDPATH**/ ?>