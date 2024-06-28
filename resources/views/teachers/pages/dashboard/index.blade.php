@extends('teachers.layouts.default')
@section('content')

<div class="row">
    @if(isset($globalEvents) && !empty($globalEvents))
        @foreach($globalEvents as $key => $event)
            <div class="col-md-4  eventCard{{ $key+1 }}">
                <div class="value-prop-slider">
                    <div class="board-creat-slide-outer item-flex">
                        <div class="img-sec">
                            <img src="{{ asset('assets/images/teachers/board-card.png') }}" alt="Tutor Wand">
                        </div>
                        <div class="content-section">
                            <h4>{{ $event['eventName'] }}</h4>
                            <p>{{ $event['eventDescription'] }}</p>
                            <a href="{{ route('boardPreparation') }}" class="btn btn-primary btn-sm btn-auto">{{ __('teachers.assessment.create') }}</a>
                            <button data-toggle="modal" data-target="#videoModal" data-src="https://www.youtube.com/embed/sseoz6bYZDY" class="video-btn btn btn-outline-primary btn-sm btn-auto pl-2 pr-2 ml-2 d-none">
                                <i class="" data-toggle="tooltip" title="{{ __('teachers.assessment.takeATour') }}">
                                    {!! config('constants.icons.tour-icon') !!}
                                </i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    @php
        $colVal = 12;
        $totalEvt = 0;
        if(isset($globalEvents) && !empty($globalEvents)){
            $totalEvt = count($globalEvents);
            $colVal = $colVal - (($totalEvt % 3) * 4);
        }
    @endphp
    <div class="col-md-{{ $colVal }}">
        <div class="value-prop-slider">
            <div class="owl-carousel owl-theme" id="owl-carousel2">
                <div class="item">
                    <div class="ft-creat-slide-outer item-flex">
                        <div class="img-sec">
                            <img src="{{ asset('assets/images/teachers/vp-ft-create.png') }}" alt="Tutor Wand">
                        </div>
                        <div class="content-section">
                            <h4>{{ __('teachers.dashboard.createAssessment') }}</h4>
                            <p>{{ __('teachers.dashboard.createAssessmentText') }}</p>
                            <a href="{{ route('fastrack') }}" class="btn btn-primary btn-sm btn-auto">{{ __('teachers.assessment.create') }}</a>
                            <button data-toggle="modal" data-target="#videoModal" data-src="https://www.youtube.com/embed/sseoz6bYZDY" class="video-btn btn btn-outline-primary btn-sm btn-auto pl-2 pr-2 ml-2 d-none">
                                <i class="" data-toggle="tooltip" title="{{ __('teachers.assessment.takeATour') }}">
                                    {!! config('constants.icons.tour-icon') !!}
                                </i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="grading-slide-outer item-flex">
                        <div class="img-sec">
                            <img src="{{ asset('assets/images/teachers/vp-grading.png') }}" alt="Tutor Wand">
                        </div>
                        <div class="content-section">
                            <h4>{{ __('teachers.dashboard.grading') }}</h4>
                            <p>{{ __('teachers.dashboard.gradingText') }}</p>
                            <a href="{{ route('grading.assessments.home') }}" class="btn btn-primary btn-sm btn-auto">{{ __('teachers.assessment.grade') }}</a>
                            <button data-toggle="modal" data-target="#videoModal" data-src="https://www.youtube.com/embed/sseoz6bYZDY" class="video-btn btn btn-outline-primary btn-sm btn-auto pl-2 pr-2 ml-2 d-none">
                                <i class="" data-toggle="tooltip" title="{{ __('teachers.assessment.takeATour') }}">
                                    {!! config('constants.icons.tour-icon') !!}
                                </i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="report-slide-outer item-flex">
                        <div class="img-sec">
                            <img src="{{ asset('assets/images/teachers/vp-report.png') }}" alt="Tutor Wand">

                        </div>
                        <div class="content-section">
                            <h4>{{ __('teachers.dashboard.reports') }}</h4>
                            <p>{{ __('teachers.dashboard.reportsText') }}</p>
                            <a href="{{ route('report.home') }}" class="btn btn-primary btn-sm btn-auto">{{ __('teachers.dashboard.reports') }}</a>
                            <button data-toggle="modal" data-target="#videoModal" data-src="https://www.youtube.com/embed/sseoz6bYZDY" class="video-btn btn btn-outline-primary btn-sm btn-auto pl-2 pr-2 ml-2 d-none">
                                <i class="" data-toggle="tooltip" title="{{ __('teachers.assessment.takeATour') }}">
                                    {!! config('constants.icons.tour-icon') !!}
                                </i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-6">
        <h4>{{ __('teachers.dashboard.classes') }}
            <span class="replace-icon d-none">
                <i class="fa fa-refresh pageRefresh cursor-pointer" aria-hidden="true"></i>
            </span>
        </h4>
        <div id="classlists">
            <ul class="classroom-listing">
                <li>
                    <a href="{{ route('class.create') }}" class="text-brand">
                        <div class="icon-box">
                            {!! config('constants.icons.plus-icon') !!}
                        </div>
                        <div class="content-box">
                            <h4 class="mt-2">{{ __('teachers.class.createClass') }}</h4>
                        </div>
                    </a> 
                </li>
            </ul>
            <div id="loader-wrapper-dashboard">
                <div id="loader1"> {!! config('constants.icons.loader-icon') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h4>{{ __('teachers.dashboard.toDo') }}</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="todo-list-outer">
                    <h5 class="mb-1">{{ __('teachers.dashboard.dueToday') }}</h5>
                    <hr>
                    <span id="todayDue">
                        <div id="loader-wrapper-dashboard">
                            <div id="loader1"> {!! config('constants.icons.loader-icon') !!}
                            </div>
                        </div>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="todo-list-outer">
                    <h5 class="mb-1">{{ __('teachers.dashboard.previousDue') }}</h5>
                    <hr>
                    <span id="previousDue">
                        <div id="loader-wrapper-dashboard">
                            <div id="loader1"> {!! config('constants.icons.loader-icon') !!}
                            </div>
                        </div>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- create modal -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" tabindex="1" role="button">
                    {!! config('constants.icons.close-icon') !!}
                </button>
                <!-- 16:9 aspect ratio -->
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="" id="videoplayer" allowfullscreen allowscriptaccess="always" allow="autoplay"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- create modal -->
<!-- classroom alert modal -->
<div class="modal" id="createClassModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ __('teachers.class.createClass') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    {!! config('constants.icons.close-icon') !!}
                </button>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div class="col-sm-12">
                    <img src="{{ asset('assets/images/teachers/class-empty.jpg') }}" class="w-100" alt="Tutor Wand">
                    
                    <div class="text-center">
                    <h4 class="mt-4 mb-4">Looks like you don't have any class yet. <br>Please create a class to get started.</h4>
                        <a href="{{ route('class.create') }}" class="btn btn-primary"> <i class="left mt--4">{!! config('constants.icons.plus-icon') !!}</i>  {{ __('teachers.class.createClass') }}</a>
                    </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- modal end -->
@endsection

@section('onPageJs')
    <script type="text/javascript">
        let getClassRoomURL = "{{ route('ajax.classroom.list') }}";
        let getAssessmentURL = "{{ route('ajax.assessment.list') }}";
        let refreshClassURL = "{{ route('ajax.refresh.class.list') }}";
        let activeBoard = "{{ isset($globalEvents) && !empty($globalEvents) ? 'true' : 'false' }}";
        let totalEvt = "{{ $totalEvt }}";
    </script>
    <script type="text/javascript" src="{{ asset('assets/teachers/js/dashboard.js') }}"></script>
    <script>
        $(document).on('click', '.launchPopup', function() {
            let w = 600;
            let h = 600;
            let left = (screen.width/2)-(w/2);
            let top = (screen.height/2)-(h/2);
            let url = $(this).attr('data-url');
            let title = 'Google Classroom';
            return popup = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
        });
    </script>
@endsection