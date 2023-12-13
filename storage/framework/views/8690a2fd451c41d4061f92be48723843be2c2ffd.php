<?php
$cache_data_time = system_setting('cache_data_time', 0);
    if($cache_data_time){
        add_js_data('____crazy_cache', true);
    }else{
        add_js_data('____crazy_cache', false);
    }
?>

<?php echo $html->getAndCleanCss(); ?>


    <script src="<?php echo e(asset('static/plugins/axios/axios.min.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script src="<?php echo e(asset("static/app/js/app.min.js")); ?>"></script>

        <script>
            App.extend({
                laravel:{
                    urls: <?php echo json_encode([
                            'token' => route("client.token")
                        ]); ?>,
                    cache: <?php echo e($cache_data_time?'true':'false'); ?>

                }
            })


        </script>

    <?php if($data = get_js_data()): ?>
        <script>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            var <?php echo e($name); ?> = <?php echo json_encode($value, 15, 512) ?>;

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </script>
    <?php endif; ?>

    <?php echo $__env->yieldContent('jsinit'); ?>

    <script>


        window.csrfTokenInit = function () {
            App.csrf.init({
                urls: <?php echo json_encode([
                        'token' => route("client.token")
                    ]); ?>

            });
        };
        window.subcribeInit = function () {
            App.subcribes.init({
                urls: <?php echo json_encode([
                        'subcribe' => route("client.ajax-subscribe")
                    ]); ?>

            });
        };

        window.locationInit = function () {
                App.location.init({
                    urls: <?php echo json_encode([
                            'region_options' => route("client.location.regions.options"),
                            'district_options' => route("client.location.districts.options"),
                            'ward_options' => route("client.location.wards.options"),
                        ]); ?>

                });
            };
        window.apiInit = function () {
            App.api.init({
                urls: <?php echo json_encode([
                        'comment_list' => route("api.comments"),
                        'comment_create' => route("api.comments.create")
                    ]); ?>

            });
        };

        window.contactInit = function () {
            App.contact.init({
                urls: <?php echo json_encode([
                        'send_contact_url' => route("client.contacts.ajax-send"),
                    ]); ?>

            });
        };

        window.visitorInit = function () {
            App.visitors.init({
                urls: <?php echo json_encode([
                        'check' => route("client.visitors.check"),
                    ]); ?>

            });
        };
    </script>

    <?php if($data = get_js_src()): ?>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $src): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <script src="<?php echo e($src); ?>"></script>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <?php if(get_web_type() == 'ecommerce'): ?>
        <script>
            App.config = App.config || {
                currency:{
                    thousands_sep:".",
                    currency_position:"left",
                    currency_type:"$",
                    decimal_poiter:",",
                    decimals:2,
                    allow_place_order:true
                }
                
            };
            
            App.config.currency = <?php echo json_encode(get_ecommerce_setting()->all()); ?>

            window.productAppInit = function () {
                App.products.init({
                    urls: <?php echo json_encode([
                            'check_price' => route("client.products.check-price"),
                            'get_data' => route("client.products.data"),
                            'review' => route("client.products.ajax-review"),
                            'reviews' => route("client.products.reviews", [
                                'slug' => ($product = get_active_model('product'))?$product->slug:'[PRODUCT-SLUG]'
                            ])
                        ]); ?>

                });
            };
            window.orderCartInit = function () {
                App.cart.init({
                    urls: <?php echo json_encode([
                            'check_price' => route("client.orders.check-price"),
                            'view_cart' => route("client.orders.cart"),
                            'checkout' => route("client.orders.checkout"),
                            'update_cart' => route("client.orders.update-cart"),
                            'update_cart_quantity' => route("client.orders.update-cart-quantity"),
                            'update_item' => route("client.orders.update-cart-item"),
                            'check_cart_data' => route("client.orders.check-cart-data"),
                            'add_cart_item' => route("client.orders.add-cart-item"),
                            'add_many_item' => route("client.orders.add-many-item"),
                            'remove_cart_item' => route("client.orders.remove-cart-item"),
                            'apply_coupon' => route("client.orders.apply-coupon"),
                            
                            'buy_now_item' => route("client.orders.buy-now"),
                            'view_buy_now_cart' => route("client.orders.buy-now-cart"),
                            'add_cart_combo' => route("client.orders.add-cart-combo"),
                            'buy_now_combo' => route("client.orders.buy-now-combo"),
                            
                            'region_options' => route("client.location.regions.options"),
                            'district_options' => route("client.location.districts.options"),
                            'ward_options' => route("client.location.wards.options"),
                        ]); ?>,
                    promo:{
                        types: <?php echo json_encode(\App\Models\Promo::getTypeMapKeys()); ?>

                    }
                });
            };
            window.orderInit = function () {
                App.orders.init({
                    urls: <?php echo json_encode([
                            'cancel' => route("client.orders.cancel"),
                        ]); ?>

                });
            };

        </script>
    <?php endif; ?>
    <script src="<?php echo e(asset("static/app/js/app.modules.js")); ?>"></script>

    <?php if($jssdk = $options->settings->jssdk): ?>
    <?php echo $jssdk->facebook; ?>

    <?php echo $jssdk->twitter; ?>


    <?php endif; ?>



    <?php if(($pwa = get_option('settings')->pwa) && $pwa->active): ?>

    <!-- Install button, hidden by default -->
    <div id="installContainer" class="hidden">
        <button id="butInstall" type="button">
          Install
        </button>
      </div>
  
      
    <p id="requireHTTPS" class="hidden d-none">
        <b>STOP!</b> This page <b>must</b> be served over HTTPS.
        Please <a>reload this page via HTTPS</a>.
      </p>
      
      <!-- import the webpage's javascript file -->
      <script src="<?php echo e(asset("static/app/js/pwa.js")); ?>"></script>
      
      <!-- include the Glitch button to show what the webpage is about and
            to make it easier for folks to view source and remix -->
      <div class="glitchButton" style="position:fixed;top:20px;right:20px;"></div>
      <script src="https://button.glitch.me/button.js"></script>
    <?php endif; ?>



    <?php echo $__env->yieldContent('js'); ?>

    
    <?php echo $html->getAndCleanScripts(); ?>

    
    <?php
        $messKeys = ['warning', 'success', 'error', 'info', 'alert'];
    ?>
    <script>

        App.onModuleLoaded(function(){
            App.task(function(){
                
    // <?php $__currentLoopData = $messKeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
       //  <?php if($_message = session($key.'_message')): ?>
            
            App.Swal.<?php echo e($key); ?>(<?php echo json_encode($_message); ?>);
            
        // <?php endif; ?>

    // <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            })

        })
    </script><?php /**PATH /Users/doanln/Desktop/VCC Corp/mien-atelier/resources/views/client-libs/js.blade.php ENDPATH**/ ?>