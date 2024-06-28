let assessmentId = 0;
let responseId = 0;
let studentId = 0;
let allGrades = [];
let overAllComments = "";
let gradingStatus = "Draft";

//side panel
$(".fixed-side-panel-trigger").click(function() {
    $(".fixed-side-panel ").toggleClass("fixed-panel-open ");
    $(".fixed-side-panel-trigger ").toggleClass("rotate-180 ");
    $(".main-header ").toggleClass("slide-100 ");

});

//side panel
$(".fixed-side-panel-trigger-right, .feedback-grading").click(function() {
    $(".fixed-side-panel-trigger-right ").toggleClass("rotate-180 ");
    $(".main-body ").toggleClass("slide-100 ");
    $(".right-panel ").toggleClass("hide-panel ");
    $(".canvas-area ").toggleClass("hide-right-panel ");
});

//click-event-badge
$(".click-event-badge").click(function() {
    $(this).find("span.coloured").toggleClass("d-block");
    $(this).find("span.normal ").toggleClass("d-none");
    let questionId = $(this).data("questionid");
    checkElement(this, questionId);
    gradeFunc();
});

//tooltip
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});

// smaple ans arrow
$(document).on('show', '.accordion', function(e) {
    //$('.accordion-heading i').toggleClass(' ');
    $(e.target).prev('.accordion-heading').addClass('accordion-opened');
});

$(document).on('hide', '.accordion', function(e) {
    $(this).find('.accordion-heading').not($(e.target)).removeClass('accordion-opened');
    //$('.accordion-heading i').toggleClass('fa-chevron-right fa-chevron-down');
});
//dropdown auto close stop
$('.sort-box').on('click', function(event) {
    $(this).parent().toggleClass('open');
});

$(document).on("click", ".collapse-btn", function() {
    $('.toggle-btn').toggleClass('collapsed');
    if ($(".collapse").hasClass('show')) {
        $(".collapse").removeClass('show');
    } else {
        $(".collapse").addClass('show');
    }
    if ($(this).find('i').hasClass('fa-angle-down')) {
        $(this).find('i').removeClass('fa-angle-down');
        $(this).find('i').addClass('fa-angle-up');
    } else {
        $(this).find('i').removeClass('fa-angle-up');
        $(this).find('i').addClass('fa-angle-down');
    }
});

$(document).on("click", ".toggle-btn", function() {
    console.log('clicked');

    $(this).parent('')

});

/* Accordian Filters */
$(document).on('change', '#subject-filter, #grade-filter', function() {
    subjectFilter = $("#subject-filter").val() != "" ? $.trim($("#subject-filter").val()) : '';
    gradeFilter = $("#grade-filter").val() != "" ? $.trim($("#grade-filter").val()) : '';
    let inProgressCounter = 0;
    let gradedCounter = 0;
    if (subjectFilter.length > 0) {
        $("#myTabContent .card").each(function(index, element) {
            let accordianSubject = $.trim($(element).data('subject'));
            let accordianGrade = $.trim($(element).data('grade'));
            if (accordianSubject == subjectFilter) {
                if (gradeFilter.length > 0) {
                    if (accordianGrade == gradeFilter) {
                        $(element).fadeIn('800'); // show
                        if ($(element).data('status')) {
                            if ($(element).data('status') == 'in-progress') {
                                inProgressCounter++;
                            }
                            if ($(element).data('status') == 'missing') {
                                gradedCounter++;
                            }
                        }
                    } else {
                        $(element).fadeOut('800'); // hide
                    }
                } else {
                    $(element).fadeIn('800'); // show
                    if ($(element).data('status')) {
                        if ($(element).data('status') == 'in-progress') {
                            inProgressCounter++;
                        }
                        if ($(element).data('status') == 'missing') {
                            gradedCounter++;
                        }
                    }
                }
            } else {
                $(element).fadeOut('800'); // hide
            }
        });
    } else {
        $("#myTabContent .card").each(function(index, element) {
            let accordianSubject = $(element).data('subject');
            let accordianGrade = $(element).data('grade');
            if (accordianSubject != subjectFilter) {
                if (gradeFilter.length > 0) {
                    if (accordianGrade == gradeFilter) {
                        $(element).fadeIn('800'); // show
                        if ($(element).data('status')) {
                            if ($(element).data('status') == 'in-progress') {
                                inProgressCounter++;
                            }
                            if ($(element).data('status') == 'missing') {
                                gradedCounter++;
                            }
                        }
                    } else {
                        $(element).fadeOut('800'); // hide
                    }
                } else {
                    $(element).fadeIn('800'); // show
                    if ($(element).data('status')) {
                        if ($(element).data('status') == 'in-progress') {
                            inProgressCounter++;
                        }
                        if ($(element).data('status') == 'missing') {
                            gradedCounter++;
                        }
                    }
                }
            }
        });
    }

    $('span.missing-tab').text(gradedCounter);
    $('span.in-progress-tab').text(inProgressCounter);

});

