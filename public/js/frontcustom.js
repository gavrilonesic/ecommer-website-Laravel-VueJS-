var productPrice = 0;
wow = new WOW({
    boxClass: 'wow', // default
    animateClass: 'animated', // default
    offset: 0, // default
    mobile: true, // default
    live: true // default
});
WebFont.load({
    google: {
        "families": ["Nunito"]
    },
    custom: {
        "families": ["simple-line-icons", 'GothamLight'],
        urls: ["/css/simplelineicons.css"]
    },
    active: function() {
        sessionStorage.fonts = true;
    }
});
/**
 * Check if an element is in the visible viewport
 * @param {jQuery|HTMLElement} el
 * @return boolean
 */
var IsInViewport = function(el) {
    if (typeof jQuery === "function" && el instanceof jQuery) el = el[0];
    var rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
};
function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function menuResize() {
    if ($(window).width() > 1024) {
        $(window).scroll(function() {
            if ($(window).scrollTop() >= 200) {
                $('body').addClass('fixed-header');
            } else {
                $('body').removeClass('fixed-header');
            }
        });
    }
}
$('.mob-mwnu-arrow').click(function(e) {
    e.preventDefault();
    var $this = $(this);
    if ($this.next().hasClass('active')) {
        $this.next().removeClass('active');
        $this.parent().removeClass('active');
        $this.next().slideUp(10);
    } else {
        $this.parent().parent().find('li .dropdown-menu').removeClass('active');
        $this.parent().parent().find('li').removeClass('active');
        $this.parent().parent().find('li .dropdown-menu').slideUp();
        $this.next().toggleClass('active');
        $this.parent().toggleClass('active');
        $this.removeClass('on');
        $this.next().slideToggle(10);
    }
});
$('.collapse').on('shown.bs.collapse', function() {
    $(this).parent().addClass('active');
});
$('.collapse').on('hidden.bs.collapse', function() {
    $(this).parent().removeClass('active');
});
$('[data-toggle="tooltip"]').tooltip();
// Open Product Quick View
$('body').on('click', '.product-quick-view', function(e) {
    $('#product-quick-view-popup').load($(this).attr("data-url"), function(result) {
        $('#product-quick-view-popup').modal({
            show: true
        });
    });
});
$('body').on('click', '.add-to-wishlist', function(e) {
    $.ajax({
        type: "GET",
        url: '/add-to-wishlist',
        dataType: "json",
        data: {
            'product': $(this).attr('data-product')
        }, // serializes the form's elements.
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.login) {
                window.location = response.login;
                return;
            } else if (response.status) {
                $('.close').trigger('click');
            }
            flashMessage(response.type, response.message);
        }
    });
});
$('body').on('change', '.quantity-count', function() {
    try {
        if ($("#quantity").length) {
            if ($("#quantity").val() == 0) $("#quantity").val('1');
            calculatePrice();
        } else {
            incDecQuantity($(this), true);
        }
    } catch (e) {

    }
});
$('body').on('change', '.quick-quantity-count', function() {
    try {
        if ($("#quick-quantity").length) {
            if ($("#quick-quantity").val() == 0) $("#quick-quantity").val('1');
            calculatePriceQuick()
        } else {
            incDecQuantity($(this), true);
        }
    } catch (e) {

    }
});
// quantity plus minus
$('body').on('click', '.icon-plus-quantity', function() {
    try {
        if ($("#quantity").length) {
            var quantity = parseInt($('#quantity').val());
            if (existQuantity > quantity && maximumQuantity > quantity) {
                $('.quantity-count').val(quantity + 1);
                $('.quantity-count').text(quantity + 1);
                calculatePrice();
            }
        } else {
            incDecQuantity($(this), 1);
        }
    } catch (e) {

    }
});
$('body').on('click', '.icon-minus-quantity', function() {
    try {
        if ($("#quantity").length) {
            var quantity = parseInt($('#quantity').val());
            if (quantity > 1) {
                $('.quantity-count').val(quantity - 1);
                $('.quantity-count').text(quantity - 1);
            }
            calculatePrice();
        } else {
            incDecQuantity($(this), -1);
        }
    } catch (e) {
        
    }
});
$('body').on('click', '.checking-cart', function(e) {
    var $this = $(this);
    $.ajax({
        type: "POST",
        url: $(this).data('url'),
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.attribute) {
                $this.parent().parent('div').find('.product-quick-view').trigger('click');
            } else if (response.status) {
                $('.close').trigger('click');
                $("#cart-count").text(response.count)
                flashMessage(response.type, response.message);
            } else {
                flashMessage(response.type, response.message);
            }
        }
    });
});

