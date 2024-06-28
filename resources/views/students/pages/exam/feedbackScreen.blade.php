@extends('students.layouts.default')
@section('title', "Feedback")
@section('content')
	<div class="row">
        <div class="col-md-12 col-lg-12 mt-4">
            <div class="celebration-bg">
                <div class="feeback-text-block">
                    {!! config('constants.icons.thumb-svg') !!}
                    <h4 class="mb-3 mt-2">{!! __('students.examFeedbackTitle') !!}</h4>
                    <a href="{{ route('students.assessment') }}" class="btn btn-primary">{{ __('students.assignment') }}</a>
                    <a href="{{ route('students.dashboard') }}" class="btn btn-primary ml-2 mr-2">{{ __('students.dashboard.dashboard') }}</a>
                    @if(isset($questionData['resultOnSubmission']) && $questionData['resultOnSubmission'])
                        <a href="{{ route('students.assessment.report-result', base64_encode($questionData['questionPaperId'])) }}" class="btn btn-primary">{{ __('students.viewResult') }}</a>
                    @endif
                </div>
            </div>

        </div>
        <div class="col-md-12 col-lg-12 d-none">
            <div class="canvas-area pt-3">
                <nav class="breadcrumb mb-0">
                    <a class="breadcrumb-item active" href="#">{{ __('students.assignment') }}</a>
                    <!-- <span class="breadcrumb-item active">FastTrack</span> -->
                </nav>
                <div class="canvas-inner canvas-inner1" >
                    <div class="canvas-body">
                        <div class=" mt-4 great">
                            <img src="{{ asset('assets/images/students/rank.png') }}">
                            
                            <h1 class="mt-2">{{ __('students.great') }}!</h1>
                            <p class="">{{ __('students.successMsg') }}</p>
                            <p>{{ __('students.sharedTextMsg') }}</p>
                            <div class="d-flex justify-content-center">
                                <ul>
                                    <li>
                                        <button>{{ __('students.assignment') }}</button>
                                    </li>
                                    <li>
                                        <button>{{ __('students.dashboard.dashboard') }}</button>
                                    </li>
                                    @if(isset($questionData['resultPublishDate']))
                                        <li>
                                            <button>{{ __('students.viewResult') }}</button>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="great-block">
                                    <div class="row ml-2 mt-4">
                                        <div class="col-sm-12 mb-2 mt-4" data-id="1">
                                            <div class="">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck1" checked="">
                                                    <label class="custom-control-label d-table" for="customCheck1">
                                                        <p class="mr-1">{{ __('students.feedback.examExperienceLabel') }}</p>  
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-2" data-id="2">
                                            <div class="">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                    <label class="custom-control-label d-table" for="customCheck2">
                                                        <p class="mr-1">{{ __('students.feedback.examExperience1') }}</p> 
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-2" data-id="3">
                                            <div class="">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck3">
                                                    <label class="custom-control-label d-table" for="customCheck3">
                                                        <p class="mr-1">{{ __('students.feedback.examExperience2') }}</p>  
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-2" data-id="4">
                                            <div class="">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck4">
                                                    <label class="custom-control-label d-table" for="customCheck4">
                                                        <p class="mr-1">{{ __('students.feedback.examExperience3') }}</p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <textarea name="" id="" cols="55" rows="5" class="ml-3" placeholder="Feedback"></textarea>
                                    </div>
                                    <button class="pull-right  btn-send"><i class="fa fa-telegram" aria-hidden="true"></i>{{ __('students.send') }}</button>
                                        
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
       
    </div>
    <!-- feedback panel -->
