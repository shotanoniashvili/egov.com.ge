'use strict';
// bootstrap wizard//
$('#gender, #gender1').select2({
    theme: 'bootstrap',
    placeholder: '',
    width: '100%',
});
$('input[type="checkbox"].custom-checkbox, input[type="radio"].custom-radio').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
    radioClass: 'iradio_minimal-blue',
    increaseArea: '20%',
});
$('#dob').datetimepicker({
    format: 'YYYY-MM-DD',
    widgetPositioning: {
        vertical: 'bottom',
    },
    keepOpen: false,
    useCurrent: false,
    maxDate: moment()
        .add(1, 'h')
        .toDate(),
});
$('.btn-add-mobile').on('click', function (e) {
    e.preventDefault();

    let container = $(this).closest('.mobile-form-groups');

    container.append('<div class="input-group mb-3">\n' +
'                                            <input type="text" name="author[mobiles][]" class="form-control required">\n' +
'                                            <div class="input-group-append">\n' +
'                                                <button class="btn btn-warning btn-remove-mobile"><i class="fa fa-minus"></i></button>\n' +
'                                            </div>\n' +
'                                        </div>');
});
$('body').on('click', '.btn-remove-mobile', function (e) {
    e.preventDefault();

    $(this).parent().parent().remove();
});
$('#projectForm').bootstrapValidator({
    fields: {
        title: {
            validators: {
                notEmpty: {
                    message: 'გთხოვთ მიუთითოთ პრაკტიკის/ინიციატივის სათაური',
                },
            },
            required: true,
            minlength: 3,
        },
        category_id: {
            validators: {
                notEmpty: {
                    message: 'გთხოვთ აირჩიოთ თემატიკა',
                },
            },
            required: true,
        },
        short_description: {
            validators: {
                notEmpty: {
                    message: 'გთხოვთ მიუთითოთ მოკლე აღწერა',
                },
            },
            required: true,
            minlength: 50
        },
        picture: {
            validators: {
                notEmpty: {
                    message: 'გთხოვთ აირჩიოთ სურათი'
                },
                required: true,
            }
        },
        municipality_id: {
            validators: {
                notEmpty: {
                    message: 'გთხოვთ აირჩიოთ მუნიციპალიტეტი',
                },
            },
            required: true,
        },
        documents: {
            validators: {

            }
        }
    },
});

$('#rootwizard').bootstrapWizard({
    tabClass: 'nav nav-pills',
    onNext: function(tab, navigation, index) {
        var $validator = $('#projectForm')
            .data('bootstrapValidator')
            .validate();
        return $validator.isValid();
    },
    onTabClick: function(tab, navigation, index) {
        return true;
    },
    onTabShow: function(tab, navigation, index) {
        var $total = navigation.find('li').length;
        var $current = index + 1;

        // If it's the last tab then hide the last button and show the finish instead
        if ($current >= $total) {
            $('#rootwizard')
                .find('.pager .next')
                .hide();
            $('#rootwizard')
                .find('.pager .finish')
                .show();
            $('#rootwizard')
                .find('.pager .finish')
                .removeClass('disabled');
        } else {
            $('#rootwizard')
                .find('.pager .next')
                .show();
            $('#rootwizard')
                .find('.pager .finish')
                .hide();
        }
    },
});

$('#rootwizard .finish').click(function() {
    var $validator = $('#projectForm')
        .data('bootstrapValidator')
        .validate();
    if ($validator.isValid()) {
        document.getElementById('projectForm').submit();
    }
});
$('#activate').on('ifChanged', function(event) {
    $('#projectForm').bootstrapValidator('revalidateField', $('#activate'));
});
$('#projectForm').keypress(function(event) {
    if (event.which == '13') {
        event.preventDefault();
    }
});


$('.datetimepicker.year').datetimepicker({
    format: 'YYYY',
    icons: {
        time: 'fa fa-clock-o',
        date: 'fa fa-calendar',
        up: 'fa fa-chevron-up',
        down: 'fa fa-chevron-down',
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
    },
});

$('.toggle-date').on('ifChecked', function() {
    $('.date-field-container').removeClass('hide');
}).on('ifUnchecked', function() {
    $('.date-field-container').addClass('hide');
});

// TinyMCE Full
tinymce.init({
    selector: '#short_description',
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