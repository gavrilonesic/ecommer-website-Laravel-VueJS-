"use strict";
$(".nav-search .input-group > input").focus(function(e) {
    $(this).parent().addClass("focus");
}).blur(function(e) {
    $(this).parent().removeClass("focus");
});
$(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
});
$(document).ready(function() {
    $("#hide-child-category").hide();
    var scrollbarDashboard = $('.sidebar .scrollbar');
    if (scrollbarDashboard.length > 0) {
        scrollbarDashboard.scrollbar();
    }
    var contentScrollbar = $('.main-panel .content-scroll');
    if (contentScrollbar.length > 0) {
        contentScrollbar.scrollbar();
    }
    var messagesScrollbar = $('.messages-scroll');
    if (messagesScrollbar.length > 0) {
        messagesScrollbar.scrollbar();
    }
    var tasksScrollbar = $('.tasks-scroll');
    if (tasksScrollbar.length > 0) {
        tasksScrollbar.scrollbar();
    }
    var quickScrollbar = $('.quick-scroll');
    if (quickScrollbar.length > 0) {
        quickScrollbar.scrollbar();
    }
    var messageNotifScrollbar = $('.message-notif-scroll');
    if (messageNotifScrollbar.length > 0) {
        messageNotifScrollbar.scrollbar();
    }
    var notifScrollbar = $('.notif-scroll');
    if (notifScrollbar.length > 0) {
        notifScrollbar.scrollbar();
    }
    var quickActionsScrollbar = $('.quick-actions-scroll');
    if (quickActionsScrollbar.length > 0) {
        quickActionsScrollbar.scrollbar();
    }
    var userScrollbar = $('.dropdown-user-scroll');
    if (userScrollbar.length > 0) {
        userScrollbar.scrollbar();
    }
    $('#search-nav').on('shown.bs.collapse', function() {
        $('.nav-search .form-control').focus();
    });
    var toggle_sidebar = false,
        minimize_sidebar = false,
        nav_open = false,
        toggle_page_sidebar = false,
        toggle_overlay_sidebar = false,
        mini_sidebar = 0,
        page_sidebar_open = 0,
        overlay_sidebar_open = 0;
    if (!toggle_sidebar) {
        var toggle = $('.sidenav-toggler');
        toggle.on('click', function() {
            if (nav_open == 1) {
                $('html').removeClass('nav_open');
                toggle.removeClass('toggled');
                nav_open = 0;
            } else {
                $('html').addClass('nav_open');
                toggle.addClass('toggled');
                nav_open = 1;
            }
        });
        toggle_sidebar = true;
    }
    if (!minimize_sidebar) {
        var minibutton = $('.toggle-sidebar');
        if ($('.wrapper').hasClass('sidebar_minimize')) {
            mini_sidebar = 1;
            minibutton.addClass('toggled');
            minibutton.html('<i class="icon-options-vertical"></i>');
        }
        minibutton.on('click', function() {
            if (mini_sidebar == 1) {
                $('.wrapper').removeClass('sidebar_minimize');
                minibutton.removeClass('toggled');
                minibutton.html('<i class="icon-menu"></i>');
                mini_sidebar = 0;
            } else {
                $('.wrapper').addClass('sidebar_minimize');
                minibutton.addClass('toggled');
                minibutton.html('<i class="icon-options-vertical"></i>');
                mini_sidebar = 1;
            }
            $(window).resize();
        });
        minimize_sidebar = true;
    }
    if (!toggle_page_sidebar) {
        var pageSidebarToggler = $('.page-sidebar-toggler');
        pageSidebarToggler.on('click', function() {
            if (page_sidebar_open == 1) {
                $('html').removeClass('pagesidebar_open');
                pageSidebarToggler.removeClass('toggled');
                page_sidebar_open = 0;
            } else {
                $('html').addClass('pagesidebar_open');
                pageSidebarToggler.addClass('toggled');
                page_sidebar_open = 1;
            }
        });
        var pageSidebarClose = $('.page-sidebar .back');
        pageSidebarClose.on('click', function() {
            $('html').removeClass('pagesidebar_open');
            pageSidebarToggler.removeClass('toggled');
            page_sidebar_open = 0;
        });
        toggle_page_sidebar = true;
    }
    $('.sidebar').hover(function() {
        if ($('.wrapper').hasClass('sidebar_minimize')) {
            $('.wrapper').addClass('sidebar_minimize_hover');
        }
    }, function() {
        if ($('.wrapper').hasClass('sidebar_minimize')) {
            $('.wrapper').removeClass('sidebar_minimize_hover');
        }
    });
    // addClass if nav-item click and has subnav
    $(".nav-item a").on('click', (function() {
        if ($(this).parent().find('.collapse').hasClass("show")) {
            $(this).parent().removeClass('submenu');
        } else {
            $(this).parent().addClass('submenu');
        }
    }));
    //form-group-default active if input focus
    $(".form-group-default .form-control").focus(function() {
        $(this).parent().addClass("active");
    }).blur(function() {
        $(this).parent().removeClass("active");
    })
    var ti = $('.datatable-with-image').DataTable({
        "search": {
            "smart": false,
            "regex": true
        },
        "columnDefs": [{
            orderable: false,
            targets: [1, -1]
        }],
        "order": [1],
        "pageLength": 50,
        "bLengthChange": true,
        "bAutoWidth": false,
        "stateSave": true,
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [0]
        }],
    });
    ti.on('order.dt search.dt', function() {
        ti.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
    var t = $('.datatable-without-image').DataTable({
        "search": {
            "smart": false,
            "regex": true
        },
        "columnDefs": [{
            orderable: false,
            targets: [1, -1]
        }],
        "order": [1],
        "pageLength": 50,
        "bLengthChange": true,
        "bAutoWidth": false,
        "stateSave": true,
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [0]
        }],
    });
    t.on('order.dt search.dt', function() {
        t.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
    $('.datatable-with-image-product-search').DataTable({
        "search": {
            "smart": false,
            "regex": true
        },
        "columnDefs": [{
            orderable: false,
            targets: [0, 1, -1]
        }],
        "order": [1],
        "pageLength": 50,
        "searching": false,
        "bLengthChange": true,
        "bAutoWidth": false,
        "stateSave": true,
    });
    setTimeout(function() {
        $.notifyClose();
    }, 3000);
});
// $('.data-table-ajax').DataTable({
//        processing: true,
//        serverSide: true,
//        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//        ajax: window.location.toString(),
//        "columnDefs": [{
//            orderable: false,
//            targets: [0, -1]
//        }],
//        "columns": [
//            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
//            {data: 'image', name: 'image',orderable: false, searchable: false},
//            {data: 'sku', name: 'sku'},
//            {data: 'name', name: 'name'},
//            {data: 'price', name: 'price'},
//            {data: 'status', name: 'status'},
//            {data: 'action', name: 'action'},
//        ],
//        "order": [1],
//        "pageLength": 50,
//        "bLengthChange": true,
//        "bAutoWidth": false,
//        // "stateSave": true,
//    });
// Show Password
function showPassword(button) {
    var inputPassword = $(button).parent().find('input');
    if (inputPassword.attr('type') === "password") {
        inputPassword.attr('type', 'text');
    } else {
        inputPassword.attr('type', 'password');
    }
}
$('.show-password').on('click', function() {
    showPassword(this);
})
// Input File Image
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(input).parent('div.input-file-image').find('img.img-upload-preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$('body').on('change', '.input-file-image input[type="file"]', function(e) {
    var mimeType = ['image/jpg', 'image/jpeg', 'image/png'];
    if (this.files && this.files[0] && mimeType.indexOf(this.files[0].type) > 0) {
        readURL(this);
    } else {
        $(this).parent('div').find('img').attr('src', '/images/150x150.png');
        $(this).val('');
    }
});
$('body').on('click', '.remove-image', function(e) {
    var ele = $(this);
    swal({
        title: 'Are you sure you want to delete?',
        text: "", //You won't be able to revert this!
        type: 'warning',
        buttons: {
            cancel: {
                visible: true,
                text: 'No, cancel!',
                className: 'btn btn-danger'
            },
            confirm: {
                text: 'Yes, delete it!',
                className: 'btn btn-success'
            }
        }
    }).then(function(willDelete) {
        if (willDelete) {
            ele.parent('div').find('img').attr('src', '/images/150x150.png');
            ele.closest('.input-file-image').find('.remove-image').hide();
            $.ajax({
                type: 'DELETE',
                url: 'deleteimage',
                dataType: "json",
                data: {
                    type: ele.data('type'),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    window.document.location.reload(true);
                }
            });
        } else {}
    });
    return false;
});

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
        delay: 0,
    });
};
$('body').on('click', '.btn-delete', function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
        title: 'Are you sure you want to delete?',
        text: "",
        type: 'warning',
        buttons: {
            cancel: {
                visible: true,
                text: 'No, cancel!',
                className: 'btn btn-danger'
            },
            confirm: {
                text: 'Yes, delete it!',
                className: 'btn btn-success'
            }
        }
    }).then(function(willDelete) {
        if (willDelete) {
            form.submit();
        } else {}
    });
    return false;
});
$('body').on('click', '.btn-restore', function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
        title: 'Are you sure you want to restore original email template?',
        text: "",
        type: 'warning',
        buttons: {
            cancel: {
                visible: true,
                text: 'No',
                className: 'btn btn-danger'
            },
            confirm: {
                text: 'Yes',
                className: 'btn btn-success'
            }
        }
    }).then(function(willDelete) {
        if (willDelete) {
            form.submit();
        } else {}
    });
    return false;
});
$('body').on('click', '.ispublish', function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
        title: 'Are you sure you want to alter the status?',
        text: "", //Refund will be manually settled with Customer.
        type: 'warning',
        buttons: {
            cancel: {
                visible: true,
                text: 'No, cancel!',
                className: 'btn btn-danger'
            },
            confirm: {
                text: 'Yes, alter it!',
                className: 'btn btn-success'
            }
        }
    }).then(function(willDelete) {
        if (willDelete) {
            form.submit();
        } else {}
    });
    return false;
});
$('body').on('click', '.btn-deactivate', function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
        title: 'Are you sure you want to deactive?',
        text: "",
        type: 'warning',
        buttons: {
            cancel: {
                visible: true,
                text: 'No, cancel!',
                className: 'btn btn-danger'
            },
            confirm: {
                text: 'Yes, deactivate it!',
                className: 'btn btn-success'
            }
        }
    }).then(function(willDelete) {
        if (willDelete) {
            form.submit();
        } else {}
    });
    return false;
});

