@extends('teachers.layouts.default')
@section('content')
<div id="rootPlaced">
    <div class="canvas-inner position-relative ">
        <div class="canvas-body">
            <div class="confainer-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        @if($responseData['status'] == 'DECLINED')
                            <div class="well">
                                {{ __('teachers.class.classActivationDeclined') }}
                            </div>
                        @else
                            <div class="well">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="classRoomId" id="classRoomId" value="{{ $classRoomId }}">
                                        <input type="hidden" name="ownerId" id="ownerId" value="{{ getStudentUserId() }}">
                                        <input type="hidden" name="inviteStudentUrl" id="inviteStudentUrl" value="{{ route('class.update') }}">
                                        <input type="hidden" name="refreshStudentUrl" id="refreshStudentUrl" value="{{ route('class.refresh', $classRoomId) }}">
                                        <h4 class="mb-0">{{ $responseData['className'] }}
                                            <span class="replace-icon">
                                                <i class="fa fa-refresh pageRefresh cursor-pointer" data-toggle="tooltip" title="Sync with Google Classroom" aria-hidden="true"></i>
                                            </span>
                                        </h4>
                                        <p class="mb-0">
                                            @if($responseData['subject'] != "")
                                                {{ __('teachers.class.subject') }}: {{ $responseData['subject'] }} | 
                                            @endif
                                            {{ __('teachers.class.students') }}: {{ !empty($responseData['students']) ? count($responseData['students']) : 0 }}
                                        </p>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="javascript:void(0)" class=" btn btn-primary btn-sm" data-toggle="modal" data-target="#copy"><i class="left">{!! config('constants.icons.share-icon') !!}</i> Share Invite</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-2">
                                    <div class="col-md-8">
                                        <h5 class="mt-2">{{ __('teachers.class.studentList') }}</h5>

                                    </div>
                                    <div class="col-md-4 text-right">
                                        <div class="std-count-box">
                                            <div class="inactive-list">
                                                <span>{{ count($responseData['students']) }}</span> {{ __('teachers.class.invited') }}
                                            </div>
                                            <div class="joined-list">
                                                <span>{{ $responseData['studentCount'] }}</span> {{ __('teachers.class.joined') }}
                                            </div>
                                        </div>
                                        <div><a href="{{ $responseData['alternateLink'] }}/sort-last-name" class="text-brand" target="_blank">{{ __('teachers.class.viewStudentList') }}</a></div>
                                    </div>
                                </div>

                                <div class="tab-panel-box student-list">
                                    <div class="tab-content">
                                        @if($responseData['status'] == config('constants.provisioned'))
                                            <div class="row mb-2">
                                                <div class="col-md-10">
                                                    @if(isset($responseData['alternateLink']) && $responseData['alternateLink'] != "")
                                                        {!! sprintf(__('teachers.class.classRoomError2'), $responseData['alternateLink'] ) !!}
                                                    @else
                                                        {!! sprintf(__('teachers.class.classRoomError3'), "#") !!}
                                                    @endif 
                                                </div>
                                            </div>
                                        @else
                                            <div class="tab-panel-box student-list">
                                                <div class="tab-content">
                                                    <div class="row">
                                                        <div class="col-sm-12">{{ __('teachers.class.studentMessage') }}</div>
                                                        <div class="col-sm-12">
                                                            @if(isset($responseData['students']) && !empty($responseData['students']))
                                                                @foreach($responseData['students'] as $studentData)
                                                                    @if($studentData['student']['id'])
                                                                        @php
                                                                            $isDisabled = "";
                                                                            $statusDiv = "";
                                                                        @endphp
                                                                        @if(isset($studentData['invitationStatus']) && $studentData['invitationStatus'] == 'Pending')
                                                                            @php
                                                                                $invitedText = __('teachers.class.invited');
                                                                                $isDisabled = "disabled";
                                                                                $statusDiv = '<span  class="d-block mt-2">'. $invitedText.'</span>';
                                                                            @endphp
                                                                        @endif
                                                                        <div class="card {{ $isDisabled }}">
                                                                            <div class="row">
                                                                                <div class="col-md-8">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="custom-control custom-checkbox">

                                                                                            <label class="custom-control-label" for="customCheck2">
                                                                                                <div class="sub-name">
                                                                                                    <div class="student-icon" data-email="{{ $studentData['student']['emailId'] }}">
                                                                                                        @if($studentData['student']['id'])
                                                                                                            <img src="{{ handleProfilePic($studentData['student']['photoUrl']) }}">
                                                                                                        @else
                                                                                                            <img src="{{ asset('assets/images/teachers/avtar.png') }}">
                                                                                                        @endif
                                                                                                        <p>{{ ($studentData['student']['id']) ? $studentData['student']['name'] : $studentData['student']['emailId'] }}</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </label>
                                                                                        </div>


                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">

                                                                                    <div class="card-action-box">
                                                                                        <div class="card-action-box text-right">
                                                                                            {!! $statusDiv !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </div>

                                                    </div>
                                                    <hr class="mt-1">
                                                    <button class="btn btn-outline-primary btn-auto" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus left" aria-hidden="true"></i> {{ __('teachers.class.addStudent') }}</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('teachers.class.addStudent') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">{!! config('constants.icons.close-icon') !!}</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="append-outer mb-2">
                        <div class="row">
                            <div class="col-sm-6 ">

                                <input type="text" name="student_name" maxlength="50" class="form-control input-regular" placeholder="{{ __('teachers.class.enterStudentName') }}">
                            </div>
                            <div class="col-sm-6 ">
                                <div class="d-flex">
                                    <input type="text" name="student_email" maxlength="50" class="form-control input-regular" placeholder="{{ __('teachers.class.enterStudentEmail') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <span id="addRow"></span>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button href="#" class="text-brand btn-auto btn btn-outline-primary insertRow mr-2"><i class="fa fa-plus left" aria-hidden="true"></i> {{ __('teachers.class.addMore') }}</button>

                        </div>

                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button href="#" class="text-brand btn-auto btn btn-primary pull-right sendInvite"><i class="fa fa-paper-plane-o left" aria-hidden="true"></i> {{ __('teachers.class.sendInvite') }}</button>
                </div>

            </div>
        </div>
    </div>
    
    <div class="cloneData d-none">
        <div class="row ">
            <div class="col-sm-6">
                <input type="text" name="student_name" maxlength="50" class="form-control input-regular" placeholder="{{ __('teachers.class.enterStudentName') }}">
            </div>
            <div class="col-sm-6">
                <div class="d-flex">
                    <input type="text" name="student_email" maxlength="50" class="form-control input-regular mr-2" placeholder="{{ __('teachers.class.enterStudentEmail') }}">
                    <button class="btn removeMe btn-outline-primary btn-auto  btn-remove  ml-3">
                        {!! config('constants.icons.class-close-icon') !!}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- feedback panel end -->
    <div class="modal confirm" id="copy">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <!-- Modal Header -->
                <button type="button" class="close" data-dismiss="modal">{!! config("constants.icons.close-icon") !!}</button>

                <!-- Modal body -->
                <div class="modal-body">
                    <h6 class="text-left">{{ __('teachers.feedback.getLink') }}</h6><hr>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="copyclip" value="{{ $inviteUrl }}" id="sharelinkurl" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text btn-primary mw-auto copyclip cursor-pointer">{{ __('teachers.feedback.copyLink') }}</span>
                        </div>
                    </div><br>
                    <p class="text-left d-flex align-items-center">{{ __('teachers.feedback.shareWhatsApp') }}
                        <a href="{{ config('constants.whatsappUrl') }}{{ $inviteUrl }}" data-action="share/whatsapp/share" target="_blank">{!! config("constants.icons.whatsapp-icon") !!}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()
  @section('onPageJs')
    <script>
        // circle graph
        let classRoomId = "{{ $classRoomId }}";
        let ownerId = "{{ getStudentUserId() }}";
        let refreshStudentUrl = "{{ route('class.refresh', $classRoomId) }}";
        let cloneDiv = $(".cloneData").html();
        let invitationSuccessText = "{{ __('teachers.class.successInvitation') }}";
        let invitationFailedText = "{{ __('teachers.class.alreadyExists') }}";
        let maxThirtyAllowed = "{{ __('teachers.class.maxThirtyStudentAllowed') }}";
        let pleaseRemoveDuplicate = "{{ __('teachers.class.pleaseRemoveDuplicate') }}";
        let buttonIcon = `<i class="fa fa-paper-plane-o left" aria-hidden="true"></i>`;
        let buttonLoader = `<i class="fa fa-circle-o-notch fa-spin fa-fw left"></i>`;
        let popup = "";
        let popupReload = 0;
        let dashboardURL = "{{ route('teacher.dashboard') }}";

        $(document).ready(function($) {
            if($(".activeBtnLink").is(':visible')) {
                
                setTimeout(() => {
                    $("#launchPopup").click();
                }, 3000);

                setInterval(() => {
                    if(popup.closed && popupReload <= 1) {
                        popupReload = popupReload+1;
                        $('.pageRefresh').click();
                    }
                }, 3000);
            }

            $('[data-toggle="tooltip"]').tooltip();

        });

        //counter
        $('.counter-count').each(function() {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {

                //chnage count up speed here
                duration: 1000,
                easing: 'swing',
                step: function(now) {
                    $(this).text(Math.ceil(now));
                }
            });
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

        $(document).on("click", ".insertRow", function() {
            if($("div.modal-body input[name=student_email]").length < 30) {
                $("#addRow").append(`<div class="append-outer mb-2">${cloneDiv}</div>`);
            } else {
                toastr.error(maxThirtyAllowed);
            }
        });

        $(document).on("click", ".removeMe", function() {
            $(this).parents("div.append-outer.mb-2").remove();
        });
        $(document).on("click", ".sendInvite", function() {
            let emailRegex = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
            let buttonText = $(this).text();
            let students = [];
            let errorBool = [];
            var studentArray = [];
            let duplicateEmail = false;
            $("div.modal-body input[name=student_email]").each(function(index, element){
                var studentEmail = $(element).val();
                var nameElement = $("input[name=student_name]")[index];
                var studentName = $(nameElement).val();
                if (studentEmail.length > 1 && studentName.length > 1) {
                    if($.inArray(studentEmail, studentArray) == -1) {
                        studentArray.push(studentEmail);
                        if ($(element).hasClass("text-required")) {
                            $(element).removeClass("text-required");
                        }
                        if($(nameElement).hasClass("text-required")) {
                            $(nameElement).removeClass("text-required");
                        }
                        if (!emailRegex.test(studentEmail)) {
                            errorBool.push(true);
                            $(element).addClass("text-required");
                        } else {
                            errorBool.push(false);
                            students.push({id:"", photoUrl:"", name:studentName, emailId: studentEmail});
                        }
                    } else {
                        duplicateEmail = true;
                        errorBool.push(true);
                        $(element).addClass("text-required");
                    }
                } else {
                    errorBool.push(true);
                    if(studentEmail.length < 3) {
                        $(element).addClass("text-required");
                    }
                    if(studentName.length < 3) {
                        $(nameElement).addClass("text-required");
                    }
                }
            });
            if(duplicateEmail) {
                toastr.error(pleaseRemoveDuplicate);
                return false;
            }
            if ($.inArray(true, errorBool) == -1) {
                    $(this).html(`${buttonLoader}${buttonText}`);
                    $(this).attr({'disabled': true});
                    let classData = createClassFormat(students);
                    let inviteStudentURL = "{{ route('class.update') }}";
                    $.ajax({
                        type: "POST",
                        url: inviteStudentURL,
                        data: classData,
                        dataType: "json",
                        headers : {
                            "X-CSRF-TOKEN" : $("meta[name=csrf-token]").attr('content')
                        },
                        success: function (response) {
                            $("#myModal").modal('hide');
                            $(".sendInvite").html(`${buttonText}`);
                            $(".sendInvite").attr({'disabled':false});
                            if (response.status) {
                                toastr[response.infoStatus](response.message);
                                setTimeout(function() {
                                    $('.pageRefresh').click();
                                }, 5000);
                            } else {
                                toastr.error(invitationFailedText);
                            }
                        }
                    });
                } else {
                    $(this).html(`${buttonIcon+''+buttonText}`);
                    $(this).attr({'disabled': false});
                }
                // toastr.success("Class created successfully and invitation sent to students.");
        });

        function createClassFormat(students) {
            return {
                classId: classRoomId,
                ownerId: ownerId,
                students: students
            };
        }

        $(document).on("click",".pageRefresh", function() {
            let buttonHtml = $(".replace-icon").html();
            $(".replace-icon").html(`${buttonSpinner}`);
            $.ajax({
                type: "GET",
                url: refreshStudentUrl,
                dataType: "json",
                success: function (response) {
                    if(response.status) {
                        if(response.declined) {
                            toastr.info(response.declined);
                            setTimeout(function() {
                                location.href = dashboardURL;
                            }, 5000);
                        } else {
                            if($(".modal").is(':visible')) {
                                $(".modal").modal('hide');
                            }
                            if($(".tooltip.fade.bs-tooltip-top").hasClass('show')) {
                               $(".tooltip.fade.bs-tooltip-top").remove();
                            }
                            $("div#rootPlaced").html(response.html);
                        }
                    }
                }
            });
        });

        $(document).on('click', '#launchPopup', function() {
            let w = 600;
            let h = 600;
            let left = (screen.width/2)-(w/2);
            let top = (screen.height/2)-(h/2);
            let url = $(this).attr('data-url');
            let title = 'Google Classroom';
            popupReload = popupReload+1;
            return popup = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
        });
    </script>
@endsection
