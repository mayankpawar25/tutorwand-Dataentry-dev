@extends('teachers.layouts.default')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="mt-5 mb-5">
            <div class="text-center svg-fill-brand mb-4">
                {!! config('constants.icons.thumb-svg') !!}
            </div>
            <div class=" text-center">
                <h4 class="mb-3">{!! __('teachers.feedback.feedbackGreatLabel') !!}</h4>
                <h5 class="mb-3">{!! __('teachers.feedback.feedbackGreatLabel2') !!}</h5>
                {{--
                    @if (isset($postData['header']['resultPublishDate']) && strtotime($postData['header']['resultPublishDate']) > time())
                        <p class="text-brand">{{ sprintf(__('students.resultOn'), utcToDateTime($postData['header']['resultPublishDate'])) }}</p>
                    @endif
                --}}

                <div class="text-center mb-3">
                    <a href="{{ route('get.question.pdf', $postData['paperId']) }}" class="mr-4" target="_blank" data-toggle="tooltip" title="Download Question Paper">{!! config('constants.icons.pdf-icon') !!}</a>
                    <a href="javascript:void(0)" class="shareIcon" data-toggle="tooltip" title="Share Assessment Link" data-toggle="modal" data-target="#copy">{!! config('constants.icons.share-icon') !!}</a>
                </div>

                <div class="text-center">
                    <a href="{{ route('fastrack') }}" class="btn btn-primary">{{ __('teachers.feedback.createNewAssessment') }}</a>
                    <a href="{{ route('grading.assessments.home') }}" class="btn btn-primary mr-2">{{ __('teachers.feedback.gradingHome') }}</a>
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
        <h4 class="mb-3">{!! __('teachers.feedback.ftFeedbackHeading') !!}</h4>
        <p class="mb-0">{!! __('teachers.feedback.ftFeedbackQ1') !!}</p>
        <div class="rating-outer">

            @php
                $starRating = starRatingKeys();
            @endphp

            <ul class="rate-area">
                @foreach($starRating as $keyValue => $star)
                    
                    {{-- Form Input component --}}

                    <x-forms.input type="radio" id="{{ $keyValue }}-star" name="rating1" value="{{ $keyValue }}"/><label for="{{ $keyValue }}-star" title="{{ $star }}"></label>

                    {{-- Form Input component --}}
                    
                @endforeach
            </ul>
        </div>
        <div class="clearfix"></div>
        <p class="mb-0">{!! __('teachers.feedback.ftFeedbackQ2') !!}</p>
        <div class="rating-outer">
            <ul class="rate-area">
                @foreach($starRating as $keyValue => $star)
                    
                    {{-- Form Input component --}}

                    <x-forms.input type="radio" id="{{ $keyValue }}a-star" name="rating2" value="{{ $keyValue }}"/><label for="{{ $keyValue }}a-star" title="{{ $star }}"></label>

                    {{-- Form Input component --}}

                @endforeach
            </ul>
        </div>
        <div class="clearfix"></div>
        <p class="mb-0">{!! __('teachers.feedback.ftFeedbackQ3') !!}</p>
        <div class="rating-outer">
            <ul class="rate-area">
                @foreach($starRating as $keyValue => $star)

                    {{-- Form Input component --}}

                    <x-forms.input type="radio" id="{{ $keyValue }}b-star" name="rating3" value="{{ $keyValue }}"/><label for="{{ $keyValue }}b-star" title="{{ $star }}"></label>

                    {{-- Form Input component --}}

                @endforeach
            </ul>
        </div>
        <div class="clearfix"></div>

        <div class="clearfix"></div>
        <p class="mb-1">{!! __('teachers.feedback.ftFeedbackMessageTitle') !!}</p>
        <div class="form-group">
            <textarea class="form-control" name="sendFeedback" id="" cols="30" rows="4"></textarea>
        </div>
        <button class="btn btn-primary ft-feedback-sent disabled">{!! __('teachers.feedback.send') !!} <i class="fa fa-paper-plane-o right" aria-hidden="true"></i></button>
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
                        <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="copyclip" value="{{ $examUrls['magicBandUrl'] }}" id="sharelinkurl">
                        <div class="input-group-append">
                            <span class="input-group-text btn-primary mw-auto copyclip cursor-pointer">{{ __('teachers.feedback.copyLink') }}</span>
                        </div>
                    </div><br>
                    <p class="text-left d-flex align-items-center">{{ __('teachers.feedback.shareWhatsApp') }}
                        <a href="{{ config('constants.whatsappUrl') }}{{ $examUrls['magicBandUrl'] }}" data-action="share/whatsapp/share" target="_blank">{!! config("constants.icons.whatsapp-icon") !!}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop
