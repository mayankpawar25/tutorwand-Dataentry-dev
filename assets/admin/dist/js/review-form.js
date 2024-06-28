$(".datepicker").datetimepicker({
    timepicker:false,
    format:'Y-m-d'
});





// Load Topic Subtopic on change
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





/* Load Subtopic on change Topic */


$(document).on("change", ".onChangeSelect", function(){


    var type = $(this).data("type");


    var selecttype = $(this).data("selecttype");


    var value = $(this).val();


    var boardId = $(".boards option:selected").val();


    var gradeId = $(".grades option:selected").val();


    var subjectId = $(".subjects option:selected").val();


    var topicId = $(".topics option:selected").val();


    var subtopicId = $(".subtopics option:selected").val();





    resetFilters(selecttype);





    if(boardId != ""){


        $.ajax({


            type: "GET",


            url: $("#selectFilterUrl").val(),


            data: { "type": type , "selecttype": selecttype, "boardId":boardId, "gradeId":gradeId, "subjectId": subjectId, "topicId": topicId , "subtopicId": subtopicId },


            dataType: "html",


            success: function (response) {


                $(`.${type}`).html(response);


                $(`.${type}`).attr({ "disabled": false });


                $('.approveBtn').attr({'data-change': true});


            }


        });


    }


});





$(document).on('change','select[name=subtopics]', function() {


    $('.approveBtn').attr({'data-change': true});


});





$(document).on('change','select[name=difficulty_level]', function() {


    $('.approveBtn').attr({'data-change': true});


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


        return true;


    })


    .fail(function(error) {


        return false;


    })


    .always(function(response) {


        return false;


    });


});





/* Question Update OnClick Approve , Reject, Hold Button Method*/


$(document).on('click','.approveBtn, .rejectBtn, .holdBtn',function() {
    let textBtn = $(this).text();
    let questionTitle = $('textarea[name=inputQuestion]').val();
    let answerTitle = $('textarea[name=inputAnswer]').val();
    let answerVariation = [];
    $('[id^=mta-variation-]').each(function() {
        let idSelector = $(this).attr('id');
        answerVariation.push($(this).val());
    })
    let hintTitle = $('textarea[name=hint]').val();
    let extendedSolitionTitle = $('textarea[name=extendedsolution]').val();
    let yearsTitle = $('input[name=year]').val();
    if( typeof(yearsTitle) == "string" && yearsTitle != ""){
        yearsTitle = $('input[name=year]').val().split(',');
    }
    let optionData = getMcqOptions();
    let subjectId = $("select[name=subjects] option:selected").val();
    let topicId = $("select[name=topics] option:selected").val();
    let subtopicId = $("select[name=subtopics] option:selected").val();
    let diffLevel = $("select[name=difficulty_level] option:selected").val();
    let isVerified = false;
    let question_type = $('.question_type').val();
    let dataUrl = $("#statusUrl").val();
    let statusId = $(this).attr('data-statusId');
    let postData = { questionId: $('input[name=questionId]').val(), reviewerId: $('input[name=reviewerId]').val(), statusId: statusId };
    if ($.trim(textBtn) == 'Approve' || ($.trim(textBtn) == 'Approve' && ($('.approveBtn').attr('data-change') == "true" || $('.approveBtn').attr('data-change') == true))) {
        if (topicId != "" && subtopicId != "" && diffLevel != "") {
            let questionSet = {};
            if(question_type.indexOf('unseen-passage_') != -1){
                questionSet = setPassageFormat()
            }else {
                questionSet = setQuestionFormat(questionTitle, answerTitle, answerVariation, hintTitle, extendedSolitionTitle, yearsTitle, optionData);
            }
           
            if (confirm(`Are you sure want ${textBtn} question ?`)) {
                $(".approveBtn, .rejectBtn, .holdBtn").attr({ "disabled": true });
                let spinner = `<span class="spinner-border spinner-border-sm"></span> ${textBtn}`;
                $(this).html(spinner);
                approveQuestionAndUpdate(questionSet, postData, dataUrl, textBtn, $(this));
            }
        } else {
            msgToast('error', selectFilters);
            $(this).removeClass("disabled");
        }
    } else {


        if (confirm(`Are you sure want ${textBtn} question ?`)) {


            $(".approveBtn, .rejectBtn, .holdBtn").attr({ "disabled": true });


            let spinner = `<span class="spinner-border spinner-border-sm"></span> ${textBtn}`;


            $(this).html(spinner);


            ajaxSubmit(postData, dataUrl, textBtn, $(this));


        }


    }


});





