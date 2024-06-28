@extends('students.layouts.default')
@section('title', "Dashboard")
@section('content')
<div class="container-fluid">
    <div class="value-prop-slider">
        <div class="owl-carousel owl-theme" id="owl-carousel4">
            <div class="item">
                <div class="ft-creat-slide-outer item-flex">
                    <div class="img-sec">
                        <img src="{{ asset('assets/images/students/vp-exam.png') }}" alt="Tutor Wand">
                    </div>
                    <div class="content-section">
                        <h4>{{__('students.dashboard.exam')}}</h4>
                        <p>{{__('students.dashboard.examDescription')}}</p>
                        <a href="{{ route('students.assessment') }}" class="btn btn-primary btn-sm btn-auto">{{ __('students.assessment') }}</a>
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
                        <img src="{{ asset('assets/images/students/vp-std-report.png') }}" alt="Tutor Wand">
                    </div>
                    <div class="content-section">
                        <h4>{{__('students.dashboard.reports')}}</h4>
                        <p>{{__('students.dashboard.reportDescription')}}</p>
                        <a href="{{ route('students.report.home') }}" class="btn btn-primary btn-sm btn-auto">{{ __('students.dashboard.reports') }}</a>
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
    <div class="row mt-4 mb-4">
        <div class="col-md-6">
            <h4>{{__('students.dashboard.classes')}}
                <span class="replace-icon d-none">
                    <i class="fa fa-refresh pageRefresh cursor-pointer" aria-hidden="true"></i>
                </span>
            </h4>
            <div id="classroomList">
                <div id="loader-wrapper-dashboard">
                    <div id="loader1"> {!! config('constants.icons.loader-icon') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h4>{{__('students.dashboard.toDo')}}</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="todo-list-outer">
                        <h5 class="mb-1">{{__('students.dashboard.dueToday')}}</h5>
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
                        <h5 class="mb-1">{{__('students.dashboard.result')}}</h5>
                        <hr>
                        <span id="result">
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
@endsection
@section('onPageJs')
    <script type="text/javascript">
        let getClassRoomURL = "{{ route('students.ajax.classroom.list') }}";
        let getAssessmentURL = "{{ route('students.ajax.assessment.list') }}";
        let refreshClassURL = "{{ route('students.refresh.class.list') }}";
    </script>
    <script type="text/javascript" src="{{ asset('assets/students/js/dashboard.js') }}"></script>
@endsection