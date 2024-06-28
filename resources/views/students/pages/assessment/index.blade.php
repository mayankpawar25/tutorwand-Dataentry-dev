@extends('students.layouts.default')
@section('title', "Feedback")
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="canvas-area-full">

                <div class="canvas-inner">

                    <div class="tab-panel-box ">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="in-progress-tab" data-toggle="tab" href="#in-progress" role="tab" aria-controls="home" aria-selected="true">{{ __('students.assessments.dueLabel')}} <span class="badge inProgressCount">{{ isset($assessments['NotStarted']) ? count($assessments['NotStarted']) : '0' }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="attempted-tab" data-toggle="tab" href="#attempted" role="tab" aria-controls="sample" aria-selected="false">{{ __('students.assessments.done')}} <span class="badge attemptedCount">{{ isset($assessments['Submitted']) ? count($assessments['Submitted']) : '0' }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="missing-tab" data-toggle="tab" href="#missing" role="tab" aria-controls="sample" aria-selected="false">{{ __('students.assessments.missing')}} <span class="badge missingCount">{{ isset($assessments['Expired']) ? count($assessments['Expired']) : '0' }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="upcoming-tab" data-toggle="tab" href="#upcoming" role="tab" aria-controls="sample" aria-selected="false">{{ __('students.assessments.upcoming')}} <span class="badge upcomingCount">{{ isset($assessments['UpComing']) ? count($assessments['UpComing']) : '0' }}</span></a>
                            </li>

                        </ul>
                        <div class="filter-box">
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <select class="selectpicker form-control" id="subjectFilter" title="Filter by Subject">
                                            <option value="">{{ __('students.assessments.selectAll') }}</option>
                                            @if(isset($studentQuestionPaper['subjects']) && !empty($studentQuestionPaper['subjects']))
                                            @foreach($studentQuestionPaper['subjects'] as $subject)
                                            <option>{{ $subject }}</option>
                                            @endforeach
                                            @endif
                                        </select>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="in-progress" role="tabpanel" aria-labelledby="in-progress-tab">
                                @if(isset($assessments['NotStarted']) && !empty($assessments['NotStarted']))
                                    @foreach($assessments['NotStarted'] as $assessment)
                                        <div class="card" data-subject="{{ $assessment['header']['subject']['subjectName'] }}" data-status="inprogress">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon">
                                                            {!! config('constants.icons.add-response') !!}
                                                        </div>
                                                        <div class="sub-name">
                                                            <a href="{{ route( 'students.instructions', $assessment['id']) }}" target="_blank">{{ $assessment['assessmentName'] }}</a>
                                                            <p title="{{ $assessment['header']['subject']['subjectName'] }} | {{ sprintf(__('students.assessments.due'), localTimeZone($assessment['header']['dueByDateTime'])) }}">{{ $assessment['header']['subject']['subjectName'] }} | {{ sprintf(__('students.assessments.due'), localTimeZone($assessment['header']['dueByDateTime'])) }}
                                                            </p>
                                                        </div>
                                                        @if(isset($assessment['examStatus']) && $assessment['examStatus'] == "NotStarted")
                                                        @php
                                                        $time = getRemainingTime($assessment['header']['dueByDateTime']);
                                                        @endphp
                                                        @endif

                                                        @if(isset($time['hours']) && $time['hours'] > 0)
                                                        <div class="status-hour">
                                                            <i class="fa fa-circle  blink"></i> {{ $time['hours'] }} {{ __('students.assessments.hours') }} {{ __('students.assessments.left') }}
                                                        </div>
                                                        @endif
                                                        @if(isset($time['minutes']))
                                                        <div class="status-min">
                                                            <i class="fa fa-circle  blink"></i> {{ $time['minutes'] }} {{ __('students.assessments.minutes') }} {{ __('students.assessments.left') }}
                                                        </div>
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card-action-box">

                                                        <div class="time">
                                                            {{ $assessment['header']['testDuration'] }}
                                                            <small>
                                                                {{ __('students.assessments.shortMin') }}
                                                            </small>
                                                        </div>
                                                        <div class="input-group w-120 point-input mr-2 green">
                                                            <input type="text" class="form-control mx-width-50" placeholder="-" aria-label="-" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">{{ $assessment['header']['maximumMarks'] }}</span>
                                                            </div>
                                                            <div class="auto-grade-lable">{{ __('students.outOfScore') }} </div>
                                                        </div>
                                                        <a href="{{ route( 'students.instructions', $assessment['id']) }}" class="btn btn-primary auto-width" target="_blank">{{ __('students.start') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="card blankCard" style="display:none">
                                        {{ __('students.assessments.nodataAvailable') }}
                                    </div>
                                @else
                                    <div class="card blankCard">
                                        {{ __('students.assessments.nodataAvailable') }}
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="attempted" role="tabpanel" aria-labelledby="attempted-tab">
                                @if(isset($assessments['Submitted']) && !empty($assessments['Submitted']))
                                    @foreach($assessments['Submitted'] as $assessment)
                                        <div class="card" data-subject="{{ $assessment['header']['subject']['subjectName'] }}" data-status="attempted">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon">
                                                            {!! config('constants.icons.add-response') !!}
                                                        </div>
                                                        <div class="sub-name">
                                                            <a href="#">{{ $assessment['assessmentName'] }}</a>
                                                            <p title="{{ $assessment['header']['subject']['subjectName'] }} {{ isset($assessment['gradedMarks']) && $assessment['gradedMarks'] > 0 ? '| ' . sprintf(__('students.assessments.resultPublishOn'), localTimeZone($assessment['resultPublishedOn'])) : '' }}">{{ $assessment['header']['subject']['subjectName'] }} {{ isset($assessment['gradedMarks']) && $assessment['gradedMarks'] > 0 ? '| ' . sprintf(__('students.assessments.resultPublishOn'), localTimeZone($assessment['resultPublishedOn'])) : '' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card-action-box">

                                                        <div class="time">{{ $assessment['header']['testDuration'] }}
                                                            <small>{{ __('students.assessments.shortMin') }}</small>
                                                        </div>
                                                        <div class="input-group w-120 point-input green mr-2">
                                                            <input type="text" class="form-control mx-width-50" placeholder="-" aria-label="-" value="{{ isset($assessment['gradedMarks']) && $assessment['gradedMarks'] > 0 ? $assessment['gradedMarks'] : '' }}" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">{{ $assessment['header']['maximumMarks'] }}</span>
                                                            </div>
                                                            <div class="auto-grade-lable">{{ __('students.outOfScore') }} </div>
                                                        </div>
                                                        @php
                                                            $buttonDisabled = "disabled";
                                                            $url = "#";
                                                        @endphp
                                                        @if(isset($assessment['isAutoEvaluation']) && $assessment['isAutoEvaluation'])
                                                            @php
                                                                $url = route('students.assessment.report-result', base64_encode($assessment['id']));
                                                                $buttonDisabled = "";
                                                            @endphp
                                                        @endif

                                                        @if(isset($assessment['gradedMarks']) && $assessment['gradedMarks'] > 0)
                                                        @php
                                                            $url = route('students.assessment.report', base64_encode($assessment['id'].'_'.$assessment['classRoomId']));
                                                            $buttonDisabled = "";
                                                        @endphp
                                                        @endif
                                                        @if($assessment['isGlobalEvent'] == 1)
                                                            @php
                                                                $url = "#";
                                                                $buttonDisabled = "disabled";
                                                                if($assessment['gradedMarks'] > 0) {
                                                                    $url = route('students.class.subject.report', base64_encode($assessment['id']));
                                                                    $buttonDisabled = "";
                                                                }
                                                            @endphp
                                                        @endif
                                                        <a href="{{ $url }}" class="btn btn-primary auto-width {{ $buttonDisabled }}" target="_blank">{{ __('students.report') }}</a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="card blankCard" style="display:none">
                                        {{ __('students.assessments.nodataAvailable') }}
                                    </div>
                                @else
                                <div class="card blankCard">
                                    {{ __('students.assessments.nodataAvailable') }}
                                </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="missing" role="tabpanel" aria-labelledby="missing-tab">
                                @if(isset($assessments['Expired']) && !empty($assessments['Expired']))
                                    @foreach($assessments['Expired'] as $assessment)
                                        <div class="card" data-subject="{{ $assessment['header']['subject']['subjectName'] }}" data-status="missing">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon">
                                                            {!! config('constants.icons.add-response') !!}
                                                        </div>
                                                        <div class="sub-name">
                                                            <a href="#">{{ $assessment['assessmentName'] }}</a>
                                                            <p title="{{ $assessment['header']['subject']['subjectName'] }} | {{ sprintf(__('students.assessments.due'), localTimeZone($assessment['header']['dueByDateTime'])) }}">{{ $assessment['header']['subject']['subjectName'] }} | {{ sprintf(__('students.assessments.due'), localTimeZone($assessment['header']['dueByDateTime'])) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card-action-box">

                                                        <div class="time">
                                                            {{ $assessment['header']['testDuration'] }}
                                                            <small>
                                                                {{ __('students.assessments.shortMin') }}
                                                            </small>
                                                        </div>
                                                        <div class="input-group w-120 point-input green">
                                                            <input type="text" class="form-control mx-width-50" placeholder="-" aria-label="-" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">{{ $assessment['header']['maximumMarks'] }}</span>
                                                            </div>
                                                            <div class="auto-grade-lable">{{ __('students.outOfScore') }} </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="card blankCard" style="display:none">
                                        {{ __('students.assessments.nodataAvailable') }}
                                    </div>
                                @else
                                    <div class="card blankCard">
                                        {{ __('students.assessments.nodataAvailable') }}
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                                @if(isset($assessments['UpComing']) && !empty($assessments['UpComing']))
                                    @foreach($assessments['UpComing'] as $assessment)
                                        <div class="card" data-subject="{{ $assessment['header']['subject']['subjectName'] }}" data-status="upcoming">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon">
                                                            {!! config('constants.icons.add-response') !!}
                                                        </div>
                                                        <div class="sub-name">
                                                            <a href="#">{{ $assessment['assessmentName'] }}</a>
                                                            <p title="{{ $assessment['header']['subject']['subjectName'] }} | {{ sprintf(__('students.assessments.start'), localTimeZone($assessment['header']['startDateTime'])) }}">{{ $assessment['header']['subject']['subjectName'] }} | {{ sprintf(__('students.assessments.start'), localTimeZone($assessment['header']['startDateTime'])) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card-action-box">

                                                        <div class="time">
                                                            {{ $assessment['header']['testDuration'] }}
                                                            <small>
                                                                {{ __('students.assessments.shortMin') }}
                                                            </small>
                                                        </div>
                                                        <div class="input-group w-120 point-input green">
                                                            <input type="text" class="form-control mx-width-50" placeholder="-" aria-label="-" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">{{ $assessment['header']['maximumMarks'] }}</span>
                                                            </div>
                                                            <div class="auto-grade-lable">{{ __('students.outOfScore') }} </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="card blankCard" style="display:none">
                                        {{ __('students.assessments.nodataAvailable') }}
                                    </div>
                                @else
                                <div class="card blankCard">
                                    {{ __('students.assessments.nodataAvailable') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="canvas-footer">
                    </div>
                </div>

            </div>

        </div>
        <!-- row end -->
    </div>
</div>
@endsection