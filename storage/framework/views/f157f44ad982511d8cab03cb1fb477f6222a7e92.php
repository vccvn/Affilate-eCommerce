<?php
	$args = [
		'next' => route('home')
	];
	if($next = request()->next){
		$args = ['next' => $next];
	}
?>



<?php $__env->startSection('title', $page_title = isset($title)?$title:"Thiết lập 2-FA"); ?>

<?php $__env->startSection('content'); ?>
    

			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(<?php echo e(asset('static/manager/assets/app/media/img//bg/bg-3.jpg')); ?>);">
				<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
					<div class="m-login__container">
						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">Xác minh tài khoản</h3>
							</div>
                            <form class="m-login__form m-form" action="<?php echo e(route('2fa', $args)); ?>" method="POST">
                                <?php echo e(csrf_field()); ?>

								<div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-5 col-lg-4">
                                            <div class="text-center">
                                                <?php if(substr($QR_Image, 0, 5) == '<'.'?xml'): ?>
                                                    
                                                    <img src="data:image/svg+xml;base64,<?php echo e(base64_encode($QR_Image)); ?>" style="max-width: 100%">
                                                <?php else: ?>
                                                    <img src="<?php echo e($QR_Image); ?>" style="max-width: 100%">
                                                <?php endif; ?>
                                                
                                            </div>        
                                        </div>
                                        <div class="col-sm-6 col-md-7 col-lg-8 pt-3">
                                            <p>Thiết lập xác minh tài khoản cho <?php echo e(auth()->user()->email); ?>. <br>
                                                Code <?php echo e($secret); ?></p>
                                            
                                        </div>
                                    </div>
                                    
                                    <?php echo e(csrf_field()); ?>

                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input m-login__form-input--last" id="one_time_password" type="number" class="form-control" name="one_time_password" placeholder="Nhập mả xác thực" required autofocus>
                                    </div>
                                    <div class="m-login__form-action">
                                        <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--success">Xác thực</button>
                                    </div>
                                </div>
        
							</form>
                        </div>
                        <div class="m-login__account">
							<span class="m-login__account-msg">
								Không phải <?php echo e(auth()->user()->email); ?>

							</span>&nbsp;&nbsp;
							<a href="<?php echo e(route('logout')); ?>" id="m_login_signup" class="m-link m-link--light m-login__account-link">Đăng xuất</a>
                        </div>
                        
                        <div class="row g2fa-app">
                            <div class="col-12">
                                <h4>Tải Google Authenticator</h4>
                            </div>
                            <div class="col-6">
                                <a href="https://apps.apple.com/us/app/google-authenticator/id388497605">
                                    <img src="<?php echo e(asset('static/manager/assets/images/vn-badge-ios.png')); ?>" alt="">
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=vi">
                                    <img src="<?php echo e(asset('static/manager/assets/images/vi_badge_web_generic.png')); ?>" alt="">
                                </a>
                            </div>
                        </div>
					</div>
				</div>
            </div>
            
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <style>
        img{
            max-width: 100%;
        }
        .g2fa-app{
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid rgba(0,0,0, .4);
            text-align: center;
        }
        .g2fa-app img{
            height: 45px;
        }
        @media screen and (min-width: 576px){
            .g2fa-app img{
                height: 75px;
            }
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin._layouts.auth', [
    '_base' => 'admin.',
    '_template' => 'admin._templates.'
    
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/google2fa/qr.blade.php ENDPATH**/ ?>