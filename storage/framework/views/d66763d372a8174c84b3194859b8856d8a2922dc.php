

<?php echo $__env->make($_lib . 'register-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('body.class', 'payment-page'); ?>
<?php $__env->startSection('content'); ?>

    <!-- Log In Section Start -->
    <div class="login-section">
        <?php echo $__env->make($_template . 'page-header', [
            'title' => $page_title,
            // 'sub_title' => isset($category) && $category->description ? $category->description : $dynamic->description,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="order-section">
            <div class="box">

                <form class="form" action="<?php echo e(route('client.payments.check-order')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php if($error = session('error')): ?>
                        <div class="alert alert-danger text-center">
                            <?php echo e($error); ?>

                        </div>
                    <?php endif; ?>

                    <div class="input">
                        <label class="form__label" for="contact">
                            Email hoặc Số điện thoại <span>*</span>
                        </label>
                        <input type="text" name="contact" id="contact" class="form-control" value="<?php echo e(old('contact')); ?>" placeholder="">
                    </div>
                    <?php if($error = $errors->first('contact')): ?>
                        <div class="alert alert-danger text-center">
                            <?php echo e($error); ?>

                        </div>
                    <?php endif; ?>
                    <div class="input">
                        <label class="form__label" for="order_code">
                            Mã đơn hàng <span>*</span>
                        </label>
                        <input type="text" name="order_code" id="order_code" class="form-control" value="<?php echo e(old('order_code')); ?>" placeholder="">
                    </div>
                    <?php if($error = $errors->first('order_code')): ?>
                        <div class="alert alert-danger text-center">
                            <?php echo e($error); ?>

                        </div>
                    <?php endif; ?>
                    <div class="buttons text-center">
                        <button type="submit" class="btn btn-primary btn-block">Tiếp tục</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Log In Section End -->




<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout . 'master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/modules/payments/order.blade.php ENDPATH**/ ?>