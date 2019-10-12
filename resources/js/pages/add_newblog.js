$(document).ready(function() {
    $('.form-group input[type=file]').attr('accept', 'image/*');
    // TinyMCE Full
    tinymce.init({
        selector: '.textarea',
        theme: 'modern',
        plugins: [
            'advlist autolink lists link charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'template paste textcolor',
        ],
        toolbar1:
            'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | print preview | forecolor backcolor',
    });
    
    $('body').on('click', '.btn-codeview', function(e) {
        if ($('.note-editor').hasClass('fullscreen')) {
            var windowHeight = $(window).height();
            $('.note-editable').css('min-height', windowHeight);
        } else {
            $('.note-editable').css('min-height', '300px');
        }
    });
    $('body').on('click', '.btn-fullscreen', function(e) {
        setTimeout(function() {
            if ($('.note-editor').hasClass('fullscreen')) {
                var windowHeight = $(window).height();
                $('.note-editable').css('min-height', windowHeight);
            } else {
                $('.note-editable').css('min-height', '300px');
            }
        }, 500);
    });

    $('.note-link-url').on('keyup', function() {
        if ($('.note-link-text').val() != '') {
            $('.note-link-btn')
                .attr('disabled', false)
                .removeClass('disabled');
        }
    });

    //summernote

    $('.custom-control-indicator')
        .removeClass('custom-control-indicator')
        .addClass('custom-control-label');
    $('.modal-footer').addClass('mx-auto');
});
