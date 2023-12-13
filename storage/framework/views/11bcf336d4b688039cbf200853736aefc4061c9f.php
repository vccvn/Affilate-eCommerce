<?php
    $jv = 'javascript:void(0);';
    // $style_class = 'text-accent btn btn-outline-accent m-btn m-btn--icon m-btn--pill m-btn--air';
    $style_class = 'page-link';
?>
<?php if($paginator->hasPages()): ?>


                <ul class="pagination float-right">
                    

                    <li class="paginate_button page-item previous <?php echo e((!$paginator->onFirstPage()) ? '' : 'disabled'); ?>" id="m_table_1_previous">
                        <a href="<?php echo e((!$paginator->onFirstPage()) ? $paginator->previousPageUrl(): $jv); ?>" class=" <?php echo e($style_class); ?>">
                            <i class="la la-angle-left"></i>
                        </a>
                    </li>
                    
                    <?php
                    $l = false;
                    $r = false;
                    $l2 = false;
                    $r2 = false;
                    $mp = 0;
                    ?>
                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                            $cp = $paginator->currentPage();
                            $t = $paginator->lastPage();
                        ?>
                            
                        
                        <?php if(is_string($element)): ?>
                            <?php if(!$l && !$l2 && $mp < $cp): ?> 
                                <?php 
                                $l = true;
                                $l2 = true; 
                                ?>
                                
                                <li class="paginate_button page-item disabled">
                                    <a href="<?php echo e($jv); ?>" class=" <?php echo e($style_class); ?>"><?php echo e($element); ?></a>
                                </li>
                            <?php elseif(!$r && !$r2 && $mp > $cp): ?>
                                <li class="paginate_button page-item disabled">
                                    <a href="<?php echo e($jv); ?>" class=" <?php echo e($style_class); ?>"><?php echo e($element); ?></a>
                                </li>
                                <?php 
                                $r = true; 
                                $r2 = true; 
                                ?>
                            <?php endif; ?>
                            
                        <?php endif; ?>
                        
                        
                        <?php if(is_array($element)): ?>
                            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $mp++; ?>
                                <?php if($page == 1 || ($page >= $cp-2 && $page <= $cp+2) || $page == $t): ?>
                                    <li class="paginate_button page-item <?php echo e($page == $paginator->currentPage()? 'active':''); ?>">
                                        <a href="<?php echo e($url); ?>" class=" <?php echo e($style_class); ?>"><?php echo e($page); ?></a>
                                    </li>
                                <?php elseif($page < $cp-2 && $page > 1 && !$l): ?>
                                <?php $l = true; ?>
                                    <li class="paginate_button page-item disabled">
                                        <a href="<?php echo e($jv); ?>" class=" <?php echo e($style_class); ?>">
                                            <i class="la la-circle-o"></i>
                                        </a>
                                    </li>
                                <?php elseif($page > $cp+2 && $page < $t && !$r): ?>
                                    <?php $r = true; ?>
                                    <li class="paginate_button page-item disabled">
                                        <a href="<?php echo e($jv); ?>" class=" <?php echo e($style_class); ?>">
                                            <i class="la la-circle-o"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    
                    <li class="paginate_button page-item next <?php echo e((!$paginator->hasMorePages()) ? 'disabled' : ''); ?>" id="m_table_1_next">
                        <a href="<?php echo e((!$paginator->hasMorePages()) ?$jv : $paginator->nextPageUrl()); ?>" class=" <?php echo e($style_class); ?>">
                            <i class="la la-angle-right"></i>
                        </a>
                    </li>
                </ul>
                <div class="clearfix" style="clear:both;"></div>

<?php endif; ?>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/_pagination/default.blade.php ENDPATH**/ ?>