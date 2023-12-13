<div class="banh-info  pb-3">
    <h4>Thông tin chuyển khoản</h4>
    <?php
    $transfer = null;
    $methods = $helper->getPaymentMethodOptions();
    foreach ($methods as $method) {
        if($method->method == 'transfer'){
            $transfer = $method;
        }
    }
    ?>
    <?php if($transfer && ($cfg = crazy_arr($transfer->config))): ?>

        <p>Số tài khoản: <strong><?php echo e($cfg->account_number); ?></strong></p>
        <p>Chủ tài khoản: <strong><?php echo e($cfg->account_name); ?></strong></p>
        <p>Ngân hàng: <strong><?php echo e($cfg->bank_name); ?></strong></p>
        <?php if($cfg->bank_branch): ?>
        <p>Chi nhánh: <strong><?php echo e($cfg->bank_branch); ?></strong></p>
        <?php endif; ?>
        <?php if($cfg->sort_code): ?>
        <p>Sort Code: <strong><?php echo e($cfg->sort_code); ?></strong></p>
        <?php endif; ?>
        <?php if($cfg->iban): ?>
        <p>IBAN: <strong><?php echo e($cfg->iban); ?></strong></p>
        <?php endif; ?>
        <?php if($cfg->bic): ?>
        <p>BIC / Swift: <strong><?php echo e($cfg->bic); ?></strong></p>
        <?php endif; ?>
    <?php else: ?>

    <P>Thông tin thanh toán chưa được cấu hình</P>
    <?php endif; ?>


    <?php if(isset($order) && $order): ?>

        <p>Số tiền: <strong><?php echo e(get_currency_format($order->total_money)); ?></strong></p>

    <?php endif; ?>

    <?php if($transfer->guide): ?>
        <p><?php echo nl2br($transfer->guide); ?></p>
    <?php endif; ?>
    <p><strong>* Lưu ý:</strong> khách hàng tự chịu phí chuyển khoản</p>
</div>
<div class="guide">
    <h4>Hướng dẫn</h4>
    <div class="guide-step">
        <h4>Bước 1:</h4>
        <p>Chuyển khoản với nội dung: <?php echo e(isset($order)?$order->billing->phone_number:'Số điện thoại'); ?> + <?php echo e(isset($order)?$order->code:'Mã đơn hàng'); ?></p>
    </div>
    <div class="guide-step">
        <h4>Bước 2:</h4>
        <p>Scan hoặc chụp hình rõ nét biên lai</p>
    </div>
    <div class="guide-step">
        <h4>Bước 3:</h4>
        <p>Điền vào form bên trên thông tin đơn hàng kèm ảnh biên lai</p>
    </div>
    <div class="guide-step">
        <h4>Bước 4:</h4>
        <p>Nhấn "Xong" để hoàn tất quá trình thanh toán</p>
    </div>
</div>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/client-libs/payments/transfer.blade.php ENDPATH**/ ?>