/* Load Next Question */


$(document).on("click", ".next-btn", function(){


    $(".next-btn, .prev-btn").attr({ "disabled" : true });


    $(".approveBtn, .rejectBtn, .holdBtn").attr({ "disabled" : true });


    let textBtn = $(this).text();


    let spinner = `<span class="spinner-border spinner-border-sm"></span> ${textBtn}`;


    $(this).html(spinner);


    


    let questionNumber = parseInt($(".questionNumber").val()) + 1;


    $(".questionNumber").val(questionNumber);


    ajaxPagination(questionNumber);


});





/* Load Prev. Question */


$(document).on("click", ".prev-btn", function(){


    $(".approveBtn, .rejectBtn, .holdBtn").attr({ "disabled" : true });


    $(".next-btn, .prev-btn").attr({ "disabled" : true });


    let textBtn = $(this).text();


    let spinner = `<span class="spinner-border spinner-border-sm"></span> ${textBtn}`;


    $(this).html(spinner);





    let questionNumber = parseInt($(".questionNumber").val()) - 1;


    if(questionNumber > 0){


        $(".questionNumber").val(questionNumber);


        ajaxPagination(questionNumber);


    }


});





/* Update Question Filter Changes then Approve Question */


function approveQuestionAndUpdate(QuestionUpdateData, ApproveQuestionData, dataUrl, textBtn, here) {


    $.ajax({


        timeout: 10000,


        type: "POST",


        url: $("#submitUrl").val(),


        data: { templateData: QuestionUpdateData },


        dataType: "json",


        headers: {


            "X-CSRF-TOKEN": $("input[name=_token]").val()


        },


        success: function (response) {


            if(response.status){


                // If Question Updated then execute approval method


                ajaxSubmit(ApproveQuestionData, dataUrl, textBtn, here);


            } else {


                // If Question updation failed then execution of approval stop


                msgToast('error', response.msg);


                return false;


            }


        },


        error: function(error) {


            msgToast('error', somethingWentWrong);


            return false;


        }


    });


}





/* Question Approval, Reject, or Hold Ajax */


function ajaxSubmit(postData, dataUrl, textBtn, here) {


    $.ajax({


        url: dataUrl,


        type: 'GET',


        dataType: 'json',


        data: postData,


        timeout:10000,


        success: function(resp){


            if(resp.status){


                msgToast('success', resp.msg);


                let questionNumber = parseInt($(".questionNumber").val());


                if(questionNumber > 0){


                    $(".questionNumber").val(questionNumber);


                    ajaxPagination(questionNumber);


                }


            } else {


                msgToast('error', resp.msg);


                $(".approveBtn, .rejectBtn, .holdBtn").attr({ "disabled" : false });


                $(here).html(textBtn);


            }


        },


        error: function(jqXHR, exception){


            msgToast('error', somethingWentWrong);


            $(".approveBtn, .rejectBtn, .holdBtn").attr({ "disabled" : false });


            $(here).html(textBtn);


        }


    });


}





/* Ajax Pagination to load Next or Prev Questions */


function ajaxPagination(questionNumber){


    $.ajax({


        url: ajaxPaginationUrl,


        type: 'GET',


        dataType: 'json',


        data: {questionNumber: questionNumber},


        success: function(response){


            if(response.status){


                $("#ajaxQuestions").html(response.ajaxQuestion);


                $("#ajaxDetails").html(response.ajaxQuestionDetails);


                $('.question-list li:first').text(`Q ${questionNumber}`);


                MathJax.typeset();


                if(questionNumber == 1){


                    $('.prev-btn').hide();


                }


            } else {


                $("#ajaxQuestions").html(response.ajaxQuestion);


                $("#ajaxDetails").html(response.ajaxQuestionDetails);


                $('.question-list li:first').text(`Q ${questionNumber}`);


                MathJax.typeset();


                if(questionNumber == 1){


                    $('.prev-btn').hide();


                }


            }


        },


        error: function(error){


        }


    });


}





/* Reset Filters on change topic */