@section('onPageJs')
<script>
    let userId = "{{ getStudentUserId() }}";
    let userRole = "{{ session()->get('profile')['userRoles'][0]['roleName'] }}";
    let assessmentCreation = '';
    let questionQualityPorvided = '';
    let swiftness = '';
    let feedback = '';
    let feedbackMessage = '{{ __("teachers.feedback.feedbackMessage") }}';

    window.setTimeout(function() {
        $('.feedback-panel').addClass('f-panel-slide');
    }, 1000);
    $(".hide-feedback").click(function() {
        $(".feedback-panel").removeClass("f-panel-slide");
    });

    $(document).on('click', '.ft-feedback-sent', function() {
        assessmentCreation = $('input[name="rating1"]:checked').val() != undefined ? $('input[name="rating1"]:checked').val() : 0;
        questionQualityPorvided = $('input[name="rating2"]:checked').val() != undefined ? $('input[name="rating2"]:checked').val() : 0;
        swiftness = $('input[name="rating3"]:checked').val() != undefined ? $('input[name="rating3"]:checked').val() : 0;
        feedback = $('textarea[name="sendFeedback"]').val();

        if(assessmentCreation > 0 && questionQualityPorvided > 0 && swiftness > 0) {
            appInsights.trackEvent({
                name: 'Feedback',
                properties: {
                    feedback: {
                        ratings: {
                            'assessmentCreation': assessmentCreation,
                            'questionQualityProvided': questionQualityPorvided,
                            'swiftness': swiftness,
                        },
                        'feedback': feedback,
                        'userId': userId,
                        'role': userRole,
                        'from': '{{ config("constants.fastrackFeedbackKey") }}'
                    }
                }
            });

            $('input[name=rating1][type="radio"]').prop('checked', false);
            $('input[name=rating2][type="radio"]').prop('checked', false);
            $('input[name=rating3][type="radio"]').prop('checked', false);
            $('textarea[name="sendFeedback"]').val('');
            $('.close.hide-feedback').click();
            $('.ft-feedback-sent').addClass('disabled');
            msgToast('success', feedbackMessage);
        }
    });

    $(document).on('change', 'input[type="radio"], textarea', function (){
        assessmentCreation = $('input[name="rating1"]:checked').val() != undefined ? $('input[name="rating1"]:checked').val() : 0;
        questionQualityPorvided = $('input[name="rating2"]:checked').val() != undefined ? $('input[name="rating2"]:checked').val() : 0;
        swiftness = $('input[name="rating3"]:checked').val() != undefined ? $('input[name="rating3"]:checked').val() : 0;
        feedback = $('textarea[name="sendFeedback"]').val();
        if(assessmentCreation > 0 && questionQualityPorvided > 0 && swiftness > 0) {
            $('.ft-feedback-sent').removeClass('disabled');
        } else {
            if( $('.ft-feedback-sent').hasClass('disabled') == false ) {
                $('.ft-feedback-sent').addClass('disabled');
            }
        }
    });

    $(document).on("click", ".shareIcon", function(){
        $("#copy").modal();
    });

</script>
@stop