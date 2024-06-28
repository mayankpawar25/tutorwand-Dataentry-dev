<script type="text/javascript">
    
    onlineChecker("{{ __('students.notifications.siteOnlineExam') }}", "{{ __('students.notifications.siteOfflineExam') }}");

    $(document).ready(function(){

        localStorage.setItem(timeId, examTimer);
         if(localStorage.getItem(flagId) == undefined){
            let flagData = {reportId: [], bookmarkId: [], timeHide: 'false', fontZoom: 'false'};  
            localStorage.setItem(flagId, JSON.stringify(flagData));
        }
        getResumeExam();
        let response = defaultResponse(studentID, paperId, examTimer);
    });

    $(document).on("click", ".startExamBtn", function(){
        if(!$(this).hasClass('disabled')) {
            let redirectUrl = $(this).data("href");
            let isChecked = $('input[name=instructions]').is(":checked");
            if(isChecked) {
                $(this).addClass('disabled');
                $("input[name=instructions]").parent().removeClass('text-danger');
                if(localStorage.answeredResponse) {
                    if(JSON.parse(localStorage.answeredResponse).examStatus == "NotStarted") {
                        localStorage.setItem("showLoader", true);
                        let response = defaultResponse(studentID, paperId, examTimer);
                        let submittedResponse = submitResponse(JSON.stringify(response), true);
                        setTimeout(() => {
                            $.ajax({
                                url: "{{ route('students.resumeExam') }}",
                                type: 'POST',
                                dataType: 'json',
                                data: {paperId: paperId},
                                success: function(resp){
                                    if(resp.data.examStatus == "NotStarted") {
                                        getResumeExam();
                                    } else if(resp.data.examStatus == "InProgress") {
                                        $(".startExamBtn span.buttonTitle").html("{{ __('students.resume') }}");
                                        localStorage.setItem('answeredResponse', JSON.stringify(resp.data));
                                        msgToast("info", "{{ __('students.assessmentStartInfoText') }}");
                                        startExam(`${redirectUrl}`);
                                    }
                                },
                                error: function(resp){
                                    msgToast("error", InternalServerError);
                                }
                            });
                        }, 2000);
                    }
        
                    if(JSON.parse(localStorage.answeredResponse).examStatus == "InProgress") {
                        getResumeExam();
                        localStorage.setItem("showLoader", false);
                        msgToast("info", "{{ __('students.assessmentStartInfoText') }}");
                        $(".startExamBtn span.buttonTitle").html("{{ __('students.resume') }}");
                        startExam(redirectUrl);
                    }
                } else {
                    getResumeExam();
                }
    
            }
            if(!isChecked){
                $("input[name=instructions]").parent().addClass('text-danger').focus();
                msgToast("error", checkTncError);
            }
        }
    });

    $(document).on('keydown', 'div[tabindex=0]', function(e){
        if(e.keyCode == 13 || e.keyCode == 32)
            $(this).find('input[type=checkbox]').click();
    });

    function getResumeExam() {
        $.ajax({
            url: "{{ route('students.resumeExam') }}",
            type: 'POST',
            dataType: 'json',
            data: {'paperId': paperId},
            success: function(resumeData){
                if(resumeData.status) {
                    localStorage.setItem(`${paperId} examResume`, false);
                    if(resumeData.data == 500){
                        msgToast("error", "{{ __('students.notifications.InternalServerError') }}");
                        $(".startExamBtn").addClass("disabled");
                    } else if(resumeData.data.message){
                        msgToast("info", resumeData.data.message);
                        $(".startExamBtn").addClass("disabled");
                    } else if(resumeData.data.examStatus == "NotStarted") {
                        $(".startExamBtn span.buttonTitle").html("{{ __('students.start') }}");
                    } else if(resumeData.data.examStatus == "InProgress") {
                        $(".startExamBtn span.buttonTitle").html("{{ __('students.resume') }}");
                        var isTruePopup = localStorage.getItem(`${paperId} popupIsOpened`);
                        if(isTruePopup == "false") {
                            localStorage.setItem(`${paperId} examResume`, true);
                            // showMessage(resumeExamText);
                        } else {
                            examPopupIsOpened();
                        }
                    } else if(resumeData.data.examStatus == "Submitted"){
                        $(".startExamBtn").addClass("disabled");
                        msgToast("info", "{{ __('students.notifications.alreadySubmittedText') }}");
                    } else if(resumeData.data.examStatus == "UpComing"){
                        $(".startExamBtn").addClass("disabled");
                        msgToast("info", "{{ __('students.notifications.upcomingExamText') }}");
                    } else if(resumeData.data.examStatus == "UnAuthorized"){
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

    function startExam(redirectUrl){
        $("#openExamPopup").click();
        setTimeout(() => {
            if($('.startExamBtn').hasClass('disabled')){
                $('.startExamBtn').removeClass('disabled');
            }
        }, 2000);
    }

    $(document).on('click','#openExamPopup', function(){
        let redirectUrl = $('.startExamBtn').data("href");
        let popup = window.open(redirectUrl, "popupWindow", "width=screen.width,height=screen.height,scrollbars=yes,directories=no,titlebar=no,toolbar=no,location=off,status=no,menubar=no,fullscreen=yes,addressbar=no,safariAllowPopups=true");
        if(popup == null || typeof(popup)=='undefined') {
            alert(popupBlocker);
            return false;
        } else {
            popup.moveTo(0, 0);
            popup.resizeTo(screen.width, screen.height);
            localStorage.setItem(`${paperId} popupIsOpened`, true);
            examPopupIsOpened();
            if (window.focus) { popup.focus() }
        }
    })

    function showMessage(resumeExamText) {
        if (!$('.info-banner.offline').length) {
            $('.main-body div:eq(0)').before(`<div class="info-banner offline">${resumeExamText}</div>`);
            $(".main-body .container-fluid").removeClass("container-wth-banner");
        }
        setTimeout(() => {
            if ($('.info-banner').length > 0) {
                $('.info-banner').remove();
                $(".main-body .container-fluid").removeClass("container-with-banner");
            }
        }, 10000);

    }

    $(document).ready(function(){
        examPopupIsOpened();
    });

    function examPopupIsOpened() {
        var popupOpendText = "{{ __('students.notifications.examInPoup') }}";
        setInterval(() => {
            var isTruePopup = localStorage.getItem(`${paperId} popupIsOpened`);
            var resumeTrue = localStorage.getItem(`${paperId} examResume`);
            if(isTruePopup == "true") {
                if ($('.info-banner').length > 0) {
                    $('.info-banner').remove();
                }
                if (!$('.info-banner.offline').length) {
                    $('.main-body div:eq(0)').before(`<div class="info-banner offline">${popupOpendText}</div>`);
                    $(".main-body .container-fluid").removeClass("container-wth-banner");
                }
            } else {
                if(resumeTrue == "true") {
                    if ($('.info-banner').length > 0) {
                        $('.info-banner').remove();
                    }
                    if (!$('.info-banner.offline').length) {
                        $('.main-body div:eq(0)').before(`<div class="info-banner offline">${resumeExamText}</div>`);
                        $(".main-body .container-fluid").removeClass("container-wth-banner");
                    }
                } else if ($('.info-banner').length > 0) {
                    $('.info-banner').remove();
                }
            }

            if(localStorage.getItem('examSubmitted')) {
                localStorage.getItem('examSubmitted');
                localStorage.clear();
                window.location.href = feedBackScreenURL;
            }

        }, "{{ config('constants.setInterval') }}");
    }
</script>