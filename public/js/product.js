var customFieldArray = "",
    descriptionPlaceholder = "",
    creatMatrixUrl = "";
// inventory tracking script
$('body').on('change', '#inventory_tracking', function() {
    if ($(this).is(':checked') === true) {
        $('.inventory-tracking').show();
    } else {
        $('.inventory-tracking').hide();
    }
    $(".inventory-level").change();
});
$('#inventory_tracking').change();
$('body').on('change', '.inventory-level', function() {
    if ($("input[name='inventory_tracking_by']:checked").val() == 1 && $("#inventory_tracking").is(':checked') === true) {
        $('.show-attribute-level-inventory').show();
        $('.show-product-level-inventory').hide();
    } else {
        $('.show-attribute-level-inventory').hide();
        $('.show-product-level-inventory').show();
    }
});
$('.inventory-level').change();
$('body').on('change', '#attributes', function(e) {
    if ($(this).val().length == 0) {
        $('.attribute-options').html('');
    }
    $.ajax({
        type: 'POST',
        url: creatMatrixUrl,
        data: {
            attribute: $(this).val()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(html) {
            $('.attribute-options').html(html);
            if ($("input[name='inventory_tracking_by']:checked").val() == 1) {
                $('.show-attribute-level-inventory').show();
            } else {
                $('.show-attribute-level-inventory').hide();
            }
            tooltip();
        }
    });
});
$("body").on("click", ".btn-delete-attribute", function() {
    $('.icon-close').tooltip('hide');
    $(this).closest('tr').remove();
    tooltip();
});
var ic = 1;
Dropzone.options.myAwesomeDropzone = { // The camelized version of the ID of the form element
    // The configuration we've talked about above
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 100,
    acceptedFiles: 'image/jpg,image/jpeg,image/png',
    maxFiles: maxFiles,
    addedfile: function(file){

    },
    // accept : function(file,done) {
    //     if (file.size > this.options.maxFilesize) {
    //         this.removeAllFiles();
    //     }else{
    //         done();
    //     }
    // },
    thumbnail: function(file,dataURL) {
        // console.log(file);
        var mimeType = ['image/jpg', 'image/jpeg', 'image/png'];
        if (mimeType.indexOf(file.type) > 0 && file.accepted && this.options.maxFiles >= ic) {
                addImage(file.dataURL, "", file.name);
                ic++;
        }else{
            if(this.options.maxFiles < ic){
                $("#image-upload-error").show();
                $('html, body').animate({
                    scrollTop: $("#image-card-div").offset().top
                }, 2000);
            }
        }

    },
    maxfilesexceeded: function(file){
        this.removeAllFiles();
    },
    // The setting up of the dropzone
    init: function() {

     }
}
var imgCount = 0;

function addImage(imageSrc, imageType, fileName, defaultChecked, description) {
    var checked = "";
    if ($('.image-section tbody >tr').length == 0 || defaultChecked) {
        checked = "checked";
    }
    var html = "<tr><td><i class='icon-cursor-move'></i></td><td>"
    html += '<div class="row image-gallery avatar">'
    html += '<input type="hidden" name="product_images[image][' + imgCount + ']" value="' + imageSrc + '" >'
    if (fileName) {
        var imgType = 'img'
        html += '<input type="hidden" name="product_images[file_name][' + imgCount + ']" value="' + fileName + '" >'
    }
    if (imageType) {
        var imgType = 'url'
        html += '<input type="hidden" name="product_images[url][' + imgCount + ']" value="1" >'
    }
    //html +=     '<img class="avatar-img rounded img-fluid" id="image-' + imgCount + '" data-target="#crop-image-popup" data-toggle="modal" src="' + imageSrc + '" data-id="' + imgCount + '">'
    html += '<img class="avatar-img rounded img-fluid" src="' + imageSrc + '">'
    html += '</div>'
    html += '</td>'
    html += '<td>'
    html += '<textarea class="form-control" name ="product_images[description][' + imgCount + ']" placeholder="' + descriptionPlaceholder + '">' + (description ? description : "") + '</textarea>'
    html += '</td>'
    html += '<td>'
    html += '<div class="form-check form-check-inline">'
    html += '<div class="custom-control custom-radio">'
    html += '<input type="radio" id="default-image-' + imgCount + '" name="default_image" class="custom-control-input" value="' + imgCount + '" ' + checked + '>'
    html += '<label class="custom-control-label" for="default-image-' + imgCount + '"></label>'
    html += '</div>'
    html += '</div>'
    html += '</td>'
    html += '<td><button class="btn btn-link btn-danger btn-delete-image" data-image-type="'+imgType+'" data-toggle="tooltip" data-placement="top" title="' + deleteButtonTooltip + '"><i class="icon-close"></i></button></td>'
    html += '</tr>'
    $('.image-section tbody').append(html);
    //$("#image-" + imgCount).rcrop();
    imgCount++;
    hideImageSection();
    tooltip();
    return true;
}
// var imageId = srcOriginal = srcResized = '';
// $("body").on("click", ".avatar-img", function() {
//     imageId = $(this).attr('data-id');
//     $(".image-wrapper").html('<img src="' + $(this).attr('src') + '" id="image-wrapper" style ="max-height:250px; max-width:250px"/>')
//     setTimeout(function() {
//         $("#image-wrapper").rcrop();
//         $('#image-wrapper').on('rcrop-changed', function() {
//             srcOriginal = $(this).rcrop('getDataURL');
//             srcResized = $(this).rcrop('getDataURL', 50, 50);
//             $('#cropped-original').append('<img src="' + srcOriginal + '">');
//             $('#cropped-resized').append('<img src="' + srcResized + '">');
//         })
//     }, 200)
// });
function cropImage() {
    $("#image-" + imageId).attr("src", srcOriginal);
}
$("body").on("click", ".btn-delete-image", function() {
    $('.icon-close').tooltip('hide');
    var imgType = $(this).data('image-type');
    $(this).closest('tr').remove();
    if (!$("input[name='default_image']:checked").val()) {
        $('.image-section tbody >tr:first').find("input[type='radio']").prop("checked", true)
    }
    if(imgType =='img'){
        ic--;
    }
    tooltip();
    hideImageSection();
});

function hideImageSection() {
    $("#image-upload-error").hide();
    if ($('.image-section tbody >tr').length == 0) {
        $(".image-section").hide();
    } else {
        $(".image-section").show();
    }
}
hideImageSection();

function imageExists(url, callback) {
    var img = new Image();
    img.onload = function() {
        callback(true);
    };
    img.onerror = function() {
        callback(false);
    };
    img.src = url;
}

function checkURL(url) {
    return (url.match(/\.(jpeg|jpg|gif|png)$/) != null);
}
$("body").on('change', "#upload-url", function() {
    addError(checkURL($(this).val()))
});

function addError(result) {
    if (result == true) {
        $("#upload-url").removeClass('is-invalid-error');
        $("#upload_url-error").hide();
    } else {
        $("#upload-url").addClass('is-invalid-error');
        $("#upload_url-error").show();
    }
}

function validateImageURL() {
    if ($('#upload-url').val().trim() == "") {
        addError(false);
        return;
    }
    if (checkURL($('#upload-url').val())) {
        imageExists($('#upload-url').val(), function(exists) {
            addError(exists)
            if (exists == true) {
                addImage($('#upload-url').val(), 1)
                $('#upload-url').val('')
                $(".close").trigger('click');
            }
        });
    }
}
var options = {
    data: customFieldArray,
    getValue: function(element) {
        return element.name;
    },
    list: {
        match: {
            enabled: true
        }
    }
};
var customFields = 0;
$("#add-custom-field").click(function() {
    addCustomField()
});

function addCustomField(key, value) {
    options.data = customFieldArray;
    var customId = 'custom-fields-' + customFields++;
    var html = '<div class="row">'
    html += '<div class="col-md-5 col-lg-5">'
    html += '<div class="form-group">';
    html += '<input type="text" name="custom_fields[name][]" value="' + (key ? key : "") + '" class="form-control" id="' + customId + '" />';
    html += '</div>';
    html += '</div>';
    html += '<div class="col-md-5 col-lg-5">'
    html += '<div class="form-group">';
    html += '<input type="text" name="custom_fields[value][]" value="' + (value ? value : "") + '" class="form-control" id="' + customId + '" />';
    html += '</div>';
    html += '</div>';
    html += '<div class="col-md-2 col-lg-2">'
    html += '<div class="form-group">';
    html += '<button type="button" class="btn btn-link btn-danger btn-delete-custom-field"><i class="icon-close" data-toggle="tooltip" data-placement="top" title="Delete Custom Fields"></i></button>'
    html += '</div>';
    html += '</div>';
    html += '</div>';
    $(".custom-fields").append(html);
    $("#" + customId).easyAutocomplete(options);
    tooltip();
}

function validateVideo() {
    if (!$('input[name="video"]:checked').length) {
        addVideoError(false);
        return;
    }
    if ($('input[name="video"]:checked').length) {
        $(".video_div").remove();
        $('input[name="video"]:checked').each(function(i) {
            var video_id = $(this).val();
            var video_url = $(this).data('video-url');
            var video_image_url = $(this).data('video-image-url');
            var video_title = $(this).data('video-title');
            addVideo(video_id, video_title, video_url, video_image_url);
        });
        addVideoError(true);
        $(".close").trigger('click');
        tooltip();
    }
}

function addVideoError(result) {
    if (result == true) {
        $(".video-error").hide();
    } else {
        $(".video-error").show();
    }
}

function addVideo(video_id, video_title, video_url, video_image_url) {
    var div_id = "'video_div_" + video_id + "'";
    html = '<div class="col-md-3 video_div videobox" id="video_div_' + video_id + '">';
    html += '<input type="hidden" value="' + video_id + '" name="video_id[]">';
    html += '<i class="icon-close" data-toggle="tooltip" data-placement="top" data-original-title="Delete Video" onclick="removeVideo(' + div_id + ')"></i>'
    html += '<div class="image-video-gallery">';
    html += '<a target="_blank" href="' + video_url + '">';
    html += '<img alt="' + video_title + '" class="avatar-img img-fluid" src="' + video_image_url + '">';
    html += '</a>';
    html += '</div>';
    html += '</div>';
    $(".video-row").append(html);
}

function removeVideo(video_id) {
    $('.icon-close').tooltip('hide');
    $('input:checkbox[name="video"][value="' + video_id + '"]').attr('checked', false);
    $('#' + video_id + '').remove();
    tooltip();
}
// $('body').on('click', '.remove-video', function(e) {
//     var video_id = $(this).data('id');
//     $('input:checkbox[value="' + video_id + '"]').attr('checked', false);
//     $(this).parent('div').remove();
// });
function validateYoutubeVideo() {
    if ($('#youtube_upload_url').val().trim() == "") {
        addYoutubeError(false);
        return;
    }
    var url = $('#youtube_upload_url').val();
    var videoid = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
    if (videoid != null) {
        addYoutubeVideo(videoid[1], url)
        addYoutubeError(true);
        $('#youtube_upload_url').val('')
        $(".close").trigger('click');
        tooltip();
    } else {
        addYoutubeError(false);
        return;
    }
}

function addYoutubeError(result) {
    if (result == true) {
        $("#youtube_upload_url").removeClass('is-invalid-error');
        $("#youtube_upload_url_error").hide();
    } else {
        $("#youtube_upload_url").addClass('is-invalid-error');
        $("#youtube_upload_url_error").show();
    }
}
var youtubeCount = 0;

function addYoutubeVideo(youtube_video_id, youtube_url) {
    var div_id = "'video_youtube_div_" + youtubeCount + "'";
    html = '<div class="col-md-3 videobox" id="video_youtube_div_' + youtubeCount + '">';
    html += '<input type="hidden" value="' + youtube_url + '" name="youtube_url[' + youtubeCount + '][url]">';
    html += '<input type="hidden" value="' + youtube_video_id + '" name="youtube_url[' + youtubeCount + '][id]">';
    html += '<i class="icon-close" data-toggle="tooltip" data-placement="top" data-original-title="Delete Image" onclick="removeVideo(' + div_id + ')"></i>'
    html += '<a target="_blank" href="' + youtube_url + '">';
    html += '<div class="image-video-gallery">';
    // html += '<iframe width="215" height="215" src="//www.youtube.com/embed/'+ youtube_video_id + '" frameborder="0" allowfullscreen></iframe>';
    html += '<img class="avatar-img img-fluid" src="https://img.youtube.com/vi/' + youtube_video_id + '/hqdefault.jpg">';
    html += '</a>';
    html += '</div>';
    html += '</div>';
    $(".video-row").append(html);
    youtubeCount++;
}
$('body').on('click', '.btn-delete-custom-field', function(e) {
    $(this).closest('div.row').remove();
    $(".tooltip").tooltip("hide");
});
/*$('.custom-control-input').click(function(){
    checked = false;
    if ($(this).is(':checked') === true) {
        checked = true
    }
    var parentUl = $(this).closest('ul'), parentChecked = true;
    $(parentUl).find('.custom-control-input').each(function( index ) {
        if ($(this).is(':checked') !== true) {
            parentChecked = false;
        }
    });
    $(parentUl).closest('li').find('.custom-control-input').first().prop('checked', parentChecked);
    $(this).closest('li').find('.custom-control-input').prop('checked', checked);
});*/
$(document).ready(function() {
    $('#search_video').keyup(function() {
        // Search text
        var text = $(this).val();
        // Hide all content class element
        $('.video-list').hide();
        // Search and show
        $('.video-list').each(function() {
            if ($(this).text().toUpperCase().indexOf(text.toUpperCase()) != -1) {
                $(this).show();
            }
        });
    });
    $('#description').summernote({
        placeholder: descriptionPlaceholder,
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
        tabsize: 2,
        height: 300
    });
    // $('#short_description').summernote({
    //     placeholder: shortDescriptionPlaceholder,
    //     fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
    //     tabsize: 2,
    //     height: 300
    // });
    $('.select2').select2({
        theme: "bootstrap"
    });
    $("i.expand-icon").each(function() {
        if ($(this).closest('li').find('[name="category_id[]"]:checked').length > 0) {
            if (!$($(this).data('target')).hasClass("show")) {
                $($(this).data('target')).collapse('show');
            }
        }
    });
});
$('body').on('click', '#add-attribute', function(e) {
    $('#add-attribute-modal').load($(this).attr("data-url"), function(result) {
        $('#add-attribute-modal').modal({
            show: true
        });
    });
});
var selectedField = "";
$('body').on('click', '#copy-product-field', function(e) {
    selectedField = $(this).data('value');
    $('#add-attribute-modal').load($(this).attr("data-url"), function(result) {
        $('#add-attribute-modal').modal({
            show: true
        });
    });
});
