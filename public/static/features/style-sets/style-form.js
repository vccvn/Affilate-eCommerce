$(function () {

    function StyleForm(selector, templateData) {
        var mapData = {};
        var $el, $components, $preview, $items;

        isFirst = false;
        var self = this;
        this.setData = function (data) {
            if (typeof templateData != "object") return false;
            mapData = {};
            mapData.itemConfigs = {};
            if (data.itemConfigs) {
                for (let index = 0; index < data.itemConfigs.length; index++) {
                    const itemConfig = data.itemConfigs[index];
                    var itemMap = {};
                    if (itemConfig.templateItems && itemConfig.templateItems.length) {
                        itemConfig.templateItems.map(function (item) {
                            itemMap[item.id] = item;
                        })
                    }
                    itemConfig.items = itemMap;

                    mapData.itemConfigs[itemConfig.id] = itemConfig;
                }
            }
        };
        this.getData = function () {
            return mapData;
        };

        this.setSelector = function (s) {
            $el = $(s);
            $components = $el.find('.style-form-components');
            $preview = $components.find('.style-preview');
            $items = $components.find('.style-items');
            this.addEvents();
        };

        this.changeItemImage = function (itemConfigId, templateItemId) {
            if (
                typeof mapData == "object" &&
                typeof mapData.itemConfigs == "object" &&
                typeof mapData.itemConfigs[itemConfigId] == "object" &&
                typeof mapData.itemConfigs[itemConfigId].items == "object" &&
                typeof mapData.itemConfigs[itemConfigId].items[templateItemId] == "object"
            ) {
                var item = mapData.itemConfigs[itemConfigId].items[templateItemId];

                $('#preview-item-back-' + itemConfigId).html('<img src="' + item.back_image_url + '" />');
                $('#preview-item-front-' + itemConfigId).html('<img src="' + item.front_image_url + '" />');
            }
        };
        this.init = function (data) {
            this.setData(data ? data : templateData);
            this.setSelector(selector);

            if (!isFirst) {
                isFirst = true;
                $('.style-form-components .style-items .template-item input[type=radio]:checked').each(function (i, inp) {
                    var $this = $(inp).closest('.template-item');
                    var itemConfigId = $this.data('item-config-id'), templateItemId = $this.data('item-id');
                    self.changeItemImage(itemConfigId, templateItemId);
                })
                $(document).on("change", '.style-form-components .style-items .template-item input[type=radio]', function (event) {
                    var $this = $(this).closest('.template-item');
                    var itemConfigId = $this.data('item-config-id'), templateItemId = $this.data('item-id');
                    self.changeItemImage(itemConfigId, templateItemId);
                })
                this.addMobileSlide('.tab-contents .tab-item.active .style-item-slides .slides');
                var activedList = [$('.style-items .tab-nav>ul>li>a.active').data('id')];
                $(document).on("click", ".style-items .tab-nav>ul>li>a", function (event) {
                    event.preventDefault();
                    var $this = $(this);
                    if ($this.hasClass('active')) return false;
                    $this.closest('.tab-nav>ul').find('li>a').removeClass('active');
                    $this.addClass("active");
                    var tabId = $this.attr('href');
                    var itemId = $this.data('id');
                    var $styleItems = $this.closest('.style-items');
                    $styleItems.find(".tab-contents .tab-item").removeClass('active');
                    var $activeTab = $styleItems.find(tabId);
                    if (activedList.indexOf(itemId) == -1) {
                        activedList.push(itemId);
                        var $slides = $(tabId + ' .style-item-slides .slides');
                        if ($slides.length) {
                            var html = $slides.html();

                            $slides.html('<div class="alert alert-success text-center">Đang tải... </div>');
                            $activeTab.addClass('active');
                            setTimeout(function () {
                                $slides.html(html);
                                self.addMobileSlide($slides[0]);
                            }, 200);

                        } else {
                            $activeTab.addClass('active');
                        }
                    } else {
                        $activeTab.addClass('active');
                    }


                    return false;
                });



            }
            $el.on("click", '.btn-save-style', function (event) {
                event.preventDefault();
                var name = $(this).data('name');
                self.saveOnMobile(name);
                return false;
            });



            $el.on("click", ".attr-nav-item", function (event) {
                event.preventDefault();
                var $wrapper = $(this).closest('.attribute-wrapper');

                var $nav = $(this).closest('.attribute-nav');
                $wrapper.find('.attribute-item-block').hide();
                var isActive = $(this).hasClass('active');
                $nav.find('.attr-nav-item').removeClass('active');
                if(isActive) return false;
                $(this).addClass('active');
                $wrapper.find($(this).attr('href')).show(300)

            });
        }

        this.addEvents = function () {
            // $items.on("click", ".template")
        };

        this.addMobileSlide = function (select) {
            var $slider = $(select);
            if ($slider.length) {
                $slider.slick({
                    dots: false,
                    infinite: false,
                    speed: 500,
                    arrows: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    responsive: [
                        {
                            breakpoint: 1630,
                            settings: {
                                slidesToShow: 4,
                            },
                        },
                        {
                            breakpoint: 1366,
                            settings: {
                                slidesToShow: 3,
                            },
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: 3,
                            },
                        }
                    ]
                });
            }
        };

        this.saveOnMobile = async function () {
            const { value: StyleName } = await Swal.fire({
                title: 'Lưu Style',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                inputPlaceholder: "Tên Style",
                inputValue: $el.find('#input-style-name').val(),
                showCancelButton: false,
                confirmButtonText: 'Xác nhận',
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                customClass: {
                    container: "save-style-confirm",
                    input: 'form-control',
                    confirmButton: 'btn btn-theme btn-colored-default',
                    title: "popup-title"
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'Vui lòng nhập tên style'
                    }
                }
            });
            if (StyleName) {
                $el.find('#input-style-name').val(StyleName);
                App.Swal.showLoading();
                $el.submit();
            }

        }
    }

    var styleForm = new StyleForm('#personal-style-set-form', window.style_template_data);
    styleForm.init();
    App.extend({
        styleForm: styleForm
    })



});