function resetFilters(selecttype){


    var htmlGrades = `<option value=""> Select grade </option>`;


    var htmlSubject = `<option value=""> Select subject </option>`;


    var htmlTopic = `<option value=""> Select topic </option>`;


    var htmlSubtopic = `<option value=""> Select subtopic </option>`;


    switch (selecttype) {


        case "boards":


            $(".grades").html(`${htmlGrades}`).val("").attr({"disabled" : true});


            $(".subjects").html(`${htmlSubject}`).val("").attr({"disabled" : true});


            $(".topics").html(`${htmlTopic}`).val("").attr({"disabled" : true});


            $(".subtopics").html(`${htmlSubtopic}`).val("").attr({"disabled" : true});


        break;


        case "grades":


            $(".subjects").html(`${htmlSubject}`).val("").attr({"disabled" : true});


            $(".topics").html(`${htmlTopic}`).val("").attr({"disabled" : true});


            $(".subtopics").html(`${htmlSubtopic}`).val("").attr({"disabled" : true});


        break;


        case "subjects":


            $(".topics").html(`${htmlTopic}`).val("").attr({"disabled" : true});


            $(".subtopics").html(`${htmlSubtopic}`).val("").attr({"disabled" : true});


        break;


        case "topics":


            $(".subtopics").html(`${htmlSubtopic}`).val("").attr({"disabled" : true});


        break;


    }


}





/* Get MEQ and TRUE FALSE Options data */


function getMcqOptions(){


    let option = [];


    let arrayDuplicateOptions = [];


    let isTrue = false;


    $("textarea[name=option]").each(function(index, selector){


        var optionId = index+1;


        isTrue = $(selector).parents("div.well2").find("input[type=radio]").is(":checked");


        var optTitle = $(`#option${optionId}`).val();


        option.push({


            id: optionId,


            isCorrect: isTrue,


            optionText: optTitle,


            images: []


        });


    });


    return option;


}





/**


 * @methods Set question format to submit db


 */


function setQuestionFormat(questionTitle, answerTitle, answerVariation, hintTitle, extendedSolitionTitle, yearsTitle, optionData){


    let GUID = $("input[name=questionId]").val();


    let selectedSubtopics = null;


    if($("select[name=subtopics] option:selected").val()) {


        selectedSubtopics = {


            id: $("select[name=subtopics] option:selected").val(),


            subTopicName: $("select[name=subtopics] option:selected").text(),


        }


    }


    let responseData = {


        id: GUID,


        questionTypeId: $("input[name=s_questionTypeId]").val(),


        questionText: questionTitle,


        questionImages: [],


        askedYears: yearsTitle,


        difficultyLevel: $("select[name=difficulty_level] option:selected").val(),


        board: {


            id: $("select[name=boards] option:selected").val(),


            boardName: $("select[name=boards] option:selected").text(),


        },


        grade: {


            id: $("select[name=grades] option:selected").val(),


            gradeName: $("select[name=grades] option:selected").text()


        },


        subject: {


          id: $("select[name=subjects] option:selected").val(),


          subjectName: $("select[name=subjects] option:selected").text()


        },


        topic: {


          id: $("select[name=topics] option:selected").val(),


          topicName: $("select[name=topics] option:selected").text()


        },


        subTopic: selectedSubtopics,


        openTags: [],


        answerBlock: {


            answer: answerTitle,

            additionalAnswers: answerVariation,

            hint: hintTitle,


            extendedSolution: extendedSolitionTitle,


            options: optionData


        },


        reviewers: [],


        noOfApproval: 0,


        questionStatus: {


            statusId: '8O0WXwZz',


            statusName: "Unapproved",


            description: "Unapproved"


        },


        creationTimeStamp: new Date(),


        creatorId: $("#creatorId").val(),


        source: $("input[name=source]").val()


    };


    return JSON.stringify(responseData);


}

/**
 * @methods Set question format to submit db
 */

function setPassageFormat(){
    const jsonData = $('textarea[name="question_response"]').val();

    // Replace HTML entity codes with their respective characters
    const decodedJsonData = $('<textarea/>').html(jsonData).text();

    // Now you have the decoded JSON string, you can parse it to get the JSON object
    const parsedData = JSON.parse(decodedJsonData);

    // Now you can access the properties of the JSON object
    return JSON.stringify(parsedData);
}