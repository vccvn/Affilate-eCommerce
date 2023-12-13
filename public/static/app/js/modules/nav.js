$(function () {
    const Nav = function (options) {
        this.urls = {};
        this.disableBack = false;
        this.message = "Bạn không thể thực hiện hành động này";
        this.init_list = ["urls", "message", 'disableBack'];
        this.options = options;
        this.canChange = true;
        var self = this;
        this.calledInit = false;
        this.init = args => {
            var arg = Object.assign({}, typeof this.options == "object" ? this.options : {}, typeof args == "object" ? args : {});

            App.setDefault(this, arg);
            this.onStart();
            this.calledInit = true;
        };

        this.onStart = function () {
            if (this.disableBack || (typeof window.disableBack != "undefined" && window.disableBack)) {
                self.disable();
            }
        };

        
        this.HaHa = function(){
            var a = document.createElement('a');
            self.canChange = true;
            for (let index = 0; index < 20; index++) {
                setTimeout(function(){
                    a.setAttribute('href', "#step-" + index);
                    a.click();
                }, 20 * index);
            }
        }

        this.disable = function () {

            jQuery(document).ready(function ($) {
                var a = document.createElement('a');
                var itd = 0;
                self.canChange = true;
                for (let index = 0; index < 20; index++) {
                    setTimeout(function(){
                        a.setAttribute('href', "#step-" + index);
                        a.click();
                    }, 20 * index);
                }
                setTimeout(() => {
                    
                    window.addEventListener("hashchange",  function () {
                        if(self.canChange) return;
                        itd++;

                        self.canChange = true;
                        var urlkeys = Object.keys(self.urls);
                        var url = urlkeys.length > 0 ? self.urls[urlkeys[0]] : '';
                        if(url){
                            alert(self.message);
                            top.location.href = url;
                        }else{
                            self.canChange = true;
                            a.setAttribute('href', "#step-" + itd);
                            a.click();
                            self.canChange = false;
                        }
                        
                    });
                    self.canChange = false;
                    setTimeout(() => {
                        self.HaHa();    
                        setTimeout(() => {
                            self.canChange = false; 
                        }, 20*26);
                    }, 50*26);
                }, 20*25);
                return;
                if (window.history && window.history.pushState) {

                    for (let index = 0; index < 20; index++) {
                        setTimeout(function(){
                            window.history.pushState('forward', null, '#step-' + index);
                        }, 40 * index);
                    }

                    setTimeout(() => {
                        $(window).on('popstate', function () {
                            var urlkeys = Object.keys(self.urls);
                            var url = urlkeys.length > 0 ? self.urls[urlkeys[0]] : '/';
                            alert(self.message);
                            top.location.href = url;
                        });
    
                    }, 40 * 25);
                    
                }
            });
        }
    };






    let options = {};
    if (typeof nav_data == 'object') {
        options = nav_data;
    }
    else if (typeof crazy_data == 'object') {
        let urls = {};
        let list = ["next", "back"];
        for (let i = 0; i < list.length; i++) {
            const act = list[i];
            if (typeof crazy_data["nav_" + act + "_url"] == "string") {
                urls[act + "_url"] = crazy_data["nav_" + act + "_url"];
            }
        }
        options.urls = urls;
    }


    let nav = new Nav(options);

    App.extend({
        nav: nav
    });
    if (typeof window.navInit == "function") {
        window.navInit();
        window.navInit = null;
        if (!nav.calledInit) {
            nav.init();
        }

    } else {
        nav.init();
    }

});
