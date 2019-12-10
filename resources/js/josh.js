'use strict';
// Csrf token for all ajax calls

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
});

var left_side_width = 220; //Sidebar width in pixels

$(function() {
    setTimeout(function() {
        $('#notific').remove();
    }, 5000);

    $(function() {
        //hide menu in small screens
        if ($(window).width() <= 992) {
            $('.wrapper').addClass('hide_menu');
            $('body').removeClass('mini_sidebar');
            $('body').addClass('left-hidden');
        }
        //Enable sidebar toggle
        $("[data-toggle='offcanvas'].sidebar-toggle").on('click', function(e) {
            e.preventDefault();
            $('body').toggleClass('left-hidden');
            //Toggle Menu
            if (!$('body').hasClass('mini_sidebar')) {
                $('.wrapper').toggleClass('hide_menu');
            }
        });
        //leftmenu init
        $('#menu').metisMenu();
        // INIT popovers
        $("[data-toggle='popover']").popover();
    });

    //Add hover support for touch devices
    $('.btn')
        .bind('touchstart', function() {
            $(this).addClass('hover');
        })
        .bind('touchend', function() {
            $(this).removeClass('hover');
        });

    //Activate tooltips
    $("[data-toggle='tooltip']").tooltip();

    /*
     * Add collapse and remove events to boxes
     */
    $("[data-widget='collapse']").click(function() {
        //Find the box parent
        var box = $(this)
            .parents('.box')
            .first();
        //Find the body and the footer
        var bf = box.find('.box-body, .box-footer');
        if (!box.hasClass('collapsed-box')) {
            box.addClass('collapsed-box');
            bf.slideUp();
        } else {
            box.removeClass('collapsed-box');
            bf.slideDown();
        }
    });

    /*
     * ADD SLIMSCROLL TO THE TOP NAV DROPDOWNS
     * ---------------------------------------
     */
    $('.navbar .menu')
        .slimscroll({
            height: '200px',
            alwaysVisible: true,
            size: '3px',
        })
        .css('width', '100%');

    /*
     * INITIALIZE BUTTON TOGGLE
     * ------------------------
     */

    $('.btn-group[data-toggle="btn-toggle"]').each(function() {
        var group = $(this);
        $(this)
            .find('.btn')
            .click(function(e) {
                group.find('.btn.active').removeClass('active');
                e.preventDefault();
            });
    });

    $("[data-widget='remove']").click(function() {
        //Find the box parent
        var box = $(this)
            .parents('.box')
            .first();
        box.slideUp();
    });

    $('input[type="file"]').change(function(e){
        let fileNames = [];

        console.log($(e.target).parent().find('.custom-file-label'));
        for(let file of e.target.files) {
            fileNames.push(file.name);
        }
        $(e.target).parent().find('.custom-file-label').text(fileNames.join(', '));
    });
});
function fix_sidebar() {
    //Make sure the body tag has the .fixed class
    if (!$('body').hasClass('fixed')) {
        return;
    }

    //Add slimscroll
    $('.sidebar').slimscroll({
        height: $(window).height() - $('.header').height() + 'px',
        color: 'rgba(0,0,0,0.2)',
    });
}
/*END DEMO*/

/* CENTER ELEMENTS */
(function($) {
    'use strict';
    jQuery.fn.center = function(parent) {
        if (parent) {
            parent = this.parent();
        } else {
            parent = window;
        }
        this.css({
            position: 'absolute',
            top: ($(parent).height() - this.outerHeight()) / 2 + $(parent).scrollTop() + 'px',
            left: ($(parent).width() - this.outerWidth()) / 2 + $(parent).scrollLeft() + 'px',
        });
        return this;
    };
})(jQuery);

//  jQuery resize event - v1.1 - 3/14/2010

