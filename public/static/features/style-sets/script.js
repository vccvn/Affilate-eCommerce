function ProductItem(selector) {
    var $el = $(selector);
    this.$el = $el;
    this.name = $el.data('name');
    this.maxIndex = parseInt($el.data('max-index'));
    this.nextIndex = this.maxIndex;
    this.addProductUrl = $el.data('add-url');
    this.search = $el.find('#' + $el.data('name') + '-items');
    this.$itemBlock = $el.find('.product-items');
    var self = this;
    this.init = function () {
        if ($el.find('.next-index').length) {
            let nextIndex = $el.find('.next-index').data('next-index') || 0;
            let nI = parseInt(nextIndex);
            if (!isNaN(nI)) {
                this.nextIndex = nI;
            }
        }
        $el.on('click', '.btn-add-product-item', function () {
            let product_id = self.search.val();
            if (!product_id || product_id == "0") return false;
            let data = {
                product_id: product_id,
                index: self.nextIndex,
                name: self.name
            }

            App.api.get(self.addProductUrl, data).then(function (res) {
                if (res.status) {
                    self.nextIndex++;
                    self.$itemBlock.append(res.data);
                }
            });
        });
        $el.on('click', '.btn-delete-style-set-product-item', function () {
            let index = $(this).data('index');
            $el.find('#style-set-item-' + index).hide(300, function () {
                $(this).remove();
            });
        });
    };
}




App.styleSetProducts = {
    list: {},
    add: function (selector) {
        var id = $(selector).data('id');
        this.list[id] = new ProductItem(selector);
        this.list[id].init()
    },
    /**
     * lấy thẻ select
     * @param {string} id 
     * 
     * @return {CrazySelect}
     */
    getTag: function (id) {
        if (id) {
            if (typeof this.list[id] != "undefined") {
                return this.list[id];
            }
        }
        return null;
    },

    changeOptions: function (id, options) {
        if (typeof this.list[id] != "undefined") {
            this.list[id].changeOptions(options);
        }
    },

    addOption: function (id, value, text) {
        if (typeof this.list[id] != "undefined") {
            this.list[id].addOption(value, text);
        }
    },
    ajaxSearch: function (id, keywords, callback) {
        if (typeof this.list[id] != "undefined") {
            this.list[id].ajaxSearch(keywords, callback);
        }
    },
    staticSearch: function (id, keywords) {
        if (typeof this.list[id] != "undefined") {
            this.list[id].staticSearch(keywords);
        }
    },
    deactive: function (id) {
        if (typeof this.list[id] != "undefined") {
            this.list[id].deactive();
        }
    },
    active: function (id, value) {
        if (typeof this.list[id] != "undefined") {
            this.list[id].active(value);
        }
    },
    getValue: function (id, defaultValue) {
        var val = !defaultValue ? null : defaultValue;
        if (typeof this.list[id] != "undefined") {
            val = this.list[id].val();
        }
        return val;
    }
};


$(function () {
    var $cs = $('.crazy-products');
    if ($cs.length) {
        $cs.each(function (i, el) {
            App.styleSetProducts.add(el);
        });
    }

});
