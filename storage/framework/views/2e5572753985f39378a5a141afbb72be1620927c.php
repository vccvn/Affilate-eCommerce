
<?php echo $__env->make($_lib . 'register-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('body.class', 'payment-page'); ?>
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make($_template . 'page-header', [
        'title' => $page_title,
        // 'sub_title' => isset($category) && $category->description ? $category->description : $dynamic->description,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if(!session('order_code')): ?>
        <!-- Log In Section Start -->
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
                        <input type="text" name="contact" id="contact" class="form-control" value="<?php echo e(old('contact')); ?>">
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
                        <input type="text" name="order_code" id="order_code" class="form-control" value="<?php echo e(old('order_code')); ?>">
                    </div>
                    <?php if($error = $errors->first('order_code')): ?>
                        <div class="alert alert-danger text-center">
                            <?php echo e($error); ?>

                        </div>
                    <?php endif; ?>
                    <div class="input submit">
                        <button type="submit" class="btn brt-primary btn-block">Tiếp tục</button>
                    </div>
                </form>

            </div>

        </div>
        <!-- Log In Section End -->
    <?php else: ?>
        <section class="transfer-section">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6  mb-40 mb-lg-0">
                        <h3 class="heading-secondary mb-3">Thanh toán</h3>
                        <div class="login-reg-box bg-white">
                            <form action="<?php echo e(route('client.payments.verify-transfer')); ?>" method="post" enctype="multipart/form-data">
                                <div class="ps-form__content">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="order_code" value="<?php echo e(session('order_code')); ?>">
                                    <div class="form-group">
                                        <label class="form__label" for="order_code">
                                            Mã đơn hàng <span>*</span>
                                        </label>
                                        <input type="text" name="code" id="order_code" class="form-control" value="<?php echo e(session('order_code')); ?>" placeholder="Mã đơn hàng" readonly>
                                    </div>
                                    <?php if($error = $errors->first('order_code')): ?>
                                        <div class="alert alert-danger text-center">
                                            <?php echo e($error); ?>

                                        </div>
                                    <?php endif; ?>

                                    <div class="form-group mt-3">
                                        <label for="billing_transaction_image" class="form__label mb-2">Biên lai <span>*</span></label>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="billing_transaction_image" class="custom-file-input" accept="image/*">
                                            
                                        </div>
                                        <?php if($errors->has('image')): ?>
                                            <div class="error has-error"><?php echo e($errors->first('image')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="orderNotes" class="form__label mb-2">Ghi chú </label>
                                        <textarea class="form-control" id="orderNotes" name="note" placeholder="Ghi chú (Tùy chọn)"><?php echo e(old('note')); ?></textarea>
                                    </div>
                                    <div class="form-group submit mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">Xong</button>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <h3 class="heading-secondary mb-3">Hướng dẫn</h3>
                        <div class=" bg-white" style="font-size: large">
                            <?php echo $__env->make($_lib . 'payments.transfer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>



            </div>
        </section>


    <?php endif; ?>






<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout . 'master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/modules/payments/transfer.blade.php ENDPATH**/ ?>