

// giỏ hàng
App.extend({

    cart: {
        htmlEntities: function htmlEntities(str) {
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        },

        decimal: 2,
        urls: {},
        tasks: {},
        promo: {
            types: {}
        },
        currency_position: "right",
        templates: {
            item: "<p>{$name} - {$price}</p>"
        },
        currency_unit: "Đ",
        init_list: ["urls", "templates", "decimal", "currency_unit", "currency_position", "promo", "tasks"],
        regionID: 0,
        districtID: 0,
        shippingRegionID: 0,
        shippingDistrictID: 0,
        cartType: "",
        cartID: 0,
        listeners: {},
        on: function (eventName, callback) {
            if (typeof callback != "function") return false;
            if (typeof this.listeners[eventName] == "undefined") {
                this.listeners[eventName] = [];
            }
            this.listeners[eventName].push(callback);
            return true;

        },
        emit: function (eventName, data) {
            if (typeof this.listeners[eventName] == "undefined") {
                return false;
            }
            this.listeners[eventName].map(c => c(data));
            return true;
        },
        // kiểm tra giá sdan3 phẩm kèm thuộc tính
        /**
         * 
         * @param {*} data 
         */
        checkPrice: function (data) {
            data.cart_type = this.cartType;
            data.cart_id = this.cartID;
            App.api.post(this.urls.check_price, data).then(function (res) {
                if (res.status) {
                    var d = res.data;
                    $(prefixClass + 'product-detail-info-' + d.product.id).find(prefixClass + "product-price").html(App.cart.currency(parseInt(d.price)));
                }
            })
        },

        updateCartData: function (data, updateQuantity) {
            if (!App.isObject(data)) data = {};
            var self = this;
            var cart_quantity = 0,
                sub_total = data.sub_total || 0,
                tax = data.tax || 0,
                total_money = data.total_money || 0,
                promo_total = data.promo_total || 0,
                shipping_fee = data.shipping_fee || 0,
                details = data.details && data.details.length ? data.details : [];
            $(prefixClass + "cart-sub-total-ammount, " + prefixClass + "cart-sub-total-amount").html(this.currency(parseInt(sub_total)));

            $(
                prefixClass + "cart-tax-ammount, " + prefixClass + "cart-tax-total-ammount, "
                + prefixClass + "cart-tax-amount, " + prefixClass + "cart-tax-total-amount"
            ).html(this.currency(parseInt(tax)));
            $(
                prefixClass + "cart-shipping-fee, " + prefixClass + "cart-shipping-fee-ammount, " +
                prefixClass + "cart-shipping-fee, " + prefixClass + "cart-shipping-fee-amount"
            ).html(this.currency(parseInt(shipping_fee)));

            if (promo_total && promo_total > 0) {
                total_money -= promo_total;
                $(
                    prefixClass + "cart-promo-total, " + prefixClass + "cart-promo-total-ammount, "
                    + prefixClass + "cart-promo-total, " + prefixClass + "cart-promo-total-amount, "
                    + prefixClass + "cart-promo-amount, " + prefixClass + "cart-promo-total-amount"
                ).html(this.currency(promo_total));

            } else if (data.promo_type == this.promo.types.TYPE_FREESHIP) {
                $(
                    prefixClass + "cart-promo-total, " + prefixClass + "cart-promo-total-ammount, "
                    + prefixClass + "cart-promo-total, " + prefixClass + "cart-promo-total-amount, "
                    + prefixClass + "cart-promo-amount, " + prefixClass + "cart-promo-total-amount"
                ).html("Miễn phí giao hàng");

            }
            $(
                prefixClass + "cart-total-ammount, " + prefixClass + "cart-total-money-ammount, "
                + prefixClass + "cart-total-amount, " + prefixClass + "cart-total-money-amount"
            ).html(this.currency(parseInt(total_money)));

            var itemTemplate = this.templates.item;
            var attrTemplate = this.templates.attribute;
            var detailLength = details.length;
            var cartItems = '';
            if (detailLength) {
                for (let i = 0; i < detailLength; i++) {
                    var item = details[i];
                    if (!item.name) item.name = item.product_name;
                    item.price = this.currency(parseInt(item.price ? item.price : item.final_price));
                    cart_quantity += item.quantity;
                    $(prefixClass + "item-total-price-" + item.id + ", #cart-item-" + item.id)
                        .find(prefixClass + "item-total-price")
                        .html(this.currency(item.total_price ? item.total_price : item.quantity * item.final_price));

                    $(prefixClass + "item-total-price-" + item.id + ", #cart-item-" + item.id)
                        .find(prefixClass + "item-total-list-price")
                        .html(this.currency(item.total_list_price ? item.total_list_price : item.quantity * item.list_price));

                    if(updateQuantity && item.quantity){
                        $(prefixClass + "item-total-price-" + item.id + " " + prefixClass + "item-quantity, #cart-item-" + item.id + ' ' + prefixClass + 'item-quantity').val(item.quantity);
                    }
                    var attributeHtml = "";

                    if (item.attributes && App.isArray(item.attributes)) {
                        var attrLength = item.attributes.length;
                        if (attrLength) {
                            for (let j = 0; j < item.attributes.length; j++) {
                                var attr = item.attributes[j];
                                attr.value = self.htmlEntities(attr.text_value || attr[attr.value_type + "_value"] || "");
                                attr.text = self.htmlEntities(attr.text_value || attr[attr.value_type + "_value"] || "");
                                attr.text_value = self.htmlEntities(attr.text_value);
                            }
                        }
                    }
                    item.attributeHtml = attributeHtml;

                    item.total_price = this.currency(item.total_price ? item.total_price : item.quantity * item.final_price);
                    cartItems += App.str.eval(itemTemplate, item);
                }
            } else {
                cartItems = '<p>Không có sản phẩm nào</p>';
                if(typeof window.needReloadIfNotTheSame == "boolean" && window.needReloadIfNotTheSame){
                    if($('.crazy-cart-section .crazy-cart-item').length){
                        top.location.reload();
                    }
                }
            }
            if(data.has_deleted_item && data.deteled_item_list && data.deteled_item_list.length && $('.crazy-cart-form').length){
                for (let i = 0; i < data.deteled_item_list.length; i++) {
                    const itemID = data.deteled_item_list[i];
                    $('#cart-item-' + itemID).remove();
                }
            }
            $(prefixClass + "cart-quantity").html(cart_quantity);
            $(prefixClass + "cart-items").html(cartItems);
            this.emit("updateCartData", data);
            // code here

        },


        checkCartData: function () {

            var self = this;
            if (typeof this.tasks == "object") {
                Object.keys(self.tasks).map(key => self.on(key, self.tasks[key]));
            }

            App.api.post(this.urls.check_cart_data, {
                key: App.str.rand()
            }).then(function (result) {
                if (result.data) {
                    App.cart.updateCartData(result.data);
                }
            })
        },

        addCartItem: function (data, redirect, form) {
            if (!data || !data.product_id) return App.Swal.alert("Hành động không hợp lệ!");
            App.api.post(this.urls.add_cart_item, data).then(function (result) {
                if (result.status) {
                    App.cart.updateCartData(result.data);
                    if (redirect == 'checkout') {
                        top.location.href = App.cart.urls.checkout;
                    }
                    else if (redirect == 'cart' || typeof redirect == "boolean" && redirect) {
                        top.location.href = App.cart.urls.view_cart;
                    }
                    else {
                        App.Swal.confirm("Sản phẩm đã được thêm vào giỏ hàng thành công!\nBạn có muốn đến trang thanh toán không?", function (p) {
                            top.location.href = App.cart.urls.view_cart;
                        })
                    }
                } else {
                    App.Swal.alert(result.message);
                }
                if(result.data){
                    if(form && result.data.details && result.data.details.length){
                        for (let oi = 0; oi < result.data.details.length; oi++) {
                            const item = result.data.details[oi];
                            if(item.product_id == data.product_id){
                                $(form).find('.crazy-product-order-quantity, .crazy-order-quantity, .crazy-quantity').val(item.quantity);
                            }
                        }
                        
                    }
                }
            }).catch(function (e) {
                App.Swal.alert("Lỗi ko xác định");
            })
        },

        addManyItem: function (items, redirect) {
            if (!items.length) return App.Swal.alert("Hành động không hợp lệ!");
            App.api.post(this.urls.add_many_item, { items: items }).then(function (result) {
                if (result.status) {
                    App.cart.updateCartData(result.data);
                    if (redirect == 'checkout') {
                        top.location.href = App.cart.urls.checkout;
                    }
                    else {
                        App.Swal.confirm("Sản phẩm đã được thêm vào giỏ hàng thành công!\nBạn có muốn đến trang thanh toán không?", function (p) {
                            top.location.href = App.cart.urls.view_cart;
                        })
                    }
                } else {
                    App.Swal.alert(result.message);
                }
            }).catch(function (e) {
                App.Swal.alert("Lỗi ko xác định");
            })
        },
        addCartCombo: function (data, redirect) {
            if (!data || !data.combo_id) return App.Swal.alert("Hành động không hợp lệ!");
            App.api.post(this.urls.add_cart_combo, data).then(function (result) {
                if (result.status) {
                    App.cart.updateCartData(result.data);
                    if (redirect == 'checkout') {
                        top.location.href = App.cart.urls.checkout;
                    }
                    else {

                        App.Swal.confirm("Sản phẩm đã được thêm vào giỏ hàng thành công!\nBạn có muốn đến trang thanh toán không?", function (p) {
                            top.location.href = App.cart.urls.view_cart;
                        })
                    }
                } else {
                    App.Swal.alert(result.message);
                }
            }).catch(function (e) {
                App.Swal.alert("Lỗi ko xác định");
            })
        },

        removeCartItem: function (id) {
            if (!id) return App.Swal.alert("ID giỏ hàng không hợp lệ");

            var self = this;
            var data = { id: id };
            var coupon = self.getCouponCode();

            if (coupon) {
                data.coupon = coupon;
            }
            data.cart_type = this.cartType;
            data.cart_id = this.cartID;


            App.api.post(this.urls.remove_cart_item, data).then(function (result) {
                if (result.status) {
                    App.cart.updateCartData(result.data);
                    $("#cart-item-" + id + ", " + prefixClass + "cart-item-" + id).hide(300, function (e) {
                        $(this).remove();
                    })
                } else {
                    App.Swal.alert(result.message);
                }
            }).catch(function (e) {
                App.Swal.alert("Lỗi ko xác định");
            });
        },
        getCouponCode: function () {
            var $cupon = $(prefixClass + "coupon-code");
            if (!$cupon.length || !$cupon.val()) {
                return '';
            }
            else {
                return $cupon.val();
            }
        },

        applyCoupon: function (coupon) {
            if (!coupon) return App.Swal.warning("Vui lòng nhập mã giảm giá");

            var self = this;
            var data = { coupon: coupon };
            data.cart_type = this.cartType;
            data.cart_id = this.cartID;

            App.api.post(this.urls.apply_coupon, data).then(function (rs) {
                if (rs.status) {
                    App.cart.updateCartData(rs.data);
                } else {
                    App.Swal.error(rs.message);
                }
            }).catch(function (error) {

                App.Swal.error("Lỗi không xác định");
            })
        },

        checkPriceOfForm: function (form) {
            var data = {
                product_id: $(form).find(prefixClass + "product-order-id").val(),
                attrs: [],
                quantity: $(form).find(prefixClass + "product-order-quantity").val() || 1
            };
            var inputs = $(form).find(prefixClass + "product-varients").find('select, input[type="radio"]:checked, input[type="checkbox"]:checked');
            for (let i = 0; i < inputs.length; i++) {
                const inp = inputs[i];
                data.attrs.push($(inp).val());
            }
            this.checkPrice(data, form);
        },
        addToCartByForm: function (form, goToCart) {
            var data = {
                product_id: 0,
                attrs: [],
                quantity: 1
            };

            var redirect = null;
            var inputs = $(form).serializeArray();
            for (let i = 0; i < inputs.length; i++) {
                const inp = inputs[i];
                if (inp.name == "_token") continue;
                else if (inp.name == "product_id" || inp.name == "quantity") data[inp.name] = inp.value;
                else if (inp.name == "qty") data["quantity"] = inp.value;
                else if (inp.name == "redirect") redirect = inp.value;
                else data.attrs.push(inp.value);
            }
            this.addCartItem(data, goToCart, form);
        },


        updateCartQuantity: function (data) {
            var self = this;
            var coupon = self.getCouponCode();
            if (coupon) {
                data.coupon = coupon;
            }
            data.cart_type = this.cartType;
            data.cart_id = this.cartID;
            App.api.post(this.urls.update_cart_quantity, data).then(function (result) {
                if (result.status) {
                    self.updateCartData(result.data);
                } else {
                    App.Swal.alert(result.message);
                    if(result.data && result.data.details){
                        self.updateCartData(result.data, true);
                    }
                }
            }).catch(function (error) {
                App.log(error);
            });
        },
        updateAllCartItemQuantity: function () {
            //var $form = $(prefixClass + "cart-form");
            var quantity = {};
            var inputs = $(prefixClass + "item-quantity");
            if (inputs.length) {
                for (let i = 0; i < inputs.length; i++) {
                    const inp = inputs[i];
                    var $inp = $(inp);
                    var id = $inp.data('item-id');
                    var qty = parseInt($inp.val());
                    if (!isNaN(qty) && qty > 0) {
                        quantity[id] = qty;
                    }

                }
                if (!App.isEmpty(quantity)) {
                    this.updateCartQuantity({ quantity: quantity });
                }
            }
        },

        changeItemAttribute: function (item_id) {

            var self = this;
            var $itemBlock = $(prefixClass + "cart-item-" + item_id);
            if (!$itemBlock.length) return App.Swal.warning("Lỗi không xác định");

            var data = {
                item_id: item_id,
                attrs: [],
                quantity: $itemBlock.find(prefixClass + "product-order-quantity").val() || 1
            };
            var inputs = $itemBlock.find('select, input[type="radio"]:checked, input[type="checkbox"]:checked');
            for (let i = 0; i < inputs.length; i++) {
                const inp = inputs[i];
                data.attrs.push($(inp).val());
            }
            var coupon = self.getCouponCode();
            if (coupon) {
                data.coupon = coupon;
            }
            data.cart_type = this.cartType;
            data.cart_id = this.cartID;

            // console.log(data);

            App.api.post(this.urls.update_item, data).then(function (result) {
                if (result.status) {
                    self.updateCartData(result.data);
                    var _data = result.data;
                    var itemData = {};
                    if (_data && _data.details && _data.details.length) {
                        var details = _data.details;
                        for (let index = 0; index < details.length; index++) {
                            const item = details[index];
                            if (item.id == item_id) {
                                itemData = item;
                            }

                        }
                    }
                    self.emit("changeItemAttribute", itemData)
                } else {
                    App.Swal.alert(result.message);
                }
            }).catch(function (error) {
                App.log(error);
            });
            // this.checkPrice(data);
        },
        currency: function (total) {
            var c = App.config.currency;

            return App.number.format(parseInt(total), 0, c.decimal_poiter, c.thousands_sep, c.currency_type, c.currency_position)
        },

        changeRegionID: function (value, text, el) {
            if (value != this.regionID) {
                this.regionID = value;
                App.dom.select.deactive('billing_district_id');
                App.dom.select.deactive('billing_ward_id');
                App.dom.select.changeOptions('billing_district_id', { 0: "Chọn Quận / Huyện" });
                App.dom.select.changeOptions('billing_ward_id', { 0: "Chọn Phường / Xã" });
                if (value && value != "0") {
                    App.ajax(this.urls.district_options, {
                        method: "get",
                        data: { region_id: value },
                        dataType: "JSON"
                    }).then(function (res) {
                        if (res.status) {
                            App.dom.select.changeOptions('billing_district_id', res.data);
                        }
                    });
                }
            }
        },

        changeDistrictID: function (value, text, el) {
            if (value != this.districtID) {
                this.districtID = value;
                App.dom.select.deactive('billing_ward_id');
                App.dom.select.changeOptions('billing_ward_id', { 0: "Chọn Xã / Phường" });
                if (value && value != "0") {
                    App.ajax(this.urls.ward_options, {
                        method: "get",
                        data: { district_id: value },
                        dataType: "JSON"
                    }).then(function (res) {
                        if (res.status) {
                            App.dom.select.changeOptions('billing_ward_id', res.data);
                        }
                    });
                }
            }
        },


        changeShippingRegionID: function (value, text, el) {
            if (value != this.shippingRegionID) {
                this.shippingRegionID = value;
                App.dom.select.deactive('shipping_district_id');
                App.dom.select.deactive('shipping_ward_id');
                App.dom.select.changeOptions('shipping_district_id', { 0: "Chọn Quận / Huyện" });
                App.dom.select.changeOptions('shipping_ward_id', { 0: "Chọn Xã / Phường" });
                if (value && value != "0") {
                    App.ajax(this.urls.district_options, {
                        method: "get",
                        data: { region_id: value },
                        dataType: "JSON"
                    }).then(function (res) {
                        if (res.status) {
                            App.dom.select.changeOptions('shipping_district_id', res.data);
                        }
                    });
                }
            }
        },

        changeShippingDistrictID: function (value, text, el) {
            if (value != this.shippingDistrictID) {
                this.shippingDistrictID = value;
                App.dom.select.deactive('shipping_ward_id');
                App.dom.select.changeOptions('shipping_ward_id', { 0: "Chọn xã / phường" });
                if (value && value != "0") {
                    App.ajax(this.urls.ward_options, {
                        method: "get",
                        data: { district_id: value },
                        dataType: "JSON"
                    }).then(function (res) {
                        if (res.status) {
                            App.dom.select.changeOptions('shipping_ward_id', res.data);
                        }
                    });
                }
            }
        },


        addBuyNowItem: function (data, redirect) {
            if (!data || !data.product_id) return App.Swal.alert("Hành động không hợp lệ!");
            App.api.post(this.urls.buy_now_item, data).then(function (result) {
                if (result.status) {
                    top.location.href = App.cart.urls.view_buy_now_cart;

                } else {
                    App.Swal.alert(result.message);
                }
            }).catch(function (e) {
                App.Swal.alert("Lỗi ko xác định");
            })
        },

        buyNowByForm: function (form) {
            var data = {
                product_id: 0,
                attrs: [],
                quantity: 1
            };

            var redirect = null;
            var inputs = $(form).serializeArray();
            for (let i = 0; i < inputs.length; i++) {
                const inp = inputs[i];
                if (inp.name == "_token") continue;
                else if (inp.name == "product_id" || inp.name == "quantity") data[inp.name] = inp.value;
                else if (inp.name == "qty") data["quantity"] = inp.value;
                else if (inp.name == "redirect") redirect = inp.value;
                else data.attrs.push(inp.value);
            }
            this.addBuyNowItem(data);
        },

        buyNowCombo: function (data, redirect) {
            if (!data || !data.combo_id) return App.Swal.alert("Hành động không hợp lệ!");
            App.api.post(this.urls.buy_now_combo, data).then(function (result) {
                if (result.status) {
                    top.location.href = App.cart.urls.view_buy_now_cart;

                } else {
                    App.Swal.alert(result.message);
                }
            }).catch(function (e) {
                App.Swal.alert("Lỗi ko xác định");
            })
        },


    }
    // end cart
});