function tooltip() {
    $('body').tooltip({
        selector: '[data-toggle="tooltip"]'
    });
}
var toggle_topbar = false,
    topbar_open = 0
if (!toggle_topbar) {
    var topbar = $('.topbar-toggler');
    topbar.on('click', function() {
        if (topbar_open == 1) {
            $('html').removeClass('topbar_open');
            topbar.removeClass('toggled');
            topbar_open = 0;
        } else {
            $('html').addClass('topbar_open');
            topbar.addClass('toggled');
            topbar_open = 1;
        }
    });
    toggle_topbar = true;
}
$("#collapse-all").click(function() {
    $(".category-expand-collapse").collapse('hide');
});
$("#expand-all").click(function() {
    $(".category-expand-collapse").collapse('show');
});
/* category create page expand collapse categories */
$('.category_type').on('click', function() {
    var value = $(this).val();
    if (value == 'null') {
        //alert('if');
        jQuery('#hide-child-category').show();
        jQuery('.hideifparent').show();
        jQuery("#custom-0").prop("checked", false);
        jQuery('input[name="parent_cat"]').val('null');
    } else if (value == '0') {
        //alert('elseif');
        jQuery('#hide-child-category').hide();
        jQuery('.hideifparent').hide();
        jQuery("#custom_child").prop("checked", false);
        jQuery('input[name="parent_cat"]').val('0');
    } else {
        //alert('else');
        jQuery('#hide-child-category').show();
        jQuery('.hideifparent').show();
        jQuery('input[name="parent_cat"]').val(value);
    }
});