<div class="feedback-panel">
        <button type="button" class="close hide-feedback" data-dismiss="modal" tabindex="1" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" viewBox="0 0 14 14">
                <defs>
                    <clipPath id="clip-path">
                    <path id="_Color" data-name=" ↳Color" d="M14,1.41,12.59,0,7,5.59,1.41,0,0,1.41,5.59,7,0,12.59,1.41,14,7,8.41,12.59,14,14,12.59,8.41,7Z" transform="translate(5 5)" fill=""></path>
                    </clipPath>
                </defs>
                <g id="icon_navigation_close_24px" data-name="icon/navigation/close_24px" transform="translate(-5 -5)">
                    <g id="Group_192" data-name="Group 192">
                    <path id="_Color-2" data-name=" ↳Color" d="M14,1.41,12.59,0,7,5.59,1.41,0,0,1.41,5.59,7,0,12.59,1.41,14,7,8.41,12.59,14,14,12.59,8.41,7Z" transform="translate(5 5)" fill=""></path>
                    </g>
                </g>
            </svg>
         </button>
        <h4 class="mb-3">{!! __('students.examFeedbackHeading') !!}</h4>
        <p class="mb-0">{!! __('students.examFeedbackQ1') !!}</p>
        @php
            $starRating = starRatingKeys();
        @endphp
        <div class="rating-outer">
            <ul class="rate-area">
                @foreach($starRating as $keyValue => $star)
                    <input type="radio" id="{{ $keyValue }}-star" name="rating1" value="{{ $keyValue }}" /><label for="{{ $keyValue }}-star" title="{{ $star }}"></label>
                @endforeach
            </ul>
        </div>
        <div class="clearfix"></div>
        <p class="mb-0">{!! __('students.examFeedbackQ2') !!}</p>
        <div class="rating-outer">
            <ul class="rate-area">
                @foreach($starRating as $keyValue => $star)
                    <input type="radio" id="{{ $keyValue }}a-star" name="rating2" value="{{ $keyValue }}" /><label for="{{ $keyValue }}a-star" title="{{ $star }}"></label>
                @endforeach
            </ul>
        </div>
        <div class="clearfix"></div>
        

        <div class="clearfix"></div>
        <p class="mb-1">{!! __('students.examFeedbackMessageTitle') !!}</p>
        <div class="form-group">
            <textarea class="form-control" name="sendFeedback" id="" cols="30" rows="4"></textarea>
        </div>
        <button class="btn btn-primary feedback-sent disabled">{!! __('students.send') !!} <i class="fa fa-paper-plane-o right" aria-hidden="true"></i></button>
    </div>
<!-- feedback panel end -->
@endsection
@section('onPageJs')
<script>
    window.setTimeout(function() {
        $('.feedback-panel').addClass('f-panel-slide');
    }, 1000);
    $(".hide-feedback").click(function() {
        $(".feedback-panel").removeClass("f-panel-slide");
    });

    let userId = "{{ getStudentUserId() }}";
    let userRole = "{{ session()->get('profile')['userRoles'][0]['roleName'] }}";
    let assessmentExperience = '';
    let questionQuality = '';
    let feedback = '';
    let feedbackMessage = '{{ __("students.feedbackMessage") }}';
    let studentExamFeedbackText = "{{ __('students.studentFeedbackPage') }}";
    $(document).on('click', '.feedback-sent', function() {
        assessmentExperience = $('input[name="rating1"]:checked').val() != undefined ? $('input[name="rating1"]:checked').val() : 0;
        questionQuality = $('input[name="rating2"]:checked').val() != undefined ? $('input[name="rating2"]:checked').val() : 0;
        feedback = $('textarea[name="sendFeedback"]').val();

        if(assessmentExperience > 0 && questionQuality > 0) {
            appInsights.trackEvent({
                name: 'Feedback',
                properties: {
                    feedback: {
                        ratings: {
                            'assessmentExperience': assessmentExperience,
                            'questionQuality': questionQuality,
                        },
                        'feedback': feedback,
                        'userId': userId,
                        'role': userRole,
                        'from': studentExamFeedbackText
                    }
                }
            });

            $('input[name=rating1][type="radio"]').prop('checked', false);
            $('input[name=rating2][type="radio"]').prop('checked', false);
            $('textarea[name="sendFeedback"]').val('');
            $('.close.hide-feedback').click();
            $('.feedback-sent').addClass('disabled');
            msgToast('success', feedbackMessage);
        }
    });

    $(document).on('change', 'input[type="radio"], textarea', function (){
        assessmentExperience = $('input[name="rating1"]:checked').val() != undefined ? $('input[name="rating1"]:checked').val() : 0;
        questionQuality = $('input[name="rating2"]:checked').val() != undefined ? $('input[name="rating2"]:checked').val() : 0;
        feedback = $('textarea[name="sendFeedback"]').val();
        if(assessmentExperience > 0 && questionQuality > 0) {
            $('.feedback-sent').removeClass('disabled');
        } else {
            if( $('.feedback-sent').hasClass('disabled') == false ) {
                $('.feedback-sent').addClass('disabled');
            }
        }
    })
</script>
@stop