// SlimScroll https://github.com/rochal/jQuery-slimScroll
//
// (function(f) {
//     jQuery.fn.extend({slimScroll: function(h) {
//         var a = f.extend({width: "auto", size: "7px", height:"200px",color: "#000", position: "right", distance: "1px", start: "top", opacity: 0.4, alwaysVisible: !1, disableFadeOut: !1, railVisible: !1, railColor: "#333", railOpacity: 0.2, railDraggable: !0, railClass: "slimScrollRail", barClass: "slimScrollBar", wrapperClass: "slimScrollDiv", allowPageScroll: !1, wheelStep: 20, touchScrollStep: 200, borderRadius: "0px", railBorderRadius: "0px"}, h);
//         this.each(function() {
//             function r(d) {
//                 if (s) {
//                     d = d ||
//                         window.event;
//                     var c = 0;
//                     d.wheelDelta && (c = -d.wheelDelta / 120);
//                     d.detail && (c = d.detail / 3);
//                     f(d.target || d.srcTarget || d.srcElement).closest("." + a.wrapperClass).is(b.parent()) && m(c, !0);
//                     d.preventDefault && !k && d.preventDefault();
//                     k || (d.returnValue = !1)
//                 }
//             }
//             function m(d, f, h) {
//                 k = !1;
//                 var e = d, g = b.outerHeight() - c.outerHeight();
//                 f && (e = parseInt(c.css("top")) + d * parseInt(a.wheelStep) / 100 * c.outerHeight(), e = Math.min(Math.max(e, 0), g), e = 0 < d ? Math.ceil(e) : Math.floor(e), c.css({top: e + "px"}));
//                 l = parseInt(c.css("top")) / (b.outerHeight() - c.outerHeight());
//                 e = l * (b[0].scrollHeight - b.outerHeight());
//                 h && (e = d, d = e / b[0].scrollHeight * b.outerHeight(), d = Math.min(Math.max(d, 0), g), c.css({top: d + "px"}));
//                 b.scrollTop(e);
//                 b.trigger("slimscrolling", ~~e);
//                 v();
//                 p()
//             }
//             function C() {
//                 window.addEventListener ? (this.addEventListener("DOMMouseScroll", r, !1), this.addEventListener("mousewheel", r, !1), this.addEventListener("MozMousePixelScroll", r, !1)) : document.attachEvent("onmousewheel", r)
//             }
//             function w() {
//                 u = Math.max(b.outerHeight() / b[0].scrollHeight * b.outerHeight(), D);
//                 c.css({height: u + "px"});
//                 var a = u == b.outerHeight() ? "none" : "block";
//                 c.css({display: a})
//             }
//             function v() {
//                 w();
//                 clearTimeout(A);
//                 l == ~~l ? (k = a.allowPageScroll, B != l && b.trigger("slimscroll", 0 == ~~l ? "top" : "bottom")) : k = !1;
//                 B = l;
//                 u >= b.outerHeight() ? k = !0 : (c.stop(!0, !0).fadeIn("fast"), a.railVisible && g.stop(!0, !0).fadeIn("fast"))
//             }
//             function p() {
//                 a.alwaysVisible || (A = setTimeout(function() {
//                     a.disableFadeOut && s || (x || y) || (c.fadeOut("slow"), g.fadeOut("slow"))
//                 }, 1E3))
//             }
//             var s, x, y, A, z, u, l, B, D = 30, k = !1, b = f(this);
//             if (b.parent().hasClass(a.wrapperClass)) {
//                 var n = b.scrollTop(),
//                     c = b.parent().find("." + a.barClass), g = b.parent().find("." + a.railClass);
//                 w();
//                 if (f.isPlainObject(h)) {
//                     if ("height"in h && "auto" == h.height) {
//                         b.parent().css("height", "200px");
//                         b.css("height", "200px");
//                         var q = b.parent().parent().height();
//                         b.parent().css("height", q);
//                         b.css("height", q)
//                     }
//                     if ("scrollTo"in h)
//                         n = parseInt(a.scrollTo);
//                     else if ("scrollBy"in h)
//                         n += parseInt(a.scrollBy);
//                     else if ("destroy"in h) {
//                         c.remove();
//                         g.remove();
//                         b.unwrap();
//                         return
//                     }
//                     m(n, !1, !0)
//                 }
//             } else {
//                 a.height = "auto" == a.height ? b.parent().height() : a.height;
//                 n = f("<div></div>").addClass(a.wrapperClass).css({position: "relative",
//                     overflow: "hidden", width: a.width, height: a.height});
//                 b.css({overflow: "hidden", width: a.width, height: a.height});
//                 var g = f("<div></div>").addClass(a.railClass).css({width: a.size, height: "200px", position: "absolute", top: 0, display: a.alwaysVisible && a.railVisible ? "block" : "none", "border-radius": a.railBorderRadius, background: a.railColor, opacity: a.railOpacity, zIndex: 90}), c = f("<div></div>").addClass(a.barClass).css({background: a.color, width: a.size, position: "absolute", top: 0, opacity: a.opacity, display: a.alwaysVisible ?
//                     "block" : "none", "border-radius": a.borderRadius, BorderRadius: a.borderRadius, MozBorderRadius: a.borderRadius, WebkitBorderRadius: a.borderRadius, zIndex: 99}), q = "right" == a.position ? {right: a.distance} : {left: a.distance};
//                 g.css(q);
//                 c.css(q);
//                 b.wrap(n);
//                 b.parent().append(c);
//                 b.parent().append(g);
//                 a.railDraggable && c.bind("mousedown", function(a) {
//                     var b = f(document);
//                     y = !0;
//                     t = parseFloat(c.css("top"));
//                     pageY = a.pageY;
//                     b.bind("mousemove.slimscroll", function(a) {
//                         currTop = t + a.pageY - pageY;
//                         c.css("top", currTop);
//                         m(0, c.position().top, !1)
//                     });
//                     b.bind("mouseup.slimscroll", function(a) {
//                         y = !1;
//                         p();
//                         b.unbind(".slimscroll")
//                     });
//                     return!1
//                 }).bind("selectstart.slimscroll", function(a) {
//                     a.stopPropagation();
//                     a.preventDefault();
//                     return!1
//                 });
//                 g.hover(function() {
//                     v()
//                 }, function() {
//                     p()
//                 });
//                 c.hover(function() {
//                     x = !0
//                 }, function() {
//                     x = !1
//                 });
//                 b.hover(function() {
//                     s = !0;
//                     v();
//                     p()
//                 }, function() {
//                     s = !1;
//                     p()
//                 });
//                 b.bind("touchstart", function(a, b) {
//                     a.originalEvent.touches.length && (z = a.originalEvent.touches[0].pageY)
//                 });
//                 b.bind("touchmove", function(b) {
//                     k || b.originalEvent.preventDefault();
//                     b.originalEvent.touches.length &&
//                     (m((z - b.originalEvent.touches[0].pageY) / a.touchScrollStep, !0), z = b.originalEvent.touches[0].pageY)
//                 });
//                 // w();
//                 // "bottom" === a.start ? (c.css({top: b.outerHeight() - c.outerHeight()}), m(0, !0)) : "top" !== a.start && (m(f(a.start).position().top, null, !0), a.alwaysVisible || c.hide());
//                 // C()
//             }
//         });
//         return this
//     }});
//     jQuery.fn.extend({slimscroll: jQuery.fn.slimScroll})
// })(jQuery);

