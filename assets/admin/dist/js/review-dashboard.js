$(function () {


    $("select[name='boardId']").change();


});





$(".datepicker").datetimepicker({


    timepicker:false,


    format:'Y-m-d'


});





$(document).on('change', '.filterChange', function(){


    let currentValue = $(this).val();


    let selectType = $(this).data('selected');


    let changeOn = $(this).data('reflecton');





    let boardId = $('.boards option:selected').val();


    let gradeId = $('.grades option:selected').val();


    let subjectId = $('.subjects option:selected').val();


    let topicId = $('.topics option:selected').val();


    resetFilters(selectType);


    $.ajax({


        type: "POST",


        url: $("#urlChange").val(),


        data: { "changeOn": changeOn, "selectType": selectType, "boardId": boardId, "gradeId": gradeId, "subjectId": subjectId, "topicId": topicId },


        dataType: "json",


        headers: {


            "X-CSRF-TOKEN": $('input[name=_token]').val()


        },


        success: function (response) {


            $(`.${changeOn}`).html(response.html);


            $(`.${changeOn}`).attr({'disabled' : false});


        },


        error: function (error){


            console.log("error", error);


        }


    });


});





$(document).on('click', '#submit-filter', function(){


    var formddata = $("#filter-data").serialize();


    $.ajax({


        url: "{{ route('review.question') }}",


        type: 'POST',


        dataType: 'json',


        data: formddata,


        headers: {


            "X-CSRF-TOKEN": "{{ csrf_token() }}"


        },


    })


    .done(function(response) {


        console.log("success", response);


    })


    .fail(function(error) {


        console.log("error",error);


    })


    .always(function(response) {


        console.log("complete", response);


    });


});








function resetFilters(selecttype) {


    var htmlGrades = `<option value=""> Select grade </option>`;


    var htmlSubject = `<option value=""> Select subject </option>`;


    var htmlTopic = `<option value=""> Select topic </option>`;


    var htmlSubtopic = `<option value=""> Select subtopic </option>`;


    switch (selecttype) {


        case "boards":


            $(".grades").html(`${htmlGrades}`).val("").attr({ "disabled": true });


            $(".subjects").html(`${htmlSubject}`).val("").attr({ "disabled": true });


            $(".topics").html(`${htmlTopic}`).val("").attr({ "disabled": true });


            $(".subtopics").html(`${htmlSubtopic}`).val("").attr({ "disabled": true });


            break;


        case "grades":


            $(".subjects").html(`${htmlSubject}`).val("").attr({ "disabled": true });


            $(".topics").html(`${htmlTopic}`).val("").attr({ "disabled": true });


            $(".subtopics").html(`${htmlSubtopic}`).val("").attr({ "disabled": true });


            break;


        case "subjects":


            $(".topics").html(`${htmlTopic}`).val("").attr({ "disabled": true });


            $(".subtopics").html(`${htmlSubtopic}`).val("").attr({ "disabled": true });


            break;


        case "topics":


            $(".subtopics").html(`${htmlSubtopic}`).val("").attr({ "disabled": true });


            break;


    }


}





$(document).on('submit', '#dashboard-filter-form', function() {


    let postData = { 'BoardId': $('#boardId').val(), 'GradeId': $('#gradeId').val(), 'SubjectId': $('#subjectId').val(), 'StatusId': $('#statusId').val(), 'Source': $('#source').val(), 'DifficultyLevel': $('#difficultyLevel').val()};


    let url = $('#postURL').val();


    let spinner_loader = `<div id="loader-modal">


            <div id="loader1"> 


                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 80" enable-background="new 0 0 0 0" xml:space="preserve">


                    <circle fill="#178D8D" stroke="none" cx="6" cy="50" r="6">


                        <animateTransform


                        attributeName="transform"


                        dur="1s"


                        type="translate"


                        values="0 15 ; 0 -15; 0 15"


                        repeatCount="indefinite"


                        begin="0.1"/>


                    </circle>


                    <circle fill="#178D8D" stroke="none" cx="30" cy="50" r="6">


                        <animateTransform


                        attributeName="transform"


                        dur="1s"


                        type="translate"


                        values="0 10 ; 0 -10; 0 10"


                        repeatCount="indefinite"


                        begin="0.2"/>


                    </circle>


                    <circle fill="#178D8D" stroke="none" cx="54" cy="50" r="6">


                        <animateTransform


                        attributeName="transform"


                        dur="1s"


                        type="translate"


                        values="0 5 ; 0 -5; 0 5"


                        repeatCount="indefinite"


                        begin="0.3"/>


                    </circle>


                    </svg>


            </div>


        </div>`;


    $('.search-dashboard').html(spinner_loader);


    $.ajax({


        type: "POST",


        url: url,


        data: postData,


        dataType: "html",


        headers: {


            "X-CSRF-TOKEN": $('input[name=_token]').val()


        },


        success: function (response) {


            $('.search-dashboard').html(response);


            $('.get-filter-data').text(`${$('.boards option:selected').text()} | ${$('.grades option:selected').text()} | ${$('.subjects option:selected').text()}`);


        },


        error: function (error) {


            console.log("error", error);


        }


    })


    return false;


});