$('body').on('click', '#product-quick-view-popup .quick-add-to-cart', function(e) {
    var $this = $(this);
    var form = $("#quick-add-to-cart-form");

    $.ajax({
        type: "POST",
        url: '/cart/add-to-cart',
        dataType: "json",
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            triggerCheckoutEvent(1)

            if (response.count) {
                $("#cart-count").text(response.count)
            }
            $('.close').trigger('click');
            flashMessage(response.type, response.message);
        }
    });
});

$('body').on('change', '#product-quick-view-popup .attribute-option-change', function(e) {
    var $this = $(this);
    var form = $("#quick-add-to-cart-form");
    $.ajax({
        type: "POST",
        url: '/product/update-product-detail',
        dataType: "json",
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.image) {
                $("div.quick-img-div").find('img').attr('src', response.image);
                $('span.quick-weight').text(response.weight);
                existQuantity = response.quantity;
                if (response.inventory_tracking == 1 && response.quantity == 0) {
                    existQuantity = 1;
                    $('#quick-out-of-stock').show();
                    $('.quick-add-to-cart').attr('disabled', true);
                } else {
                    //maximumQuantity = parseInt(response.quantity) 1 ? ($quantity > config('constants.MAXIMUM_QUANTITY_PER_PRODUCT') ? config('constants.MAXIMUM_QUANTITY_PER_PRODUCT') : $quantity)}})
                    $('#quick-out-of-stock').hide();
                    $('.quick-add-to-cart').attr('disabled', false);
                }
                if (response.inventory_tracking == 0) {
                    existQuantity = maximumQuantity;
                }
                var quantity = parseInt($('#quick-quantity').val());
                if (existQuantity < quantity) {
                    $('#quick-quantity').val(existQuantity);
                    $('.quick-quantity-count').val(existQuantity);
                    $('.quick-quantity-count').text(existQuantity);
                }
                productPrice = parseFloat(response.price).toFixed(2);
                calculatePriceQuick();
            } else {}
        }
    });
});
$('body').on('click', '#add-to-cart-form .add-to-cart', function(e) {
    var $this = $(this);
    var form = $("#add-to-cart-form");
    $.ajax({
        type: "POST",
        url: '/cart/add-to-cart',
        dataType: "json",
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            triggerCheckoutEvent(1)

            if (response.count) {
                $("#cart-count").text(response.count)
            }
            $('.close').trigger('click');
            flashMessage(response.type, response.message);
        }
    });
});
$('body').on('change', '#add-to-cart-form .attribute-option-change', function(e) {
    var $this = $(this);
    var form = $("#add-to-cart-form");
    $.ajax({
        type: "POST",
        url: '/product/update-product-detail',
        dataType: "json",
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.image) {
                $('span.weight').text(response.weight);
                // Image detail page
                if (response.default == 1) {
                    $('.slider-for').slick('unslick');
                    $('.slider-nav').slick('unslick');
                    $('.att_image').remove();
                    slickSlider();
                } else {
                    $('.slider-for').slick('unslick');
                    $('.slider-nav').slick('unslick');
                    $('.att_image').remove();
                    $('.slider-for').prepend('<div class="att_image"><img src="' + response.image + '" alt="" /></div>');
                    $('.slider-nav').prepend('<a  class="att_image" ><img src="' + response.image + '" alt="" /></a>');
                    slickSlider();
                }
                existQuantity = response.quantity;
                if (response.inventory_tracking == 1 && response.quantity == 0) {
                    existQuantity = 1;
                    $('#out-of-stock').show();
                    $('.add-to-cart').attr('disabled', true);
                } else {
                    //maximumQuantity = parseInt(response.quantity) 1 ? ($quantity > config('constants.MAXIMUM_QUANTITY_PER_PRODUCT') ? config('constants.MAXIMUM_QUANTITY_PER_PRODUCT') : $quantity)}})
                    $('#out-of-stock').hide();
                    $('.add-to-cart').attr('disabled', false);
                }
                if (response.inventory_tracking == 0) {
                    existQuantity = maximumQuantity;
                }
                var quantity = parseInt($('#quantity').val());
                if (existQuantity < quantity) {
                    $('#quantity').val(existQuantity);
                    $('.quantity-count').val(existQuantity);
                    $('.quantity-count').text(existQuantity);
                }
                productPrice = parseFloat(response.price).toFixed(2);
                calculatePrice();
            } else {}
        }
    });
});
$('body').on('change', '.input-file-image input[type="file"]', function(e) {
    var mimeType = ['image/jpg', 'image/jpeg', 'image/png'];
    if (this.files && this.files[0] && mimeType.indexOf(this.files[0].type) > 0) {
        readURL(this);
    } else {
        // console.log(mimeType.indexOf(this.files[0].type));
        alert('Only Images allowed!');
        $(this).parent('div').find('img').attr('src', '/images/default-avatar.png');
        $(this).val('');
    }
});

