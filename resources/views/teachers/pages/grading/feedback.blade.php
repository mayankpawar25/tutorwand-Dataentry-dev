@extends('teachers.layouts.common')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="mt-5 mb-5">
            <div class="text-center svg-fill-brand mb-4">
                {!! config('constants.icons.thumb-svg') !!}
            </div>
            <div class=" text-center">
                <h4 class="mb-3">{!! __('teachers.grading.gradingFeedbacTitle') !!}</h4>
                
                <!-- <div class="text-center mb-3">
                    <a href="#" class="mr-4" target="_blank" title="PDF">{!! config('constants.icons.pdf-icon') !!}</a>
                    <a href="#" class="shareIcon" title="Share">{!! config('constants.icons.share-icon') !!}</a>
                </div> -->

                <div class="text-center">
                    <a href="{{ route('grading.assessments.home') }}" class="btn btn-primary mr-2">{{ __('teachers.grading.gradingAssessmentHome') }}</a>
                    <a href="{{ route('assignment') }}" class="btn btn-primary">{{ __('teachers.feedback.createNewAssessment') }}</a>
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
        <h4 class="mb-3">{!! __('teachers.grading.gradingFeedbackHeading') !!}</h4>
        <p class="mb-0">{!! __('teachers.grading.gradingFeedbackQ1') !!}</p>
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
        <p class="mb-0">{!! __('teachers.grading.gradingFeedbackQ2') !!}</p>
        <div class="rating-outer">
            <ul class="rate-area">
                @foreach($starRating as $keyValue => $star)
                    <input type="radio" id="{{ $keyValue }}a-star" name="rating2" value="{{ $keyValue }}" /><label for="{{ $keyValue }}a-star" title="{{ $star }}"></label>
                @endforeach
            </ul>
        </div>
        <div class="clearfix"></div>
        

        <div class="clearfix"></div>
        <p class="mb-1">{!! __('teachers.grading.gradingFeedbackMessageTitle') !!}</p>
        <div class="form-group">
            <textarea class="form-control" name="sendFeedback" id="" cols="30" rows="4"></textarea>
        </div>
        <button class="btn btn-primary feedback-sent disabled">{!! __('teachers.feedback.send') !!} <i class="fa fa-paper-plane-o right" aria-hidden="true"></i></button>
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
    let overallGradingExperience = '';
    let autogradingExperience = '';
    let feedback = '';
    let feedbackMessage = '{{ __("teachers.feedback.feedbackMessage") }}';

    $(document).on('click', '.feedback-sent', function() {
        overallGradingExperience = $('input[name="rating1"]:checked').val() != undefined ? $('input[name="rating1"]:checked').val() : 0;
        autogradingExperience = $('input[name="rating2"]:checked').val() != undefined ? $('input[name="rating2"]:checked').val() : 0;
        feedback = $('textarea[name="sendFeedback"]').val();

        if(overallGradingExperience > 0 && autogradingExperience > 0) {
            appInsights.trackEvent({
                name: 'Feedback',
                properties: {
                    feedback: {
                        ratings: {
                            'overallGradingExperience': overallGradingExperience,
                            'autogradingExperience': autogradingExperience,
                        },
                        'feedback': feedback,
                        'userId': userId,
                        'role': userRole,
                        'from': '{{ config("constants.gradingFeedbackKey") }}'
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
        overallGradingExperience = $('input[name="rating1"]:checked').val() != undefined ? $('input[name="rating1"]:checked').val() : 0;
        autogradingExperience = $('input[name="rating2"]:checked').val() != undefined ? $('input[name="rating2"]:checked').val() : 0;
        feedback = $('textarea[name="sendFeedback"]').val();
        if(overallGradingExperience > 0 && autogradingExperience > 0) {
            $('.feedback-sent').removeClass('disabled');
        } else {
            if( $('.feedback-sent').hasClass('disabled') == false ) {
                $('.feedback-sent').addClass('disabled');
            }
        }
    })
</script>
@stop