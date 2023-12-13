var st_submitAndRefresh = function (form) {
    try {
        var $form = $(form);
        var data = $form.serializeArray();

        ajaxRequest($form.attr('action'), "POST", data, function (rs) {
            if (rs.status) {
                var data = rs.data;
                App.Swal.success(rs.message, null, function () {
                    location.reload();
                });

            }
            else {
                var message = '';
                if (rs.errors) {
                    message = Object.keys(rs.errors).map(function (k) {
                        return rs.errors[k];
                    }).join("<br>");
                } else {
                    message = rs.message;
                }
                App.Swal.error(message);
            }
            $form.find('.btn-submit-form,button[type="submit"],input[type="submit"]').removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1);
            $form.attr('data-submitting', "")
        }, function (error) {
            App.Swal.error("Lỗi không xác định!");
            $form.find('.btn-submit-form,button[type="submit"],input[type="submit"]').removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1);
            $form.attr('data-submitting', "")
        });
    } catch (error) {
        App.Swal.error("Lỗi không xác định!");
        console.warn(error);
    }
};
var st_submitAndAlert = function (form, success, onError) {
    try {
        var $form = $(form);
        var data = $form.serializeArray();

        ajaxRequest($form.attr('action'), "POST", data, function (rs) {
            if (rs.status) {
                var data = rs.data;
                App.Swal.success(rs.message, null, function(){
                    return typeof success == "function" ? success(data) : null;
                });

            }
            else {
                var message = '';
                if (rs.errors) {
                    message = Object.keys(rs.errors).map(function (k) {
                        return rs.errors[k];
                    }).join("<br>");
                } else {
                    message = rs.message;
                }
                App.Swal.error(message);
            }
            $form.find('.btn-submit-form,button[type="submit"],input[type="submit"]').removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1);
            $form.attr('data-submitting', "")
        }, function (error) {
            App.Swal.error("Lỗi không xác định!");
            $form.find('.btn-submit-form,button[type="submit"],input[type="submit"]').removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1);
            $form.attr('data-submitting', "")
        });
    } catch (error) {
        App.Swal.error("Lỗi không xác định!");
        console.warn(error);
    }
};
function StyleTemplatePreview(selector, options) {
    var $el = $(selector);
    var $inputs = $el.find('.style-set-template-inputs');

    var $width = $inputs.find('#width');
    var $height = $inputs.find('#height');

    var $preview = $el.find('.style-set-template-preview');
    var $updateForms = $el.find('.style-template-item-config-update-form');
    var $itemUpdateForms = $el.find('.template-item-update-form');
    var installed = $el.length > 0;

    this.urls = {};
    this.init_list = ['urls'];

    this.deletingID = 0;

    var self = this;
    
    this.isInstalled = function(){
        return installed;
    };
    this.init = function (args) {
        App.setDefault(this, args || options);
        
        $width.on('change input', function () {
            self.updateWidth();
        })
        $height.on('change input', function () {
            self.updateHeight();
        })
        self.updateWidth();
        self.updateHeight();

        $inputs.find('#template-form').on("submit", function (ev) {
            ev.preventDefault();
            var $form = $(this);
            var data = $form.serializeArray();

            ajaxRequest($form.attr('action'), "POST", data, function (rs) {
                if (rs.status) {
                    var data = rs.data;
                    App.Swal.success(rs.message);
                    if (typeof success == "function") {
                        success(data);
                    }
                }
                else {
                    var message = '';
                    if (rs.errors) {
                        var messages = [];
                        for (const key in rs.errors) {
                            if (rs.errors.hasOwnProperty(key)) {
                                const error = rs.errors[key];
                                messages.push(error);
                            }
                        }
                        message = messages.join("<br>");
                    } else {
                        message = rs.message;
                    }
                    App.Swal.error(message);
                }
                $form.find('.btn-submit-form,button[type="submit"],input[type="submit"]').removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1);
                $form.attr('data-submitting', "")
            }, function (error) {
                App.Swal.error("Lỗi không xác định!");
                $form.find('.btn-submit-form,button[type="submit"],input[type="submit"]').removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1);
                $form.attr('data-submitting', "")
            });
        });



        $el.find('#create-style-item-config-form').on("submit", function (ev) {
            ev.preventDefault();
            st_submitAndRefresh(this);
            return false;
        });


        $updateForms.on("click", ".btn-delete-item", function (event) {
            event.preventDefault();
            var $inp = $(event.target);
            var $cfItem = $inp.closest('.style-item-config-update-form');
            var itemId = $cfItem.data('id');
            var url = $inp.attr('href');

            ajaxRequest(url, "POST", { id: itemId }, function (rs) {
                if (rs.status) {
                    $('#style-item-config-preview-' + itemId).remove();
                    $('#style-vonfirm-form-' + itemId).remove();

                }
                else {
                    App.Swal.error(rs.message);
                }

            }, function (error) {
                App.Swal.error("Lỗi không xác định!");
            });
            return false;
        });
        $updateForms.on("change input keyup", "input", function (event) {
            var $inp = $(event.target);
            var $form = $inp.closest('.style-template-item-config-update-form');
            var itemId = $form.data('id');
            var prop = $inp.data('name');
            var checked = $form.find('input[name="use_custom_config"]:checked').length > 0;
            if (['top', 'left', 'width', 'heght'].indexOf($inp.attr('name')) == -1 || !checked) {
                if (checked) {
                    var c = {};
                    $form.find('.style-item-preview-group input').each(function (i, el) {
                        var $input = $(el);
                        var p = $input.data('name');
                        var v = Number($input.val());
                        if (isNaN(v)) v = 40;
                        c[p] = v + "px";
                    });

                    $('#style-item-config-preview-' + itemId).css(c);
                }
                return;
            }
            var val = Number($inp.val());

            if (isNaN(val)) val = 40;

            var css = {};
            css[prop] = val + "px";
            $('#style-item-config-preview-' + itemId).css(css);
        });
        $updateForms.on("submit", function (ev) {
            ev.preventDefault();
            
            st_submitAndAlert(this);
            return false;
        });

        $el.find('.style-template-item-config-create-form').on("submit", function (event) {
            event.preventDefault();
            st_submitAndRefresh(this);
            return false;
        });

        $(document).on("submit", '.template-item-update-form', function (event) {
            event.preventDefault();
            st_submitAndAlert(this, function(data){
                var detail = data.detail?data.detail:data;
                var $head = $('#style-template-items_'+detail.template_item_config_id+'-'+detail.id+'_list-update_head');
                $head.find('.thumbnails img.front-image').attr('src', detail.front_image_url);
                $head.find('.thumbnails img.back-image').attr('src', detail.back_image_url);
            });
            return false;
        });


        $(document).on("submit", '.template-item-create-form', function (event) {
            event.preventDefault();
            var $form = $(this);
            var data = $form.serializeArray();

            ajaxRequest($form.attr('action'), "POST", data, function (rs) {
                if (rs.status) {
                    var data = rs.data;
                    App.Swal.success(rs.message);
                    if (data.detail && data.item_form) {
                        $('#style-template-items_' + data.detail.template_item_config_id + '_list').append(data.item_form);

                        var tag = $('#style-template-item-'+data.detail.template_item_config_id+'-'+data.detail.id+'-update .crazy-tag');
                        if (tag.length) {
                            tag.each(function (i, el) {
                                App.tagInput.add(el);
                            });
                        }
                    }
                }
                else {
                    var message = '';
                    if (rs.errors) {
                        var messages = [];
                        for (const key in rs.errors) {
                            if (rs.errors.hasOwnProperty(key)) {
                                const error = rs.errors[key];
                                messages.push(error);
                            }
                        }
                        message = messages.join("<br>");
                    } else {
                        message = rs.message;
                    }
                    App.Swal.error(message);
                }
                $form.find('.btn-submit-form,button[type="submit"],input[type="submit"]').removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1);
                $form.attr('data-submitting', "")
            }, function (error) {
                App.Swal.error("Lỗi không xác định!");
                $form.find('.btn-submit-form,button[type="submit"],input[type="submit"]').removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1);
                $form.attr('data-submitting', "")
            });
            return false;
        });

        $(document).on('click', '.btn-delete-template-item', function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            var item_id = form.data('item-id');
            self.deleteItem(item_id);
            return false;
        });



    };
    
    this.deleteItem = function(id){
        if(this.deletingID == id) return false;
        App.Swal.confirm("Bạn có chắc muốn xóa item này?", function(){
            App.Swal.showLoading(50000);
            App.api.post(self.urls.deleteItem, {id: id})
                .then(rs => {
                    if (!rs || !rs.status) {
                        if (!rs) {
                            App.Swal.error("Lỗi không xác định");
                            return false;
                        }
                        if (rs.errors) {
                            var errors = Object.keys(rs.errors).map(k => rs.errors[k]);
                            if (errors.length) {
                                return App.Swal.errorDetail(rs.message, errors.join("\r\n"))
                            }
                        }
                        return App.Swal.warning(rs.message ? rs.message : 'Lỗi không xác định');
                    }
                    App.Swal.success("Tạo Style mới thành công!");
                    var data = rs.data;
                    
                
                    $('#style-template-item-'+data.template_item_config_id+'-'+data.id+'-update').remove()

                })
                .catch(e => {
                    console.warn(e);
                    App.Swal.error("Lỗi không xác định");
                });
        })
        
    };
    this.updateWidth = function () {
        var w = parseInt($width.val());
        if (w < 100) w = 100;
        $preview.css({
            width: w + 'px'
        });
    };
    this.updateHeight = function () {
        var w = parseInt($height.val());
        if (w < 100) w = 200;
        $preview.css({
            height: w + 'px'
        });
    };
    this.onAvatarInputChange = function (f) {
        $preview.css({
            backgroundImage: "url('" + f.url + "')"
        });
    }



    this.save = function (data, success) {
        App.modal.hide();

    };

    this.changeTemplate = function (url) {
        if (url == 'new') {
            App.modal.show('style-set-template-form-modal');
            return false;
        }
        window.location.replace(url);
    }

    this.addTemplate = function(form){
        if(typeof this.urls != "object" || typeof this.urls.detail == "undefined") return st_submitAndRefresh(form, function(){
            window.StyleSetTemplate.addTemplate(this)
        });
        return st_submitAndAlert(form, function(data){
            top.location.replace(App.str.replace(self.urls.detail, 'TEMPLATE_ID', data.id))
        }, function(){
            window.StyleSetTemplate.addTemplate(this)
        });
    };
}

$(function () {

    var initData = {};
    if(typeof style_template_data != "undefined"){
        initData = style_template_data;
    }
    window.StyleSetTemplate = new StyleTemplatePreview('.style-set-template-page');
    window.StyleSetTemplate.init(initData);

    $('.btn-add-item').on("click", function (event) {
        event.preventDefault();
        App.modal.show('style-set-template-form-modal');
        return false;
    });

    $('#create-style-set-template-form').on("submit", function (ev) {
        ev.preventDefault();
        window.StyleSetTemplate.addTemplate(this);
        return false;

    });


})