function slickSlider() {
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav',
        infinite: false,
    });
    $('.slider-nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        centerMode: false,
        focusOnSelect: true,
        infinite: false,
        arrows: true,
        // variableWidth: true,
        adaptiveHeight: false,
        // accessibility: false,
        mobileFirst: true
    });
}

function calculatePrice() {
    $("#price-count").text(addCommas(parseFloat(parseInt($("#quantity").val()) * productPrice).toFixed(2)));
}

function calculatePriceQuick() {
    $("#quick-price-count").text(addCommas(parseFloat(parseInt($("#quick-quantity").val()) * productPrice).toFixed(2)));
}
// Input File Image
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(input).parent('div.input-file-image').find('img.img-upload-preview').attr('src', e.target.result);
            var name = document.getElementById("profile_pic").files[0].name;
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();
            //console.log(jQuery.inArray(ext, ['gif','png','jpg','jpeg']));
            if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                alert("Invalid Image File");
                return false;
            } else {
                console.log(ext);
            }
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("profile_pic").files[0]);
            var f = document.getElementById("profile_pic").files[0];
            var fsize = f.size || f.fileSize;
            if (fsize > 2000000) {
                alert("Image File Size is very big");
            } else {
                form_data.append("file", document.getElementById('profile_pic').files[0]);
                $.ajax({
                    url: '/uploadimage',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {},
                    success: function(data) {
                        if (data) {
                            window.location.reload();
                        }
                    }
                });
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function flashMessage(type, message) {
    var content = {};
    content.title = type.toUpperCase();
    if (type == 'error') {
        type = 'danger';
    }
    var placementFrom = 'top';
    var placementAlign = 'center';
    var state = type;
    var style = 'withicon';
    content.message = message;
    if (style == "withicon") {
        switch (type) {
            case 'danger':
                content.icon = 'icon-close';
                break;
            case 'warning':
                content.icon = 'icon-bulb';
                break;
            case 'success':
                content.icon = 'icon-check';
                break;
            case 'info':
                content.icon = 'icon-information';
                break;
            default:
                content.icon = 'none';
        }
    } else {
        content.icon = 'none';
    }
    $.notify(content, {
        type: state,
        placement: {
            from: placementFrom,
            align: placementAlign
        },
        time: 1000,
        delay: 3000,
        template: '<div data-notify="container" class="col-md-8  col-sm-10  col-12 alert alert-{0}" role="alert">' + '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' + '<span data-notify="icon"></span> ' + '<span data-notify="title">{1}</span> ' + '<span data-notify="message">{2}</span>' + '<div class="progress" data-notify="progressbar">' + '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' + '</div>' + '<a href="{3}" target="{4}" data-notify="url"></a>' + '</div>'
    });
};
var bloodhound = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: '/product/search?q=%QUERY%',
        wildcard: '%QUERY%'
    },
});
$('#search-product').typeahead({
    hint: false,
    highlight: true,
    minLength: 1,
    autoselect: true,
    limit: 10,
}, {
    name: 'products',
    source: bloodhound,
    display: function(data) {
        return data.name + '-' + data.sku
    },
    templates: {
        empty: ['<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'],
        suggestion: function(data) {
            return '<div class="list-group-item">' + data.name + '-' + data.sku + '</div>'
        }
    }
}).bind('typeahead:selected', function(obj, data) {
    window.location.href = /product/ + data.slug;
}).on('typeahead:asyncrequest', function() {
    $('.searchloader').show();
}).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    $('.searchloader').hide();
});
$('#newsletter').on('submit', function(e) {
    if ($("#newsletter").valid()) {
        e.preventDefault();
        var form = $("#newsletter");
        var url = form.attr('action');
        var $this = $(this);
        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize(),
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                flashMessage(response.type, response.message);
                form[0].reset();
            },
            error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                flashMessage('error', msg);
            },
        });
        return false;
    }
});
jQuery(document).ready(function() {
    jQuery(".loader").hide();
    wow.init();
    menuResize();
    $(".navbar-toggler").click(function() {
        $("body").toggleClass("menu-active");
    });
    setTimeout(function() {
        $('#alert-messages').slideUp();
    }, 10000);
});
$(window).resize(function() {
    menuResize();
});


