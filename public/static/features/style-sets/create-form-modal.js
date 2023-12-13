$(function () {
    function objectifyForm(form) {
        var formArray = $(form).serializeArray();

        //serialize data function
        var returnArray = {};
        for (var i = 0; i < formArray.length; i++) {
            returnArray[formArray[i]['name']] = formArray[i]['value'];
        }
        return returnArray;
    }

    function resetFormData(form) {
        $(form).find('input[type="text"],input[type="number"],textarea').val("");
        $(form).find('input[type="radio"],input[type="checkbox"]').prop("checked", false);
    }
    var $stepOne = $('.style-modal .form-section.step-one');
    var $stepTwo = $('.style-modal .form-section.step-two');
    var $stepOneForm = $('#create-style-modal-form-step-one');
    var $stepTwoForm = $('#create-style-modal-form-step-two');


    function showCreateModal() {
        resetFormData($stepOneForm);
        resetFormData($stepTwoForm);
        App.modal.show('createStyleFormModal');
        $stepTwo.removeClass('active');
        $stepOne.addClass('active');
    }

    var sampleSlider = $stepTwoForm.find('.sample-style-groups .sample-item-slides');
    var bodyShapeSliderContent = $stepTwoForm.find('.body-shape-groups').html();
    var sampleSliderContent = sampleSlider.length > 0 ? sampleSlider.html() : '';
    function goNext() {
        $stepTwoForm.find('.body-shape-groups').html('');
        $stepOne.removeClass('active');
        $stepTwo.addClass('active');
        if (sampleSlider.length) {
            sampleSlider.html('');
        }
        setTimeout(() => {
            $stepTwoForm.find('.body-shape-groups').html(bodyShapeSliderContent);
            sampleSlider.html(sampleSliderContent);
            setTimeout(() => {
                $stepTwoForm.find('.body-shape-groups .body-shape-sliders').slick({
                    dots: false,
                    infinite: false,
                    speed: 500,
                    arrows: false,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 4,
                            },
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 4,
                            },
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 3,
                            },
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: 2,
                            },
                        }
                    ]
                });

                if (sampleSlider.length) {
                    sampleSlider.find('.slides').slick({
                        dots: false,
                        infinite: false,
                        speed: 500,
                        arrows: false,
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        responsive: [
                            {
                                breakpoint: 1200,
                                settings: {
                                    slidesToShow: 4,
                                },
                            },
                            {
                                breakpoint: 992,
                                settings: {
                                    slidesToShow: 4,
                                },
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 3,
                                },
                            },
                            {
                                breakpoint: 576,
                                settings: {
                                    slidesToShow: 2,
                                },
                            }
                        ]
                    });
                }

            }, 200);
        }, 100);
    }

    function submitMyStyle(url, data) {
        App.Swal.showLoading(50000);
        App.api.post(url, data)
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
                App.Swal.success("Tạo Style mới thành công!", null, () => {
                    App.Swal.showLoading(50000);
                    setTimeout(() => {
                        top.location.href = rs.data.redirect;
                    }, 1000);
                });
            })
            .catch(e => App.Swal.error("Lỗi không xác định"));
    }


    $stepOneForm.on("submit", function (e) {
        e.preventDefault();
        var data = objectifyForm(this);
        if (['auto', 'manual'].indexOf(data.mode) == -1) {
            App.Swal.warning("Vui lòng chọn cách thức");
            return;
        }
        if (!data.name) {
            App.Swal.warning("Vui lòng nhập tên style");
            return;
        }
        if (data.mode == 'manual') {
            App.Swal.showLoading(50000);
            setTimeout(() => {
                top.location.href = $stepOneForm.data('create-style-url') + "?name=" + data.name;
            }, 1000);
        } else {
            $('#step-2-input-style-name').val(data.name);
            goNext()

        }
        return false;
    });
    $stepTwoForm.on("submit", function (e) {
        e.preventDefault();
        var data = objectifyForm(this);
        if (!data.name) {
            App.Swal.warning("Vui lòng nhập tên style");
            return;
        }
        if (!data.body_shape_id) {
            App.Swal.warning("Vui lòng chọn Dáng người");
            return;
        }

        if (!data.sample_id) {
            App.Swal.warning("Vui lòng chọn kiểu mẫu");
            return;
        }
        submitMyStyle($stepTwoForm.attr('action'), data);


        return false;
    })

    $('.style-modal .form-section.step-two input[type="range"]').each(function (i, el) {
        var $el = $(el);
        var $output = $el.closest(".col-input").find(".output span");
        $el.rangeslider({
            polyfill: false,
            onInit: function () {
                $output.html($el.val());
            },
            onSlide: function (position, value) {
                //console.log('onSlide');
                // console.log('position: ' + position, 'value: ' + value);
                $output.html(value);
            },
            onSlideEnd: function (position, value) {
                //console.log('onSlideEnd');
                //console.log('position: ' + position, 'value: ' + value);
            }
        });
    })


    $(document).on("click", '.btn-menu-add-style a, .btn-add-new-style', function () {
        showCreateModal();
        return false;
    })


})