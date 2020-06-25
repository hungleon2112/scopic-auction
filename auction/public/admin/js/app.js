/*
 Template Name: lexa - Responsive Bootstrap 4 Admin Dashboard
 Author: Themesbrand
 Website: www.themesbrand.com
 File: Main js
 */


!function($) {
    "use strict";

    var MainApp = function() {};

    MainApp.prototype.intSlimscrollmenu = function () {
        $('.slimscroll-menu').slimscroll({
            height: 'auto',
            position: 'right',
            size: "5px",
            color: '#9ea5ab',
            wheelStep: 5,
            touchScrollStep: 50
        });
    },
    MainApp.prototype.initSlimscroll = function () {
        $('.slimscroll').slimscroll({
            height: 'auto',
            position: 'right',
            size: "5px",
            color: '#9ea5ab',
            touchScrollStep: 50
        });
    },

    MainApp.prototype.initMetisMenu = function () {
        //metis menu
        $("#side-menu").metisMenu();
    },

    MainApp.prototype.initLeftMenuCollapse = function () {
        // Left menu collapse
        $('.button-menu-mobile').on('click', function (event) {
            event.preventDefault();
            $("body").toggleClass("enlarged");
        });
    },

    MainApp.prototype.initEnlarge = function () {
        if ($(window).width() < 1025) {
            $('body').addClass('enlarged');
        } else {
            $('body').removeClass('enlarged');
        }
    },

    MainApp.prototype.initActiveMenu = function () {
        // === following js will activate the menu in left side bar based on url ====
        $("#sidebar-menu a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("active"); // add active to li of the current link
                $(this).parent().parent().addClass("in");
                $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
                $(this).parent().parent().parent().addClass("active");
                $(this).parent().parent().parent().parent().addClass("in"); // add active to li of the current link
                $(this).parent().parent().parent().parent().parent().addClass("active");
            }
        });
    },

    MainApp.prototype.initComponents = function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
    },

    MainApp.prototype.initHeaderCharts = function () {
        $('#header-chart-1').sparkline([8, 6, 4, 7, 10, 12, 7, 4, 9, 12, 13, 11, 12], {
            type: 'bar',
            height: '35',
            barWidth: '5',
            barSpacing: '3',
            barColor: '#7A6FBE'
        });
        $('#header-chart-2').sparkline([8, 6, 4, 7, 10, 12, 7, 4, 9, 12, 13, 11, 12], {
            type: 'bar',
            height: '35',
            barWidth: '5',
            barSpacing: '3',
            barColor: '#29bbe3'
        });
    },

    MainApp.prototype.init = function () {
        this.intSlimscrollmenu();
        this.initSlimscroll();
        this.initMetisMenu();
        this.initLeftMenuCollapse();
        this.initEnlarge();
        this.initActiveMenu();
        this.initComponents();
        this.initHeaderCharts();
        Waves.init();
    },

    //init
    $.MainApp = new MainApp, $.MainApp.Constructor = MainApp
}(window.jQuery),

//initializing
function ($) {
    "use strict";
    $.MainApp.init();
}(window.jQuery);


$(document).ready(function () {
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
    if($(".editor").length > 0){
        tinymce.init({
            selector: "textarea.editor",
            theme: "modern",
            height:300,
            toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
            valid_styles : 'text-align,color,font-size',
            entity_encoding : "raw"
        });
    }
    var _loader = $('.loader');
    _loader.fadeOut(1000);
    $( "form" ).submit(function () {
        if($(this).attr('id') !== 'createUser'){
            _loader.show();
        }
    });
});
function restoreItem (url) {
    if(confirm('Are you sure you want to restore this item?')){
        $.ajax({
            type: "POST",
            url: url,
            success: function () {
                alert('Item is restored!');
                window.location.reload();
            },
            error: function () {
                alert('Cannot restore this item due to system error!');
            }
        });
    }
}
function startTime() {
    var today = new Date();
    var y = today.getFullYear();
    const mo = today.toLocaleString('default', { month: 'long' });
    var d = today.getUTCDate();
    var h = today.getUTCHours();
    var m = today.getUTCMinutes();
    var s = today.getUTCSeconds();
    d = checkTime(d);
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('systemTime').innerHTML =
        y + '-'+ mo + '-' + d + ' ' + h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
function stripSpecialCharacter(object, keep = '') {
    let str = '[^a-z0-9\u0026'+keep+']';
    let regex = new RegExp( str , 'gi');
    // /[^a-z0-9\s]/gi
    object.value = object.value.replace(regex, '');
}
function formatNumber(object) {
    let str = '[^\-?0-9\.]';
    let regex = new RegExp( str , 'gi');
    object.value = object.value.replace(regex, '');
}
