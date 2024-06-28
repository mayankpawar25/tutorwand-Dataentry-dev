$(document).ready(function() {
    var owl = $('#owl-carousel2');
    let itemCount = 3;
    if (totalEvt > 0 ) {
        itemCount = 3 - (totalEvt % 3);
    }
    owl.owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: true,
        autoplay: true,
        nav: false,
        dots: false,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,

            },
            600: {
                items: 2,

            },
            1000: {
                items: itemCount,
                loop: true,
                margin: 30
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
let loadIcon = `<i class="fa fa-refresh pageRefresh cursor-pointer" aria-hidden="true"></i>`;

function loadClassRooms() {
    $.ajax({
        type: "GET",
        url: getClassRoomURL,
        dataType: "json",
        success: function(response) {
            $("div#classlists").html(response.html);
            $(".replace-icon").html(loadIcon);
            if ($(".replace-icon").hasClass('d-none')) {
                $(".replace-icon").removeClass('d-none');
            }
            if (response.status == false) {
                $("#createClassModal").modal();
            }
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
            $("span#previousDue").html(response.previousDue);
        }
    });
}
$(document).on("click", ".pageRefresh", function() {
    $(this).parent().html(buttonSpinner);
    refreshClassLiist();
});

function refreshClassLiist() {
    $.ajax({
        type: "GET",
        url: refreshClassURL,
        success: function(response) {
            $("div#classlists").html(response.html);
            $(".replace-icon").html(loadIcon);
            if ($(".replace-icon").hasClass('d-none')) {
                $(".replace-icon").removeClass('d-none');
            }
        }
    });
}

loadClassRooms();
loadTodayPreviousDue();