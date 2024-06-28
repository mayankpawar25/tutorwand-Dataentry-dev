// JavaScript Document
$(window).on('load', function() {

    $('#loader-wrapper').hide();

}); //ready
// loader

// custom page with background on side
$('.side-bg').each(function() {
    $(this).find(".image-container").css("height", $(this).find(".image-container").parent().css("height"));
});
/* --------------------------------------------------
 * custom background
 * --------------------------------------------------*/
function custom_bg() {
    $("div,section").css('background-color', function() {
        return jQuery(this).data('bgcolor');
    });
    $("div,section").css('background-image', function() {
        return jQuery(this).data('bgimage');
    });
    $("div,section").css('background-size', function() {
        return 'cover';
    });
}

/*banner end*/
// nav trigger
$(".navbar-toggler").click(function() {

    $(".navbar-expand-lg").toggleClass("drawer-open");

});
/*owl js*/
//for products

// sticky header
$(window).scroll(function() {

    var sticky = $('.sticky'),

        scroll = $(window).scrollTop();

    if (scroll >= 50) sticky.addClass('fixed');

    else sticky.removeClass('fixed');

});

wow = new WOW(

    {

        animateClass: 'animated',

        offset: 100,

        callback: function(box) {

        }
    }

);

wow.init();

$('*').each(function() {

    if ($(this).attr('data-animation')) {

        var $animationName = $(this).attr('data-animation'),

            $animationDelay = "delay-" + $(this).attr('data-animation-delay');

        $(this).appear(function() {

            $(this).addClass('wow').addClass($animationName);

            $(this).addClass('wow').addClass($animationDelay);

        });

    }

});
// navigation active
$(window).scroll(function() {
        var t = $("#myHeader");
        $(window).scrollTop() >= 50 ? t.addClass("sticky") : t.removeClass("sticky")
    }),
    function(t, i, e, n) {
        var o = function(n, o) {
            this.elem = n, this.$elem = t(n), this.options = o, this.metadata = this.$elem.data("plugin-options"), this.$win = t(i), this.sections = {}, this.didScroll = !1, this.$doc = t(e), this.docHeight = this.$doc.height()
        };
        o.defaults = (o.prototype = {
            defaults: {
                navItems: "a",
                currentClass: "current",
                changeHash: !1,
                easing: "swing",
                filter: "",
                scrollSpeed: 750,
                scrollThreshold: .5,
                begin: !1,
                end: !1,
                scrollChange: !1
            },
            init: function() {
                return this.config = t.extend({}, this.defaults, this.options, this.metadata), this.$nav = this.$elem.find(this.config.navItems), "" !== this.config.filter && (this.$nav = this.$nav.filter(this.config.filter)), this.$nav.on("click.onePageNav", t.proxy(this.handleClick, this)), this.getPositions(), this.bindInterval(), this.$win.on("resize.onePageNav", t.proxy(this.getPositions, this)), this
            },
            adjustNav: function(t, i) {
                t.$elem.find("." + t.config.currentClass).removeClass(t.config.currentClass), i.addClass(t.config.currentClass)
            },
            bindInterval: function() {
                var t, i = this;
                i.$win.on("scroll.onePageNav", function() {
                    i.didScroll = !0
                }), i.t = setInterval(function() {
                    t = i.$doc.height(), i.didScroll && (i.didScroll = !1, i.scrollChange()), t !== i.docHeight && (i.docHeight = t, i.getPositions())
                }, 250)
            },
            getHash: function(t) {
                return t.attr("href").split("#")[1]
            },
            getPositions: function() {
                var i, e, n, o = this;
                o.$nav.each(function() {
                    i = o.getHash(t(this)), n = t("#" + i), screen.width < 1e3 ? screen.width < 768 ? n.length && (e = n.offset().top - 50, o.sections[i] = Math.round(e)) : n.length && (e = n.offset().top - 10, o.sections[i] = Math.round(e)) : n.length && (e = n.offset().top - 120, o.sections[i] = Math.round(e))
                })
            },
            getSection: function(t) {
                var i = null,
                    e = Math.round(this.$win.height() * this.config.scrollThreshold);
                for (var n in this.sections) this.sections[n] - e < t && (i = n);
                return i
            },
            handleClick: function(e) {
                var n = this,
                    o = t(e.currentTarget),
                    s = o.parent(),
                    a = "#" + n.getHash(o);
                s.hasClass(n.config.currentClass) || (n.config.begin && n.config.begin(), n.adjustNav(n, s), n.unbindInterval(), n.scrollTo(a, function() {
                    n.config.changeHash && (i.location.hash = a), n.bindInterval(), n.config.end && n.config.end()
                })), e.preventDefault()
            },
            scrollChange: function() {
                var t, i = this.$win.scrollTop(),
                    e = this.getSection(i);
                null !== e && ((t = this.$elem.find('a[href$="#' + e + '"]').parent()).hasClass(this.config.currentClass) || (this.adjustNav(this, t), this.config.scrollChange && this.config.scrollChange(t)))
            },
            scrollTo: function(i, e) {
                if (screen.width < 1e3)
                    if (screen.width < 768) var n = t(i).offset().top - 50;
                    else n = t(i).offset().top - 10;
                else n = t(i).offset().top - 70;
                t("html, body").animate({
                    scrollTop: n
                }, this.config.scrollSpeed, this.config.easing, e)
            },
            unbindInterval: function() {
                clearInterval(this.t), this.$win.unbind("scroll.onePageNav")
            }
        }).defaults, t.fn.onePageNav = function(t) {
            return this.each(function() {
                new o(this, t).init()
            })
        }
    }(jQuery, window, document), $(document).ready(function() {
        $("#nav").onePageNav({
            filter: ":not(.external)"
        })
    });

// light box

$('#myModal').on('shown.bs.modal', function(e) {
    // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
    let videoSrc = $('.video-outer').data("src");
    $("#player").attr('src', videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
});

// stop playing the youtube video when I close the modal
$('#myModal').on('hide.bs.modal', function(e) {
    // a poor man's stop video
    let videoSrc = $('.video-outer').data("src");
    $("#player").attr('src', videoSrc);
});

// testimonial slider
$(document).ready(function() {
    var owl = $('#owl-carousel4');
    owl.owlCarousel({
        //$('.owl-carousel').owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: true,
        autoplay: true,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 1,
                nav: false
            },
            1000: {
                items: 2,
                nav: true,
                loop: true,
                margin: 14
            }
        }
    })
    $(".owl-prev").html('<i class="fa fa-angle-left"></i>');
    $(".owl-next").html('<i class="fa fa-angle-right"></i>');
})