/* Filter by Auto Graded, Ungraded, Graded */
$(document).on('change', '.responseStatusFilter', function() {
    let selectedFilter = $(this).val();
    if (selectedFilter.length > 0) {
        $('div.answerStatus').each(function(index, element) {
            if ($(element).hasClass(selectedFilter)) {
                $(element).fadeIn('800'); // show
            } else {
                $(element).fadeOut('800'); // hide
            }
        });
    }
});

$(document).on('click', '.publishResult', function() {
    var countGraded = 0;
    var countAbsent = 0;
    var countDue = 0;
    $('.gradingStatus').each(function(index, element) {
        if ($(element).data('status') == consGradedText) {
            countGraded++;
        }
        if ($(element).data('status') == consAbsentText) {
            countAbsent++;
        }
        if ($(element).data('status') == consDueText || $(element).data('status') == consDraftText) {
            countDue++
        }
    });
    if (countDue > 0) {
        msgToast('warning', publishResultWarningText);
    } else {
        showConfirmBox(countAbsent, countGraded);
    }
});

function showConfirmBox(absentCount, gradeCount) {
    let gradedData = `${gradedText}: ${gradeCount}`;
    let absentData = ` | ${absentText}: ${absentCount}`;
    $("#countAbsent").html(`<p class="mb-0">${gradedData} ${absentData}</p>`);
    $("#confirm").modal();
}

$(document).on('click', '.publish-confirm', function() {
    var confirmBtn = $(".publish-confirm").text();
    $(".publish-confirm").html(`${btnSpinner}`);
    $("#confirm .btn").attr({
        'disabled': true
    });
    publishResult(confirmBtn);
});

$(document).ready(function() {
    $('div.answerStatus').each(function(index, element) {
        if ($(element).data('status') == graded) {
            gradedCount++;
        }
        if ($(element).data('status') == ungraded) {
            ungradedCount++;
        }
        if ($(element).data('status') == autograded) {
            autogradedCount++;
        }
        answerStatusCount++;
    });
    $(`select.responseStatusFilter option[value=${answerstatus}]`).text(`${allText} (${answerStatusCount})`);
    $(`select.responseStatusFilter option[value=${graded}]`).text(`${gradedText} (${gradedCount})`);
    $(`select.responseStatusFilter option[value=${ungraded}]`).text(`${ungradedText} (${ungradedCount})`);
    $(`select.responseStatusFilter option[value=${autograded}]`).text(`${autogradedText} (${autogradedCount})`);
    $('input[name="questionBank"]').click(function() {
        updateTextArea(this)
    });
    $('textarea[name="feedback"]').on('change, keyup', function () {
        updateFeedbackCheckbox(this)
    });
});