$(function() {

    $('body').on('click', 'a.jq-view-product', function(event) {

        event.preventDefault();

        $('#loading').fadeOut()
        $('#loading').fadeIn()

        let url = $(this).attr('href')

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
        .always(function(response) {

            $('#loading').fadeOut()

            try {
                window.dataLayer.push({
                    'event': 'productClick',
                    'ecommerce': {
                      'click': {
                            'actionField': {'list': 'Product click'},
                            'products': [{
                                'id': response.product.id,
                                'name': response.product.name,
                                'price': response.product.price,
                                'position': 1
                            }]
                        }
                    },
                    'eventCallback': function() {
                        document.location = url
                    }
                });
            } catch (e) {
                document.location = url
            }

            setTimeout(function() {
                document.location = url   
            }, 1000)

        });
    });
})



window.checkCartContent = function (callback) {
    $.ajax({
        url: '/cart',
        type: 'GET',
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    })
    .done(function(response) {
        callback(response)

        if (response.isHazmat === true) {
            $('.jq-is-hazmat').show();
        }

    })
}

window.triggerCheckoutEvent = function (step) {

    try {
        checkCartContent(function(response) {
            try {

                console.log(step)

                let mappedProducts = []

                $.each(response.cart, function(index, p) {
                    mappedProducts.push({
                        id: p.id,
                        name: p.name,
                        price: p.price,
                        quantity: p.quantity,
                        category: p.attributes.categories[0],
                    });
                });

                dataLayer.push({
                    'event': 'checkout',
                    'ecommerce': {
                        'checkout': {
                            'actionField': {
                                'step': step
                            },
                            'products': mappedProducts
                        }
                    }
                });
            } catch (e) {
                console.log(e)
            }
        })
    } catch (e) {
        console.log(e)
    }
}