if (typeof window.orderCartInit == "function" || typeof window.customCartInit == "function") {
    if (typeof window.orderCartInit == "function") {
        window.orderCartInit();
    }
    if (typeof window.customCartInit == "function") {
        window.customCartInit();
    }


    App.cart.checkCartData();

    var detailClass = prefixClass + "product-detail";

    var frmSelector = detailClass + " " + prefixClass + "product-order-form";
    $(document).on("submit", frmSelector, function (e) {
        e.preventDefault();
        App.cart.addToCartByForm(this);
        return false;
    });
    $(document).on("click", frmSelector + " " + prefixClass + 'btn-buy-now', function (e) {
        e.preventDefault();
        var form = $(this).closest(prefixClass + "product-order-form");
        if (form.length) {
            App.cart.addToCartByForm(form, true);
        }

        return false;
    });



    // var productOrderForms = $(frmSelector);

    // if (productOrderForms.length) {
    //     // for (let i = 0; i < productOrderForms.length; i++) {
    //     //     const form = productOrderForms[i];
    //     //     App.cart.checkPriceOfForm(form);
    //     // }
    //     // productOrderForms.change(function (e) {
    //     //     App.cart.checkPriceOfForm(this);
    //     // });

    //     productOrderForms.(function (e) {
    //         e.preventDefault();
    //         App.cart.addToCartByForm(this);
    //         return false;
    //     });

    // }

    $(document).on('click', prefixClass + "remove-cart-item", function (e) {
        e.preventDefault();
        try {
            App.cart.removeCartItem($(this).data('item-id'));
        } catch (error) {
            App.log(error)
        }
        return false;
    });



    $(document).on('click', prefixClass + "add-to-cart", function (e) {
        e.preventDefault();
        try {
            var data = {
                product_id: $(this).data('product-id'),
                attrs: [],
                quantity: 1
            };

            var form = $(this).closest(prefixClass + "product-item-form");
            if (form.length) {

                var redirect = null;
                var inputs = form.serializeArray();
                for (let i = 0; i < inputs.length; i++) {
                    const inp = inputs[i];
                    if (inp.name == "_token") continue;
                    else if (inp.name == "product_id" || inp.name == "quantity") data[inp.name] = inp.value;
                    else if (inp.name == "qty") data["quantity"] = inp.value;
                    else if (inp.name == "redirect") redirect = inp.value;
                    else data.attrs.push(inp.value);
                }
            }
            App.cart.addCartItem(data, $(this).data('redirect'), form);
        } catch (error) {
            App.log(error)
        }
        return false;
    });


    $(document).on('click', prefixClass + "add-many-to-cart", function (e) {
        e.preventDefault();

        try {
            var items = [];
            var $lists = $('#' + $(this).data('list-id'));
            if ($lists.length == 0) {
                App.Swal.warning("Không tìm thấy danh sách");
                return false;
            }
            var $list = $($lists[0]);
            var $forms = $list.find((prefixClass + "product-item-form"));
            if ($forms.length == 0) {
                App.Swal.warning("Không tìm thấy danh sách");
                return false;
            }
            $forms.each((i, f) => {
                var data = {
                    product_id: $(f).data('product-id'),
                    attrs: [],
                    quantity: 1
                };
                var form = $(f);
                var redirect = null;
                var inputs = form.serializeArray();
                for (let i = 0; i < inputs.length; i++) {
                    const inp = inputs[i];
                    if (inp.name == "_token") continue;
                    else if (inp.name == "product_id" || inp.name == "quantity") data[inp.name] = inp.value;
                    else if (inp.name == "qty") data["quantity"] = inp.value;
                    else if (inp.name == "redirect") redirect = inp.value;
                    else data.attrs.push(inp.value);
                }
                items.push(data);

            });
            if (items.length) {
                App.cart.addManyItem(items, $(this).data('redirect'));
            }

        } catch (error) {
            App.log(error)
        }
        return false;
    });

    $(document).on('click', prefixClass + "add-combo", function (e) {
        e.preventDefault();
        try {
            App.cart.addCartCombo({
                combo_id: $(this).data('combo-id')
            }, $(this).data('redirect'));
        } catch (error) {
            App.log(error)
        }
        return false;
    });

    $(document).on('click', prefixClass + "buy-now-combo", function (e) {
        e.preventDefault();
        try {
            App.cart.buyNowCombo({
                combo_id: $(this).data('combo-id')
            }, $(this).data('redirect'));
        } catch (error) {
            App.log(error)
        }
        return false;
    });


    $(document).on('click', prefixClass + "btn-update-cart", function (e) {
        e.preventDefault();
        try {
            App.cart.updateAllCartItemQuantity();
        } catch (error) {
            App.log(error)
        }
        return false;
    });


    $(document).on('click', prefixClass + "btn-apply-coupon", function (e) {
        e.preventDefault();
        try {
            var $cupon = $(prefixClass + "coupon-code");
            if (!$cupon.length || !$cupon.val()) {
                App.Swal.warning("Bạn chưa nhập mã giảm giá");
            }
            else {
                App.cart.applyCoupon($cupon.val());
            }
        } catch (error) {
            App.log(error)
        }
        return false;
    });



    App.cart.cartType = $(prefixClass + "cart-form").data('cart-type');
    App.cart.cartID = $(prefixClass + "cart-form").data('cart-id');
    $(prefixClass + "cart-form").submit(function (e) {
        e.preventDefault();
        try {
            App.cart.updateAllCartItemQuantity();
        } catch (error) {
            App.log(error)
        }
        return false;
    });

    $(document).on("change", prefixClass + 'product-order-quantity', function (e) {
        var $inp = $(this);
        var quantity = parseInt($inp.val());
        if (isNaN(quantity) || quantity < 1) {
            $inp.val(1);
            App.Swal.warning("Số lượng tối thiểu là 1");
        }
        App.cart.updateAllCartItemQuantity();
    });




    $(document).on("change", prefixClass + 'cart-item-attribute', function (e) {
        // App.cart.updateAllCartItemQuantity();
        var item_id = $(this).data('item-id');
        App.cart.changeItemAttribute(item_id);
    });



    var createAccountCheckbox = $(prefixClass + "create-account-checkbox");
    if (createAccountCheckbox.length) {
        var createAccountGroup = $(prefixClass + "create-account-group");
        var toggleCreateAccountGroup = function () {
            if (createAccountCheckbox.is(':checked')) {
                createAccountGroup.show(300);
            } else {
                createAccountGroup.hide(300);
            }
        };
        createAccountCheckbox.on('change', function (e) {
            toggleCreateAccountGroup();
        });
        toggleCreateAccountGroup();
    }


    var shiptoDifferentAddressCheckbox = $(prefixClass + "ship-to-different-address");
    if (shiptoDifferentAddressCheckbox.length) {
        var shiptoDifferentAddressGroup = $(prefixClass + "shipping-address-group");
        var toggleshiptoDifferentAddressGroup = function () {
            if (shiptoDifferentAddressCheckbox.is(':checked')) {
                shiptoDifferentAddressGroup.show(300);
            } else {
                shiptoDifferentAddressGroup.hide(300);
            }
        };
        shiptoDifferentAddressCheckbox.on('change', function (e) {
            toggleshiptoDifferentAddressGroup();
        });
        toggleshiptoDifferentAddressGroup();
    }

    var paymentMethods = $(prefixClass + "payment-methods");

    if (paymentMethods.length) {
        var hidePaymentMethodDescription = function () {
            paymentMethods.find(prefixClass + "payment-method-description").removeClass('show');

        };
        var showPaymentMethodDescription = function (value) {
            hidePaymentMethodDescription();
            paymentMethods.find(prefixClass + "payment-method-description[data-method=" + value + "]").addClass('show');
        }

        var paymentValues = paymentMethods.find(prefixClass + "payment-method-value");
        // hidePaymentMethodDescription();
        paymentValues.map(function (e) {
            if ($(e).is(":checked")) {
                showPaymentMethodDescription($(e).val());
            }
        });
        $(document).on('change', prefixClass + "payment-method-value", function (e) {
            if ($(this).is(":checked")) {
                showPaymentMethodDescription($(this).val());
            }
        });

    }
}

