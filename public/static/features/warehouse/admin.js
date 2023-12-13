$(function(){
    var Warehouse = function (options){
        this.urls = {
            detail: ""
        };

        this.init_list = ['urls'];
        this.options = options;
        this.init = args => {
            App.setDefault(this, args || this.options);
            this.onStart();
        };

        this.onStart = function(){
            $(document).on('click', '.btn-toggle-desc', function (e){
                var wrapper = $(this).closest('.desc-wrapper');
                if(wrapper.hasClass('full-desc')){
                    wrapper.removeClass('full-desc');
                    $(this).html("Xem thêm");
                }else{
                    wrapper.addClass('full-desc');
                    $(this).html("ẩn bớt");
                }
            })
        }
    }
})