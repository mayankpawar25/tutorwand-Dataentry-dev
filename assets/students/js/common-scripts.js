let answerArray = [];
let instructionsTime = '';
let toolInstructionsTime = '';

let attempted = 0;
let unattempted = 0;
let unanswered = 0;
let answeredCount = 0;
let markedReview = 0;

var questionID = 0;
let questionTypeID = 0;
let submissionType = 0;
let answerData = 0;
let responseTime = 0;
let examStatus = 0;

let onlineCount = 0;
let fileNumber = 0;
let globalFileNumber = 0;
let responseId = "";
let changeStatus = false;
let removeFileData = "";

$(document).ready(function() {
    $(document)[0].oncontextmenu = function() {
        return false;
    }
    $(document).mousedown(function(e) {
        if (e.button == 2) {
            return false;
        } else {
            return true;
        }
    });

    let step = $('#questionWizard div.step-content').find('.step-pane.active').attr('data-step');
    if (step == 1) {
        $('button.prev-btn').hide();
    }

    let totalQuestion = $("#totalQuestion").val();
    if (step == totalQuestion) {
        $('button.next-btn').hide();
        $('button.finish-btn').show();
    }

    $(document).bind("contextmenu", function(e) {
        return false;
    });

    $('.showQuestionArea').each(function() {
        let fData = JSON.parse(localStorage.getItem(flagId));
        let questionId = $(this).attr("id");
        let id = $('#questionWizard div.step-content').find('.step-pane.active').attr('data-questionid');
        if ($.inArray(questionId, fData.bookmarkId) > -1) {
            if (questionId == id) {
                $('#questionWizard div.step-content').find('.step-pane.active').attr({
                    'data-reviewed': 'reviewed'
                })
                $(".mark-review-btn").addClass('active');
            }
            $(`#${questionId} button`).addClass('mark-review');
        }
    });
    toastr.options.closeButton = true;
    toastr.options.titleClass = true;
    toastr.options.preventDuplicates = true;
    $('[data-toggle="tooltip"]').tooltip();
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

$(".fixed-side-panel-trigger").click(function() {
    $("body").toggleClass("side-panel-open");
    $(".fixed-side-panel").toggleClass("fixed-panel-open");
    $(".fixed-side-panel-trigger").toggleClass("rotate-180");
    $(".main-header").toggleClass("slide-100");
});

$(document).on('click', '.instruction-next', function() {
    $('#instructionsPage').hide();
    $('#toolInstructionsPage').show();
    instructionsTime = new Date();
});

$(document).on('click', '.tool-instruction-next', function() {
    $('#toolInstructionsPage').hide();
    $('#examPage').show();
    toolInstructionsTime = new Date();
});

$(document).on('click', '.next-btn', function() {
    unattempted = parseInt($('button.unattempted').find('span.badge').text());
    unanswered = parseInt($('button.unanswered').find('span.badge').text());
    answeredCount = parseInt($('button.attempted').find('span.badge').text());
    markedReview = parseInt($('button.mark-review').find('span.badge').text());

    let currentStep = $('#questionWizard div.step-content').find('.step-pane.active').attr('data-step');
    let nextStep = parseInt(currentStep) + parseInt(1);

    if (nextStep > 1) {
        $(`button.prev-btn`).show();
    }

    let totalQuestion = $("#totalQuestion").val();
    if (nextStep == totalQuestion) {
        $(`button.next-btn`).hide();
        $(`button.finish-btn`).show();
    } else {
        $(`button.next-btn`).show();
        $(`button.finish-btn`).hide();
    }
    updatQuestionStatus();
    $(`div[data-step=${currentStep}]`).removeClass('active');
    $(`div[data-step=${nextStep}]`).addClass('active');

    questionJumpTime();

    updateLegendCounter();
    checkBookmarkActive();
    checkReportActive();
    activeClearBtn();
    
    updatePalletStrings();

});

$(document).on("click", '.prev-btn', function() {
    let currentStep = $('#questionWizard div.step-content').find('.step-pane.active').attr('data-step');
    let nextStep = parseInt(currentStep) - parseInt(1);
    updatQuestionStatus();
    if (nextStep == 1) {
        $('button.prev-btn').hide();
    }
    $(`div[data-step=${currentStep}]`).removeClass('active');
    $(`div[data-step=${nextStep}]`).addClass('active');
    questionJumpTime();

    let totalQuestion = $("#totalQuestion").val();
    if (nextStep == totalQuestion) {
        $(`button.next-btn`).hide();
        $(`button.finish-btn`).show();
    } else if (nextStep < totalQuestion) {
        $(`button.next-btn`).show();
        $(`button.finish-btn`).hide();
    }
    updateLegendCounter();
    checkBookmarkActive();
    checkReportActive();
    activeClearBtn();
    updatePalletStrings();
});

$(document).on('click', '.mark-review-btn', function() {
    let fData = JSON.parse(localStorage.getItem(flagId));
    let id = $('#questionWizard div.step-content').find('.step-pane.active').attr('data-questionid');
    if ($(`#${id} button`).hasClass('mark-review')) {
        $(`#${id} button`).removeClass('mark-review');
        $('#questionWizard div.step-content').find('.step-pane.active').attr({
            'data-reviewed': ''
        })
        $('.btn.mark-review-btn').removeClass('active');
        fData.bookmarkId = $.grep(fData.bookmarkId, function(value) {
            return value != id;
        });
    } else {
        $('#questionWizard div.step-content').find('.step-pane.active').attr({
            'data-reviewed': 'reviewed'
        })
        $(`#${id} button`).addClass('mark-review');
        $('.btn.mark-review-btn').addClass('active');
        changeStatus = true;
        if ($.inArray(id, fData.bookmarkId) == -1) {
            fData.bookmarkId.push(id);
        }
    }
    localStorage.setItem(flagId, JSON.stringify(fData));
    if ($(`#${id} button`).hasClass('unanswered')) {
        $(`#${id} button`).removeClass('unanswered');
    }
    updateLegendCounter();
    /* This will update data to localstorage */
    updateLocalStorage();

    updatePalletStrings();

});

$(document).on("click", '.showQuestionArea', function() {
    if (timeLeft > 0) {
        updatQuestionStatus(false);
        if ($('div.question-block.step-pane.sample-pane').hasClass('active')) {
            let currentQuestionId = $('div.question-block.step-pane.sample-pane.active').attr('data-questionid');
            let step = $('div.question-block.step-pane.sample-pane.active').attr('data-step');
            updateCurrentStaus(currentQuestionId, step);

            $('div.question-block.step-pane.sample-pane').removeClass('active')
        }
        $(`div[data-questionid=${$(this).attr('id')}]`).addClass('active');
        questionJumpTime();
        let step = $(`div[data-questionid=${$(this).attr('id')}]`).attr('data-step');
        if (step > 1) {
            $(`button.prev-btn`).show();
        } else {
            $(`button.prev-btn`).hide();
        }
        let totalQuestion = $("#totalQuestion").val();
        if (parseInt(step) == parseInt(totalQuestion)) {
            $(`button.next-btn`).hide();
            $(`button.finish-btn`).show();
        } else if (parseInt(step) < parseInt(totalQuestion)) {
            $(`button.next-btn`).show();
            $(`button.finish-btn`).hide();
        }
        updatQuestionStatus();
        updateLegendCounter();
        checkBookmarkActive();
        activeClearBtn();
        checkReportActive();
        updatePalletStrings();
    }
});

$(document).on("click", ".reviewPaletteArea", function() {
    if (timeLeft > 0) {
        if ($('div.question-block.step-pane.sample-pane').hasClass('active')) {
            $('div.question-block.step-pane.sample-pane').removeClass('active')
        }
        $(`div[data-questionid=${$(this).attr('id')}]`).addClass('active');
        questionJumpTime();
        let step = $(`div[data-questionid=${$(this).attr('id')}]`).attr('data-step');
        if (step > 1) {
            $(`button.prev-btn`).show();
        } else {
            $(`button.prev-btn`).hide();
        }
        let totalQuestion = $("#totalQuestion").val();
        if (parseInt(step) == parseInt(totalQuestion)) {
            $(`button.next-btn`).hide();
            $(`button.finish-btn`).show();
        }

        if (parseInt(step) < parseInt(totalQuestion)) {
            $(`button.next-btn`).show();
            $(`button.finish-btn`).hide();
        }

        $('div.header-right button.finishBtn').show();
        $(`.paper-area`).show();
        $(`.submit-review-area`).hide();
        $(".submitBtn").hide();
        checkReportActive();
        activeClearBtn();
        activeBtn();
        updateLegendCounter();
        updatePalletStrings();
    }
});

$(document).on('change', '.radioBox', function() {
    let questionId = $(this).attr('data-questionId');
    let answerKey = $(this).attr('data-answerKey');
    let answerText = $(this).val();
    setAnswerValue(questionId, answerText, answerKey);
});

//side panel
$(document).on("click", ".fixed-side-panel-trigger-right", function() {
    //$(".fixed-side-panel").toggleClass("right-panel");
    $(".fixed-side-panel-trigger-right").toggleClass("rotate-180");
    $(".main-body").toggleClass("slide-100");
    $(".right-panel-exam").toggleClass("hide-panel");
    $(".canvas-area").toggleClass("hide-right-panel");
    $(".canvas-footer").toggleClass("hide-right-panel-footer");

    if ($("fixed-side-panel").hasClass("fixed-panel-open")) {
        $("body").addClass('side-panel-open');
    } else {
        $("body").removeClass('side-panel-open');
    }
});

$(document).on("click", ".font-btn", function() {
    let flagData = JSON.parse(localStorage.getItem(flagId));

    $(".font-btn").toggleClass("active");
    $('.canvas-inner').find('.canvas-body').toggleClass('enlargeFont');
    if ($('.canvas-inner').find('.canvas-body').hasClass('enlargeFont')) {
        flagData.fontZoom = true;
    } else {
        flagData.fontZoom = false;
    }
    localStorage.setItem(flagId, JSON.stringify(flagData));
});

$(document).on("click", ".zoomer-btn", function() {

    $(".zoomer-btn").toggleClass("active");
});

//mobile right panel slideing
$(document).on("click", "#mob-right-panel-trigger", function() {
    $(".right-panel-exam").toggleClass("mob-slide");
    $(".overlay-slide-panel").toggleClass("show-overlay");
});
$(document).on("click", ".show-overlay", function() {
    $(".right-panel-exam").removeClass("mob-slide");
    $(".overlay-slide-panel").removeClass("show-overlay");
});
$(document).on("click", ".showQuestionArea", function() {
    $(".right-panel-exam").removeClass("mob-slide");
    $(".overlay-slide-panel").removeClass("show-overlay");
});

$(document).on('change', '.select-legend', function() {
    let stringText = $(this).val();
    showPallets(stringText);
});

function showPallets(stringText) {
    let className = "";
    $(`ul.question-pallet li`).hide();
    if (stringText == allQuestionText) {
        $(`ul.question-pallet li`).show();
    } else {
        if (stringText == unattemptedText) {
            className = "unattempted";
        } else if (stringText == attemptedText) {
            className = "answered";
        } else if (stringText == unansweredText) {
            className = "unanswered";
        } else if (stringText == markedForReviewText) {
            className = "mark-review";
        }
        $(`ul.question-pallet`).find(`button.${className}`).parent('li').show();
    }
}

function updatePalletStrings() {
    let stringText = $('.select-legend option:selected').val();
    showPallets(stringText);
}

/* Upload Image File Section */
$(document).on('click', '.uploadFileBtn', function() {
    $(this).parent().find('input.uploadFileInput').click();
});

$(document).on('click', '.uploadGlobalFileBtn', function() {
    $('input.uploadGlobalFile').click();
});

$(document).on('change', '.uploadGlobalFile', function(evt) {
    $(".uploadGlobalFileBtn").html(spinner);
    $(".uploadGlobalFileBtn").addClass('disabled');
    let fileError = false;
    let files = $(this)[0]['files'];
    let uploadedGlobalFile = [];
    var form_data = new FormData();
    form_data.append('paperId', paperId);
    form_data.append('studentId', studentID);
    form_data.append('global', true);
    let acceptedImageTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/svg+xml'];
    let allowedFileTypes = ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-excel"];
    let uploadedFilesCount = parseInt($("div.right-panel-body div.uploaded-file-block ul.uploaded-doc li").length);
    let uploadingFilesCount = files.length;
    let totalFileLength = uploadedFilesCount + parseInt(uploadingFilesCount);
    let otherFiles = false;
    let unknownFileType = false;
    let fileLimitExceed = false;
    if (totalFileLength <= 5) {
        $.each(files, function(fileIndex, file) {

            /* Create File Name */
            var fileNumber = fileIndex + 1 + uploadedFilesCount;
            var arr = file.name.split(".");
            var fileName = `${arr[0].replace(/ /g, "_")}_${userName}_G_${fileNumber}.${arr[arr.length-1]}`;
            /* Create File Name */

            var fileSize = file.size; // Get File Size
            var totalFileSize = (fileSize / 1048576).toFixed(2); // Convert file size byte to MB
            var fileType = file.type; // Get File Type 
            // Check File Size
            if (parseInt(totalFileSize) <= parseInt(maxFileSizeLimit) && !(fileError)) {
                // Check File Type
                if ($.inArray(fileType, acceptedImageTypes) != -1) {
                    imageCropper(file, fileName); // To Crop Image
                } else if ($.inArray(fileType, allowedFileTypes) != -1) {
                    otherFiles = true;
                    form_data.append('files[]', file, fileName); // Push file to form Data
                } else {
                    unknownFileType = true;
                    fileError = true;
                }
            } else {
                fileLimitExceed = true;
                fileError = true;
            }
        });

        if (!fileError) {
            if (otherFiles) {
                uploadGlobalFile(uploadAnswerFileUrl, form_data, files.length);
            }
        } else {
            if (unknownFileType) {
                msgToast("error", attachmentFormatText);
            }
            if (fileLimitExceed) {
                msgToast("error", attachmentSizeLimitText);
            }
            if ($('.uploadGlobalFileBtn').hasClass('disabled')) {
                $('.uploadGlobalFileBtn').removeClass('disabled');
                $('.uploadGlobalFileBtn').html(btnText);
            }
        }
    } else {
        msgToast("error", allowedFiveAttachmentText);
        if ($('.uploadGlobalFileBtn').hasClass('disabled')) {
            $('.uploadGlobalFileBtn').removeClass('disabled');
            $('.uploadGlobalFileBtn').html(btnText);
        }
    }
    $("#globalForm")[0].reset();
});

$(document).on('change', '.uploadFileInput', function() {
    $("div.question-text.active").find('.uploadFileBtn').html(spinner);
    $("div.question-text.active").find('.uploadFileBtn').addClass('disabled');
    let questionId = $(this).parents('div.question-text.active').attr('data-questionID');
    let questionNumber = $(this).parents('div.question-text.active').find('div.q-serial').text();

    let files = $(this)[0]['files'];
    let acceptedImageTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/svg+xml'];
    let allowedFileTypes = ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-excel"];
    let form_data = new FormData();
    form_data.append('paperId', paperId);
    form_data.append('questionId', questionId);
    form_data.append('studentId', studentID);
    form_data.append('global', false);
    form_data.append('questionNumber', questionNumber);
    let fileError = false;
    let otherFiles = false;
    let unknownFileType = false;
    let fileLimitExceed = false;
    let uploadedFileslength = $('div.question-text.active').find('ul.putURLImageHere li').length;
    let totalFileLength = parseInt(uploadedFileslength) + parseInt(files.length);
    if (totalFileLength <= 2) {
        $.each(files, function(index, file) {

            /* Create File Name */
            var fileNumber = index + 1 + uploadedFileslength;
            var arr = file.name.split(".");
            var fileName = `${arr[0].replace(/ /g, "_")}_${userName}_Q${questionNumber}_${fileNumber}.${arr[arr.length-1]}`;
            /* Create File Name */

            var fileSize = file.size; // Get File Size
            var totalFileSize = (fileSize / 1048576).toFixed(2); // Convert file size byte to MB
            var fileType = file.type; // Get File Type
            if (parseInt(totalFileSize) <= parseInt(maxFileSizeLimit) && !(fileError)) {
                if ($.inArray(fileType, acceptedImageTypes) != -1) {
                    imageCropper(file, fileName, false, questionId); // To Crop Image
                } else if ($.inArray(fileType, allowedFileTypes) != -1) {
                    form_data.append('files[]', file, fileName);
                    otherFiles = true;
                } else {
                    unknownFileType = true;
                    fileError = true;
                }
            } else {
                fileLimitExceed = true;
                fileError = true;
            }
        });
        if (!fileError) {
            if (otherFiles) {
                uploadQuestionFile(uploadAnswerFileUrl, form_data, questionId);
            }
        } else {
            if (unknownFileType) {
                msgToast("error", attachmentFormatText);
            }
            if (fileLimitExceed) {
                msgToast("error", attachmentSizeLimitText);
            }
            if ($("div.question-text").find('.uploadFileBtn').hasClass('disabled')) {
                $("div.question-text").find('.uploadFileBtn').removeClass('disabled');
                $("div.question-text").find('.uploadFileBtn').html(addImagePdfBtn);
            }
        }
    } else {
        msgToast("error", allowedTwoAttachmentText);
        if ($("div.question-text").find('.uploadFileBtn').hasClass('disabled')) {
            $("div.question-text").find('.uploadFileBtn').removeClass('disabled');
            $("div.question-text").find('.uploadFileBtn').html(addImagePdfBtn);
        }
        fileError = true;
    }
    $(this).parent('form')[0].reset();
});

$(document).on('click', '.finishBtn', function() {
    $(`.paper-area`).hide();
    $(`.submit-review-area`).show();
    updatQuestionStatus();
    $(".finishBtn").hide();
    $(".submitBtn").show();
    updateReviewSubmit();
    updateLegendCounter();
    updatePalletStrings();
});

$(document).on('click', '.submitBtn', function() {
    showConfirmBox(wantToSubmitAssessmentText);
});

$(document).on('click', '.removeFile', function(e) {
    $("#removeAttachment").modal();

    let name = $(this).data('filename');
    let url = $(this).data('href');
    let className = $(this).data('id');

    $("#removeAttachment").find('input[name=className]').val(className);

    questionId = $(this).parents('div.question-text').attr('data-questionID');
    removeFileData = {
        name: name,
        url: url,
        paperId: paperId,
        questionId: questionId,
        studentID: studentID
    };
});

$(document).on("click", ".delete-attachment", function() {
    let className = $("#removeAttachment").find('input[name=className]').val();
    removeFile(className);
    $("#removeAttachment").modal('hide');
});

$(document).on('change', '.radioBox', function() {
    let questionId = $(this).attr('data-questionid');
    if ($(`.radioBox[data-questionid=${questionId}]`).is(":checked")) {
        changeStatus = true;
    }
});

$(document).on('change', '.fillupAnswer', function() {
    // let questionId = $(this).attr('data-questionid');
    changeStatus = true;
});

$(document).on("click", ".file-name", function() {
    let fileName = $(this).text();
    let fileUrl = $(this).parent().find(".cursor-pointer").data("href");
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
    $("div#fileModalPreview #fileModalTitle").html(fileName);
    $("div#fileModalPreview div#fileModalBody").html(html);
    openFullscreen();
    $("div#fileModalPreview").show();
});

$(document).on("click", "div#fileModalPreview button.close", function() {
    closeFullscreen();
    $("div#fileModalPreview").hide();
});

$(document).on("click", ".print-btn", function() {
    window.print();
});

CKEDITOR.on("instanceReady", function(event) {
    event.editor.on("change", function(ev) {
        changeStatus = true;
    });
});

/* Methods Start */
function removeFile(className) {
    $.ajax({
        url: removeFileUrl,
        type: "POST",
        data: removeFileData,
        success: function(data) {
            if (data.status) {
                $(`li.${className}`).remove();
                msgToast("success", fileRemovedText);
                if ($("div.right-panel-body div.uploaded-file-block ul.uploaded-doc li").length > 0) {
                    $("div.right-panel-body div.uploaded-file-block ul.uploaded-doc").show();
                } else {
                    $("div.right-panel-body div.uploaded-file-block ul.uploaded-doc").hide();
                }
                changeStatus = true;
            } else {
                msgToast("error", somethingWentWrong);
            }
        },
        error: function(e) {
            msgToast("error", somethingWentWrong);
        }
    });
}

function imageCropper(file, fileName, globalTrue = true, questionId = "") {
    let editor = document.createElement('div');
    editor.style.position = 'fixed';
    editor.style.left = 0;
    editor.style.right = 0;
    editor.style.top = 0;
    editor.style.bottom = 0;
    editor.style.zIndex = 9999;
    editor.style.backgroundColor = '#000';

    // Create the confirm button
    let confirm = document.createElement('button');
    confirm.style.position = 'absolute';
    confirm.style.left = '10px';
    confirm.style.top = '10px';
    confirm.style.zIndex = 9999;
    confirm.textContent = 'Confirm';
    confirm.classList.add("btn");
    confirm.classList.add("btn-primary");
    confirm.addEventListener('click', function() {

        // Get the canvas with image data from Cropper.js
        let canvas = cropper.getCroppedCanvas({
            minwidth: 256,
            minheight: 256,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        // Turn the canvas into a Blob (file object without a name)
        canvas.toBlob(function(blob) {
            // Update the image thumbnail with the new image data
            let cropImagedata = new FormData();
            cropImagedata.append('files[]', blob, fileName);
            cropImagedata.append('paperId', paperId);
            cropImagedata.append('studentId', studentID);
            cropImagedata.append('global', globalTrue);
            if (globalTrue) {
                uploadGlobalFile(uploadAnswerFileUrl, cropImagedata);
            } else {
                cropImagedata.append('questionId', questionId);
                uploadQuestionFile(uploadAnswerFileUrl, cropImagedata, questionId)
            }
        });

        // Remove the editor from view
        editor.parentNode.removeChild(editor);

    });
    editor.appendChild(confirm);

    // Load the image
    let image = new Image();
    image.src = URL.createObjectURL(file);
    editor.appendChild(image);

    // Append the editor to the page
    document.body.appendChild(editor);

    // Create Cropper.js and pass image
    let cropper = new Cropper(image, {
        aspectRatio: NaN
    });
}

function updateCurrentStaus(currentQuestionId, step) {
    if ($(`li#${currentQuestionId}`).hasClass('answered')) {
        $(`li#${currentQuestionId}`).removeClass('answered');
    }
    if ($(`li#${currentQuestionId}`).hasClass('unattempted')) {
        $(`li#${currentQuestionId}`).removeClass('unattempted');
    }
}

function submitExam(paperId, studentId, feedBackScreenURL) {
    if (isOnline) {
        $.ajax({
            url: submitPaperUrl,
            type: 'GET',
            dataType: 'json',
            data: {
                paperId: paperId,
                responseId: responseId,
                studentId: studentId
            },
            success: function(response) {
                if (response.status) {
                    msgToast("success", successSubmitExamText);
                    redirectToFB(feedBackScreenURL);
                }
            },
            error: function(error) {
                if (!isOnline) {
                    // msgToast("warning", submitResponseOfflineError);
                } else {
                    msgToast("warning", somethingWentWrong);
                }

            }
        });
    }
}

function updatQuestionStatus(reviewScreen = true) {
    let answered = false;
    let answerData = "";
    let answerListData = {};
    let id = $('#questionWizard div.step-content').find('.step-pane.active').attr('data-questionID');
    let questionTypeID = $('#questionWizard div.step-content').find('.step-pane.active').attr("data-questiontypeid");
    let questionNumber = $('#questionWizard div.step-content').find('.step-pane.active').attr("data-step");
    let jumpTime = $('#questionWizard div.step-content').find('.step-pane.active').attr("data-jumptime");
    let ansResp = getQuestionResponse();
    answerData = ansResp.answerData;
    answerListData = ansResp.answerListData;
    answered = ansResp.answered;
    let answers = ansResp.answerResponse;
    let createResponseData = createResponse($("#paperID").val(), $("#studentID").val(), id, questionTypeID, questionNumber, submissionType, answerData, examStatus, answerListData, jumpTime, answers);
    let updateStatus = true;

    let localStorageResponses = JSON.parse(localStorage.answeredResponse).responses;
    $.each(localStorageResponses, function (indexInArray, valueOfElement) { 
        if(valueOfElement.questionId == id) {
            createResponseData = editResponse($("#paperID").val(), $("#studentID").val(), id, questionTypeID, questionNumber, submissionType, answerData, examStatus, answerListData, jumpTime, answers);
            updateStatus = false;
        }
    });

    if (answered && changeStatus) {
        if ($(`li#${id}`).find('button').hasClass('unattempted')) {
            $(`li#${id}`).find('button').removeClass('unattempted');
        }
        $(`li#${id}`).find('button').addClass('answered');
        submitResponse(JSON.stringify(createResponseData), updateStatus);
        changeStatus = false;
    }

    if (!answered) {
        if ($(`li#${id}`).find('button').hasClass('answered')) {
            submitResponse(JSON.stringify(createResponseData), updateStatus);
            $(`li#${id}`).find('button').removeClass('answered');
        }
        if (!$(`li#${id}`).find('button').hasClass('unattempted')) {
            $(`li#${id}`).find('button').addClass('unattempted');
        }
        if ($(`li#${id}`).find('button').hasClass('mark-review')) {
            submitResponse(JSON.stringify(createResponseData), updateStatus);
        }
    }

    if (questionReported) {
        if (checkQuestionToReport(id)) {
            submitResponse(JSON.stringify(createResponseData), updateStatus);
        }
        questionReported = false;
    }

    showGlobalFileMsg();
    showLocalFileMsg();
    return false;
}

function updateLegendCounter() {
    attempted = 0;
    unanswered = 0;
    markedReview = 0;
    unattempted = 0;

    $('ul.question-pallet').find('li').each(function(index, element) {
        if ($(element).find('button').hasClass('answered')) {
            attempted++;
        }
        if (($(element).find('button').hasClass('unattempted') && $(element).find('button').hasClass('mark-review')) || $(element).find('button').hasClass('unattempted')) {
            unattempted++;
        }
        if ($(element).find('button').hasClass('mark-review')) {
            markedReview++;
        }
        // if (!$(element).find('button').hasClass('answered') && !$(element).find('button').hasClass('unanswered')) {
        //     unattempted++;
        // }
    });

    $('button.unattempted').find('span.badge').text(unattempted);
    $('button.attempted').find('span.badge').text(attempted);
    $('button.unanswered').find('span.badge').text(unanswered);
    $('button.mark-review').find('span.badge').text(markedReview);

    $('.select-legend option').each(function(index, element) {
        if ($(element).val() == attemptedText) {
            $(element).text(`${$(element).val()} (${attempted})`);
        } else if ($(element).val() == markedForReviewText) {
            $(element).text(`${$(element).val()} (${markedReview})`);
        } else if ($(element).val() == unansweredText) {
            $(element).text(`${$(element).val()} (${unanswered})`);
        } else if ($(element).val() == unattemptedText) {
            $(element).text(`${$(element).val()} (${unattempted})`);
        } else {
            $(element).text(`${$(element).val()} (${$('ul.question-pallet').find('li').length})`);
        }
    });
    $('input[name="upload_file"]').attr({
        'id': 'upload-' + $('.question-text.active').attr('id')
    });
    activeBtn();
}

function activeBtn() {
    $(`ul.question-pallet li button`).removeAttr('style');
    let questionId = $('#questionWizard div.step-content').find('.step-pane.active').attr('data-questionid');
    $(`li#${questionId} button`).css({
        'border': "1px solid #178d8d"
    });
}

function activeClearBtn() {
    let questionTypeId = $(`div.question-text.step-pane.active`).attr('data-questiontypeid');
    if (questionTypeId == shortTypeId || questionTypeId == longTypeId) {
        $('.clear-data-btn').hide();
    } else {
        $('.clear-data-btn').show();
    }
}

function checkReportActive() {
    let fData = JSON.parse(localStorage.getItem(flagId));
    questionId = $('.question-text.active').data("questionid");
    if ($.inArray(questionId, fData.reportId) == -1) {
        $(".report-btn").removeClass('active');
        $(".report-btn").attr({
            'disabled': false
        });
    } else {
        $(".report-btn").addClass('active');
        $(".report-btn").attr({
            'disabled': true
        });
    }
}

function checkBookmarkActive() {
    let fData = JSON.parse(localStorage.getItem(flagId));
    let questionId = $('.question-text.active').data("questionid");
    if ($.inArray(questionId, fData.bookmarkId) > -1) {
        $(".mark-review-btn").addClass('active');
        $(`#${questionId} button`).addClass('mark-review');
    } else {
        $(".mark-review-btn").removeClass('active');
        $(`#${questionId} button`).removeClass('mark-review');
    }
}

function defaultResponse(studentId, paperId, remainingTime) {
    return response = {
        "textZoomed": true,
        "timerEnabled": true,
        "submissionType": 400,
        "remainingTime": remainingTime,
        "recentResponseTime": new Date(),
        "examStatus": "NotStarted",
        "studentId": studentId,
        "paperId": paperId,
        "responses": [],
        "globalFiles": [],
        "examDurationInsecond": examTimerInSeconds
    }
}

function createResponse(paperID, studentID, questionID, questionTypeID, questionNumber, submissionType, answerData, examStatus, answerList, jumpTime, answers) {
    let responseTime = new Date();

    let questionFiles = [];
    $(`div.question-text[data-questionid=${questionID}]`).find('.uploaded-doc li').each(function(index, element) {
        fileName = $(element).find('.cursor-pointer').attr('data-filename');
        fileUrl = $(element).find('.cursor-pointer').attr('data-href');
        questionFiles.push({
            fileName: fileName,
            fileUrl: fileUrl
        });
    });

    let globalFiles = [];
    $(`.right-panel-exam`).find('.uploaded-doc li').each(function(index, element) {
        fileName = $(element).find('.cursor-pointer').attr('data-filename');
        fileUrl = $(element).find('.cursor-pointer').attr('data-href');
        globalFiles.push({
            fileName: fileName,
            fileUrl: fileUrl
        });
    });

    let createResponse = {
        "textZoomed": false,
        "timerEnabled": true,
        "submissionType": 400,
        "remainingTime": timeLeft,
        "recentResponseTime": responseTime,
        "examStatus": 200,
        "studentId": studentID,
        "paperId": paperID,
        "responses": [{
            "errored": $('.report-btn').hasClass('active'),
            "bookMarked": $(".mark-review-btn").hasClass('active'),
            "sequenceNumber": parseInt(questionNumber),
            "questionId": questionID,
            "questionType": questionTypeID,
            // "responseTime": responseTime,
            "answer": answers,
            "files": questionFiles,
            "answerList": answerList,
            "timeSpent": parseInt(jumpTime) - parseInt(timeLeft)
        }],
        "examDurationInsecond": examTimerInSeconds,
        "globalFiles": globalFiles
    };
    return createResponse;
}

function editResponse(paperID, studentID, questionID, questionTypeID, questionNumber, submissionType, answerData, examStatus, answerList, jumpTime, answers) {
    let responseTime = new Date();

    let questionFiles = [];
    $(`div.question-text[data-questionid=a802945f-10fb-4f0e-b0d7-ad3600a6a05b]`).find('.uploaded-doc li').each(function(index, element) {
        fileName = $(element).find('.cursor-pointer').attr('data-filename');
        fileUrl = $(element).find('.cursor-pointer').attr('data-href');
        questionFiles.push({
            fileName: fileName,
            fileUrl: fileUrl
        });
    });

    let editResponse = {
        "studentId": studentID,
        "paperId": paperID,
        "response": {
            "errored": $('.report-btn').hasClass('active'),
            "bookMarked": $(".mark-review-btn").hasClass('active'),
            "sequenceNumber": parseInt(questionNumber),
            "questionId": questionID,
            "questionType": questionTypeID,
            // "responseTime": responseTime,
            "answer": answers,
            "files": questionFiles,
            "answerList": answerList,
            "timeSpent": parseInt(jumpTime) - parseInt(timeLeft)
        }
    };
    return editResponse;
}

function submitResponse(postData, status) {
    /* Store in localstorage */
    updateAnswerStorage(postData, status);
    if (isOnline) {
        $.ajax({
            url: $("#submitResponseUrl").val(),
            type: 'POST',
            dataType: 'html',
            data: {
                'post': postData,
                'status': status
            },
            success: function(resp) {
                if (resp.status == false) {
                    msgToast('error', InternalServerError);
                    return false;
                }
            },
            error: function(request, status, error) {
                if (request.status == 419) {
                    msgToast("error", sessionDestroyText);
                } else {
                    msgToast("error", error);
                }
            }
        });
    }
}

function updateAnswerStorage(postData, status) {
    let data = JSON.parse(postData);
    let storageData = "";
    if (!isEmpty(data.responses) || !isEmpty(data.response)) {
        if (localStorage.getItem('answeredResponse') != undefined || localStorage.getItem('answeredResponse') != null) {
            storageData = JSON.parse(localStorage.getItem('answeredResponse'));
            let dataPresent = false;
            let resp = '';
            $.each(storageData.responses, function(ind, valu) {
                let questionId = '';
                if (status) {
                    questionId = data.responses[0].questionId;
                } else {
                    questionId = data.response.questionId
                }
                if (valu.questionId == questionId) {
                    if (status) {
                        resp = data.responses[0];
                    } else {
                        resp = data.response;
                    }
                    storageData.remainingTime = data.remainingTime;
                    storageData.textZoomed = data.textZoomed;
                    storageData.timerEnabled = data.timerEnabled;
                    storageData.responses[ind] = resp;
                    dataPresent = true;
                }
            });

            if (dataPresent == false) {
                if (status) {
                    resp = data.responses[0];
                } else {
                    resp = data.response;
                }
                storageData.responses.push(resp);
            }
            localStorage.setItem('answeredResponse', JSON.stringify(storageData));
        } else {
            localStorage.setItem('answeredResponse', postData);
        }
    }
}

function clearAnswerStorage(questionId) {
    let storageData = JSON.parse(localStorage.getItem('answeredResponse'));
    $.each(storageData.responses, function(ind, valu) {
        if (valu != undefined) {
            if (valu.questionId == questionId) {
                toastr.success(answerClearText);
                updateLegendCounter();
                if ($(`ul.question-pallet li#${questionId} button`).hasClass('answered')) {
                    $(`ul.question-pallet li#${questionId} button`).removeClass('answered');
                    $(`ul.question-pallet li#${questionId} button`).addClass('unattempted');
                }
                getResumeExam();
            }
        }
    });
}

function isEmpty(obj) {
    for (var key in obj) {
        if (obj.hasOwnProperty(key))
            return false;
    }
    return true;
}

function setAnswerValue(key, value, answerKey) {
    let newArray = {
        'questionId': key,
        'answerText': value,
        'answerKey': answerKey
    }
    answerArray.push(newArray);
}

function setAllData() {
    let newArr = {
        instructionsTime: instructionsTime,
        toolInstructionsTime: toolInstructionsTime,
        data: answerArray
    }
    return newArr;
}

function uploadQuestionFile(uploadAnswerFileUrl, form_data, questionId) {
    $.ajax({
        url: uploadAnswerFileUrl,
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function(response) {
            if (response.Message || response.status == false) {
                msgToast("error", uploadFailedText);
                if ($('.uploadFileBtn').hasClass('disabled')) {
                    $('.uploadFileBtn').removeClass('disabled');
                    $('.uploadFileBtn').html(addImagePdfBtn);
                }
            } else {
                $.each(response.data, function(index, fileData) {
                    fileNumber++;
                    let fileNameHtml = `<li class="local_${fileNumber}" data-fileNumber="${fileNumber}"><div>${fileIcon}</div>
		                <div class="file-name">${fileData.fileName}</div>
		                <div class="cursor-pointer close removeFile" data-id="local_${fileNumber}" data-filename="${fileData.fileName}" data-href="${fileData.fileUrl}">
		                    ${removeFileIcon}
		                </div>
		            </li>`;
                    let fileLen = $(`#questionWizard div.step-content div.step-pane[data-questionid=${questionId}]`).find('.putURLImageHere li').length;
                    $(`#questionWizard div.step-content div.step-pane[data-questionid=${questionId}]`).find('.putURLImageHere').append(fileNameHtml);
                    $(".questionFiles").append(fileNameHtml);
                    $("div#question-carousel-slide div.carousel-inner").append(`<div class="carousel-item" style="width:100%"><embed src="${fileData.fileUrl}" width="100%" /></div>`);
                    changeStatus = true;
                });
                msgToast("success", fileAddedText);
                if ($('.uploadFileBtn').hasClass('disabled')) {
                    $('.uploadFileBtn').removeClass('disabled');
                    $('.uploadFileBtn').html(addImagePdfBtn);
                }
            }
        }
    });
}

function uploadGlobalFile(uploadAnswerFileUrl, form_data, totalUploadedFiles) {
    $.ajax({
        url: uploadAnswerFileUrl,
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function(response) {
            if (response.Message || response.status == false) {
                msgToast("error", uploadFailedText);
                if ($('.uploadGlobalFileBtn').hasClass('disabled')) {
                    $('.uploadGlobalFileBtn').removeClass('disabled');
                    $('.uploadGlobalFileBtn').html(btnText);
                }
            } else {
                $.each(response.data, function(index, fileData) {
                    globalFileNumber++;
                    let fileNameHtml = `<li class="global_${globalFileNumber}"><div>${fileIcon}</div>
		                <div class="file-name">${fileData.fileName}</div>
		                <div class="cursor-pointer close removeFile" data-id="global_${globalFileNumber}" data-filename="${fileData.fileName}" data-href="${fileData.fileUrl}">
		                    ${removeFileIcon}
		                </div>
		            </li>`;
                    $("div#global-carousel-slide div.carousel-inner").append(`<div class="carousel-item" style="width:100%"><embed src="${fileData.fileUrl}" width="100%" /></div>`);
                    $("div.right-panel-body div.uploaded-file-block ul.uploaded-doc").append(fileNameHtml);
                    $(".globalUploades").append(fileNameHtml);
                });
                if ($("div.right-panel-body div.uploaded-file-block ul.uploaded-doc li").length > 0) {
                    $("div.right-panel-body div.uploaded-file-block ul.uploaded-doc").show();
                }
                msgToast("success", fileAddedText);
                if ($('.uploadGlobalFileBtn').hasClass('disabled')) {
                    $('.uploadGlobalFileBtn').removeClass('disabled');
                    $('.uploadGlobalFileBtn').html(btnText);
                }

            }

        },
        error: function(error) {
            $(".uploadGlobalFileBtn").removeClass('disabled');
            $(".uploadGlobalFileBtn").html(btnText);
        }
    });
}

function getQuestionResponse() {
    let answerData = '';
    let answerListData = {};
    let answerText = '';
    let answered = false;

    let answer = "";
    let hint = "";
    let extendedSolution = "";
    let optionsArray = [];

    var questionId = $('#questionWizard div.step-content').find('.step-pane.active').data('questionid');
    $('#questionWizard div.step-content').find('.step-pane.active div.option-list').each(function(index, indexValue) {
        var optionTrue = false;
        answerText = $(indexValue).find('input[type=radio]').val();
        if ($(indexValue).find('input[type=radio]').is(':checked')) {
            optionTrue = true;
            answerListData[`${index + 1}`] = answerText;
            answered = true;
        }

        optionsArray.push({
            id: `${index + 1}`,
            isCorrect: optionTrue,
            optionText: answerText,
            images: []
        });

    });

    $('#questionWizard div.step-content').find('.step-pane.active div.fill-ups').each(function(index, responseVal) {
        if ($(responseVal).find('input[type=text]').val() != "") {
            answerText = $(responseVal).find('input[type=text]').val();
            answerListData[`${index + 1}`] = answerText;
            answered = true;
        }
        optionsArray.push({
            id: `${index + 1}`,
            isCorrect: answered,
            optionText: answerText,
            images: []
        });

    });

    let textAreaID = $('#questionWizard div.step-content').find('.step-pane.active div textarea').attr('id');
    if (textAreaID != undefined) {
        answerData = CKEDITOR.instances[textAreaID].getData();
        answer = answerData;
        if (answerData) {
            answered = true;
        }

        $(`div.question-text[data-questionid=${questionId}]`).find('.uploaded-doc li').each(function(index, element) {
            fileName = $(element).find('.cursor-pointer').attr('data-filename');
            fileUrl = $(element).find('.cursor-pointer').attr('data-href');
            answered = true;
        });
    }

    let answerResponse = {
        answer: answer,
        hint: hint,
        extendedSolution: extendedSolution,
        options: optionsArray,
    }
    return {
        answerData: answerData,
        answerListData: answerListData,
        answered: answered,
        answerResponse: answerResponse
    };
}

function updateLocalStorage() {
    /* This will update data to localstorage */
    let paperId = $("#paperID").val();
    let studentId = $("#studentID").val();
    let questionId = $('#questionWizard div.step-content').find('.step-pane.active').attr('data-questionID');
    let questionTypeID = $('#questionWizard div.step-content').find('.step-pane.active').attr("data-questiontypeid");
    let questionNumber = $('#questionWizard div.step-content').find('.step-pane.active').attr("data-step");
    let jumpTime = $('#questionWizard div.step-content').find('.step-pane.active').attr("data-jumptime");
    let ansResp = getQuestionResponse();
    let answerData = ansResp.answerData;
    let answerListData = ansResp.answerListData;
    let answers = ansResp.answerResponse;
    let createResponseData = createResponse(paperId, studentId, questionId, questionTypeID, questionNumber, submissionType, answerData, examStatus, answerListData, jumpTime, answers);
    submitResponse(JSON.stringify(createResponseData), true);
}

function redirectToFB(feedBackScreenURL) {
    setTimeout(function() {
        if (window.opener) {
            window.opener.location.href = feedBackScreenURL;
        } else {
            localStorage.setItem('examSubmitted', true);
        }
        self.close();
    }, 2000);
}

function showGlobalFileMsg() {
    if ($('.globalUploades li').length > 0) {
        $(".globalfilesmsg").hide();
    } else {
        $(".globalfilesmsg").show();
    }
}

function showLocalFileMsg() {
    if ($('.questionFiles li').length > 0) {
        $(".localfilesmsg").hide();
    } else {
        $(".localfilesmsg").show();
    }
}

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
