$(document).ready(function() {
    var owl = $('#owl-carousel4');
    owl.owlCarousel({
        loop: true,
        margin: 10,
        responsiveClass: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                margin: 0
            },
            600: {
                items: 2,
                nav: false
            },
            1000: {
                items: 2,
                nav: true,
                loop: false,
                margin: 14
            }
        }
    })
    $(".owl-prev").html('<i class="fa fa-angle-left"></i>');
    $(".owl-next").html('<i class="fa fa-angle-right"></i>');
})

$('#videoModal').on('shown.bs.modal', function(e) {
    // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
    let videoSrc = $('.video-btn').data("src");
    $("#videoplayer").attr('src', videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
});

// stop playing the youtube video when I close the modal
$('#videoModal').on('hide.bs.modal', function(e) {
    // a poor man's stop video
    let videoSrc = $('.video-btn').data("src");
    $("#videoplayer").attr('src', videoSrc);
});

function loadClassRooms() {
    $.ajax({
        type: "GET",
        url: getClassRoomURL,
        dataType: "json",
        success: function(response) {
            $("div#classroomList").html(response.html);
        }
    });
}

function loadTodayPreviousDue() {
    $.ajax({
        type: "GET",
        url: getAssessmentURL,
        dataType: "json",
        success: function(response) {
            $("span#todayDue").html(response.todayDue);
            $("span#result").html(response.previousDue);
        }
    });
}

loadClassRooms();
loadTodayPreviousDue();