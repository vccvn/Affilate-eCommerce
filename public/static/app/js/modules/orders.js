
// giỏ hàng
App.extend({
    orders: {
        urls: {},
        init_list: ["urls"],
        cancel: function (id, code, success) {
            App.api.post(this.urls.cancel, {id:id}).then(function (result) {
                if(result.status){
                    App.Swal.alert("Đã hủy đơn hàng " + code + " thành công!", null, function (){
                        top.location.reload();
                    });
                    $('#order-item-' + id + ' .order-status').html('Đã huỷ')
                    if(typeof success == "function"){
                        success();
                        
                    }
                }else{
                    App.popup.alert(result.message);
                }
            }).catch(function(err){
                App.popup.alert("Lỗi không xác định");
            });

        }
    }
    // end orders
});


if (typeof window.orderInit == "function") {
    if (typeof window.orderInit == "function") {
        window.orderInit();
    }
    $(document).on('click', prefixClass+"btn-cancel-order", function(e){
        e.preventDefault();
        var self = this;
        var id = $(this).data('id');
        var code = $(this).data('order-code');
        App.popup.confirm("Bạn có chắc chắn muốn hủy đơn hàng "+code+" không?", function(){
            App.orders.cancel(id, code, function(){
                $(self).remove();
            });
        });
        return false;
    });
}

