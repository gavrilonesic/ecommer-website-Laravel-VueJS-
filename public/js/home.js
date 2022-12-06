$('#home-page-banner').owlCarousel({
    loop: true,
    navigation: true, // Show next and prev buttons
    slideSpeed: 300,
    autoplay: true,
    autoplayTimeout:7000,
    autoplayHoverPause: true,
    paginationSpeed: 400,
    singleItem: true,
    items: 1,
    nav: true
})
$("#popular-products, #new-products, #featured-products").each(function() {
    $(this).owlCarousel({
        loop: true,
        margin: 10,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 2,
                nav: true
            },
            800: {
                items: 3,
                nav: true
            },
            1000: {
                items: 4,
                nav: true,
                loop: false
            }
        }
    })
});
$('#client-testimonials').owlCarousel({
    loop: true,
    margin: 10,
    responsiveClass: true,
    responsive: {
        0: {
            items: 1,
            nav: true
        },
        1200: {
            items: 2,
            nav: true,
            loop: false
        }
    }
});

$('#clients').owlCarousel({
    loop: true,
    navigation: true, // Show next and prev buttons
    slideSpeed: 300,
    dots: false,
    margin: 8,
    autoplay: true,
    autoplayTimeout:3000,
    autoplayHoverPause: true,
    paginationSpeed: 400,
    nav: true,
    items: 1,
    responsiveClass: true,
    responsive: {
        400: {
            margin: 10,
            items: 2,
        },
        600: {
            margin: 12,
            items: 3,
        },
        1000: {
            margin: 16,
            items: 4,
        },
        1440: {
            margin: 20,
            items: 5,
        }
    }
});
