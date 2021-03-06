//Back to top code
$(document).ready(function() {
    $(function() {
        setTimeout(function() {
            $('#notific').remove();
        }, 5000);
    });

    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    // scroll body to 0px on click
    $('#back-to-top').click(function() {
        $('#back-to-top').tooltip('hide');
        $('body,html').animate(
            {
                scrollTop: 0,
            },
            800
        );
        return false;
    });

    // $('#back-to-top').tooltip('show');
});
$(document).ready(function() {
    $('.dropdown').hover(
        function() {
            $('.dropdown-menu', this)
                .not('.in .dropdown-menu')
                .stop(true, true)
                .slideDown('fast');
        },
        function() {
            $('.dropdown-menu', this)
                .not('.in .dropdown-menu')
                .stop(true, true)
                .slideUp('fast');
        }
    );

    $(".select2").each(function(){
        $(this).select2({
            placeholder: $(this).attr("data-placeholder"),
        });
    });

    $('input[type="file"]').change(function(e){
        let fileNames = [];

        for(let file of e.target.files) {
            fileNames.push(file.name);
        }
        $(e.target).parent().find('.custom-file-label').html(fileNames.join(', '));
    });
});
