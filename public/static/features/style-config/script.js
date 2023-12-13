function StyleConfigPreview(selector){
    var $el = $(selector);
    var $inputs = $el.find('.style-set-config-inputs');

    var $width = $inputs.find('#width');
    var $height = $inputs.find('#height');

    var $preview = $el.find('.style-set-config-preview');
    var self = this;
    var $updateForms = $el.find('.style-item-config-update-form');
    this.init = function(){

        $width.on('change input', function(){
            self.updateWidth();
        })
        $height.on('change input', function(){
            self.updateHeight();
        })
        self.updateWidth();
        self.updateHeight();

        $el.find('#create-style-item-config-form').on("submit", function(ev){
            ev.preventDefault();
            var $form = $(this);
            var data = $form.serializeArray();

            ajaxRequest($form.attr('action'), "POST", data, function(rs){
                if(rs.status){
                    var data = rs.data;
                    App.Swal.success(rs.message, function(){
                        top.location.reload()
                    });
                    if(typeof success == "function"){
                        success(data);
                    }
                }
                else{
                    var message = '';
                    if(rs.errors){
                        var messages = [];
                        for (const key in rs.errors) {
                            if (rs.errors.hasOwnProperty(key)) {
                                const error = rs.errors[key];
                                messages.push(error);
                            }
                        }
                        message = messages.join("<br>");
                    }else{
                        message = rs.message;
                    }
                    App.Swal.error(message);
                }
                $form.find('.btn-submit-form,button[type="submit"],input[type="submit"]').removeClass("m-loader m-loader--right m-loader--light").attr("disabled",!1);
            }, function(error){
                App.Swal.error("Lỗi không xác định!");
                $form.find('.btn-submit-form,button[type="submit"],input[type="submit"]').removeClass("m-loader m-loader--right m-loader--light").attr("disabled",!1);
            });
        });
        

        $updateForms.on("click", ".btn-delete-item", function(event){
            event.preventDefault();
            var $inp = $(event.target);
            var $cfItem = $inp.closest('.style-item-config-update-form');
            var itemId = $cfItem.data('id');
            var url = $inp.attr('href');

            ajaxRequest(url, "POST", {id: itemId}, function(rs){
                if(rs.status){
                    $('#style-item-config-preview-' + itemId).remove();
                    $('#style-vonfirm-form-' + itemId).remove();
                    
                }
                else{
                    App.Swal.error(rs.message);
                }
               
            }, function(error){
                App.Swal.error("Lỗi không xác định!");
            });
            return false;
        });
        $updateForms.on("change input keyup", "input", function(event){
            var $inp = $(event.target);
            var itemId = $inp.closest('.style-item-config-update-form').data('id');
            var prop = $inp.data('name');
            
            if($inp.attr('name') == 'name'){
                $('#style-item-config-preview-' + itemId + " .name").html($inp.val());
                return;
            }
            var val = Number($inp.val());
            
            if(isNaN(val)) val = 40;
            
            var css = {};
            css[prop] = val + "px";
            $('#style-item-config-preview-' + itemId).css(css);
        });
        $updateForms.on("submit", function(ev){
            ev.preventDefault();
            var $form = $(this);
            var data = $form.serializeArray();

            ajaxRequest($form.attr('action'), "POST", data, function(rs){
                if(rs.status){
                    var data = rs.data;
                    App.Swal.success(rs.message);
                    if(typeof success == "function"){
                        success(data);
                    }
                }
                else{
                    var message = '';
                    if(rs.errors){
                        var messages = [];
                        for (const key in rs.errors) {
                            if (rs.errors.hasOwnProperty(key)) {
                                const error = rs.errors[key];
                                messages.push(error);
                            }
                        }
                        message = messages.join("<br>");
                    }else{
                        message = rs.message;
                    }
                    App.Swal.error(message);
                }
                $form.find('.btn-submit-form,button[type="submit"],input[type="submit"]').removeClass("m-loader m-loader--right m-loader--light").attr("disabled",!1);
            }, function(error){
                App.Swal.error("Lỗi không xác định!");
                $form.find('.btn-submit-form,button[type="submit"],input[type="submit"]').removeClass("m-loader m-loader--right m-loader--light").attr("disabled",!1);
            });
        });

    }
    this.updateWidth = function(){
        var w = parseInt($width.val());
        if(w<100) w = 100;
        $preview.css({
            width: w+'px'
        });
    };
    this.updateHeight = function(){
        var w = parseInt($height.val());
        if(w<100) w = 200;
        $preview.css({
            height: w+'px'
        });
    };
    this.onAvatarInputChange = function(f){
        $preview.css({
            backgroundImage: "url('" + f.url + "')"
        });
    }

    

    this.save = function(data, success){
        App.modal.hide();

    };
}

$(function(){
    $('.style-set-config').each(function(i, e){
        window.StyleCobfig = new StyleConfigPreview(e);
        window.StyleCobfig.init();
    })
})