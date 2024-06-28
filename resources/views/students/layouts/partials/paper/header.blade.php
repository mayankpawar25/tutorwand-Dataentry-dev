<div class="main-header">
    <div class="header-bg-strip">
        <div class="container-fluid">
            <div class="header-left">
            <span  class="mob-logo d-block d-lg-none d-md-none">
                <img src="{{ asset('assets/images/students/logo-sm.svg')}}" class="small-logo">
                </span>
                <a class="navbar-brand "><img src="{{ asset('assets/images/students/logo-sm.svg') }}" class="small-logo"></a>
                <button class="btn btn-outline-primary-v2 font-btn btn-lg pull-right font-change-ic" data-toggle="tooltip" data-placement="bottom" title="{{ __('students.fontResize') }}">
                    {!! html_entity_decode(Config('constants.icons.font-size-svg')) !!}
                </button>
                
                @php
                    $displayNone = "";
                @endphp
                @if($questionData['header']['isUntimed'] == "false")
                    @php
                        $displayNone = "d-none";
                    @endphp
                @endif
                    <button class="btn btn-outline-primary-v2 btn-lg mr-2 pull-right clock active {{ $displayNone }}">
                        <span class="time" id="timer"></span>
                        <span class="time-left">{{ __('students.timeLeft') }}</span> <i class="fa fa-eye time-on" aria-hidden="true"></i> <i class="fa fa-low-vision time-of" aria-hidden="true"></i> 
                    </button>
            </div>
            <div class="header-right">
                <div class="my-lg-0">
                    <button class="btn btn-outline-primary-v2 btn-lg mr-2" data-toggle="modal" data-target="#full-paper">
                        <i class="fa left fa-file-text-o" aria-hidden="true"></i><span class="m-btn-text-none"> {{ __('students.viewFullPaper') }}</span>
                    </button>
                    <button class="btn btn-primary-v2 btn-lg pull-right finishBtn SubmitAndReviewScreen"><i class="fa fa-flag-checkered left" aria-hidden="true"></i>{{ __('students.finish') }}</button>

                    <button class="btn btn-primary-v2 btn-lg pull-right submitBtn SubmitAndReviewScreen" style="display:none;"><i class="fa fa-paper-plane left" aria-hidden="true"></i>{{ __('students.submit') }}</button>

                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid end -->
</div>
