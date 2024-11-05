$.noConflict();

jQuery(document).ready(function($) {

    "use strict";

    [].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
        new SelectFx(el);
    } );

    jQuery('.selectpicker').selectpicker;


    $('#menuToggle').on('click', function(event) {
        $('body').toggleClass('open');
    });

    $('.search-trigger').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $('.search-trigger').parent('.header-left').addClass('open');
    });

    $('.search-close').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $('.search-trigger').parent('.header-left').removeClass('open');
    });

    // $('.user-area> a').on('click', function(event) {
    // 	event.preventDefault();
    // 	event.stopPropagation();
    // 	$('.user-menu').parent().removeClass('open');
    // 	$('.user-menu').parent().toggleClass('open');
    // });

    // Кнопка добавить еше галлея
    var btn = $('.multi_img_add');
    var content = $('.multi_img_content');
    var i = 1;
    btn.click(function (e) {
        e.preventDefault();
        i++;
        var div = '<div style="margin-bottom: 25px;" class="multi_img">' +
            'Имя картинки <span class="number">' + i + '</span>: <input type="text" name="galleryName[]" class="form-control" value="">' +
            'Картинка <span class="number">' + i + '</span>: <input type="file" id="file-multiple-input" name="galleryFile[]" multiple="" class="form-control-file" style="display: inherit; width: inherit">' +
            '</div>'
        content.append(div);
    });

    // ///  Html editor
    // $('.html-editor').summernote({
    //     toolbar: [
    //         ['style', ['style']],
    //         ['font', ['bold', 'underline', 'clear']],
    //         ['color', ['color']],
    //         ['para', ['ul', 'ol', 'paragraph']],
    //         ['table', ['table']],
    //         ['insert', ['link']],
    //         ['view', ['fullscreen', 'help']]
    //     ]
    // });
});
