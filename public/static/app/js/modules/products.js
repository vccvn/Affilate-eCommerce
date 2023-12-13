
// Sản phẩm
App.extend({
    products: {
        decimal: 0,
        urls: {},
        templates: {
            item: "<p>{$name} - {{$price}}</p>"
        },
        init_list: ["urls", "templates", "decimal"],
        // kiểm tra giá sdan3 phẩm kèm thuộc tính
        /**
         *
         * @param {*} data
         */
        checkPrice: function (data, form) {
            App.api.post(this.urls.check_price, data)
                .then(function (res) {
                    if (res.status) {
                        var d = res.data;
                        $(prefixClass + 'product-detail-info-' + d.product.id).find(prefixClass + "product-price").html(App.cart.currency(d.price));
                        if (!d.status) {
                            App.Swal.warning(d.message);
                            $(prefixClass + 'product-detail-info-' + d.product.id).find(prefixClass + "product-order-quantity").val(d.quantity)
                        }
                        if(!d.available && form){
                            App.Swal.warning("Chỉ còn " + d.available_quantity + " sản phẩm có thể đặt hàng!");
                            $(form).find(prefixClass + "product-order-quantity").val(d.available_quantity?d.available_quantity:1);
                        }
                    }
                    else{
                        App.Swal.warning(res.message);
                    }
                });
        },

        checkPriceOfForm: function (form) {
            var $inp = $(form).find(prefixClass + "product-order-quantity");
            var quantity = parseInt($inp.val());
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
                $inp.val(quantity);
                App.Swal.warning("Số lượng tối thiểu là 1");
            }

            var data = {
                product_id: $(form).find(prefixClass + "product-order-id").val(),
                attrs: [],
                quantity: quantity
            };

            var inputs = $(form).find(prefixClass + "product-variants").find('select, input[type="radio"]:checked, input[type="rcheckbox"]:checked');
            for (let i = 0; i < inputs.length; i++) {
                const inp = inputs[i];
                data.attrs.push($(inp).val());
            }
            this.checkPrice(data, form);

        },
        getData: function (id, callback) {
            var ajax = App.ajax(this.urls.get_data, {
                method: "GET",
                data: { id: id },
                dataType: "json"
            });
            if (App.isCallable(callback)) {
                ajax.then(callback);
            }
            return ajax;
        },
        currency: function (total) {
            var c = App.config.currency;
            return App.number.format(total, c.decimal, c.decimal_poiter, c.thousands_sep, c.currency_type, c.currency_position)
        },
        review: function (form) {
            var self = this;
            var serialized = $(form).serializeArray();
            var data = {};
            var $form = $(form);
            serialized.map(function (inp) {
                if (inp.name == '_token') return null;
                if (typeof data[inp.name] != "undefined") {

                    if (App.getType(data[inp.name]) == 'array') {
                        data[inp.name].push(inp.value);
                    } else {
                        data[inp.name] = [data[inp.name], inp.value];
                    }
                } else {
                    data[inp.name] = inp.value;
                }
            });
            if (!data.rating || data.rating == "0" || !data.name || !data.email) {
                App.Swal.warning("Vui lòng xếp hạn sản phẩm, điều đầy dủ họ tên và email!");
            } else {
                App.api.post(this.urls.review, data).then(function (res) {
                    if (res.status) {
                        App.Swal.success(res.message, null, function(){
                            if(res.data && res.data.refresh){
                                self.getReviews(null, true);
                            }
                        });
                        App.modal.hide("review-form-modal");
                        $form[0].reset();
                        $form.find("input,textarea").map(function (inp) {
                            if (["comment", "name", "email"].indexOf(inp.name) >= 0) {
                                $(inp).val("");
                            }
                        })
                        
                    } else {
                        var errMessage = "";
                        if (res.errors) {
                            for (const key in res.errors) {
                                if (res.errors.hasOwnProperty(key)) {
                                    const error = res.errors[key];
                                    errMessage = error;
                                    break;
                                }
                            }
                        }
                        App.Swal.error(errMessage ? errMessage : "Kiểm tra lại thông tin");
                    }
                }).catch(function (e) {
                    App.Swal.error("Lỗi không xác định");
                });
            }
        },
        getReviews: function getReviews(url, scrollTop) {
            if (!url) url = this.urls.reviews;
            var self = this;
            App.api.get(url).then(function (rs) {
                if (rs.status) {
                    var $container = $('.review-ajax-render-container');
                    $container.html(rs.data.html);
                    setTimeout(() => {
                        App.Swal.hideLoading();
                        if ($container.length && scrollTop) {
                            setTimeout(() => {
                                $('html, body').animate({
                                    scrollTop: $container.offset().top - 10
                                }, 100);
                            }, 500);
                        }

                    }, 500);
                }
                else {
                    App.Swal.alert(rs.message);
                }
            }).catch(function (e) {
                App.Swal.alert("Lỗi không xác định");
            })
        }
    },
    orderFormSelector: null
    // end cart
});


if (typeof window.productAppInit == "function" || typeof window.customProductAppInit == "function") {
    if (typeof window.productAppInit == "function") {
        window.productAppInit();
    }
    if (typeof window.customProductAppInit == "function") {
        window.customProductAppInit();
    }


    var detailClass = prefixClass + "product-detail";



    var frmSelector = detailClass + " " + prefixClass + "product-order-form";
    App.products.orderFormSelector = frmSelector;
    $(document).on("change", frmSelector, function (e) {
        App.products.checkPriceOfForm(this);
    });

    var productOrderForms = $(frmSelector);
    if (productOrderForms.length) {
        for (let i = 0; i < productOrderForms.length; i++) {
            const form = productOrderForms[i];
            var checkRequired = $(form).data('check-required');
            if (checkRequired == 'false') {

            } else {
                App.products.checkPriceOfForm(form);
            }

        }
    }

    if ($('.review-ajax-render-container').length) {
        App.products.getReviews();
    }

    $(prefixClass + "product-review-form").submit(function (e) {
        e.preventDefault();
        App.products.review(this);
        return false;
    });
    $(document).on("click", prefixClass + "show-review-form", function (e) {
        e.preventDefault();
        App.modal.show("review-form-modal");
        return false;
    });
    $(document).on("click", '.review-ajax-render-container .review-ajax-pagination .page-item .page-link', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (url != 'javascript:void(0)' && url.substring(0, 4) == 'http') {
            App.Swal.showLoading(100000);
            App.products.getReviews(url, true);
        }
        return false;
    });


}

