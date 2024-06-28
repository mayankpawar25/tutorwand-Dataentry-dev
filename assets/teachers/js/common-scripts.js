//side panel
$(".fixed-side-panel-trigger ").click(function() {
    $(".fixed-side-panel ").toggleClass("fixed-panel-open ");
    $(".fixed-side-panel-trigger ").toggleClass("rotate-180 ");
    $(".main-header ").toggleClass("slide-100 ");
});

//side panel
$(".fixed-side-panel-trigger-right ").click(function() {
    //$(".fixed-side-panel ").toggleClass("right-panel ");
    $(".fixed-side-panel-trigger-right ").toggleClass("rotate-180 ");
    $(".main-body ").toggleClass("slide-100 ");
    $(".right-panel ").toggleClass("hide-panel ");
    $(".canvas-area ").toggleClass("hide-right-panel ");
});