function updateFeedbackCheckbox(e) {

    var allVals = [];

    var textVal = $.trim($(e).val());

    if (textVal.length > 0) {

        allVals = textVal.split(",");

    }

    $('input[name="questionBank"]').each(function (index, element) {

        if (allVals.indexOf($.trim($(element).val())) < 0) {

            $(element).prop({checked: false});

        }        

    });

}

$(document).on('change', '.calculateGradeMarks', function() {
    let updatedMarks = $(this).val();
    let gradedMarks = $(this).data('oldmarks');
    let maxMarks = $(this).data('maxmarks');
    let questionId = $(this).data('questionid');
    let currentStatus = $(`#question_${questionId}`).data('status');
    let autograded = $(`#question_${questionId}`).data('autograded');

    if (isNaN(parseInt(updatedMarks))) {
        $(this).val(0);
    } else {
        if (updatedMarks > maxMarks) {
            msgToast('warning', warningMaximumMarks);
            if (gradedMarks > 0 || currentStatus == 'autograded') {
                $(this).val(gradedMarks);
            } else {
                $(this).val('');
            }
            $(this).focus();
        } else if ($(this).val() == gradedMarks && gradedMarks != 0) {
            if (!isNaN(parseInt(autograded)) && currentStatus == 'autograded') {
                $(`#question_${questionId}`).find('div.updateNewStatus').text(autogradedText);
            }
            if (!isNaN(parseInt(autograded)) && currentStatus == 'graded') {
                $(`#question_${questionId}`).find('div.updateNewStatus').addClass('auto-over-riden');
                $(`#question_${questionId}`).find('div.updateNewStatus').text(overriddenText);
            }
        } else {
            if (!isNaN(parseInt(autograded)) && currentStatus == 'autograded') {
                $(`#question_${questionId}`).find('div.updateNewStatus').addClass('auto-over-riden');
                $(`#question_${questionId}`).find('div.updateNewStatus').text(overriddenText);
            }
            gradeFunc();
        }
    }
    $(`#question_${questionId}`).find('.w-120').removeClass('requiredGrade');
    getobtainedMarks();
});

$(document).on('click', '.saveStudentsGradingMarks', function() {
    if (checkAllGraded()) {
        $('#grade-confirmation').modal('show');
    }
});

$(document).on('click', '#submitGrade', function() {
    gradingStatus = $(".saveStudentsGradingMarks").attr('data-status');
    $(this).html(`${btnSpinner}`);
    $("#grade-confirmation .btn").attr({
        'disabled': true
    });
    submitGrade();
});

$(document).on('click', '.sort-name', function(e) {
    let selector = $(this);
    let select = $('.student-lists');
    selector.removeClass('disabled');
    select.html(select.find('.student-icon').sort(function(x, y) {
        // to change to descending order switch "<" for ">"
        if ($(x).find('.s-name').text() > $(y).find('.s-name').text()) {
            if (selector.attr('data-order') == 'asc') {
                return 1;
            } else {
                return -1;
            }
        } else {
            if (selector.attr('data-order') == 'asc') {
                return -1;
            } else {
                return 1;
            }
        }
    }));
    setSortSession('name', selector.attr('data-order'));

    if (selector.attr('data-order') == 'asc') {
        selector.attr({
            'data-order': 'desc'
        });
        selector.html(`<i class="fa fa-long-arrow-down" aria-hidden="true"></i> Name`);
    } else {
        selector.attr({
            'data-order': 'asc'
        });
        selector.html(`<i class="fa fa-long-arrow-up" aria-hidden="true"></i> Name`);
    }

    if (!$('.sort-status').hasClass('disabled')) {
        $('.sort-status').addClass('disabled');
    }
    e.stopPropagation();
});

