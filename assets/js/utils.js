const __INTERVAL = 1000;
const __TIMEOUTINTERVAL = 5000;
let elem = document.documentElement;

let isOnline = true;

function onlineChecker(onlineMsg, offlineMsg) {
    setInterval(() => {
        if (navigator.onLine) {
            if (isOnline == false) {
                isOnline = true;
                if ($('.info-banner').length > 0) {
                    $('.info-banner').remove();
                }
                $('.main-body div:eq(0)').before(`<div class="info-banner online">${onlineMsg}</div>`);
                $(".main-body .container-fluid").addClass("container-wth-banner");
                setTimeout(() => {
                    if ($('.info-banner').length > 0) {
                        $('.info-banner').remove();
                        $(".main-body .container-fluid").removeClass("container-with-banner");
                    }
                }, __TIMEOUTINTERVAL);
            } else {
                if ($('container-with-banner').length > 0) {
                    $(".main-body .container-fluid").removeClass("container-with-banner");
                }
            }
            $(".startExamBtn").attr({
                "disabled": false
            });
        } else {
            isOnline = false;
            if (!$('.info-banner.offline').length) {
                $(".startExamBtn").attr({
                    "disabled": true
                });
                $('.main-body div:eq(0)').before(`<div class="info-banner offline">${offlineMsg}</div>`);
                $(".main-body .container-fluid").removeClass("container-wth-banner");
            }
        }
    }, __INTERVAL);
}


function onlineCheckerExam(onlineMsg, offlineMsg, offlineTimeUpText) {
    setInterval(() => {
        if (navigator.onLine) {
            if (isOnline == false) {
                isOnline = true;
                if ($('.info-banner').length > 0) {
                    $('.info-banner').remove();
                }
                $('.main-body div:eq(0)').before(`<div class="info-banner online">${onlineMsg}</div>`);
                $(".main-body .container-fluid").addClass("container-wth-banner");
                setTimeout(() => {
                    if ($('.info-banner').length > 0) {
                        $('.info-banner').remove();
                        $(".main-body .container-fluid").removeClass("container-with-banner");
                    }
                }, __TIMEOUTINTERVAL);
            } else {
                if ($('container-with-banner').length > 0) {
                    $(".main-body .container-fluid").removeClass("container-with-banner");
                }
            }
        } else {
            isOnline = false;
            if (timeLeft > 0) {
                if (!$('.info-banner.offline').length) {
                    $('.main-body div:eq(0)').before(`<div class="info-banner offline">${offlineMsg}</div>`);
                    $(".main-body .container-fluid").removeClass("container-wth-banner");
                }
            } else {
                $('.info-banner').remove();
                if (!$('.info-banner.offline').length) {
                    $('.main-body div:eq(0)').before(`<div class="info-banner offline">${offlineTimeUpText}</div>`);
                    $(".main-body .container-fluid").removeClass("container-wth-banner");
                }
            }
        }
    }, __INTERVAL);
}


function underElementError(element, message, isRemove = true) {
    if (isRemove) {
        $('.text-danger.error-msg').remove();
    }
    $(element).after(`<div class="text-danger error-msg">${message}</div>`)
}

function msgToast(type, message) {
    // toastr.clear();
    toastr.options = {
        "closeButton": true,
        "preventDuplicates": true,
        "preventOpenDuplicates": true
    };
    let toastTitle = '';
    switch (type) {
        case "success":
            toastTitle = 'Success';
            break;
        case "info":
            toastTitle = 'Information';
            break;
        case "warning":
            toastTitle = 'Warning';
            break;
        case "error":
            toastTitle = 'Alert';
            break;

        default:
            toastTitle = 'Success';
            break;
    }
    toastr.remove();
    if ($('#toast-container').length <= 0) {
        toastr[type](`<div class='toast-title'>${toastTitle}</div><div class='toast-message'>${message}</div>`);
    }
}

/* View in fullscreen */
function openFullscreen() {
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.webkitRequestFullscreen) { /* Safari */
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) { /* IE11 */
        elem.msRequestFullscreen();
    }
}

/* Close fullscreen */
function closeFullscreen() {
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.webkitExitFullscreen) { /* Safari */
        document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) { /* IE11 */
        document.msExitFullscreen();
    }
}

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).val()).select();
    document.execCommand("copy");
    $temp.remove();
    msgToast('info', 'Link copied to clipboard.');
}

/* Keyboard Accessibility */
$('[tabindex=0]').on("keypress", function(e) {
    if (e.keyCode == '32' || e.keyCode == '13') {
        $(this).click();
    }
});


/* $(document).on("keypress", ".selectOptGroup", function (e) {
    console.log(e.keyCode, 'focus');
    if(e.keyCode == '30') {
        alert("keydown");
    }
    if (e.keyCode == '32' || e.keyCode == '13') {
        $(this).click();
    }
}); */

/* Back to top */
let btn = $('#back-to-top');

$(window).scroll(function() {
    if ($(window).scrollTop() > 100) {
        btn.addClass('show');
    } else {
        btn.removeClass('show');
    }
});

btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({
        scrollTop: 0
    }, '300');
});

$(function() {
    $('input').attr('autocomplete', 'off');
    disableSelect();

    setCookie('timezoneOffset', new Date().getTimezoneOffset(), 1);
});

function setCookie(key, value, expiry) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
}

function disableSelect() {
    if (!$('body').hasClass('data-injetion')) {
        document.onselectstart = new Function('return false;');
    }
}

$('body').bind('cut copy paste', function(e) {
    if (!$('body').hasClass('data-injetion')) {
        if ($(this).hasClass('copy-enable')) {
            return true;
        } else {
            msgToast('error', 'Cut/Copy is not allowed');
        }
        return false;
    }
});

$("body").bind('contextmenu', function(e) {
    if (!$('body').hasClass('data-injetion')) {
        msgToast('error', 'Right click is not allowed');
        return false;
    }
});

function getTimeZone() {
    var timezone_offset_minutes = new Date().getTimezoneOffset();
    timezone_offset_minutes = timezone_offset_minutes == 0 ? 0 : -timezone_offset_minutes;
    return timezone_offset_minutes;
    // Timezone difference in minutes such as 330 or -360 or 0
}

$('div.modal').on('hidden.bs.modal', function (e) {
    if ($(this).hasClass('modal-fullscreen')) {
        $(this).find('.enlarge-popup-btn').click();
    }
    $('[data-toggle="tooltip"]').tooltip('dispose');
    $('[data-toggle="tooltip"]').tooltip();
});
