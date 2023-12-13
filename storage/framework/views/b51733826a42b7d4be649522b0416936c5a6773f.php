<?php
    add_js_src(asset('static/plugins/real-time-content-analysis/js/script.js'));
    add_css_link('static/plugins/real-time-content-analysis/css/style.build.min.css');
?>


<div class="custom-background theme-yoast-theme woocommerce-no-js has_paypal_express_checkout theme-home theme-academy">
    <section class="content">

        <div id="input" class="form-container">
            <div id="inputForm" class="inputForm">
                <label for="focusKeyword">Focus keyword</label>
                <input type="text" id="focusKeyword" name="focus_keyword" value="<?php echo e(old('focus_keyword', $input->parent->formData('focus_keyword'))); ?>" placeholder="Chọn từ khóa tập chung (từ khóa chính)" />
                <?php if($errors && $errors->has('focus_keyword')): ?>
                    <div class="error has-error text-danger">
                        <?php echo e($errors->first('focus_keyword')); ?>

                    </div>
                <?php endif; ?>
            </div>
            <div id="snippetForm" class="snippetForm">
                <label>Snippet Preview</label>
                <div id="snippet" class="output">

                </div>
            </div>
        </div>
        <div id="output-container" class="output-container">
            <p>Đây là nội dung trang của bạn khi được hiển thị trên danh sách kết quả tìm kiếm của google.</p>

            <p>Click vào Meta Title hoặc meta Description để chỉnh sửa</p>
            
            <div id="output" class="output">

            </div>

            <p><strong>Đánh giá nội dung</strong></p>
            <div id="contentOutput" class="contentOutput">

            </div>
        </div>
    </section>




</div>
<?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/admin/forms/templates/seo.blade.php ENDPATH**/ ?>