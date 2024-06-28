<!-- Common JS FILES -->
<script type="text/javascript" src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-multiselect.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-slider.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.datetimepicker.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/utils.js') }}"></script>

<!-- Plugins JS Files -->
<script type="text/javascript" src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/owlcarousel/owl.carousel.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/plugins/progressbar/circle-progress.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/chartjs/chart.js') }}"></script>

<script type="text/javascript">
    let steps = 0;
    let toolbarGroups1 = [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        { name: 'forms', groups: [ 'forms' ] },
        '/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
        '/',
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'others', groups: [ 'others' ] },
        { name: 'about', groups: [ 'about' ] }
    ];

    let removeButtons = 'Styles,Format,Font,FontSize,TextColor,BGColor,ShowBlocks,Maximize,About,Image,Link,Unlink,Flash,Anchor,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Source,Save,NewPage,ExportPdf,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,RemoveFormat,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language';
    let selectedTemplateStatus = [];
    let filterTemplate = {};
    let isSkip = false;
    let buttonSpinner = `<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>`;
    let previous = false;
    let previousModified = false;
    let flaggedIds = [];
    let examTotalMinutes = "{{ config('constants.MaxMinutes') }}";
    let timeDurationText = "{{ __('teachers.assessment.timeDuration') }}";
    let dueDateErrorStr = "{{ __('teachers.assessment.dueDateErrorStr') }}";
    let noDataAvailable = "{{ __('teachers.assessment.noDataAvailable') }}";

    $.datetimepicker.setDateFormatter('moment');
    // @Function PopOver
    $( function() {
        $('[data-toggle="popover"]').popover();
        callCarousel();
        updateTemplateStatus(0);
    });

    // side panel
    $(".fixed-side-panel-trigger").click(function() {
        $(".fixed-side-panel").toggleClass("fixed-panel-open");
        $(".fixed-side-panel-trigger").toggleClass("rotate-180");
        $(".main-header").toggleClass("slide-100");
        if($(".fixed-side-panel").hasClass("fixed-panel-open")) {
            $("body").addClass('side-panel-open');
        } else {
            $("body").removeClass('side-panel-open');
        }
    });

    $('body').on('click', function(e) {
        $('[data-toggle=popover]').each(function() {
            // hide any open popovers when the anywhere else in the body is clicked
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

    //sort table
    let fixHelperModified = function(e, tr) {
        let $originals = tr.children();
        let $helper = tr.clone();
        $helper.children().each(function(index) {
            $(this).width($originals.eq(index).width())
        });
        return $helper;
    },
    updateIndex = function(e, ui) {
        $('td.index', ui.item.parent()).each(function(i) {
            // $(this).html(i + 1);
        });
        $('input[type=text]', ui.item.parent()).each(function(i) {
            // $(this).val(i + 1);
        });
    };

    $("#sortTtable tbody").sortable({
        helper: fixHelperModified,
        stop: updateIndex,
        update: function (event, ui) {}
    }).disableSelection();

    $("tbody").sortable({
        distance: 5,
        delay: 100,
        opacity: 0.6,
        cursor: 'move',
        update: function(event, ui) {
            /* This will update the template edit status */
            updateTemplateStatus();
        }
    });

    $(document).on("change", "#sortTtable input[type='text']", function(){
        if( parseFloat($(this).val()) != parseFloat($(this).data('value')) ) {
            updateTemplateStatus();
        } else {
            updateTemplateStatus(0);
        }
    });

    function updateTemplateStatus(status=1, filterStatus=0) {
        selectedTemplateStatus = {
            templateId: $(".test-format-right .item > a.active.current").parent("div").data("id"),
            templateType: $(".test-format-right .item > a.active.current").parent("div").data("type"),
            templateName: $(".test-format-right .item > a.active.current").parent("div").data("title"),
            maxMarks: $(".test-format-right .item > a.active.current").parent("div").data("marks"),
            isModified: status,
            filterModified: filterStatus,
            oldTemplate: false
        };
    }

    $(document).on('click', '#reviewTab', function(e){

        $(document).on("keydown", function(e){
            if((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 17){
                e.preventDefault();
                return false;
            }
        });

        if(!isOnline) {
            msgToast('error', `{{ __('questionLayout.offlineNotification') }}`);
            return false;
        }

        let errorCounter = validateQuestionLayoutInp();
        if(errorCounter == 0){
            getReviewQuestionPage();
            $(".right-panel-section").addClass('d-none');
            $('#reviewDiv').addClass('active').removeClass('fade')
            $('#review').addClass('fade').removeClass('active')
            $('#reviewPreviousBtn').removeClass('d-none')
            $('#scheduleTab').removeClass('d-none')
            $('#scheduleTab').attr('disabled', false);
            $(this).addClass('d-none')
            $('#reviewNav').removeClass('done')
            $('#reviewNav').addClass('active')
            steps = 1
        }

        selectedTemplateStatus.templateId = $(".item").find(".active.current").parent(".item").data("id");
    });

    if($("div").hasClass("oldpaper")) {
        $("#reviewDiv").show();
        $("#scheduleTab").removeClass("d-none disabled").attr({"disabled": false});
    }

    /* On click save template button on modal */
    $(document).on({
        click: function (event) {
            if($(this).hasClass("disabled") || $(this).is('[disabled=disabled]')) {
                return true;
            }
            let $selector = $(this);
            let selectorText = $selector.text();
            let templateName = $("input[name='template_title']").val();
            let selectedTemplateName = selectedTemplateStatus.templateName;
            let templateTitleThreshold = 20;
            let errorDiv = '';

            $("input[name='template_title']").removeClass("text-required");
            $(".text-danger.error-msg").remove();
            if($.trim(templateName).length <= 0) {
                $("input[name='template_title']").val('');
                $("input[name='template_title']").focus();
                underElementError("input[name='template_title']", `{{ __('questionLayout.required') }}`);
                return false;
            }
            if($.trim(templateName).length > templateTitleThreshold ) {
                $("input[name='template_title']").focus();
                underElementError("input[name='template_title']", `{{ __('questionLayout.maxCharacterAllowed') }}`);
                return false;
            }

            if($.trim(selectedTemplateName) == $.trim(templateName)) {
                $("input[name='template_title']").focus();
                errorDiv += `<div class='toast-message'> {{ __('questionLayout.duplicateAssignmentError') }}</div>`;
                $selector.attr({'disabled': false});
                $selector.html(`${selectorText}`);
                msgToast("error", errorDiv);
            } else {
                let error = validateBlueprint();
                if(!error) {
                    $selector.attr({'disabled': true});
                    $selector.html(`${buttonSpinner} ${selectorText}`);
                    $.ajax({
                        type: "GET",
                        url: "{{ route('check.duplicate.template') }}",
                        data: { 'string': templateName },
                        dataType: "json",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            if(response.string_name == 'duplicate') {
                                $("input[name='template_title']").focus();
                                $selector.attr({'disabled': false});
                                $selector.html(`${selectorText}`);
                                msgToast("error", `<div class='toast-message'> {{ __('questionLayout.duplicateAssignmentError') }}</div>`);
                            } else {
                                let ntemplateData = templateDataCreator(response.string_name);
                                saveTemplateData(ntemplateData);
                            }
                        },
                        error: function (err) {
                            $selector.attr({'disabled': false});
                            $selector.html(`${selectorText}`);
                        }
                    });
                } else {
                    $selector.attr({'disabled': false});
                    $selector.html(`${selectorText}`);
                }
            }
        }
    }, "#saveTemplate");

    function setAssignmentTitleErrorMessage($selector, $action, message, selectorText) {
        $action.addClass("text-required");
        $action.after(`<small class="text-danger error-msg">${message}</small>`);
        $selector.attr({'disabled': false});
        $selector.html(`${selectorText}`);    
        return false;
    }

    /* Check Duplicate String Template */
    function checkDupString(stringName){
        $.ajax({
            type: "GET",
            url: "{{ route('check.duplicate.template') }}",
            data: { 'string': stringName },
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            success: function (response) {
                return response.string_name;
            }
        });
    }

    /* Save Template Data */
    function saveTemplateData(templateData) {
        updateTemplateStatus(1, 1);
        $.ajax({
            type: "POST",
            url: "{{ route('save.template.data') }}",
            data: templateData,
            dataType: "text",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            success: function (response) {
                if(response != false) {
                    selectedTemplateStatus.templateId = response;
                    // getReviewQuestionPage();
                    /* Reset Modal */
                    $('input[name=template_title]').val('');
                    $('tbody.ui-sortable').html('');
                    $('.total_count_value').text(0);
                    $('.all_totals').html('0.00');
                    $('#preview2').modal('hide');
                    getTemplateData();
                } else {
                    $(this).attr({'disabled': false});
                    $("input[name='template_title']").addClass("text-required");
                    $("input[name='template_title']").after(`<small class="text-danger error-msg">{{ __('teachers.script.errorMsg1') }}</small>`);
                }
                $('#saveTemplate').attr({'disabled': false});
                $('#saveTemplate').html($('#saveTemplate').text());
            }
        });
    }

    /* On change value of template name on modal */
    $(document).on({
        change: function (event) {
            $(this).removeClass("text-required");
            $("#saveTemplate").attr({"disabled": false});
            $(this).parents('.modal-body').find('.error-msg').remove();
            if($(this).val().length <= 0) {
                $(this).addClass("text-required");
            }
        }
    }, "input[name='template_title']");

    $(document).on("click", ".assign-confirm", function() {
        if($(this).hasClass("disabled")) {
            return false;
        }
        let templateid = selectedTemplateStatus.templateId;
        let questionsCheck = $("#questionsCheck").is(":checked");
        let dontUseCalculator = $("#dontUseCalculator").is(":checked");
        let scheduleDate = $("#test-schedule-date").val();
        let dueDate = $("#test-due-date").val();
        let radioBoxVal = "";
        let endDate = "";
        let publishedDate = "";
        let $selector = $(this);
        let selectorText = $selector.text();
        $selector.html(`${buttonSpinner} ${selectorText}`);
        $selector.addClass('disabled');
        $("#close-confirm").attr({'disabled': true});
        
        let templateData = {
            "userId": "{{ Session::has('profile') ? Session::get('profile')["userId"] : '' }}",
            "templateId": templateid
        };
        let postData = {
            "allQuestionsRequired": questionsCheck,
            "dontUseCalculator": dontUseCalculator,
            "scheduleDate": scheduleDate,
            "dueDate": dueDate,
            "endDateType": radioBoxVal,
            "endDate": endDate,
            "publishedDate": publishedDate
        };

        let examinationData = createExaminationBody();

        $.ajax({
            type: "POST",
            url: "{{ route('assign.template.data') }}",
            data: { templateId: templateid, postdata: JSON.stringify(examinationData) },
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            success: function (response) {
                console.log(response);
                if(response.status) {
                    console.log('success');
                    location.href = "{{ route('question.feedback.page') }}";
                } else {
                    console.log('fail');
                    $("#close-confirm").attr({'disabled': false});
                    $(".assign-confirm").attr({'disabled': false});
                    if($(".assign-confirm").hasClass("disabled")) {
                        $(".assign-confirm").removeClass('disabled');
                        $(".assign-confirm").html(selectorText);
                        $("#confirm").modal('hide');
                    }
                    msgToast("error", `${response.msg}`);
                }
            },
            error: function(error) {
                msgToast("error", `${response.message}`);
                $(".assign-confirm").attr({'disabled': false});
                $("#close-confirm").attr({'disabled': false});
                if($(".assign-confirm").hasClass("disabled")) {
                    $(".assign-confirm").removeClass('disabled');
                    $(".assign-confirm").html(selectorText);
                    $("#confirm").modal('hide');
                }
            }
        });
    });

    $('#confirm').on('hidden.bs.modal', function () {
        let $selector = $("#assign");
        let selectorText = $selector.text();
        $selector.html(`${selectorText}`);
        $('#assign').removeClass('disabled');
    });

    /* On click assign template to owner */
    $(document).on('click', "#assign" , function() {
        if($(this).hasClass('disabled') || $(this).is('[disabled=disabled]')) {
            return true;
        }
        if($('.multiselect-container.dropdown-menu').hasClass('show')){
            $('.multiselect-container.dropdown-menu').removeClass('show');
        }
        let templateid = selectedTemplateStatus.templateId;
        let templateName = selectedTemplateStatus.templateName;
        let questionsCheck = $("#questionsCheck").is(":checked");
        let dontUseCalculator = $("#dontUseCalculator").is(":checked");
        let scheduleDate = $("#test-schedule-date").val();
        let dueDate = $("#test-due-date").val();
        let radioBoxVal = "";
        let endDate = "";
        let publishedDate = "";
        let $selector = $(this);
        let selectorText = $selector.text();
        $selector.addClass('disabled');
        $(".text-danger.error-msg").remove();
        $(".error-minutes").remove();
        let schedule_minutes = $('[name="schedule_minutes"]');
        let schedule_minutes_val = parseInt(schedule_minutes.val(), 10) || 0;
        let schedule_minutes_max = parseInt(schedule_minutes.attr('max'), 10) || 0;

        $("input[name=test-radio]").each(function(i,v){
            IsChecked = $(v).is(":checked");
            if(IsChecked) {
                radioBoxVal = $(v).val();
            }
        });

        if(radioBoxVal == 'end-date') {
            endDate = $("#test-end-date").val();
        } else {
            publishedDate = $("#test-published-on").val();
        }

        if($('select[name=select_students]').val() == ""){
            $('select[name=select_students]').parents('span.multiselect-native-select').addClass('text-required').focus();
            underElementError($('select[name=select_students]').parents('span.multiselect-native-select'), "{{ __('questionLayout.required') }}", false);
            $('#assign').removeClass('disabled');
            return false;
        } else {
            $('select[name=select_students]').parents('span.multiselect-native-select').removeClass('text-required').focus();
        }

        /* Validation for schedule */
        
        if($('#customCheck101').is(":checked")) {
            if(schedule_minutes.val().length <= 0 || schedule_minutes.val() <= 0){
                $('#schedule-3').collapse("show");

                underElementError(schedule_minutes.parents('.d-flex'), timeDurationText.replace(/%s/g, schedule_minutes_max), true);
                schedule_minutes.focus();
                $selector.html(`${selectorText}`);
                $('#assign').removeClass('disabled');
                return false;
            }
        }

        let maxValue = parseInt((new Date($("#test-due-date").val()) - new Date($("#test-schedule-date").val()))/60000);
        if(schedule_minutes_val < 0 || schedule_minutes_max < 0 || schedule_minutes_val > schedule_minutes_max) {
            $('#schedule-3').collapse("show");
            // html.replace(/%s/g, 'TEST')
            underElementError(schedule_minutes.parents('.d-flex'), timeDurationText.replace(/%s/g, schedule_minutes_max), true);
            schedule_minutes.focus();
            $selector.html(`${selectorText}`);
            $('#assign').removeClass('disabled');
            return false;
        } if(maxValue < schedule_minutes_val) { 
            /* Toastr Error*/
            msgToast("error", dueDateErrorStr);
            $('#assign').removeClass('disabled');
            return false;
        } else {
            $('#confirm').modal();
        }
    });

    $(document).on('click', `input[name=assessment_type]`, function() {
        if($(this).val() == "assignment"){
            $('input[name="schedule_minutes"]').val('').attr({'disabled': true});
        } else {
            $('input[name="schedule_minutes"]').attr({'disabled': false});
        }
    })

    function createExaminationBody(){
        let isUntimed = false;
        let forAllStudent = false;
        let isAutoEvaluation = true;
        if($("#isAutoEvaluation").val() == true) {
            isAutoEvaluation = false;
        }
        let resultOnSubmission = false;
        if($('.scheduleResult').is(':checked')) {
            resultOnSubmission = true;
        }

        let totalStudentCounter = 0;
        let googleids = [];
        let googlecourse = 0;
        let testDuration = parseInt($("input[name=schedule_minutes]").val());
        if($(`input[name=assessment_type]:checked`).val() == "assignment"){
            isUntimed = true;
            testDuration = 0;
        }
        let courseStudentList = [];
        let courseName = '';
        let courseId = '';
        let optionLen = 0;
        let checkedOptionLen = 0;
        let studentIdArr = [];
        let studentId = '';
        let maxMarks = selectedTemplateStatus.maxMarks;
        $('select[name=select_students] optgroup').each(function(index, optgrpelement) {
            googleids = [];
            forAllStudent = false;
            courseName = $(this).attr("label");
            courseId = $(this).data("value");
            optionLen = $('option', this).length ;
            checkedOptionLen = 0;
            $(optgrpelement).find('option:selected').each(function(optindex, optelement) {
                if($(optelement).is(':selected')) {
                    studentIdArr  = ($(this).data('value')).split("_");
                    studentId = studentIdArr.pop();
                    googleids.push({
                        "id": studentId,
                        "name": $(this).data('name'),
                        "profilePicUrl": $(this).data('profilepic')
                    });
                    checkedOptionLen++;
                }
            });
            
            if(optionLen == checkedOptionLen) {
                forAllStudent = true;
            }

            if(googleids.length > 0) {
                courseStudentList.push({
                    "courseId": "" + courseId,
                    "className": courseName,
                    "courseWorkId": "",
                    "forAllStudent": forAllStudent,
                    "students": googleids
                });
            }                
        });
        
        forAllStudent = $('#scheduleDiv input[type="checkbox"][value="multiselect-all"]').is(':checked');

        let assignExaminationData = {}
        if($("div").hasClass("oldpaper")) {
            assignExaminationData = {
                "paperId": $("#newPaperId").val(),
                "paperName": $("input[name=input_title]").val(),
                "header": {
                    "board": {
                        "id": "", // backend will handle this in reassign scenario
                        "boardName": $("input[name=selected_board]").val(),
                    },
                    "class": {
                        "id": "", // backend will handle this in reassign scenario
                        "gradeName": $("input[name=selected_grade]").val(),
                    },
                    "subject": {
                        "id": "", // backend will handle this in reassign scenario
                        "subjectName": $("input[name=selected_subject]").val()
                    }, 
                    "maximumMarks": parseInt($("input[name=maximumMarks]").val()),
                    "testDuration": testDuration,
                    "isUntimed": isUntimed,
                    "schoolLogoUrl": "",
                    "startDateTime": new Date($("#test-schedule-date").data("date")).toISOString(),
                    "dueByDateTime": new Date($("#test-due-date").data("date")).toISOString(),
                    "resultPublishDate": new Date($("#test-published-on").data("date")).toISOString()
                },
                "instructions": CKEDITOR.instances["testInstructions"].getData(),
                "creatorId": "{{ getStudentUserId() }}",
                "courses": courseStudentList,
                "assignmentBaseUrl": "{{ route('students.instructions') }}",
                "isReAssign": "true",
                isAutoEvaluation: isAutoEvaluation,
                resultOnSubmission: resultOnSubmission
            }

        } else {
            assignExaminationData = {
                "paperId": $("#newPaperId").val(),
                "paperName": $("input[name=input_title]").val(),
                "header": {
                    "board": {
                        "id": $("select[name=select_board] option:selected").val(),
                        "boardName": $("select[name=select_board] option:selected").text(),
                    },
                    "class": {
                        "id": $("select[name=select_grade] option:selected").val(),
                        "gradeName": $("select[name=select_grade] option:selected").text(),
                    },
                    "subject": {
                        "id": $("select[name=select_subject] option:selected").val(),
                        "subjectName": $("select[name=select_subject] option:selected").text()
                    }, 
                    "maximumMarks": maxMarks,
                    "testDuration": testDuration,
                    "isUntimed": isUntimed,
                    "schoolLogoUrl": "",
                    "startDateTime": new Date($("#test-schedule-date").data("date")).toISOString(),
                    "dueByDateTime": new Date($("#test-due-date").data("date")).toISOString(),
                    "resultPublishDate": new Date($("#test-published-on").data("date")).toISOString()
                },
                "instructions": CKEDITOR.instances["testInstructions"].getData(),
                "creatorId": "{{ getStudentUserId() }}",
                "courses": courseStudentList,
                "assignmentBaseUrl": "{{ route('students.instructions') }}",
                "isReAssign": "false",
                isAutoEvaluation: isAutoEvaluation,
                resultOnSubmission: resultOnSubmission
            }
        }
        return assignExaminationData;
    }

    function ajaxSubmit(postData) {
        $.ajax({
            type: "POST",
            url: "{{ route('question.feedback.submit') }}",
            data: postData,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            success: function (response) {
                location.href = "{{ route('question.feedback.page') }}";
            }
        });
    }

    /* Question Layout Validations */
    function validateQuestionLayoutInp() {
        let errorCounter = 0;
        $('.error-msg').remove();
        let testTitleThreshold = 30;
        let errorDiv = '';
        
        if($.trim($('input[name=input_title]').val()) == ''){
            $('input[name=input_title]').addClass('text-required').focus();
            underElementError($('input[name=input_title]'), "{{ __('questionLayout.required') }}", false);
            errorCounter += true;
        } else if($('input[name=input_title]').val().length > testTitleThreshold) {
            $('input[name=input_title]').addClass('text-required').focus();
            underElementError($('input[name=input_title]'), "{{ __('questionLayout.maxCharacterAllowedPaperName') }}");
            errorCounter += true;
        } else{
            $('input[name=input_title]').removeClass('text-required');
            errorCounter += false;
        }

        if($('select[name=select_board] option:selected').val() == ""){
            $('select[name=select_board]').parents('div.bootstrap-select').addClass('text-required').focus();
            underElementError($('select[name=select_board]').parents('div.bootstrap-select'), "{{ __('questionLayout.required') }}", false);
            errorCounter += true;
        }else{
            $('select[name=select_board]').parents('div.bootstrap-select').removeClass('text-required');
            errorCounter += false;
        }
        if($('select[name=select_grade]').val() == ""){
            $('select[name=select_grade]').parents('div.bootstrap-select').addClass('text-required').focus();
            underElementError($('select[name=select_grade]').parents('div.bootstrap-select'), "{{ __('questionLayout.required') }}", false);
            errorCounter += true;
        }else{
            $('select[name=select_grade]').parents('div.bootstrap-select').removeClass('text-required');
            errorCounter += false;
        }
        if($('select[name=select_subject] option:selected').val() == ""){
            $('select[name=select_subject]').parents('div.bootstrap-select').addClass('text-required').focus();
            underElementError($('select[name=select_subject]').parents('div.bootstrap-select'), "{{ __('questionLayout.required') }}", false);
            errorCounter += true;
        }else{
            $('select[name=select_subject]').parents('div.bootstrap-select').removeClass('text-required');
            errorCounter += false;
        }
        if($('select[name=select_topic]').val() == ""){
            $('select[name=select_topic]').parents('span.multiselect-native-select').addClass('text-required').focus();
            underElementError($('select[name=select_topic]').parents('span.multiselect-native-select'), "{{ __('questionLayout.required') }}", false);
            errorCounter += true;
        }else{
            $('select[name=select_topic]').parents('span.multiselect-native-select').removeClass('text-required');
            errorCounter += false;
        }

        if(!$('.test-format-slider-link').hasClass('current')) {
            errorDiv += `<div class='toast-message'>Select Assessment Format/Blueprint</div>`;
            errorCounter += true;
        } else {
            errorCounter += false;
        }

        if(errorDiv != '') {
            msgToast("error", errorDiv);
        }

        return errorCounter;
    }

    function validateBlueprint() {
        let errorCounter = 0;
        let errorDiv = '';
        $('.error-msg').remove();
        
        if ($('.count').length == 0) {
            $('.selectpicker.add_question_type').addClass('text-required').focus();
            errorCounter ++;
        } else {
            $('.selectpicker.add_question_type').removeClass('text-required');
        }
        if ($('.marks').length == 0) {
            $('.selectpicker.add_question_type').addClass('text-required').focus();
            errorCounter ++;
        } else {
            $('.selectpicker.add_question_type').removeClass('text-required');
        }

        let questionTypeArr = [];
        $('.count').each(function(i,v){
            let value = $(v).val();
            value = value.replace(/[^0-9]/g,'');
            $(v).val(value);
            questionTypeArr.push($(v).parents('tr').find('td:nth-child(2)').text())
            if(value == 0 || value == ''){
                $(v).addClass('text-required').focus();
                errorCounter ++;
                errorDiv += `<div class='toast-message'>{{ __('teachers.script.errorMsg2') }}</div>`;
            }else{
                $(v).removeClass('text-required');
            }
        }); 

        let isRowAdded = false;
        if($('.count').length == 0 || $('.count').length < 0){
            errorCounter ++;
            isRowAdded = true;
            $('.enter_counter').addClass('text-required');
            $('.add_question_type').parents('div.bootstrap-select').addClass('text-required').focus();
        } else {
            $('.add_question_type').parents('div.bootstrap-select').removeClass('text-required').focus();
            $('.enter_counter').removeClass('text-required');
        } 

         if($('.marks').length == 0 || $('.marks').length < 0){
            isRowAdded = true;
            errorCounter ++;
            $('.enter_marks').addClass('text-required');
        } else {
            $('.enter_marks').removeClass('text-required');
        }

        if(isRowAdded) {
            errorDiv += `<div class='toast-message'>{{ __('teachers.script.errorMsg3') }}</div>`;
        }

        $('.marks').each(function(i,v){
            let value = $(v).val();
            if(value == 0 || value == '') {
                $(v).addClass('text-required').focus();
                errorDiv += `<div class='toast-message'>{{ __('teachers.script.errorMsg4') }}</div>`;
                errorCounter ++;
            } else {
                $(v).removeClass('text-required');
            }
        });

        if(errorDiv != '') {
            msgToast("error", errorDiv);
            return errorCounter;
        }

        /* Check question type is more than two */
        let counts = {};
        let greaterThanTwo = false;
        jQuery.each(questionTypeArr, function(key, value) {
            if (!counts.hasOwnProperty(value)) {
                counts[value] = 1;
            } else {
                counts[value]++;
            }

            if (counts[value] > 2) {
                errorCounter ++;
                greaterThanTwo = true;
            }
        });

        if(greaterThanTwo) {
            errorDiv = `<div class='toast-message'>{{ __('questionLayout.Only2Set') }}</div>`; 
            $('.selectpicker.add_question_type').addClass('text-required').focus();
        }

        /* Check total number of count not greater than 200 */
        if( $('.total_count_value').text() > 200 ){
            errorCounter ++;
            $('.selectpicker.add_question_type').addClass('text-required').focus();
            errorDiv += `<div class='toast-message'>{{ __('questionLayout.allowedQuestionsNotification') }}</div>`; 
        }

        if(errorDiv != '') {
            msgToast("error", errorDiv);
        }
        return errorCounter;
    }

    $(document).on('change, keyup', 'input[name=input_title]', function() {
        let errorCounter = false;
        let testTitleThreshold = "{{ config('constants.testTitleThreshold') }}";
        if($(this).val().length > testTitleThreshold) {
            $(this).addClass('text-required').focus();
            underElementError($(this), "{{ __('questionLayout.maxCharacterAllowedPaperName') }}");
            errorCounter = true;
        } else{
            $(this).removeClass('text-required');
            errorCounter = false;
        }
        if(errorCounter == 0){
            $('.error-msg').remove();
        }
    });

    $(document).on('change, keyup', 'input[name=template_title]', function() {
        let errorCounter = false;
        let templateTitleThreshold = "{{ config('constants.templateTitleThreshold') }}";
        if($(this).val().length > templateTitleThreshold) {
            $(this).addClass('text-required').focus();
            underElementError($(this), "{{ __('questionLayout.maxCharacterAllowed') }}");
            errorCounter = true;
        } else{
            $(this).removeClass('text-required');
            errorCounter = false;
        }
        if(errorCounter == 0){
            $('.error-msg').remove();
        }
    });

    /* @methodd to create template data creator */
    function templateDataCreator(templateName,id="0") {
        let questionFormats = [];
        $("tbody.ui-sortable tr").each(function(key, tr) {
            let data = {
                "groupId": parseInt(key) + 1,
                "questionTypeId": $(tr).find('input:nth(0)').data('id'),
                "numberOfQuestion": $(tr).find('input:nth(0)').val(),
                "weightage": $(tr).find('input:nth(1)').val()
            };
            questionFormats.push(data);
        });
        
        let templateData = {};
        if(id != 0) {
            /* update */
            templateData = { 
                "id": id,
                "ownerId": "{{ Session::has('profile') ? Session::get('profile')["userId"] : '' }}",
                "formatName": templateName,
                "questionFormats": questionFormats
            }
        } else {
            /* create */
            templateData = { 
                "ownerId": "{{ Session::has('profile') ? Session::get('profile')["userId"] : '' }}",
                "formatName": templateName,
                "questionFormats": questionFormats
            }
        }
        return templateData;
    }

    /* @methodd to get information Tab data */
    $(document).on('click', '#reviewPreviousBtn', function(e){
        previous = true;
        $('#reviewTab').removeClass('d-none')
        $('#reviewPreviousBtn').addClass('d-none').removeClass('active');
        $('#information').removeClass('fade').addClass('active');
        $('#reviewDiv').removeClass('active').addClass('fade');
        $("#scheduleTab").removeClass('active').addClass('d-none disabled');
        $(".right-panel-section").removeClass('d-none');
        $('#schedulePreviousTab').addClass('d-none').removeClass('active');
        $('#reviewNav').addClass('done').removeClass('active')
        $('#scheduleNav').addClass('done').removeClass('active')
        if(isSkip == false){
            updateTemplateStatus(0);
        }
        steps = 0
    });

    $(document).on('click', '#schedulePreviousTab', function(e){
        previous = true;
        $('#reviewPreviousBtn').removeClass('d-none')
        $(this).addClass('d-none').removeClass('active');
        $('#scheduleTab').removeClass('d-none').addClass('active');
        $('#assign').addClass('d-none')
        $('#review').removeClass('active').addClass('fade');
        $('#reviewDiv').addClass('active').removeClass('fade').show();
        $('#schedulePreviousTab').addClass('d-none').removeClass('active');
        $('#scheduleNav').addClass('done').removeClass('active')
        if(isSkip == false){
            updateTemplateStatus(0);
        }
        steps = 1
    });

    $(document).on('click', '#informationNav', function(e){
        if(steps == 1){
            $('#reviewPreviousBtn').click()
        }
    })
    
    $(document).on('click', '#reviewNav', function(e){
        if(steps == 0){
            $('#reviewTab').click()
        }
        if(steps == 2){
            $('#schedulePreviousTab').click()
        }
    })
    $(document).on('click', '#scheduleNav', function(e){
        if(steps == 1){
            $('#scheduleTab').click()
        }
    })

    /* @methodd to get carousel */
    function callCarousel(){
        $('.owl-carousel2').owlCarousel({
            loop: true,
            margin: 100,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                400: {
                    items: 4,
                    nav: false
                },
                600: {
                    items: 6,
                    nav: false
                },
                800: {
                    items: 6,
                    nav: true,
                    loop: false,
                    margin: 0
                },
                1000: {
                    items: 7,
                    nav: true,
                    loop: false,
                    margin: 0
                },
                1200: {
                    items: 9,
                    nav: true,
                    loop: false,
                    margin: 0
                },
                1300: {
                    items: 10,
                    nav: true,
                    loop: false,
                    margin: 0
                },
                1400: {
                    items: 12,
                    nav: true,
                    loop: false,
                    margin: 10
                },
                1700: {
                    items: 13,
                    nav: true,
                    loop: false,
                    margin: 0
                },
                1800: {
                    items: 14,
                    nav: true,
                    loop: false,
                    margin: 0
                },
                1900: {
                    items: 15,
                    nav: true,
                    loop: false,
                    margin: 0
                }
            }
        })
        $(".owl-prev").html('<i class="fa  fa-caret-left"></i>');
        $(".owl-next").html('<i class="fa  fa-caret-right"></i>');
    }

    let slideValue = 3;
    @if (isset($session['difficultyLevel']))
        slideValue = "{{ $session['difficultyLevel'] }}";
    @endif
    $("#ex13").bootstrapSlider({
        ticks_snap_bounds: 2,
        value: slideValue,
    });

    $(function(){
        singleRow();
        getSubTotalCount();
        getTotalMarks();
    })

    /**
     * @Event on change select box question
     */
    $(document).on('blur, change','.enter_marks , .enter_counter , select.add_question_type',function(){
        let question_type = $(this).parents('tr').find('select.add_question_type option:selected').text();
        let question_id = $(this).parents('tr').find('select.add_question_type option:selected').val();
        let count = $(this).parents('tr').find('.enter_counter').val() || 0;
        let marks = $(this).parents('tr').find('.enter_marks').val() || 0;
        let marksThreshold = parseInt("{{ config('constants.weightageThreshold') }}");
        let countThreshold = parseInt("{{ config('constants.numberOfQuestionThreshold') }}");
        let marksDecimal = marks.toString().split(".");
        if(marksDecimal[1] != undefined && marksDecimal[1].length > 2) {
            marks = parseFloat(marks).toFixed(2);
            $(this).parents('tr').find('.enter_marks').val(marks);
        }
        $('.enter_marks').removeClass('text-required');
        $('.enter_counter').removeClass('text-required');
        if(count > 0){
            count = count.replace(/[^0-9]/g,'');
        }

        if(question_id != " " && question_type != "" && (count != "" && count > 0) && (marks !="" && marks > 0)){
            let err = false;
            if (marks > marksThreshold) {
                $('.enter_marks').val("");
                $('.enter_marks').addClass('text-required').focus();
                err = true;
            }

            if (count > countThreshold) {
                $('.enter_counter').val("");
                $('.enter_counter').addClass('text-required').focus();
                err = true;
            }

            if(err) {
                return false;
            }
            let subtotal = parseFloat(count) * parseFloat(marks);
            if(question_type && count && marks){
                let tr_html = `{{ view("teachers.includes.select") }}`;
                $(this).parents('table#sortTtable').find('tbody.ui-sortable').append(tr_html);
                $("#preview2 tfoot").find("#question-type").focus();
            }else{
                $(this).parents('tr').find('select.add_question_type').addClass('text-required').focus();
            }
            $(this).parents('tr').find('.enter_counter').val("");
            $(this).parents('tr').find('.enter_marks').val("");
            
            $(".add_question_type").val('');
            $(".add_question_type").selectpicker("refresh");
            $("#preview2 .filter-option-inner-inner").html('{{ __("questionLayout.selectQuestionType") }}');
            singleRow();
            updateTemplateStatus();
        }
    });

    /**
     * @Event on keyup count and marks calculate Total Marks
     */
    $(document).on('blur', '.count , .marks', function(){
        let count = $(this).parents('tr').find('.count').val() || 0;
        let marks = $(this).parents('tr').find('.marks').val() || 0;
        let marksThreshold = parseInt("{{ config('constants.weightageThreshold') }}");
        let countThreshold = parseInt("{{ config('constants.numberOfQuestionThreshold') }}");
        let errorDiv = '';

        let marksDecimal = marks.toString().split(".");
        if(marksDecimal[1] != undefined && marksDecimal[1].length > 2) {
            marks = parseFloat(marks).toFixed(2);
            $(this).parents('tr').find('.marks').val(marks);
        }
        if(count > 0) {
            count = count.replace(/[^0-9]/g,'');
        }
        $(this).parents('tr').find('.count').val(count);

        marks = (marks <= marksThreshold) ? marks : 0;
        count = (count <= countThreshold) ? count : 0;

        if(marks > 0){
            $(this).parents('tr').find('.marks').removeClass('text-required');
        } else {
            $(this).parents('tr').find('.marks').val('');
            errorDiv += `<div>{{ __('questionLayout.maxPointAllowed') }}</div>`;
        }
        if(count > 0){
            $(this).parents('tr').find('.count').removeClass('text-required');
        } else {
            $(this).parents('tr').find('.count').val('');
            errorDiv += ` <div>{{ __('questionLayout.maxQuestionTypeQuestion') }}</div>`;
        }
        
        let rowMarks = parseFloat(count) * parseFloat(marks);
        rowMarks = (isNaN(rowMarks) || typeof rowMarks == undefined) ? 0.00 : rowMarks.toFixed(2);
        $(this).parents('tr').find('.total_marks').text(rowMarks);
        getSubTotalCount();
        getTotalMarks();
        updateTemplateStatus();
        
        if(errorDiv.length > 0) {
            msgToast('error', errorDiv);
            return;
        }
    });

    /**
     * @Event to remove question type Row
     */
    $(document).on('click','.remove',function(){
        $(this).parents('tr').remove();
        singleRow();
        getSubTotalCount();
        getTotalMarks();
        /* This will update the template edit status */
        updateTemplateStatus();
    })

    /**
     * @MethodFunction to calculate Sub-Total Question Counter
     */
    function getSubTotalCount(){
        let total = 0;
        $('.count').each(function(i,v){
            let value = ($(v).val()) ? $(v).val() : 0;
            if(value > 0){
                total = parseFloat(total) + parseFloat(value);
            }
        });
        $('.total_count_value').text(total);
    }

    /**
     * @MethodFunction to calculate Total Marks
     */
    function getTotalMarks(){
        let total = 0;
        $('.total_marks').each(function(i,v){
            let value = ($(v).text()) ? $(v).text() : 0;
            if(value > 0){
                total = parseFloat(total) + parseFloat(value);
            }
        });
        $('.all_totals').text(total.toFixed(2));
    }

    /**
     * @MethodFunction to counter sortable total
     */
    function singleRow(){
        $('table#sortTtable > tbody > tr').each(function(i,v){
            let count = $(v).find('.count').val();
            let marks = $(v).find('.marks').val();
            marks = (marks) ? marks : 0;
            count = (count) ? count : 0;
            $(v).find('.total_marks').text((parseFloat(count) * parseFloat(marks)).toFixed(2));
            getSubTotalCount();
            getTotalMarks();
        });
    }

    /* @event OnChange Remove Required */
    $(document).on('change' ,'.onchangeValue', function(){
        updateTemplateStatus(selectedTemplateStatus.isModified, 1);
        if($(this).val() != ""){
            if($(this).hasClass('selectpicker')){
                // I'm SelectBox
                if($(this).parents('div.bootstrap-select').hasClass('text-required')){
                    $(this).parents('div.bootstrap-select').removeClass('text-required');
                }
            }else if($(this).hasClass('selectOptGroup')){
                // I'm SelectBox
                if($(this).parents('span.multiselect-native-select').hasClass('text-required')){
                    $(this).parents('span.multiselect-native-select').removeClass('text-required');
                }
            }else{
                // I'm InputBox
                if($(this).hasClass('text-required')){
                    $(this).removeClass('text-required');
                }
            }
        }else{
            if($(this).hasClass('selectpicker')){
                // I'm SelectBox
                $(this).parents('div.bootstrap-select').addClass('text-required').focus();
            }else{
                // I'm InputBox
                $(this).removeClass('text-required');
            }
        }
    });

    /**
     * @event to remove text-required validation color
     */
    $(document).on('keyup', '.is_number' , function(evt){
        let charCode = (evt.which) ? evt.which : evt.keyCode;
        if (/*(charCode == 110) ||*/ (charCode >= 37 && charCode <= 40) || (charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode == 9 || charCode == 8 || charCode == 16) {
            return true;
        }
        $(this).val('');
        return false;
    });

    
    /**
     * @Event Multiselect Picker
     */
    $(document).ready(function() {
        toastr.options.preventDuplicates = true;
        toastr.options.closeButton = true;
        onlineChecker("{{ __('questionLayout.onlineNotification') }}", "{{ __('questionLayout.offlineNotification') }}");

        if( $(".selectPanel").length > 0 ) {
            getDropDownData();
        }
        if( $(".defaultTemplateSection").length > 0 ) {
            getTemplateData();
        }
        
        $('[data-toggle="tooltip"]').tooltip();
        $('.selectOptGroup').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableCaseInsensitiveFiltering: true,
            allSelectedText: 'Select All',
            includeSelectAllOption: true,
            nonSelectedText: "{{ __('questionLayout.selectTopic') }}"
        });

        $('.multiselectpicker').each(function(i,v){
            let label = $(v).data('label');
            $(v).selectpicker({
                noneSelectedText: label
            });
        });
    });

    /**
     * @Event onchange item active
     */
    $(document).on('click','.item', function (){
        $('.item').each(function(i,v){
            $(v).find('a').removeClass('active current');
        });
        /* This will update the template edit status */
        $(this).find('a').addClass('active current');
        updateTemplateStatus(0, 1);
    });

    $(document).on('change','.get_curl_data', function(){
        if($(this).attr('name')){
            let boardName = $('select[name=select_board]').val();
            let gradeName = $('select[name=select_grade]').val(); 
            let subjectName = $('select[name=select_subject]').val();
            let route_name = $(this).data('get');
            let value = $(this).val();
            if(value && route_name){
                resetDepedableDropdown(this);
                $.ajax({
                    type: "GET",
                    url: "{{ route('get.curl.data') }}",
                    data: {
                        'route_name': route_name , 
                        'value': value, 
                        'boardName': boardName, 
                        'gradeName': gradeName, 
                        'subjectName': subjectName
                    },
                    dataType: "html",
                    success: function (response) {
                        $(`select[name=${route_name}]`).parents(`div.div-${route_name}`).html(response);
                        if($(`select[name=${route_name}]`).hasClass('selectOptGroup')){
                            $('.selectOptGroup').multiselect({
                                enableClickableOptGroups: true,
                                enableCollapsibleOptGroups: true,
                                enableCaseInsensitiveFiltering: true,
                                allSelectedText: 'Select All',
                                includeSelectAllOption: true,
                                nonSelectedText: "{{ __('questionLayout.selectTopic') }}",
                            });
                        }else{
                            $(`select[name=${route_name}]`).selectpicker('default');
                            $(`select[name=${route_name}]`).selectpicker('refresh');
                        }
                        $('.selectPanel').find('.error-msg').remove();
                        $('.selectPanel').removeClass('text-required');
                        
                    }
                });
            } else {
                /* If value is empty */
                resetDepedableDropdown(this);                
            }
        }
    });

    function resetDepedableDropdown(event) {
        switch ($(event).attr('name')) {
            case "select_board":
                $("select[name='select_grade']").attr('disabled',true).val('').selectpicker('refresh');
                $("select[name='select_subject']").attr('disabled',true).val('').selectpicker('refresh');
                $("select[name='select_topic']").attr('disabled',true);
                $('.selectOptGroup').multiselect('disable');
                $('.selectOptGroup option:selected').each(function(){
                    $(this).prop('selected', false);
                });
                $('.selectPanel .selectOptGroup').multiselect("refresh");
                break;
            case "select_grade":
                $("select[name='select_subject']").attr('disabled',true).val('').selectpicker('refresh');
                $("select[name='select_topic']").attr('disabled',true);
                $('.selectpicker').selectpicker('refresh');
                $('.selectOptGroup').multiselect('disable');
                $('.selectOptGroup option:selected').each(function(){
                    $(this).prop('selected', false);
                });
                $('.selectPanel .selectOptGroup').multiselect("refresh");
                break;
            case "select_subject":
                $("select[name='select_topic']").attr('disabled',true);
                $('.selectpicker').selectpicker('refresh');
                $('.selectOptGroup').multiselect('disable');
                $('.selectOptGroup option:selected').each(function(){
                    $(this).prop('selected', false);
                });
                $('.selectPanel .selectOptGroup').multiselect("refresh");
                break;
            default:
                break;
        }
    }

    function getDropDownData(){
        /* Get Board , Topics Select Section Blade */
        $.ajax({
            type: "GET",
            url: "{{ route('pages.selectPanel') }}",
            dataType: "html",
            success: function (response) {
                $(".selectPanel").html(response);
                refreshSelectPicker();
            }
        });
        return true;
    }

    function getTemplateData(){
        /* Get My Templates Blade */
        $.ajax({
            type: "GET",
            url: "{{ route('pages.myTemplates') }}",
            dataType: "html",
            success: function (response) {
                $('[data-toggle=popover]').popover('hide');
                $(".defaultTemplateSection").html(response);
                callCarousel();
                $('[data-toggle="popover"]').popover();
                $('#reviewTab').attr('disabled', false);
                $(".defaultTemplateSection").find('.owl-stage .item:first').click();
                $('[data-toggle="tooltip"]').tooltip();
                updateTemplateStatus(1,1);
            }
        });
        return true;
    }

    function refreshSelectPicker(){
        $('.selectpicker').selectpicker('refresh');
        $('.multiselectpicker').each(function(i,v){
            let label = $(v).data('label');
            $(v).selectpicker({
                noneSelectedText: label
            });
        });
        $('.selectOptGroup').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableCaseInsensitiveFiltering: true,
            allSelectedText: 'Select All',
            includeSelectAllOption: true,
            nonSelectedText: "{{ __('questionLayout.selectTopic') }}",
        });
    }

    $(document).on("click", function(event){
        let $trigger = $('.flag-btn');
        let $trigger1 = $('#question-option-checkboxes');
        if($trigger1.has(event.target).length){
            return true;
        } else if($trigger !== event.target && !$trigger.has(event.target).length){
            $("#question-option-checkboxes").slideUp("fast");
        }  else {
            if($trigger.hasClass('disabled')){
                return true;
            }
            $("#question-option-checkboxes").toggle();
        }
    });

    /* Question Review Section script */
    $(document).on('click', '.swap-question', function(e) {
        let questionId = $(this).data('questionid');
        let questionNumber = $(this).data('questionnumber');
        let paperId = $(this).data('paperid');
        let parentDiv = $('div.question-block#quest' + questionNumber);
        $(parentDiv).find('.question-text').css('visibility', 'hidden');
        $(parentDiv).find('.row').css('visibility', 'hidden');
        $(parentDiv).append(`{{ view("teachers.includes.loader", ["msg" => "Please wait swapping..."]) }}`);
        $('.btn.btn-tpt').attr('disabled', true);
        /* Swap question ajax */
        $.ajax({
            type: "GET",
            timeout: 45000,
            url: "{{ route('get.question.swap') }}",
            data:{id: questionId, paperId: paperId, questionNumber: questionNumber},
            dataType: "html",
            success: function (response) {
                if(response.length > 0) {
                    $(parentDiv).html(response);
                    flaggedIds = jQuery.grep(flaggedIds, function(value) {
                        return value != questionId;
                    });
                } else {
                    $(parentDiv).find('#loader-wrapper').remove();
                    $(parentDiv).find('.question-text').css('visibility', 'visible');
                    $(parentDiv).find('.row').css('visibility', 'visible');
                    $(`div#quest${questionNumber}`).find("#loader-wrapper").hide();
                    msgToast('info', `{{ __('questionLayout.noQuestionSwap') }}`);
                }
                $('.btn.btn-tpt').attr('disabled', false);
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function(data) {
                $(parentDiv).find('#loader-wrapper').remove();
                $(parentDiv).find('.question-text').css('visibility', 'visible');
                $(parentDiv).find('.row').css('visibility', 'visible');
                $(`div#quest${questionNumber}`).find("#loader-wrapper").hide();
                msgToast('info', `{{ __('questionLayout.noQuestionSwap') }}`);
                $('.btn.btn-tpt').attr('disabled', false);
            }
        });
    })

    /**
     * @Methodd for Carousel for review section
     */
    function reviewCarousel(item = 0){
        let spinner_loader = `<div id="loader-modal" style="display:none">
            <div id="loader1"> {!! config('constants.icons.loader-icon') !!}
            </div>
        </div>`;
        $('div#preview').find('div.modal-body').html(`${spinner_loader}<div id="owl-carousel-review" class="owl-carousel"></div>`);
        $.ajax({
            type: "GET",
            url: "{{ route('get.questions.modal') }}",
            data:{},
            dataType: "html",
            success: function (response) {
                if(response) {
                    $('#owl-carousel-review').html(response);
                    $('#owl-carousel-review').owlCarousel({
                        loop: true,
                        margin: 24,
                        responsiveClass: true,
                        responsive: {
                            0: {
                                items: 1,
                                nav: true
                            },
                            600: {
                                items: 1,
                                nav: false
                            },
                            1000: {
                                items: 1,
                                nav: true,
                                loop: false,
                               
                            }
                        }
                    });
                    $('#owl-carousel-review').trigger('to.owl.carousel', item);
                    $(".owl-prev").html('<i class="fa  fa-caret-left"></i>');
                    $(".owl-next").html('<i class="fa  fa-caret-right"></i>');
                    $("#preview").modal();
                    $('.slide-jump').attr({disabled: false});
                    setTimeout(() => {
                        $("#loader-modal").hide();
                        reportStatus();        
                    }, 1000);
                    $('[data-toggle="tooltip"]').tooltip();       
                }
            }
        });
    }

    $(document).on('click', '.slide-jump', function(e){
        let dataId = $(this).data('id');
        $('.slide-jump').attr({disabled: true});
        // $('#owl-carousel-review').trigger('to.owl.carousel', dataId);
        reviewCarousel(dataId);
        handleReviewQuestionOwlItem(false);
    });

    $(document).on('keydown', function(e) {
        if($('#preview').hasClass('show')) {
            if (e.keyCode === 37) {
                // Previous
                $(".owl-prev").click();
                return false;
            }
            if (e.keyCode === 39) {
                // Next
                $(".owl-next").click();
                return false;
            }
        }
    });

    $(document).on('click', '.close-preview', function(e) {
        if ($(this).parents('div.modal').hasClass('modal-fullscreen')) {
            $(this).parents('div.modal').find('.enlarge-popup-btn').click();
        }
        $('#preview').modal('hide');
        $('[data-toggle="tooltip"]').tooltip('dispose');
        $('[data-toggle="tooltip"]').tooltip();
    })

    function handleReviewQuestionOwlItem(isEditMode) {
        let $activeOwlItem = $("#owl-carousel-review .owl-item.active");
        let $activeOwlItems = $("#owl-carousel-review .owl-item");

        if(isEditMode) {
            $activeOwlItems.find(".question-block").hide();
            $activeOwlItems.find(".question-form-wrapper").show();
        } else {
            $activeOwlItems.find(".question-block").show();
            $activeOwlItems.find(".question-form-wrapper").hide();
        }
    }


    $(document).on("change", "input[name=questionBank]", function() {
        updateTemplateStatus(selectedTemplateStatus.isModified, 1)
    });

    $(document).on("change", "input[name=difficultyLevel]", function() {
        updateTemplateStatus(selectedTemplateStatus.isModified, 1)
    });
    
    /* @methodd to view review section */
    function getReviewQuestionPage() {
        $("#custonReviewDiv").removeClass('active');
        $("#custonReviewDiv").addClass('fade');
        $("#reviewTab").addClass('active');
        $("#scheduleTab").addClass("disabled").attr({"disabled": true});
   
        let inputTitle     = $('input[name=input_title]').val();
        let selectBoard    = $('select[name=select_board] option:selected').val();
        let selectSubject  = $('select[name=select_subject] option:selected').val();
        let selectGrade    = $('select[name=select_grade]').val();
        let subTopic = new Array();
        let topic = new Array();
        $('select[name=select_topic] option').each(function() {
            if($(this).is(':selected') && $(this).data('type') == 'subtopic'){
                subTopic.push($(this).data('value'));
                if($.inArray($(this).parent('optgroup').data('value'), topic) == -1){
                    topic.push($(this).parent('optgroup').data('value'));
                }
            } else if($(this).is(':selected') && $(this).data('type') == 'topic'){
                topic.push($(this).data('value'));
            }
        });

        let selectTopic         = topic.join(',');
        let selectSubTopic      = subTopic.join(',');
        let selectedTemplateId = selectedTemplateStatus.templateId;
        if(selectedTemplateId == undefined){
            selectedTemplateId = $('a.test-format-slider-link.active').parent().data('id');
        }
        let selectedTemplateType = $('a.test-format-slider-link.active').parent().data('type');
        let difficultyLevel = $('input[name=difficultyLevel]').val();
        let questionBank = $('input[name=questionBank]:checked').val();
        let previousYear = $('input[name=previousYear]:checked').val();
        let templateid = selectedTemplateStatus.templateId;
        let templateName = selectedTemplateStatus.templateName;
        let templateData = templateDataCreator(templateName, templateid);
        let isModified = "0";
        if(isSkip == true && selectedTemplateStatus.isModified == "1"){
            isModified = "1";
        }
        $("#reviewDiv").html(`{{ view("teachers.includes.loader") }}`);

        $.ajax({
            type: "POST",
            url: "{{ route('save.general.data') }}"+`?inputTitle=${inputTitle}&selectBoard=${selectBoard}&selectSubject=${selectSubject}&selectGrade=${selectGrade}&selectTopic=${selectTopic}&selectSubTopic=${selectSubTopic}&selectedTemplateId=${selectedTemplateId}&selectedTemplateType=${selectedTemplateType}&difficultyLevel=${difficultyLevel}&questionBank=${questionBank}&previousYear=${previousYear}&isModified=${isModified}&isSkip=${isSkip}`,
            data: templateData,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            success: function (response) {
                filterTemplate = response;
                let newPaper = "true";
                if((previous && selectedTemplateStatus.isModified  == 0)){
                    newPaper = "false";
                }
                if(selectedTemplateStatus.filterModified == 1) {
                    newPaper = "true";
                }

                let dataRequest = {};
                dataRequest.data = filterTemplate;
                dataRequest['_token'] = "{{ csrf_token() }}";
                dataRequest.newPaper = newPaper;

                $.ajax({
                    type: "POST",
                    url: "{{ route('questionreview') }}",
                    data: dataRequest,
                    dataType: "html",
                    timeout: 45000,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    success: function (resp) {
                        $('#loader-wrapper').hide();
                        $('#reviewDiv').html(resp);
                        $("#scheduleTab").removeClass("disabled").attr({"disabled": false});
                        $('#reviewPreviousBtn').attr({"disabled": false}).removeClass('disabled');
                        if($('.insufficient-question').length > 0) {
                            let insufficientResp = $.trim($('.insufficient-question').text());
                            $('#reviewPreviousBtn').click();
                            msgToast('error', `Oops! Maximum ${insufficientResp} are available for selected filters in the question bank. Please create a new assessment format.`);
                        }
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    error: function (error) {
                        $('#loader-wrapper').hide();
                        msgToast('error', `${noDataAvailable}`);
                        window.location.href = '{{ route("fastrack") }}'; //using a named route
                    }
                });
            },
            error: function (err) {
                if(err.status == 419) {
                    msgToast('error', `{{ __("teachers.general.sessionExpired") }}`);
                    window.location.href = '{{ route("home_page") }}'; //using a named route
                }
            }
        });
        $('#information').addClass('fade');
        $('#information').removeClass('active');

        $('#reviewPreviousBtn').removeClass('active'); 
        $('#reviewPreviousBtn').removeClass('d-none');

        $('.reviewTabDisabled').parent('li').removeClass('disabled');
        $('#reviewTab').addClass('d-none');
        $('#review').removeClass('fade');
        $('#review').addClass('active');

    }

    function getReviewQuestionPage1() {
        $("#scheduleDiv").html(`{{ view("teachers.includes.loader") }}`);
        $("#assign").addClass("disabled");
        let dt = {};
        if(selectedTemplateStatus.templateId != null) {
            dt = {templateId: selectedTemplateStatus.templateId};
        } else {
            dt = {isUntimed: $(".oldpaper").data("isuntimed"), restrictresult: $(".oldpaper").data('restrictresult')};
        }

        $.ajax({
            url: `{{ route('schedule') }}`,
            data: dt,
            type: 'GET',
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            success: function(resp){ 
                $('#scheduleDiv').html(resp);
                $("#assign").removeClass("disabled");
                $('[data-toggle="tooltip"]').tooltip();
                $('.selectAssignGroup').multiselect({
                    enableClickableOptGroups: true,
                    collapseOptGroupsByDefault: true,
                    enableCollapsibleOptGroups: true,
                    enableCaseInsensitiveFiltering: true,
                    allSelectedText: 'Select All',
                    includeSelectAllOption: true,
                    selectAllJustVisible: false,
                    nonSelectedText: "Student List"
                });
                CKEDITOR.replace( 'testInstructions', {
                    toolbarGroups1,
                    removeButtons,
                    removePlugins: 'help, basket, flash, iframe, textarea, form, hidden_field, smiley, checkbox, print, preview, pdf, templates, replace, anchor, elementspath, save, flash, iframe, link, smiley, find, pagebreak, templates, about, maximize, showblocks, newpage, language, exportpdf, paste,elementspath,save,font',
                    on: {
                        instanceReady: function() {
                            updateTestInstructions();
                        },
                        change: function (event) {
                        }
                    }
                });
                
                /**
                 * All questions are required & Do not use calculator checkbox 
                 */
                CKEDITOR.instances['testInstructions'].on('change', function(e) {
                    let questionTitle = CKEDITOR.instances['testInstructions'].getData();
                    $('input.testinstructions').each(function(i,v){
                        let value = $(v).val();
                        if(questionTitle.indexOf(value) == -1){
                            $(v).prop("checked", false);
                        } else {
                            $(v).prop("checked", true);
                        }
                    });
                });
                /**
                 * All questions are required & Do not use calculator checkbox 
                 */

                CKEDITOR.editorConfig = function (config) {
                    //...other settings 
                    config.removePlugins = 'exportpdf';//Add this line of code to close the easyimage, cloudservices plugin
                };

                $('[data-students]').selectpicker({
                    // enableClickableOptGroups: true,
                    // enableCollapsibleOptGroups: true,
                    // enableFiltering: true,
                    // includeSelectAllOption: false,
                    nonSelectedText: "{{ __('questionReview.selectStudents') }}"
                });

                $("#test-schedule-date-fa").click(function(){
                    $("#test-schedule-date").focus();
                });

                $("#test-due-date-fa").click(function(){
                    $("#test-due-date").focus();
                });

                $("#test-end-date-fa").click(function(){
                    $("#test-due-date").focus();
                });

                $("#test-published-on-fa").click(function(){
                    $("#test-published-on").focus();
                });

                $("#test-schedule-date").datetimepicker({
                    format: 'ddd, MMM D, hh:mm A',
                    minDate:moment(new Date()),
                    minTime:moment(new Date()).add(2, 'minutes'),
                    step:30,
                    onSelectDate: function(date){
                        let selectedDate = new Date(date);
                        let msecsInADay = 15000;
                        let endDate = new Date(selectedDate.getTime() + msecsInADay);
                        let eDate = moment(selectedDate).add(0, 'days');
                        let endDate1 = moment(selectedDate).add(2, 'days');
                        let twoWeeksEndDate1 = moment(selectedDate).add(2+14, 'days');
                        dueDate = endDate1.format('ddd, MMM D, hh:mm A');

                        $("#test-due-date").val(dueDate).attr('placeholder', dueDate).datetimepicker({minDate:eDate, maxDate: twoWeeksEndDate1} );

                        let endDate2 = moment(selectedDate).add(4, 'days');
                        let twoWeeksEndDate2 = moment(selectedDate).add(4+14, 'days');
                        dueDate = endDate2.format('ddd, MMM D, hh:mm A');
                        $("#test-published-on").val(dueDate).attr('placeholder', dueDate).datetimepicker({minDate:endDate2, maxDate: twoWeeksEndDate1});
                        $("#test-due-date").data('date', new Date(endDate1));
                        $("#test-published-on").data('date', new Date(endDate2));
                
                        let iscurrentDate = moment(date).isSame(moment(), 'day');
                        let scheduleDate = $("#test-schedule-date").val();

                        if(iscurrentDate) {
                            // this.setOptions({ minTime: moment(new Date()).add(15, 'minutes') });
                            this.setOptions({ minTime: moment(new Date()) });
                        } else {
                            this.setOptions({ minTime: false });
                        }
                        $("#test-schedule-date").data('date', date);
                        let maxValue = parseInt((new Date($("#test-due-date").val()) - new Date($("#test-schedule-date").val()))/60000);
                        if(maxValue < examTotalMinutes) {
                            // $("input[name=schedule_minutes]").attr('max', maxValue);
                            /* Toastr Error */
                        } /* else if(maxValue > examTotalMinutes) {
                            $("input[name=schedule_minutes]").attr('max', examTotalMinutes);
                        } */
                    },
                    onSelectTime: function(time){
                        let selectedTime = new Date(time);
                        let msecsInADay = 5000;
                        let endDate = new Date(selectedTime.getTime() + msecsInADay);

                        let endDate1 = moment(selectedTime).add(2, 'days');
                        let eDate = moment(selectedTime).add(0, 'days');
                        let twoWeeksEndDate1 = moment(selectedTime).add(2+14, 'days');
                        dueDate = endDate1.format('ddd, MMM D, hh:mm A');

                        $("#test-due-date").val(dueDate).attr('placeholder', dueDate).datetimepicker({minTime:eDate, maxDate: twoWeeksEndDate1});

                        $("#test-due-date").data('date', new Date(endDate1));

                        let endDate2 = moment(selectedTime).add(4, 'days');
                        dueDate2 = endDate2.format('ddd, MMM D, hh:mm A');
                        $("#test-published-on").val(dueDate2).attr('placeholder', dueDate2).datetimepicker({minTime:endDate2});
                        $("#test-published-on").data('date', new Date(endDate2));
                        $("#test-schedule-date").data('date', time);
                        
                        let maxValue = parseInt((new Date($("#test-due-date").val()) - new Date($("#test-schedule-date").val()))/60000);
                        if(maxValue < examTotalMinutes) {
                            // $("input[name=schedule_minutes]").attr('max', maxValue);
                            /* Toastr Error */

                        }/*  else if(maxValue > examTotalMinutes) {
                            $("input[name=schedule_minutes]").attr('max', examTotalMinutes);
                        } */

                    }
                });

                $(document).on('input', '[name="schedule_minutes"]', function(){
                    $(".error-minutes").remove();  
                })

                $(document).on('click', '.validateMinutes', function(e) {
                    $(".error-minutes").remove();
                    let schedule_minutes = $('[name="schedule_minutes"]');
                    let schedule_minutes_val = parseInt(schedule_minutes.val(), 10) || 0;
                    let schedule_minutes_max = parseInt(schedule_minutes.attr('max'), 10) || 0;
                    if(schedule_minutes_val > schedule_minutes_max) {
                        schedule_minutes.after(`<p class='error-minutes' style='color: red'>${timeDurationText.replace(/%s/g, schedule_minutes_max)}</p>`)
                    }
                });
                
                $("#test-due-date").datetimepicker({
                    format: 'ddd, MMM D, hh:mm A',
                    minDate: moment(new Date()).add(0, 'days'),
                    minTime: moment(new Date()).add(15, 'minutes'),
                    maxDate: moment(new Date()).add(14, 'days'),
                    step: 30,
                    onSelectDate: function(date){
                        let selectedDate = new Date(date);
                        let endDate = new Date(selectedDate.getTime());
                        dueDate = moment(selectedDate).format('ddd, MMM D, hh:mm A');

                        let endDate1 = moment(selectedDate).add(2, 'days');
                        let twoWeeksEndDate1 = moment(selectedDate).add(2+14, 'days');
                        dueDate = endDate1.format('ddd, MMM D, hh:mm A');

                        $("#test-published-on").val(dueDate).attr('placeholder', dueDate).datetimepicker({minDate:endDate});

                        let scheduleDate = $("#test-schedule-date").val();
                        let scheduleDate1 = $("#test-schedule-date").data('date');
                    
                        let iscurrentDate = moment(date).isSame(moment(scheduleDate1), 'day');                                                                                                                                          
                        if(iscurrentDate) {
                            this.setOptions({ minTime: moment(scheduleDate1).add(30, 'minutes') });
                        } else {
                            this.setOptions({ minTime: false });
                        }

                        $("#test-due-date").data('date', date);

                        let maxValue = parseInt((new Date($("#test-due-date").val()) - new Date($("#test-schedule-date").val()))/60000);

                        if(maxValue < examTotalMinutes) {
                            // $("input[name=schedule_minutes]").attr('max', maxValue);
                            /* Toastr Error */

                        }/*  else if(maxValue > examTotalMinutes) {
                            $("input[name=schedule_minutes]").attr('max', examTotalMinutes);
                        } */

                    },
                    onSelectTime: function(time){
                        let selectedTime = new Date(time);
                        let endDate = new Date(selectedTime.getTime());
                        dueDate = moment(selectedTime).format('ddd, MMM D, hh:mm A');

                        let endDate1 = moment(selectedTime).add(2, 'days');
                        let twoWeeksEndDate1 = moment(selectedTime).add(2+14, 'days');
                        dueDate = endDate1.format('ddd, MMM D, hh:mm A');

                        $("#test-published-on").val(dueDate).attr('placeholder', dueDate).datetimepicker({minDate:endDate, maxDate: twoWeeksEndDate1});
                        $("#test-end-date,#test-published-on").val(dueDate).attr('placeholder', dueDate).datetimepicker({minTime:endDate} );
                        let scheduleDate = $("#test-schedule-date").val();
                        
                        $("#test-due-date").data('date', time);
                        let maxValue = parseInt((new Date($("#test-due-date").val()) - new Date($("#test-schedule-date").val()))/60000);

                        if(maxValue < examTotalMinutes) {
                            // $("input[name=schedule_minutes]").attr('max', maxValue);
                            /* Toastr Error */
                        } /* else if(maxValue > examTotalMinutes) {
                            $("input[name=schedule_minutes]").attr('max', examTotalMinutes);
                        } */
                    }
                });

                $("#test-published-on").datetimepicker({
                    format: 'ddd, MMM D, hh:mm A',
                    minDate: moment(new Date()).add(0, 'days'),
                    minTime:moment(new Date()).add(15, 'minutes'),
                    maxDate: moment(new Date()).add(14, 'days'),
                    step: 30,
                    onSelectDate: function(date){
                        let dueDate = $("#test-due-date").data('date');
                        let iscurrentDate = moment(date).isSame(moment(dueDate), 'day');                                                                                                                                          
                        if(iscurrentDate) {
                            this.setOptions({ minTime: moment(dueDate)});
                        } else {
                            this.setOptions({ minTime: false });
                        }
                        $("#test-published-on").data('date', date);
                    },
                    onSelectTime: function(time){
                        $("#test-published-on").data('date', time);
                    }
                });

                $(document).on("keydown", function(e){
                    if((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 17){
                        e.preventDefault();
                        return false;
                    }
                });

                let scheduleDateMain = new Date();
                let newScheduleDate = new Date(moment(scheduleDateMain));
                let testDueDate = new Date(moment(newScheduleDate).add(2, 'days'));
                let minDueDate = new Date(moment(newScheduleDate).add(0, 'days'));
                let testPublishedDate = new Date(moment(newScheduleDate).add(3, 'days'));

                $("#test-schedule-date").data('date', newScheduleDate).val(moment(newScheduleDate).format('ddd, MMM D, hh:mm A'));
                $("#test-due-date").data('date', testDueDate).val(moment(testDueDate).format('ddd, MMM D, hh:mm A')).datetimepicker({minDate:minDueDate});
                $("#test-published-on").data('date', testPublishedDate).val(moment(testPublishedDate).format('ddd, MMM D, hh:mm A'));
                $("#test-published-on").datetimepicker({minDate:new Date(testDueDate.getTime())});
                $('input[name="schedule_minutes"]').focus();
            },
            error: function(data) {
                if(isOnline) {
                    msgToast('error', `{{ __("teachers.schedule.error.noStudentAvailable") }}`);
                    $("#schedulePreviousTab").click();
                    $("#loader-wrapper").remove();
                } else {
                    msgToast('error', `{{ __('questionLayout.offlineNotification') }}`);
                    $("#schedulePreviousTab").click();
                    $("#loader-wrapper").remove();
                }
            }
        });

        let inputTitle     = $('input[name=input_title]').val();
        let selectBoard    = $('select[name=select_board] option:selected').val();
        let selectSubject  = $('select[name=select_subject] option:selected').val();
        let selectGrade    = $('select[name=select_grade]').val();

        let subTopic = new Array();
        let topic = new Array();
        $('select[name=select_topic] option').each(function() {
            if($(this).is(':selected') && $(this).data('type') == 'subtopic'){
                subTopic.push($(this).data('value'));
                if($.inArray($(this).parent('optgroup').data('value'), topic) == -1){
                    topic.push($(this).parent('optgroup').data('value'));
                }
            } else if($(this).is(':selected') && $(this).data('type') == 'topic'){
                topic.push($(this).data('value'));
            }
        });

        let selectTopic         = topic.join(',');
        let selectSubTopic      = subTopic.join(',');
        let selectedTemplateId = selectedTemplateStatus.templateId;
        if(selectedTemplateId == undefined){
            selectedTemplateId = $('a.test-format-slider-link.active').parent().data('id');
        }
        let selectedTemplateType = $('a.test-format-slider-link.active').parent().data('type');
        let difficultyLevel = $('input[name=difficultyLevel]').val();
        let questionBank = $('input[name=questionBank]:checked').val();
        let previousYear = $('input[name=previousYear]:checked').val();
        let templateid = selectedTemplateStatus.templateId;
        let templateName = selectedTemplateStatus.templateName;
        let templateData = templateDataCreator(templateName, templateid);
        let isModified = "0";
        if(isSkip == true && selectedTemplateStatus.isModified == "1"){
            isModified = "1";
        }

        if(!$("div").hasClass("oldpaper")) {
            $.ajax({
                type: "POST",
                url: "{{ route('save.general.data') }}"+`?inputTitle=${inputTitle}&selectBoard=${selectBoard}&selectSubject=${selectSubject}&selectGrade=${selectGrade}&selectTopic=${selectTopic}&selectSubTopic=${selectSubTopic}&selectedTemplateId=${selectedTemplateId}&selectedTemplateType=${selectedTemplateType}&difficultyLevel=${difficultyLevel}&questionBank=${questionBank}&previousYear=${previousYear}&isModified=${isModified}&isSkip=${isSkip}`,
                data: templateData,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                success: function (response) {
                    filterTemplate = response;
                    let newPaper = true;
                    if((previous && selectedTemplateStatus.isModified  == 0)){
                        newPaper = false;
                    }
                    if(selectedTemplateStatus.filterModified == 1) {
                        newPaper = true;
                    }
                },
                error: function(err) {
                    if(err.status == 419) {
                        msgToast('error', `{{ __("teachers.general.sessionExpired") }}`);
                        window.location.href = '{{ route("home_page") }}'; //using a named route
                    }
                }
            });
        }

    }
    
    if($("div").hasClass("oldpaper")) {
        selectedTemplateStatus.templateId = "";
        selectedTemplateStatus.oldTemplate = true;
    }

    $(document).on('click', '#scheduleTab', function(e){
        if($(this).hasClass('disabled') || $(this).is('[disabled=disabled]')) {
            return true;
        }
        $("#reviewDiv").removeClass('active');
        $("#reviewDiv").addClass('fade');
        $('#schedulePreviousTab').removeClass('d-none');
        $("#scheduleTab").addClass('d-none');
        $('#assign').removeClass('d-none')

        $('#scheduleNav').removeClass('done').addClass('active');

        $('#reviewPreviousBtn').removeClass('active'); 
        $('#reviewPreviousBtn').addClass('d-none');
        $(".right-panel-section").removeClass('d-none');
        $('#review').removeClass('fade');
        $('#review').addClass('active');
        $('#reviewDiv').hide();
        steps = 2
        // if ($('#review #scheduleDiv').html().length <= 1) {
            getReviewQuestionPage1()
        // }
    });

    function updateTestInstructions($currentCheckbox) {
        let testInstructionsData = "";
        let  testInstructionsEditor = CKEDITOR.instances.testInstructions; 
        let questionCheckedCheckboxes = $('[data-question-checkbox]:checked');
        if(typeof $currentCheckbox !== "undefined") {
            let checkboxInput =  testInstructionsEditor.document.find("#"+$currentCheckbox.attr("id"));
            if(checkboxInput.$.length){
                checkboxInput.$.forEach(checkboxInput => checkboxInput.remove());
            }
            questionCheckedCheckboxes = $currentCheckbox;
        }
        for(let i = 0; i < questionCheckedCheckboxes.length; i++) {
            let questionCheckedCheckbox = questionCheckedCheckboxes[i];
            if($(questionCheckedCheckbox).is(":checked")){
                let currentCheckboxId = $(questionCheckedCheckbox).attr("id");
                let checkboxInputElement = CKEDITOR.dom.element.createFromHtml( `<span class="checkbox-input" id="${currentCheckboxId}">${questionCheckedCheckbox.value}<br></span>` );
                testInstructionsEditor.insertElement(checkboxInputElement);
            }
        }
    }

    function handleTestDate() {
        let selectedValue = $('[name="test-radio"]:checked').val();
        $('[data-test-date]').addClass('d-none');
        $(`[data-test-date=${selectedValue}]`).removeClass('d-none')
    }
     
    $(document).on('change', '[data-question-checkbox]', function(e) {
        updateTemplateStatus()
        // click on assesment instructions checkbox. show value in ckeditor 
        updateTestInstructions($(this));
    }) ;

    $(document).on('change', '[name="test-radio"]', function() {
        handleTestDate();
    });

    $(document).on('change', 'input[name="schedule_minutes"]', function() {
        $(this).removeClass("text-required");
        this.value = this.value.replace(/[^0-9]/g,'');
        if(this.value > parseInt('{{ config('constants.MaxMinutes') }}')) {
            $(this).addClass("text-required").focus();
            this.value = '';
        }
    });

     /**
     * @event to edit question section in popup
     */
    $(document).on('click', '#review .question-edit' , function(e){
        e.preventDefault();
        if($('.owl-item').hasClass('active')){
            let id = $('.owl-item.active').find('.items').attr('data-id');
            let questionVal = $("#question" + id).find("input#question-" + id + "-title").val();
            let questionId = "question-" + id + "-title";
            $(".question-option").each(function(i,v){
                let optionId = $(v).attr('id');
                let questionVal = $(v).val();
            });
            let answerId = `question-${id}-correct-answrer`;
            let answerVal = $(`#${answerId}`).val();
            handleReviewQuestionOwlItem(true);
            $('div#preview div.modal-content div.modal-body input').each(function(i,v){
                if($(v).attr('type') == 'text'){
                    let dataId = $(v).attr('id');
                    let dataVal = $(v).val();
                    addCkeditor(dataId, dataVal);
                }
            });
        }
    });

    /**
     * @event on slide change next or prev
     */
    $(document).on('click','.owl-next , .owl-prev' , function(){
        setAttrOnEditFlagNSwap();
        $('#question-option-checkboxes').find('input[type="checkbox"]:checked').each(function() {
            $(this).prop("checked", false);
        });

        let $selector = $('.report-button');
        let selectorText = $selector.text();
        selectorText.replace(buttonSpinner, '');
        $selector.attr({'disabled': false});
        $selector.html(`${selectorText}`);
        reportStatus();        
    });

    function reportStatus() {
        let questionid = $('#preview .owl-stage-outer').find('.owl-stage').find('.owl-item.active').find('.item').attr('data-questionid');
        if (flaggedIds.length > 0 && $.inArray(questionid,flaggedIds) >= 0) {
            $('.flag-btn').addClass('disabled');
        } else {
            $('.flag-btn').removeClass('disabled');
        }
    }

    $(document).on('changed.owl.carousel', '.owl-carousel', function(e) {
        setTimeout(() => {
            setAttrOnEditFlagNSwap();
        }, 500);
        $('#question-option-checkboxes').find('input[type="checkbox"]:checked').each(function() {
            $(this).prop("checked", false);
            reportStatus();
        });
        let $selector = $('.report-button');
        let selectorText = $selector.text();
        selectorText.replace(buttonSpinner, '');
        $selector.attr({'disabled': false});
        $selector.html(`${selectorText}`);
        $('.flag-btn').removeClass('disabled');
    });

    function setAttrOnEditFlagNSwap() {
        if($('.owl-item').hasClass('active')){
            let id = $('.owl-item.active').find('.items').attr('data-id');
            let questionVal = $("#question" + id).find("input#question-" + id + "-title").val();
            let questionId = "question-" + id + "-title";

            let questionIdenti = $('.owl-item.active').find('.question-block').attr('data-questionid');
            let paperId = $('.owl-item.active').find('.question-block').data('paperid');
            $('#preview').find('.swap-question').attr({'data-questionid': questionIdenti, 'data-paperid': paperId, 'data-questionnumber': id});
            $(".question-option").each(function(i,v){
                let optionId = $(v).attr('id');
                let questionVal = $(v).val();
            });
            reportStatus();        
        }
    }

    /**
     * @methods to create CKEditor in question and option section
     */
    function addCkeditor(ids, questionVal){

        let mathElements = [
            'math'
        ];

        CKEDITOR.plugins.addExternal('ckeditor_wiris', 'https://ckeditor.com/docs/ckeditor4/4.16.0/examples/assets/plugins/ckeditor_wiris/', 'plugin.js');

        let config = {
            extraPlugins: 'ckeditor_wiris, uploadimage',

            // For now, MathType is incompatible with CKEditor file upload plugins.
            removePlugins: 'help, basket, flash, iframe, textarea, form, hidden_field, smiley, checkbox, print, preview, pdf, templates, replace, anchor, elementspath, save, flash, iframe, link, smiley, find, pagebreak, templates, about, maximize, showblocks, newpage, language, exportpdf, paste,elementspath,save,font',
            
            removeButtons: 'Copy, Cut, Paste, Undo, Redo, Print, Form, TextField, Textarea, Button, SelectAll, NumberedList, BulletedList, CreateDiv, Table, PasteText, PasteFromWord, Select, HiddenField, Checkbox, Radio,exportpdf',

            height: 80,

            toolbarCanCollapse : true,
            toolbarStartupExpanded: false,

            // uploadUrl: '/magicband-dev/upload.php',

            // Update the ACF configuration with MathML syntax.
            extraAllowedContent: mathElements.join(' ') + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
        };

        config.image2_alignClasses = [ 'image-left', 'image-center', 'image-right' ];
        config.image2_captionedClass = 'image-captioned';
        config.image2_altRequired = true;

        CKEDITOR.replace(ids, config);
        CKEDITOR.instances[ids].setData(questionVal);
    }

    $('#preview').on('hidden', function() {
        $("#scheduleDiv").html(`{{ view("teachers.includes.loader") }}`);
        $.get("{{ route('get.questions.view') }}", {"_token" : "{{ csrf_token() }}"}, function(resp) {
            $('#loader-wrapper').hide();
            $('#scheduleDiv').html(resp);
            reviewCarousel();
        });
    })

    $(document).on('click','.swap-question-modal', function(){
        let id = $('#owl-carousel-review .owl-item.active').find('.item').attr('data-swapId');
        let dataId = $('#owl-carousel-review .owl-item.active').find('.item .question-block').attr('data-id');

        let questionNumber = $('#owl-carousel-review .owl-item.active').find('.item').attr('data-questionnumber');
        let questionId = $('#owl-carousel-review .owl-item.active').find('.item .question-block').attr('data-questionid');
        let paperId = $('#owl-carousel-review .owl-item.active').find('.item .question-block').attr('data-paperid');
        let indexKey = id;
        swapQuestionIndex(questionId, paperId, questionNumber, indexKey, dataId);
    });

    function swapQuestionIndex(questionId, paperId, questionNumber, indexKey, dataId){
        $("#loader-modal").show();
        $('.btn.btn-tpt').attr('disabled', true);

        $.ajax({
            type: "POST",
            timeout: 45000,
            url: "{{ route('get.modal.question.swap') }}",
            data:{id: questionId, paperId: paperId, questionNumber: questionNumber, indexKey: indexKey, dataId: dataId},
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            success: function (response) {
                if(response.modal_view.length > 0) {
                    if(response.question_view){
                        $(`#quest${questionNumber}`).html(response.question_view);
                    }
                    if(response.modal_view){
                        $("#preview").find(`div#question${indexKey}`).html(response.modal_view);
                    }
                    $("#loader-modal").hide();
                    flaggedIds = jQuery.grep(flaggedIds, function(value) {
                        return value != questionId;
                    });
                } else {
                    $("#loader-modal").hide();
                    msgToast('info', `{{ __('questionLayout.noQuestionSwap') }}`);
                }
                $('.btn.btn-tpt').attr('disabled', false);
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function(data) {
                $("#loader-modal").hide();
                msgToast('info', `{{ __('questionLayout.noQuestionSwap') }}`);
                $('.btn.btn-tpt').attr('disabled', false);
            }
        });
    }


    $(document).on('click', '.report-button', function() {
        let $selector = $(this);
        let selectorText = $selector.text();
        $selector.attr({'disabled': true});
        $selector.html(`${buttonSpinner} ${selectorText}`);
        let id = $('.owl-item.active').find('.items').attr('data-swapId');
        let questionId = $('#preview .owl-stage-outer').find('.owl-stage').find('.owl-item.active').find('.item').attr('data-questionid');
        let selectedCheck = new Array();
        var selectedCheckText = [];
        $('#question-option-checkboxes').find('input[type="checkbox"]:checked').each(function() {
            selectedCheck.push($(this).val());
        });
        $('#question-option-checkboxes').find('input[type="checkbox"]:checked').each(function() {
            selectedCheckText.push($(this).parent().find('.custom-control-label').text());
        });
        if(selectedCheck.length > 0) {
            $.ajax({
                type: "POST",
                timeout: 10000,
                url: "{{ route('get.modal.question.report') }}",
                data:{id: questionId, issueIds: JSON.stringify(selectedCheck), issueTexts: JSON.stringify(selectedCheckText) },
                dataType: "text",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                success: function (response) {
                    if(response != 'error') {
                        $("#question-option-checkboxes").slideUp("fast");
                        flaggedIds.push(questionId);
                        $('#question-option-checkboxes').find('input[type="checkbox"]:checked').each(function() {
                            $(this).prop("checked", false);
                        });
                        msgToast("success", `{{ __("questionLayout.reportSuccess") }}`);
                    } else {
                        msgToast("error", `{{ __("questionLayout.reportFail") }}`);
                    }
                    let selectorText = $selector.text();
                    selectorText.replace(buttonSpinner, '');
                    $selector.html(`${selectorText}`);
                    $('.flag-btn').addClass('disabled');
                },
                error: function(data) {
                    msgToast("error", `{{ __("questionLayout.reportFail") }}`);
                }
            });
        } else {
            let selectorText = $selector.text();
            selectorText.replace(buttonSpinner, '');
            $selector.attr({'disabled': false});
            $selector.html(`${selectorText}`);
            msgToast('error', '{{ __("questionLayout.selectOptionReporting") }}');
            return false;
        }

    });

    function reportError(id, msg) {
        $("#question-option-checkboxes").slideUp("fast");
        $("#preview").find(`div#question${id}`).find('.question-list').before(`<div class="alert alert-default alert-dismissible fade show text-danger border-dark" role="alert">
                ${msg}
            </div>`);
        setTimeout(() => {
            let $target = $('.alert-default.alert-dismissible');
            $target.hide('slow', function(){ $target.remove(); });
        }, 5000);
    }

    $(document).on('click', '.enlarge-popup-btn', function () {
        $(this).parents('.modal').toggleClass('modal-fullscreen');
        if ($(this).parents('div.modal').hasClass('modal-fullscreen')) {
            $(this).html(`{!! config('constants.icons.enlarge-big-icon') !!}`);
            openFullscreen();
        } else {
            $(this).html(`{!! config('constants.icons.enlarge-icon') !!} `);
            closeFullscreen();
        }
        $('#owl-carousel-review').trigger('refresh.owl.carousel');
        $('[data-toggle="tooltip"]').tooltip('dispose');
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).on('click','.downloadPdf', function(){
        var url = "{{ route('get.question.pdf') }}";
        window.open(url, '_blank');
    });

    $(document).on('click', '#customCheck102', function(){
        if($(this).is(':checked')) {
            $('input[name="schedule_minutes"]').attr('disabled', true);
        }
    });

    $(document).on('click', '#customCheck101', function(){
        if($(this).is(':checked')) {
            $('input[name="schedule_minutes"]').attr('disabled', false);
        }
    });

    $(document).on('click', '#customCheck103', function(){
        if($(this).is(':checked')) {
            $('div.test-date-detail').hide('slow');
        } else {
            $('div.test-date-detail').show('slow');
        }
    });

    $(document).on('click', '.copyclip', function () {
        copyToClipboard("#sharelinkurl");
    });

    $(document).on('click', 'button, a', function () {
        if(!isOnline){
            msgToast('error', `{{ __('questionLayout.offlineNotification') }}`);
            return false;
        }
    });
    
    /* Keyboard Accessicibility */
    $(document).on("keypress", ".template-box-creat, .remove-table-tr.remove", function(e) {
        if (e.keyCode == '32' || e.keyCode == '13') {
            $(this).click();
        }
    });

    $("#preview2").on('shown.bs.modal', function(){
        $('[data-toggle="popover"]').popover();
        $("input[name=template_title]").focus();
        $(this).attr({"tabindex": "-1"});
    });

    $("#copy").on('shown.bs.modal', function(){
        $(this).parents('body').addClass('copy-enable');
    });

    $("#copy").on('hidden.bs.modal', function(){
        $(this).parents('body').removeClass('copy-enable');
    });
   
</script>