$(document).on('click', '.sort-status', function(e) {
    let selector = $(this);
    let select = $('.student-lists');
    selector.removeClass('disabled');
    select.html(select.find('.student-icon').sort(function(x, y) {
        // to change to descending order switch "<" for ">"
        if ($(x).find('.s-status').text() > $(y).find('.s-status').text()) {
            if (selector.attr('data-order') == 'asc') {
                return 1;
            } else {
                return -1;
            }
        } else {
            if (selector.attr('data-order') == 'asc') {
                return -1;
            } else {
                return 1;
            }
        }
    }));
    setSortSession('status', selector.attr('data-order'));

    if (selector.attr('data-order') == 'asc') {
        selector.attr({
            'data-order': 'desc'
        });
        selector.html(`<i class="fa fa-long-arrow-down" aria-hidden="true"></i> Status`);
    } else {
        selector.attr({
            'data-order': 'asc'
        });
        selector.html(`<i class="fa fa-long-arrow-up" aria-hidden="true"></i> Status`);
    }
    if (!$('.sort-name').hasClass('disabled')) {
        $('.sort-name').addClass('disabled');
    }
    e.stopPropagation();
});

function checkAllGraded() {
    let submitStatus = true;
    let focusIndex = 0;
    $(".calculateGradeMarks").each(function(indexValue, element) {
        var questionId = $(element).attr("data-questionId");
        var sequenceNo = $(element).attr("data-sequence");
        var gradedMarks = $(element).val();
        var maxMarks = $(element).attr('data-maxMarks');
        if (gradedMarks == "") {
            if (focusIndex == 0) {
                $(element).focus();
            }
            $(element).parents(`div#question_${questionId}`).find('.w-120').addClass('requiredGrade');
            submitStatus = false;
            focusIndex++;
        }
    });
    if (submitStatus) {
        return submitStatus;
    } else {
        msgToast('error', fewGradeLeft);
        return false;
    }
}

function getobtainedMarks() {
    let obtainedMarks = 0;
    $('.calculateGradeMarks').each(function(index, element) {
        obtainedMarks += isNaN(parseInt($(element).val())) ? 0 : parseInt($(element).val());
    });
    $("span.obtainedMarks").text(obtainedMarks);
}

function createGrading() {
    assessmentId = $("input[name=assessmentId]").val();
    responseId = $("input[name=responseId]").val();
    studentId = $("input[name=studentId]").val();
    allGrades = getAllGrades();
    let overAllComments = $('textarea[name="feedback"]').val();
    if (allGrades) {
        return {
            assessmentId: assessmentId,
            responseId: responseId,
            studentId: studentId,
            grades: allGrades,
            overAllComments: overAllComments,
            gradingStatus: gradingStatus,
            overAllComments: overAllComments
        }
    }
    return false;
}

function getAllGrades() {
    let grades = [];
    let submitStatus = true;
    $(".calculateGradeMarks").each(function(index, element) {
        var questionId = $(element).attr("data-questionId");
        var sequenceNo = $(element).attr("data-sequence");
        var gradedMarks = $(element).val();
        var maxMarks = $(element).attr('data-maxMarks');
        var badges = [];

        if ($(element).parents(`div#question_${questionId}`).find('div.badge-award.click-event-badge.award span.coloured').hasClass('d-block')) {
            var value = $(element).parents(`question_${questionId}`).find('div.badge-award.click-event-badge.award').attr("data-original-title");
            badges.push("Excellent");
        }

        if ($(element).parents(`div#question_${questionId}`).find('div.badge-award.click-event-badge.shield span.coloured').hasClass('d-block')) {
            var value = $(element).parents(`question_${questionId}`).find('div.badge-award.click-event-badge.shield').attr("data-original-title");
            badges.push("Perfect");
        }

        if ($(element).parents(`div#question_${questionId}`).find('div.badge-award.click-event-badge.madel span.coloured').hasClass('d-block')) {
            var value = $(element).parents(`question_${questionId}`).find('div.badge-award.click-event-badge.madel').attr("data-original-title");
            badges.push("VeryCreative");
        }
        if (gradedMarks >= 0) {
            if (parseInt(gradedMarks) > parseInt(maxMarks)) {
                msgToast('error', `Please check grade marks of question no. ${sequenceNo}`);
                submitStatus = false;
            } else {
                if (gradedMarks != "") {
                    grades.push({
                        serialNumber: sequenceNo,
                        questionId: questionId,
                        gradedMarks: gradedMarks,
                        badges: badges
                    });
                }
            }
        } else {
            msgToast('error', fewGradeLeft);
            submitStatus = false;
            $(element).parents(`div#question_${questionId}`).find('.w-120').addClass('requiredGrade');
        }
    });
    if (submitStatus) {
        return grades;
    } else {
        return grades;
    }
}

