App.extend({
    subcribes: {
        urls: {},
        init_list: ["urls"],
        subscribe: function (email) {
            return App.ajax(this.urls.subscribe?this.urls.subscribe:this.urls.subcribe, {
                method: "POST",
                dataType: "json",
                data: {email:email}
            }).then(function (result) {
                if(result.status){
                    App.popup.alert("Đăng ký theo dõi thành công!");
                    return true;
                }else{
                    var message = '';
                    if(result.errors){
                        var errors = result.errors;
                        var messages = [];
                        for (const key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                const error = errors[key];
                                messages.push(error);
                            }
                        }
                        message = messages.join("<br>");
                    }else{
                        message = result.message;
                    }
                    App.popup.alert(message);
                }
            }).catch(function(err){
                App.popup.alert("Lỗi không xác định");
            });

        }
    },
    subcribe: function(email){
        return this.subscribe(email);
    }
    // end subcribes
});


if (typeof window.subcribeInit == "function" || typeof window.subscribeInit == "function") {
    if (typeof window.subcribeInit == "function") {
        window.subcribeInit();
    }
    if (typeof window.subscribeInit == "function") {
        window.subscribeInit();
    }
    var subcribeForm = $(prefixClass+"subcribe-form,"+prefixClass+"subscribe-form");
    if(subcribeForm.length){
        subcribeForm.submit(function (e) {
            e.preventDefault();
            var self = this;
            App.subcribes.subscribe($(this).find('input[name="email"]').val())
            .then(function(res){
                $(self).find('input[name="email"]').val("");
            });
            return false;
        });
    }
    var subcribeblock = $("div"+ prefixClass+"subcribe-form,"+"div"+ prefixClass+"subscribe-form");
    if(subcribeblock.length){
        subcribeblock.each(function(i, el){
            var $el = $(el);

            $el.find(prefixClass+"btn-subcribe,"+prefixClass+"btn-subscribe").on("click", function(e){
                App.subcribes.subscribe($el.find('input[name="email"]').val())
                .then(function(res){
                    $el.find('input[name="email"]').val("");
                });
            })
        });
    }
    
}

