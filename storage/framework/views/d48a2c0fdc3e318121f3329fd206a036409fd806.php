
<?php $__env->startSection('title', $page_title); ?>
<?php echo $__env->make($_lib . 'register-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('body.class', 'cart-page'); ?>
<?php $__env->startSection('content'); ?>

    <div class="cart-container">
        <?php echo $__env->make($_template . 'page-header', [
            'title' => $page_title,
            // 'sub_title' => isset($category) && $category->description ? $category->description : $dynamic->description,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Box contents Cart -->
        <section>
            <div class="container">
                <?php if($cart && $cart->details && count($cart->details)): ?>

                    <?php if($e = session('warning_message')): ?>
                        <div class="alert alert-warning text-center"><?php echo e($e); ?></div>
                    <?php endif; ?>


                    <div class="row">
                        <div class="col-md-7">
                            <form action="<?php echo e(route('client.orders.checkout')); ?>" method="POST" class="form form--cart <?php echo e(parse_classname('checkout-form', 'cart-form', 'cart-section')); ?>" data-cart-type="<?php echo e($cart->type); ?>" data-cart-id="<?php echo e($cart->id); ?>">
                                <input type="hidden" name="cart_type" value="<?php echo e($cart->type); ?>">
                                <?php echo csrf_field(); ?>




                                <div class="production">

                                    <div class="prod-cart">
                                        <h3 class="title">Sản phẩm</h3>

                                        <?php $__currentLoopData = $cart->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="product-box row <?php echo e(parse_classname('cart-item', 'cart-item-' . $item->id)); ?>" id="cart-item-<?php echo e($item->id); ?>">
                                                <div class="img-wrapper col-lg-4 col-md-4 t-img-wrapper">
                                                    <a href="<?php echo e($item->link); ?>">
                                                        <img src="<?php echo e($item->image); ?>" alt="<?php echo e($item->product_name); ?>" style="width: 100%">
                                                    </a>
                                                </div>
                                                <div class="product-details col-lg-8 col-md-8 mt-md-0">
                                                    <div class="row">
                                                        <div class="cart-item-info-left">
                                                            <p class="prod_name">
                                                                <a href="<?php echo e($item->link); ?>"><?php echo e($item->product_name); ?></a>
                                                            </p>
                                                            <p class="material_size d-none d-md-block">
                                                                <?php if($item->attributes && count($item->attributes)): ?>
                                                                    <?php $__currentLoopData = $item->attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <span data-item-attribute-name="<?php echo e($attr->name); ?>" class="<?php echo e(parse_classname('cart-item-attribute', 'cart-item-attribute-selected', 'cart-item-attribute-value-' . $attr->name)); ?>"><?php echo e($attr->text); ?></span>
                                                                        <?php if(!$loop->last): ?>
                                                                            /
                                                                        <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>

                                                            </p>

                                                        </div>
                                                        <div class="cart-item-info-right">
                                                            
                                                            
                                                            <p class="price-sale total-price <?php echo e(parse_classname('item-total-price')); ?>"><?php echo e($item->getPriceFormat('total')); ?></p>
                                                        </div>

                                                    </div>
                                                    <div class="row d-md-none">
                                                        <div class="col-12">
                                                            <p class="material_size">
                                                                <?php if($item->attributes && count($item->attributes)): ?>
                                                                    <?php $__currentLoopData = $item->attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <span data-item-attribute-name="<?php echo e($attr->name); ?>" class="<?php echo e(parse_classname('cart-item-attribute', 'cart-item-attribute-selected', 'cart-item-attribute-value-' . $attr->name)); ?>"><?php echo e($attr->text); ?></span>
                                                                        <?php if(!$loop->last): ?>
                                                                            /
                                                                        <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>
                                                            </p>
                                                        </div>
                                                    </div>


                                                    <div class="row pt-10">
                                                        
                                                        <div class="col-md-">
                                                            <div class="number-input cart-item-qty">
                                                                <button type="button" class="quantity-left-minus"></button>
                                                                <input type="number" name="quantity" min="1" value="<?php echo e($item->quantity); ?>" data-item-id="<?php echo e($item->id); ?>" class="quantity <?php echo e(parse_classname('product-order-quantity', 'quantity', 'item-quantity')); ?>">
                                                                <button type="button" class="plus quantity-right-plus"></button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="cart-item-info-closed text-right">
                                                        <span class="cart-item-remove <?php echo e(parse_classname('remove-cart-item')); ?>" data-item-id="<?php echo e($item->id); ?>">✕</span>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </div>



                                </div>

                            </form>
                        </div>

                        <div class="col-md-5">
                            <div class="pay">
                                <div class="box-info">
                                    <h3 class="title">Thông tin thanh toán</h3>
                                    <form action="<?php echo e(route('client.orders.place-order')); ?>" method="POST" class="form form--cart <?php echo e(parse_classname('checkout-form', 'placeh-order-form', 'cart-section')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="cart_type" value="<?php echo e($cart->type); ?>">
                                        <div class="card box-cart">
                                            <?php
                                                $form = $cart->getForm([
                                                    'className' => 'form-control',
                                                ]);
                                                
                                                $info = $form->get('billing_name', 'billing_phone_number', 'billing_email', 'billing_region_id', 'billing_district_id', 'billing_ward_id', 'billing_address');
                                                $shipping = $form->get('shipping_name', 'shipping_email', 'shipping_phone_number', 'shipping_region_id', 'shipping_district_id', 'shipping_ward_id', 'shipping_address');
                                            ?>
                                            <div class="form-cart">
                                                <div class="row">
                                                    <?php $__currentLoopData = $info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $input): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="col-md-<?php echo e($input->name == 'billing_email' || $input->name == 'billing_address' ? 12 : 6); ?> mr-input">
                                                            
                                                            <div class="form-field">
                                                                <?php echo $input; ?>

                                                            </div>
                                                            <?php if($input->error): ?>
                                                                <div class="error has-error"><?php echo e($input->error); ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <div class="col-md-12 mr-input">
                                                        <?php echo $form->note; ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="discount-block">
                                                    <div class="coupon-public">
                                                        <div class="coupons">
                                                            <?php if($coupons && count($coupons)): ?>
                                                                <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <div class="coupon coupon-item" data-coupon-code="<?php echo e($coupon->code); ?>">
                                                                        <div class="coupon-left">
                                                                        </div>
                                                                        <div class="coupon-right">
                                                                            <div class="coupon-title">
                                                                                <?php echo e($coupon->code); ?>

                                                                                <span class="coupon-count"><i>(còn <?php echo e($coupon->total - $coupon->usage); ?>)</i></span>
                                                                            </div>
                                                                            <div class="coupon-description">
                                                                                <?php echo e($coupon->getDownTotalFLabel()); ?>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="apply-voucher mb-20">
                                                <div class="input-group">
                                                    <input type="text" class="form-control <?php echo e(parse_classname('coupon-code')); ?>" id="coupon_code" name="coupon_code" placeholder="Mã giảm giá" value="<?php echo e(old('coupon_code')); ?>">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-apply-voucher <?php echo e(parse_classname('btn-apply-coupon')); ?>">Áp dụng</button>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="ps-block--shopping-total">
                                                <h3 class="title">Hóa đơn</h3>
                                                <div class="table-responsive">
                                                    <table class="table bill-table">
                                                        <tbody>
                                                            <tr>
                                                                <td>Tạm tính</td>
                                                                <td><span class="<?php echo e(parse_classname('cart-sub-total-amount')); ?>"><?php echo e($helper->getCurrencyFormat($cart->sub_total)); ?></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Khuyến mãi</td>
                                                                <td><span class="<?php echo e(parse_classname('cart-promo-amount')); ?>">Chưa có</span></td>
                                                            </tr>

                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td>Tổng thành tiền</td>
                                                                <td><span class="<?php echo e(parse_classname('cart-total-ammount')); ?>"><?php echo e($helper->getCurrencyFormat($cart->total_money)); ?></span></td>

                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                            </div>


                                            <div class="box-method">
                                                <h3 class="title">Hình thức thanh toán</h3>
                                                <div class="method <?php echo e(parse_classname('payment-methods')); ?>">
                                                    <?php if(count($methods = $helper->getPaymentMethodOptions())): ?>
                                                        <?php
                                                        $defaultMethod = old('payment_method');
                                                        ?>
                                                        <?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                if (!$loop->index && !$defaultMethod) {
                                                                    $defaultMethod = $method->method;
                                                                }
                                                            ?>
                                                            <label for="payment-<?php echo e($method->value); ?>" class="payment-method__item payment-group <?php echo e(parse_classname('payment-method-option')); ?>">
                                                                <span class="payment-method__item-custom-checkbox custom-radio">
                                                                    <input type="radio" id="payment-<?php echo e($method->value); ?>" name="payment_method" autocomplete="off" value="<?php echo e($method->value); ?>" <?php if($method->value == $defaultMethod || (!$defaultMethod && !$loop->index)): ?> checked <?php endif; ?>>
                                                                    <span class="checkmark"></span>
                                                                </span>
                                                                <span class="payment-method__item-icon-wrapper">
                                                                    <img src="<?php echo e($method->icon); ?>" alt="<?php echo e($method->title); ?>">
                                                                </span>
                                                                <span class="payment-method__item-name"><?php echo e($method->title); ?></span>
                                                            </label>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if($err = $errors->first('payment_method')): ?>
                                                    <div class="crazy-error">
                                                        <?php echo e($err); ?>

                                                    </div>
                                                <?php endif; ?>

                                            </div>


                                            <div class="row btn-pay">
                                                <button type="submit" class="btn btn-apply-voucher">Thanh toán</button>
                                            </div>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="empty-content mt-40 mb-40">
                        <div class="empty-image text-center mb-10">
                            <img src="<?php echo e(theme_asset('images/empty-cart.png')); ?>" alt="">
                        </div>
                        <div class="theme-color text-center">
                            Không có sản phẩm nào trong giỏ hàng
                        </div>
                        <div class="buttons text-center">
                            <a href="<?php echo e(route('client.products')); ?>" class="btn btn-primary">Đến trang sản phẩm</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- End Box contents Cart -->
    </div>


<?php $__env->stopSection(); ?>

<?php
    add_js_src(theme_asset('js/cart.js'));
?>


<?php $__env->startSection('js'); ?>
    <script>
        window.needReloadIfNotTheSame = true;
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($_layout . 'master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/clients/64061caf6eaa1/modules/orders/cart.blade.php ENDPATH**/ ?>