function publishResult(confirmBtn) {
    teacherId = $("input[name=teacherId]").val();
    paperId = $("input[name=paperId]").val();
    $.ajax({
        url: publishResultUrl,
        type: 'GET',
        dataType: 'json',
        data: {
            paperId: paperId,
            teacherId: teacherId
        },
        success: function(response) {
            if (response.status) {
                msgToast('success', successResultPublish);
                setTimeout(function(){
                        location.href = gradingFeedbackURL;
                    }
                , 5000);
            } else {
                $("#confirm .btn").attr({
                    'disabled': false
                });
                $(".publish-confirm").html(`${confirmBtn}`);
                msgToast('error', publishedErrorText);
            }
        },
        error: function(error) {
            $("#confirm .btn").attr({
                'disabled': false
            });
            msgToast('error', somethingWentWrong);
        }
    });
}

function gradeFunc() {
    submitGrade(false);
}

function submitGrade(reload = true) {
    gradingUrl = $("input[name=gradingUrl]").val();
    gradingData = createGrading();
    if (gradingData) {
        $.ajax({
            url: gradingUrl,
            type: 'POST',
            dataType: 'json',
            data: gradingData,
            headers: {
                "X-CSRF-TOKEN": $("input[name=_token]").val()
            },
            success: function(response) {
                if (response.status && reload) {
                    msgToast('success', `${statusUpdateText}<b>${gradingStatus.toLowerCase()}</b>`);
                    location.href = response.redirect_url;
                }
                updateStudentList();
            },
            error: function(error) {
                $("#submitGrade").html(`Submit`);
                $("#grade-confirmation.btn").attr({
                    'disabled': false
                });
            }
        });
    }
}

function updateTextArea(e) {
    var allVals = [];
    var textVal = $.trim($('textarea[name="feedback"]').val());
    var selectedval = $.trim($(e).val());
    if (textVal.length > 0) {
        allVals = textVal.split(",");
    }
    if ($(e).is(':checked')) {
        allVals.push($.trim(selectedval));
    } else {
        console.log(allVals.indexOf(selectedval), allVals.indexOf(textVal))
        if (allVals.indexOf(selectedval) > -1) {
            var idx = $.inArray(selectedval, allVals);

            if (idx == -1) {
                allVals.push(dataid);
            } else {
                allVals.splice(idx, 1);
            }
        }
    }
    $('textarea[name="feedback"]').val(allVals);
}

function checkElement(event, questionId) {
    if ($(event).parents(`div#question_${questionId}`).find('div.badge-award.click-event-badge.award span.coloured').hasClass('d-block')) {
        $(event).parents(`div#question_${questionId}`).find('.calculateGradeMarks').addClass('change');
    } else if ($(event).parents(`div#question_${questionId}`).find('div.badge-award.click-event-badge.shield span.coloured').hasClass('d-block')) {
        $(event).parents(`div#question_${questionId}`).find('.calculateGradeMarks').addClass('change');
    } else if ($(event).parents(`div#question_${questionId}`).find('div.badge-award.click-event-badge.madel span.coloured').hasClass('d-block')) {
        $(event).parents(`div#question_${questionId}`).find('.calculateGradeMarks').addClass('change');
    } else {
        $(event).parents(`div#question_${questionId}`).find('.calculateGradeMarks').removeClass('change');
    }
}