//Back to top code
$(document).ready(function() {
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
//color switcher code
$(function() {
    //BEGIN THEME SETTING
    $('#theme-setting > a.btn-theme-setting').click(function() {
        if ($('#theme-setting').css('right') < '0') {
            $('#theme-setting').css('right', '0');
        } else {
            $('#theme-setting').css('right', '-250px');
        }
    });
    $('#white').click(function() {
        //		alert('white clicked');
        $('#colorscheme').attr('href', 'css/styles/white.css');
    });
    $('#blacks').click(function() {
        //		alert('black clicked');
        $('#colorscheme').attr('href', 'css/styles/black.css');
    });
    // Begin Change Theme Color
});

//Code for collpasing panels

$(document).on('click', '.removepanel', function() {
    var $this = $(this);
    $this.parents('.card').hide('slow');
});
//panel hide
$('.showhide').attr('title', 'Hide Panel content');
$(document).on('click', '.clickable', function(e) {
    var $this = $(this);
    if (!$this.hasClass('card-collapsed')) {
        $this
            .parents('.card')
            .find('.card-body')
            .slideUp();
        $this.addClass('card-collapsed');
        $this
            .closest('i')
            .removeClass('fa-chevron-up')
            .addClass('fa-chevron-down');
        $('.showhide').attr('title', 'Show Panel content');
    } else {
        $this
            .parents('.card')
            .find('.card-body')
            .slideDown();
        $this.removeClass('card-collapsed');
        $this
            .closest('i')
            .removeClass('fa-chevron-down')
            .addClass('fa-chevron-up');
        $('.showhide').attr('title', 'Hide Panel content');
    }
});
//leftmenu init
$(function() {
    $('#menu').metisMenu();
});

$('.sub-menu .active')
    .parent()
    .parent('li')
    .first('a')
    .css('background', '#414151');

$("#toggleAll").click(function(){
    if($("#toggleAll").is(':checked') ){
        $('.select2 > option').prop("selected", true).trigger("change");
    }else{
        $('.select2 > option').prop("selected", false).trigger("change");
    }
});

// Add the Select All and Deselect all options to the chosen multiselect control
$(".chosen-select.chosen-select-all").each(function(){
    var parentSelect = $(this);

    //check to see if this was already added.
    var selectAllOption = parentSelect.find("option[value='chosen-select-all-option']");
    if(selectAllOption == undefined || selectAllOption.length == 0){
        //Add the options as default first and last for Select and Deselect respectively.
        parentSelect.prepend("<option value='chosen-select-all-option' id='chosen-select-all-option'>-- Select All --</option>");
        parentSelect.append("<option value='chosen-select-none-option' id='chosen-select-none-option'>-- Deselect All --</option>");

        //When it chages loop through the options list to see which were selected.
        parentSelect.change(function() {
            $(this).find("option:selected").each(function(){
                var value = $(this).attr("value");
                switch (value){
                    //If one of the options selected was the 'Select All' option, remove the Select All and Deselect All options, set all other options to selected, add the master Select All and Deselect All back after the fact. Update Chosen
                    case "chosen-select-all-option":
                        parentSelect.find("option[value='chosen-select-all-option']").remove();
                        parentSelect.find("option[value='chosen-select-none-option']").remove();
                        parentSelect.find("option").prop("selected","selected");
                        parentSelect.prepend("<option value='chosen-select-all-option' id='chosen-select-all-option'>-- Select All --</option>");
                        parentSelect.append("<option value='chosen-select-none-option' id='chosen-select-none-option'>-- Deselect All --</option>");
                        parentSelect.trigger("chosen:updated");
                        break;
                    case "chosen-select-none-option":
                        parentSelect.find("option[value='chosen-select-all-option']").remove();
                        parentSelect.find("option[value='chosen-select-none-option']").remove();
                        parentSelect.find("option").prop("selected",false);
                        parentSelect.prepend("<option value='chosen-select-all-option' id='chosen-select-all-option'>-- Select All --</option>");
                        parentSelect.append("<option value='chosen-select-none-option' id='chosen-select-none-option'>-- Deselect All --</option>");
                        parentSelect.trigger("chosen:updated");
                        break;
                }
            });
        }).trigger( "change" );

        //Update chosen to include the Select all and Deselect All options
        parentSelect.trigger("chosen:updated");
    }
});