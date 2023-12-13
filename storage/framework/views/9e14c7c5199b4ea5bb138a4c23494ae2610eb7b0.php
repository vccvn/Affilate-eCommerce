<?php
use Gomee\Helpers\Arr;
?>

					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator"><?php echo $__env->yieldContent('module.name'); ?></h3>
								<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
									<li class="m-nav__item m-nav__item--home">
										<a href="<?php echo e(route('dashboard')); ?>" class="m-nav__link m-nav__link--icon">
											<i class="m-nav__link-icon la la-home"></i>
										</a>
									</li>
									<?php if( is_array($map = admin_breadcrumbs()) ): ?>
									<?php $__currentLoopData = $map; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										
									<li class="m-nav__separator">-</li>
									<li class="m-nav__item">
										<a href="<?php echo e(isset($item['url'])?$item['url']:'#'); ?>" class="m-nav__link">
											<span class="m-nav__link-text"><?php echo e(isset($item['text'])?$item['text']:''); ?></span>
										</a>
									</li>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
									
								</ul>
							</div>

							<?php if($actionmenus = admin_action_menu()): ?>
								

							<div>
								<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
									<a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
										<i class="la la-plus m--hide"></i>
										<i class="la la-ellipsis-h"></i>
									</a>
									<div class="m-dropdown__wrapper">
										<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
										<div class="m-dropdown__inner">
											<div class="m-dropdown__body">
												<div class="m-dropdown__content">
													<ul class="m-nav">
														
														<?php $__currentLoopData = $actionmenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<?php $a = new Arr($item); ?>
														<li class="m-nav__item">
															<a href="<?php echo e($a->url?$a->url:($a->link?$a->link:($a->route?route($a->route, $a->params?$a->params:[]):'javascript:void(0);' ))); ?>" class="m-nav__link <?php echo e($a->class); ?>">
																<?php if($a->icon): ?>
																<i class="m-nav__link-icon <?php echo e($a->icon); ?>"></i>
																<?php endif; ?>
																
																<span class="m-nav__link-text"><?php echo e($a->text?$a->text:'menu item'); ?></span>
															</a>
														</li>
														
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<?php endif; ?>

						</div>
					</div><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/_components/subheader.blade.php ENDPATH**/ ?>