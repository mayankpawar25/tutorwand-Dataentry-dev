<script>
    var ctrlKeyDown = false;
    let questionReported = false;
    let questionReportedSuccess = "{{ __('students.questionReportedSuccess') }}";
    let serverErrorText = "{{ __('students.serverError') }}";
    let lastestQuestionId = "";
    onlineCheckerExam("{{ __('students.notifications.backToOnlineText') }}", "{{ __('students.notifications.offlineExam') }}", submitResponseOfflineError);

    setInterval(() => {
        if(navigator.onLine) {
            isOnline = true;
            $(".uploadFileBtn").attr({'disabled' : false});
            $(".uploadGlobalFileBtn ").attr({'disabled' : false});
            if(onlineCount > 0) {
                if(localStorage.getItem('answeredResponse') != undefined || localStorage.getItem('answeredResponse') != null) {
                    let pData = localStorage.getItem('answeredResponse');
                    submitResponse(pData, true);
                    onlineCount = 0;
                    updateReviewSubmit();
                }

                if(localStorage.getItem('clearResponse') != undefined || localStorage.getItem('clearResponse') != null) {
                    let cData = JSON.stringify(localStorage.getItem('clearResponse'));
                    submitClearCall(cData['paperId'], cData['questionId']);
                    localStorage.removeItem("clearResponse");
                    onlineCount = 0;
                }
            }
        } else {
            isOnline = false;
            onlineCount++;
            $(".uploadFileBtn").attr({'disabled' : true});
            $(".uploadGlobalFileBtn ").attr({'disabled' : true});
        }
    }, "{{ config('constants.setInterval') }}");

    function keydown(e) { 
        if ((e.which || e.keyCode) == 116 || ((e.which || e.keyCode) == 82 && ctrlKeyDown)) {
            // Pressing F5 or Ctrl+R
            e.preventDefault();
        } else if ((e.which || e.keyCode) == 17) {
            // Pressing  only Ctrl
            ctrlKeyDown = true;
        } else if (e.ctrlKey && (e.key == 'p' || e.key == 'PrintScreen')) {
            e.cancelBubble = true;
            e.preventDefault();
            e.stopImmediatePropagation();
        } 
    };

    function keyup(e){
        if ((e.which || e.keyCode) == 17) {
            ctrlKeyDown = false;
        } else if (e.key == 'PrintScreen' ||((e.which ||  e.keyCode) == 44)) {
           navigator.clipboard.writeText('');
        }
    };

    $(document).ready(function() {
        $('.long-question').each(function(i,v){
            studentCkeditor($(v).attr('id'));
        })

        $('.short-question').each(function(i,v){
            studentCkeditor($(v).attr('id'));
        });

        if(localStorage.showLoader == "true") {
            localStorage.setItem('showLoader', false);
            $(".loader-outer").show();
            setTimeout(function(){
                $(".loader-outer").fadeOut('slow');
                $(".exam-warp").show();
                startTimer();
            }, 4000);
        } else {
            $(".exam-warp").show();
            $(".loader-outer").hide();
            startTimer();
        }

        $(document).on("keydown", keydown);
        $(document).on("keyup", keyup);

        /* Disable cut copy paste */
        $('body').bind('cut copy', function(e) {
            e.preventDefault();
        });
       
        /* Disable select text */
         $('body').attr('unselectable','on')
         .css({'-moz-user-select':'-moz-none',
               '-moz-user-select':'none',
               '-o-user-select':'none',
               '-khtml-user-select':'none', /* you could also put this in a class */
               '-webkit-user-select':'none',/* and add the CSS class here instead */
               '-ms-user-select':'none',
               'user-select':'none'
         }).bind('selectstart', function(){ return false; });

        /* Set all last attempted, bookmarked, report */
        let answeredData = JSON.parse(localStorage.getItem('answeredResponse'));
        let fData = JSON.parse(localStorage.getItem(flagId));
        if(answeredData.responses.length > 0) {
            answeredData.textZoomed = fData.fontZoom;
            answeredData.timerEnabled = fData.timeHide;
            $.each(answeredData.responses, function (ind, valData) {
                if(valData.bookMarked) {
                    if(fData.bookmarkId.length > 0){
                        if($.inArray(valData.questionId, fData.bookmarkId) != -1){
                            fData.bookmarkId.push(valData.questionId);
                        }
                    } else {
                        fData.bookmarkId.push(valData.questionId);
                    }
                }
                if(valData.errored) {
                    if(fData.reportId.length > 0){
                        if($.inArray(valData.questionId, fData.reportId) != -1){
                            fData.reportId.push(valData.questionId);
                        }
                    } else {
                        fData.reportId.push(valData.questionId);
                    }
                }
            });    
        }
        localStorage.setItem(flagId, JSON.stringify(fData));

    	$('.exam-warp').find('.clock').addClass('active');

        if(fData.fontZoom == true) {
            $('.exam-warp').find(".font-btn").addClass("active");
            $('.exam-warp').find('.canvas-inner').find('.canvas-body').addClass('enlargeFont');
    	} else {
            $('.exam-warp').find(".font-btn").removeClass("active");
            $('.exam-warp').find('.canvas-inner').find('.canvas-body').removeClass('enlargeFont');
    	}
        setInterval(() => {
            let timeRemaining = timeLeft;
            if(isOnline) {
                $(".submitBtn").attr({'disabled' : false});
            } else {
                $(".submitBtn").attr({'disabled' : true});
                let answeredData = JSON.parse(localStorage.getItem('answeredResponse'));
                answeredData.remainingTime = timeRemaining;
                localStorage.setItem('answeredResponse', JSON.stringify(answeredData));
            }  
        }, 5000);

        setTimeout(function(){
    		updateLegendCounter();
            activeWidgetStatus();
            questionJumpTime();
            updateLegendCounter();
            updatePalletStrings();
            /* switch to last attempted question */
            let answeredData = JSON.parse(localStorage.getItem('answeredResponse'));
            if(!$.isEmptyObject(answeredData.responses)) {
                let lastAttemptedResp = (getMaxTime(answeredData.responses, 'responseTime'));
                // $(`.question-pallet .showQuestionArea#${lastAttemptedResp.questionId}`).click();
            }
            let self = $('.question-list img');
            // self.attr({'style' : 'width:150px;height:150px;'});
            self.wrap('<span class="zoom" />');
            
            // $('.zoom').zoom({magnify:2});
            $('.zoom').each(function (index, element) {
                if(!$(this).parents('div#full-paper').hasClass('modal')) {
                    $(this).zoom({magnify: 2});
                }
            });

    	}, 1000);
    });
        
    $(document).on('keydown', 'div[tabindex=0]', function(e){
        if(e.keyCode == 13 || e.keyCode == 32)
            $(this).find('input[type=radio]').click();
    });

    function getMaxTime(arr, prop) {
        let max;
        for (var i=0 ; i<arr.length ; i++) {
            if (max == null || parseInt(new Date(arr[i][prop]).getTime()) > parseInt(max[prop]))
                max = arr[i];
        }
        return max;
    }

    /* Disable printscreen */
    $(window).keydown(function(e){
        if(e.keyCode == 44){
            $('body').hide();
        }
    });

    $(window).keyup(function(e){
        if(e.keyCode == 44){
            setTimeout(() => {
                $('body').show();
            }, 1000);
        }
    });

    // Report question
    $(document).on("click", ".report-btn", function(){
        let questionId = $('.question-text.active').data("questionid");
        let fData = JSON.parse(localStorage.getItem(flagId));
        $(this).toggleClass('active');
        if($(this).hasClass('active')) {
            if($.inArray(questionId, fData.reportId) == -1){
                $(".report-btn").addClass("active");
                // reportQuestion(questionId);
                fData.reportId.push(questionId);
                localStorage.setItem(flagId, JSON.stringify(fData));
                questionReported = true;
            }
        } else {
            fData.reportId = $.grep(fData.reportId, function(value) {
                return value != questionId;
            });
            localStorage.setItem(flagId, JSON.stringify(fData));
            questionReported = false;
        }
    });

    function reportQuestion(questionId){
        let fData = JSON.parse(localStorage.getItem(flagId));
        $.ajax({
            type: "POST",
            timeout: 10000,
            url: "{{ route('students.get.student.question.report') }}",
            data:{id: questionId},
            dataType: "json",
            success: function (response) {
                if(response.status) {
                    $("#question-option-checkboxes").slideUp("fast");
                    if($.inArray(questionId, fData.reportId) == -1) {
                        fData.reportId.push(questionId);
                    }
                    localStorage.setItem(flagId, JSON.stringify(fData));
                    msgToast('success', questionReportedSuccess);
                } else {
                    msgToast('error', serverErrorText);
                }
            },
            error: function(data) {
                msgToast('error', serverErrorText);
            }
        });
    }

    function checkQuestionToReport(questionId){
        let fData = JSON.parse(localStorage.getItem(flagId));
        if($.inArray(questionId, fData.reportId) != -1){
            reportQuestion(questionId);
            return true;
        }
        return false;
    }

    $(".clear-data-btn").click(function() {
    	/* Reset CkEditor Short Answer */

        let questionId = $('.question-text.active').attr('data-questionid');

    	if ($('.question-text.active').find('.short-question').length > 0) {
    		let dataId = $('.question-text.active').find('.short-question').attr('id');
    		CKEDITOR.instances[dataId].setData('');

    		$('.question-text.active').find('textarea').val('');
    		$('.question-text.active').find('input').val('');

            if($('.question-text.active').find('.putURLImageHere li').length > 0){
                if (confirm("{{ __('students.examPage.clearConfirmText') }}")) {
                    $('.question-text.active').find('.putURLImageHere li').remove();
                }
            }
    	}

    	/* Reset CkEditor Long Answer */
    	if ($('.question-text.active').find('.long-question').length > 0) {
    		let dataId = $('.question-text.active').find('.long-question').attr('id');
    		CKEDITOR.instances[dataId].setData('');
    		$('.question-text.active').find('textarea').val('');
    		$('.question-text.active').find('input').val('');
    		  
            if($('.question-text.active').find('.putURLImageHere li').length > 0){
                if (confirm("{{ __('students.examPage.clearConfirmText') }}")) {
                    $('.question-text.active').find('.putURLImageHere li').remove();
                }
            }
    	}

    	/* Reset fill up the blanks */
    	if ($('.question-text.active').find('.fill-ups').length > 0) {
    		$('.question-text.active').find('input[type="text"]').val('');
    	}

    	/* Reset MCQ */
    	if ($('.question-text.active').find('input[type="radio"]').length > 0) {
    		$('.question-text.active').find('input.radioBox').prop('checked', false);
    	}

    	questionId = $('#questionWizard div.step-content').find('.step-pane.active').attr('data-questionID');

        if(isOnline) {
            /* Service Call to clear questions from paper */
            submitClearCall($("#paperID").val(), questionId);
        } else {
            let clearData = localStorage.getItem('clearResponse') != null ? JSON.parse(localStorage.getItem('clearResponse')) : [];
            let pushData = {paperId: $("#paperID").val(), questionId: questionId};
            clearData.push(pushData);
            localStorage.setItem('clearResponse', JSON.stringify(clearData));
        }
        clearAnswerStorage(questionId);

        let stringText = $('.select-legend option:selected').val();
        showPallets(stringText);

    });

    function submitClearCall(paperId, questionId) {
        $.ajax({
    		url: "{{ route('students.clearQuestion') }}",
    		type: 'POST',
    		dataType: 'html',
    		data: { paperId: paperId, questionId: questionId },
    		success: function (response) {
    			if (response) {
    				$(`#update-submit-review-status`).html(response.html);
    			}
    		}
    	});
    }
     
    function activeWidgetStatus(){
        let fData = JSON.parse(localStorage.getItem(flagId));
        var answers = JSON.parse(localStorage.getItem('answeredResponse'));
        responseId = answers.responseId;
        if(answers && $(`.question-text`).attr('data-questionid') != undefined){
        	$.each(answers.responses, function(indexKey, questionResponse) {
                var questionId = questionResponse.questionId;
                if(questionResponse.sequenceNumber != 0) {
                    if($(`.question-text`).hasClass('active')){
                        $(`.question-text`).removeClass('active');
                    }
                    $(`.question-text[data-questionid=${questionId}]`).addClass('active');

                    lastestQuestionId = questionId;
                    $(`li#${questionResponse.questionId} button`).click();

                    /* select correct option in multi-choice / true or false / Fill in the blanks */
                    $.each(questionResponse.answer.options, function(indexData, optionData) {
                        if(optionData.optionText && optionData.isCorrect) {
                            indexData++;

                            /* Multi-Choice / True False */
                            $(`.question-text[data-questionid=${questionId}]`).find(`.optionnumber${indexData}`).attr({'checked': true});
                            if($(`.question-text[data-questionid=${questionId}]`).find(`.optionnumber${indexData}`).is(':checked')) {
                                if($(`li#${questionId} button`).hasClass('unattempted')){
                                    $(`li#${questionId} button`).removeClass('unattempted');
                                }
                                $(`li#${questionId} button`).addClass('answered');
                            }

                            /* Fill in the blanks */
                            if($(`.question-text[data-questionid=${questionId}]`).find(`input[name=correctAnswer_${questionResponse.sequenceNumber}_${indexData}]`)) {
                                $(`.question-text[data-questionid=${questionId}]`).find(`input[name=correctAnswer_${questionResponse.sequenceNumber}_${indexData}]`).val(optionData.optionText);
                                if($(`li#${questionId} button`).hasClass('unattempted')){
                                    $(`li#${questionId} button`).removeClass('unattempted');
                                }
                                $(`li#${questionId} button`).addClass('answered');
                            }
                        }
                    });
                    if(questionResponse.timeSpent > 1) {
                        $(`.question-text[data-questionid=${questionId}]`).attr({'data-spentTime' : questionResponse.timeSpent});
                    }


                    /* Long and Short Type Question */
                	if($(`.question-text[data-questionid=${questionId}]`).find("textarea").attr("id")){
        	        	let textareaId = $(`.question-text[data-questionid=${questionId}]`).find("textarea").attr("id");
                        if(questionResponse.answer.answer) {
                            CKEDITOR.instances[`${textareaId}`].setData($.trim(questionResponse.answer.answer));
            	        	if($(`li#${questionId} button`).hasClass('unattempted')){
            	                $(`li#${questionId} button`).removeClass('unattempted');
            	        	}
            	            $(`li#${questionId} button`).addClass('answered');
                        }
                        $.each(questionResponse.files, function(index, element) {
                            fileNumber++;
                            $("div#question-carousel-slide div.carousel-inner").append(`<div class="carousel-item" style="width:100%"><embed src="${element.fileUrl}" width="100%" /></div>`);

                            var html = `<li class="${questionId}_${fileNumber}" data-fileNumber="${fileNumber}">
                                <div>${fileIcon}</div>
                                <div class="file-name">${element.fileName}</div>
                                <div class="cursor-pointer close removeFile" data-id="${questionId}_${fileNumber}" data-filename="${element.fileName}" data-href="${element.fileUrl}">
                                    ${removeFileIcon}
                                </div>
                            </li>`;
                            $(`.question-text[data-questionid=${questionId}]`).find('.putURLImageHere').append(html);
                            $(".questionFiles").append(html);

                            if($(`li#${questionId} button`).hasClass('unattempted')){
                                $(`li#${questionId} button`).removeClass('unattempted');
                            }
                            $(`li#${questionId} button`).addClass('answered');
                        });
        	        }
                }

                /* Bookmarked questions */
    	        if(questionResponse.bookMarked){
    	            $(`li#${questionId} button`).addClass('mark-review');
    				if ($.inArray(questionId, fData.bookmarkId) == -1) {
    					fData.bookmarkId.push(questionId);
    				}
    	        }

                /* Error reporting questions */
    	        if(questionResponse.errored){
    				if (fData && $.inArray(questionId, fData.reportId) == -1) {
    					fData.reportId.push(questionId);
    				}
    	        } else {
                    fData.reportId = $.grep(fData.reportId, function(value) {
                        return value != questionId;
                    });
                }
    			localStorage.setItem(flagId, JSON.stringify(fData));
    	    });

            /* Attach Global uploaded files */
            $.each(answers.globalFiles, function(key, fileArray){
                globalFileNumber++;
                let fileNameHtml = `<li class="global_${globalFileNumber}"><div>${fileIcon}</div>
                    <div class="file-name">${fileArray.fileName}</div>
                    <div class="cursor-pointer close removeFile" data-id="global_${globalFileNumber}" data-filename="${fileArray.fileName}" data-href="${fileArray.fileUrl}">
                        ${removeFileIcon}
                    </div>
                </li>`;
                
                $("div#global-carousel-slide div.carousel-inner").append(`<div class="carousel-item" style="width:100%"><embed src="${fileArray.fileUrl}" width="100%" /></div>`);
                $("div.right-panel-body div.uploaded-file-block ul.uploaded-doc").append(fileNameHtml);
                $("div.right-panel-body div.uploaded-file-block ul.uploaded-doc").show();
                $(".globalUploades").append(fileNameHtml);
            });
        }
    }


    function updateReviewSubmit() {
        let answersArray = [];
        $('ul.question-pallet li').each(function(index,selector){
            let questionId = $(selector).attr('id');
            let className = ($(selector).find('button').attr('class')) ? $(selector).find('button').attr('class') : 'notattempted';
            let id = parseInt(index) + parseInt(1);
            updateArray = {id : id , className : className, questionId: questionId};
            answersArray.push(updateArray);
        });

        $.ajax({
            url: $(`#submit-review-url`).val(),
            type: 'POST',
            dataType: 'json',
            data: { answersArray: answersArray, timeLeft: timeLeft },
            success: function (response) {
                if (response) {
                    $(`#update-submit-review-status`).html(response.html);
                }
            }
        });
    }

    function getResumeExam() {
        $.ajax({
            url: "{{ route('students.resumeExam') }}",
            type: 'POST',
            dataType: 'json',
            data: {'paperId': paperId},
            success: function(resumeData){
                if(resumeData.status) {
                    if(resumeData.data == 500) {
                        msgToast("error", "{{ __('students.notifications.InternalServerError') }}");
                        $(".startExamBtn").addClass("disabled");
                    } else if(resumeData.data.message) {
                        msgToast("info", resumeData.data.message);
                        $(".startExamBtn").addClass("disabled");
                    } else if(resumeData.data.examStatus == "NotStarted") {
                        $(".startExamBtn span.buttonTitle").html("{{ __('students.start') }}");
                    } else if(resumeData.data.examStatus == "InProgress") {
                        $(".startExamBtn span.buttonTitle").html("{{ __('students.resume') }}");
                    } else if(resumeData.data.examStatus == "Submitted") {
                        $(".startExamBtn").addClass("disabled");
                        msgToast("info", "{{ __('students.notifications.alreadySubmittedText') }}");
                    } else if(resumeData.data.examStatus == "UpComing") {
                        $(".startExamBtn").addClass("disabled");
                        msgToast("info", "{{ __('students.notifications.upcomingExamText') }}");
                    } else if(resumeData.data.examStatus == "UnAuthorized") {
                        $(".startExamBtn").addClass("disabled");
                        msgToast("info", "{{ __('students.notifications.unauthorizeExamText') }}");
                    }
                    localStorage.setItem('answeredResponse', JSON.stringify(resumeData.data));
                } else {
                    let response = defaultResponse(studentID, paperId, examTimer);
                    if(submitResponse(JSON.stringify(response), true)){
                        getResumeExam();
                    }
                }
            }
        });
    }

    $(document).on('change','.select-question-type', function(){
        var typeID = $(this).val();
        $(`ul.question-pallet li`).hide();    
        if(typeID != ""){
            $(`ul.question-pallet li[data-question=${typeID}]`).show();
        } else {
            $(`ul.question-pallet li`).show();
        }
    });

    $(document).on('click', '.submit-exam', function() {
        $(this).html(`${simpleSpinner} {{ __('students.submit') }}`);
        $(this).attr({'disabled':true});
        $("#close-confirm").attr({'disabled':true});
        submitExam(paperId, studentID, feedBackScreenURL);
        localStorage.clear();
    });

    $(document).on("keydown", function(e){
        if((e.which || e.keyCode) == 39) {
            // Next Key
            if($('.next-btn').is(':visible')) {
                $('.next-btn').click();
            }
        }
        if((e.which || e.keyCode) == 37) {
            // Previous Key
            if($('.prev-btn').is(':visible')) {
                $('.prev-btn').click();
            }
        }
    });

    function showConfirmBox(text=""){
        if(text != ""){
            $('#confirm div.modal-body').find('h5').text(text);
        }
        $("#confirm").modal();
    }
  
    window.onbeforeunload = function(e) {
        localStorage.setItem(`${paperId} examResume`, true);
        localStorage.setItem(`${paperId} popupIsOpened`, false);
    };

    function getCsrfToken(){
        var newToken = "{{ csrf_token() }}";
        return newToken;
    }

</script>
<script type="text/javascript" src="{{ asset('assets/students/js/exam.js') }}"></script>