function setSortSession(sortBy, orderBy) {
    let url = $('#sort-student').val();
    let studentLists = [];
    $('.s-name').each(function(index, ele) {
        if ($(ele).attr('data-studentid') != undefined) {
            studentLists.push($(ele).attr('data-studentid'));
        }
    });
    $.ajax({
        url: url,
        type: 'post',
        data: {
            "studentLists": studentLists,
            "sortBy": sortBy,
            "orderBy": orderBy
        },
        dataType: 'json',
        headers: {
            "X-CSRF-TOKEN": $("input[name=_token]").val()
        },
        success: function(response) {
            return false;
        },
        error: function(error) {
            msgToast('error', error);
        }
    });
}

function updateStudentList() {
    let selector = $('.student-lists');
    let studentListUrl = $('input[name=studentListUrl]').val();
    let paperId = $('input[name=assessmentId]').val();
    $.ajax({
        url: studentListUrl,
        type: 'POST',
        data: {
            paperId: paperId
        },
        dataType: 'json',
        headers: {
            "X-CSRF-TOKEN": $("input[name=_token]").val()
        },
        success: function(response) {
            if (response.status) {
                selector.html(response.html);
            }
        },
        error: function(error) {
            msgToast('error', error);
        }
    });
}

$(document).on('click', '.gradeToAll', function() {
    $("#confirmGradeAll").modal();
});

$(document).on('click', '.gradeall-confirm', function() {
    $(this).html(`${btnSpinner}`);
    $("#confirmGradeAll .btn").attr({
        'disabled': true
    });
    let assessmentId = $("#assessmentId").val();
    let teacherId = $("#teacherId").val();
    $.ajax({
        type: "POST",
        url: $("#gradeAllAjaxUrl").val(),
        data: {
            assessmentId: assessmentId,
            teacherId: teacherId
        },
        dataType: "json",
        headers: {
            "X-CSRF-TOKEN": $("input[name=_token]").val()
        },
        success: function(response) {
            if (response.status) {
                msgToast('success', response.msg);
                location.reload();
            } else {
                msgToast('error', response.msg);
            }
        }
    });
});

$(document).on("click", ".viewFile", function() {
    let fileName = $(this).data('filename');
    let fileUrl = $(this).data("href");
    let html = "";
    var arr = fileUrl.split('.');
    var fileType = arr[arr.length - 1];
    var acceptImageFileType = ['png', 'jpg', 'jpeg'];
    if ($.inArray(fileType, acceptImageFileType) != -1) {
        html = `<img src="${fileUrl}">`;
    } else {
        html = `<iframe src="${fileUrl}"></iframe>`;
    }
    if (!$("div#fileModalPreview").hasClass("modal-fullscreen")) {
        $("div#fileModalPreview").addClass("modal-fullscreen");
        $("div#fileModalPreview span.enlarge-popup-btn").html(zoomOutIcon);
    }
    $("div#fileModalPreview #fileModalTitle").html(fileName.replace(/_/g, " "));
    $("div#fileModalPreview div#fileModalBody").html(html);
    openFullscreen();
    $("div#fileModalPreview").modal();
});

$(document).on("click", ".enlarge-popup-btn", function() {
    $(this).parents('div.modal').toggleClass('modal-fullscreen');
    if ($(this).parents('div.modal').hasClass('modal-fullscreen')) {
        $(this).html(zoomOutIcon);
        openFullscreen();
    } else {
        $(this).html(zoomIcon);
        closeFullscreen();
    }
});

$(document).on("click", "div#fileModalPreview button.close", function() {
    closeFullscreen();
});

$(document).on('click','.showReports', function(){
    let assessmentId = $(this).data('assessmentid');
    let getClassUrl = $(this).data('url');
    let classList = $(this).parent().find('textarea').val();
    $.ajax({
        type: "POST",
        url: getClassUrl,
        data: {assessmentId: assessmentId, classList: classList},
        dataType: "json",
        success: function (response) {
            $("#showReports .modal-body").html(response.html);
        }
    });
});