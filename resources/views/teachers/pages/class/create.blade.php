@extends('teachers.layouts.default')
@section('content')
    <div class="canvas-inner position-relative ">
        <div class="canvas-body">
            <div class="confainer-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="well">
                            <div class="create-class-stricky-header">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input type="hidden" name="loggedInEmail" value="{{ getStudentUserEmail() }}">
                                        <h4>{{ __('teachers.class.createNewClass') }}</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn createClass btn-primary pull-right btn-auto"><i class="fa fa-plus left" aria-hidden="true"></i>{{ __('teachers.class.createClass') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">{{ __('teachers.class.className') }} ({{ __('teachers.class.required') }})</label>
                                    <input type="text" class="form-control input-regular" name="class_name" placeholder="{{ __('teachers.class.enterClassName') }}" maxlength="50">
                                </div>

                                <div class="col-sm-6">
                                    <label for="">{{ __('teachers.class.subject') }} ({{ __('teachers.class.optional') }})</label>
                                    <input type="text" class="form-control input-regular" name="subject" placeholder="{{ __('teachers.class.enterSubject') }}" maxlength="50">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="cloneData d-none">
        <div class="row ">
            <div class="col-sm-6">
                <input type="text" name="student_name" class="form-control input-regular" placeholder="{{ __('teachers.class.enterStudentName') }}">
            </div>
            <div class="col-sm-6">
                <div class="d-flex">
                    <input type="text" name="student_email" class="form-control input-regular mr-2" placeholder="{{ __('teachers.class.enterStudentEmail') }}">
                    <button class="btn removeMe btn-outline-primary btn-auto  btn-remove  ml-3">
                        {!! config('constants.icons.class-close-icon') !!}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection()
@section('onPageJs')
    <script>
        let createdClassSuccessText = "Class created successfully and invitation sent to students.";
        let somethingWentWrong = "Something went wrong";
        var reloadUrl = "{{ route('class.show', 'replacemyid') }}";
        let maxThirtyAllowed = "{{ __('teachers.class.maxThirtyStudentAllowed') }}";
        let pleaseRemoveDuplicate = "{{ __('teachers.class.pleaseRemoveDuplicate') }}";
        let buttonLoader = `<i class="fa fa-circle-o-notch fa-spin left"></i>`;
        let plusIcon = `<i class="fa fa-plus left" aria-hidden="true"></i>`;
        // circle graph
        let cloneDiv = $(".cloneData").html();

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
    
        $(document).on("click", ".insertRow", function() {
            if($("div.append-outer.mb-2 input[name=student_email]").length < 30) {
                $("#addRow").append(`<div class="append-outer mb-2">${cloneDiv}</div>`);
            } else {
                toastr.error(maxThirtyAllowed);
            }
        });
    
        $(document).on("click", ".removeMe", function() {
            $(this).parents("div.append-outer.mb-2").remove();
        });
        $(document).on("click", ".createClass", function() {
            let buttonText = $(this).text();
            let emailRegex = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
            let className = $("input[name=class_name]").val();
            let subject = $("input[name=subject]").val();
            let section, room, ownerId = "";
            let errorBool = [];
            if ($("input[type=text]").hasClass("text-required")) {
                $("input[type=text]").removeClass("text-required");
            }

            if (className.length > 1 ) {
                if ($("input[name=class_name]").hasClass("text-required")) {
                    $("input[name=class_name]").removeClass("text-required");
                }

                if ($.inArray(true, errorBool) == -1) {
                    $(this).html(`${buttonLoader}${buttonText}`);
                    $(this).attr({'disabled': true});
                    let classData = createClassFormat(className, subject, section, room, ownerId);
                    let createClassURL = "{{ route('class.store') }}";
                    $.ajax({
                        type: "POST",
                        url: createClassURL,
                        data: classData,
                        dataType: "json",
                        headers : {
                            "X-CSRF-TOKEN" : $("meta[name=csrf-token]").attr('content')
                        },
                        success: function (response) {
                            localStorage.setItem('response', JSON.stringify(response));
                            console.log(response);
                            $(".createClass").attr({'disabled': false});
                            $(".createClass").html(`${plusIcon +' '+ buttonText}`);
                            if(response.status) {
                                toastr.success(response.message);
                            } else {
                                toastr.info(response.message);
                            }
                            if (response.response.id) {
                                location.href = reloadUrl.replace("replacemyid", response.response.id);
                            }
                        }
                    });
                } else {
                    $(this).html(`${buttonText}`);
                    $(this).attr({'disabled': false});
                }
            } else {
                $("input[name=class_name]").addClass("text-required");
            }
        });

        function createClassFormat(className, subject, section, room, ownerId, students) {
            let loggedInEmail = $("input[name=loggedInEmail]").val();
            let findGmail = "@gmail.com";
            let isPublicGmail = false;
            if(loggedInEmail.indexOf(findGmail) != -1){
                isPublicGmail = true;
            }
            return {
                className: className,
                subject: subject,
                section: section,
                isPublicGmail: isPublicGmail,
                room: room,
                ownerId: ownerId
            };
        }

    </script>
@endsection()