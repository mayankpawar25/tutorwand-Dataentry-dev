@extends('teachers.layouts.home')
@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12 col-lg-12">

            <div class="canvas-area-full">

                <div class="canvas-inner">

                    <div class="tab-panel-box ">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="in-progress-tab" data-toggle="tab" href="#in-progress" role="tab" aria-controls="home" aria-selected="true">{{ __('teachers.grading.inGrading') }} <span class="badge in-progress-tab">{{ isset($assessments['Due']) ? count($assessments['Due']) : 0 }}</span></a>
                            </li>
                            <li class="nav-item d-none">
                                <a class="nav-link" id="attempted-tab" data-toggle="tab" href="#attempted" role="tab" aria-controls="sample" aria-selected="false">{{ __('teachers.grading.overDue') }} <span class="badge attempted-tab">{{ isset($assessments['OverDue']) ? count($assessments['OverDue']) : 0 }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="missing-tab" data-toggle="tab" href="#missing" role="tab" aria-controls="sample" aria-selected="false">{{ __('teachers.grading.graded') }} <span class="badge missing-tab">{{ isset($assessments['Graded']) ? count($assessments['Graded']) : 0 }}</span></a>
                            </li>
                        </ul>
                        <div class="filter-box">
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="selectpicker form-control" id="grade-filter" title="{{ __('teachers.grading.allClasses') }}">
                                            <option value="">{{ __('teachers.grading.allClasses') }}</option>
                                            @if (isset($grades) && !empty($grades))
                                            @foreach ($grades as $grade)
                                            <option>{{ $grade }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="selectpicker form-control" id="subject-filter" title="{{ __('teachers.grading.allSubjects') }}">
                                            <option value="">{{ __('teachers.grading.allSubjects') }}</option>
                                            @if (isset($subjects) && !empty($subjects))
                                            @foreach ($subjects as $subject)
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
                                @if (isset($assessments['Due']) && !empty($assessments['Due']))
                                @foreach ($assessments['Due'] as $assessment)
                                <div class="card" data-subject="{{ $assessment['subject'] }}" data-grade="{{ $assessment['grade'] }}" data-status="in-progress">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center">
                                                <div class="icon">
                                                    {!! config('constants.icons.add-response') !!}
                                                </div>
                                                <div class="sub-name">
                                                    <a href="javascript:void(0)">{{ $assessment['assessmentName'] }}</a>
                                                    <p title="{{ $assessment['board'] }}, {{ $assessment['grade'] }}, {{ $assessment['subject'] }} | {{ __('teachers.grading.due') }} {{ localTimeZone($assessment['dueDateTime']) }}">{{ $assessment['board'] }}, {{ $assessment['grade'] }}, {{ $assessment['subject'] }} | {{ __('teachers.grading.due') }} {{ localTimeZone($assessment['dueDateTime']) }}</p>
                                                </div>
                                                @if (getRemainingTime($assessment['resultDateTime'], 'days') <= 3 ) <div class="status-min d-none">
                                                    <i class="fa fa-circle blink"></i> {{ __('teachers.grading.dueSoon') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-action-box">
                                            <div class="time">
                                                {{ $assessment['testDuration'] }}
                                                <small>
                                                    {{ __('teachers.assessment.min') }}
                                                </small>
                                            </div>
                                            <div class="row-point">
                                                {{ $assessment['maximumMarks'] }}
                                                <small>
                                                    {{ pointText($assessment['maximumMarks']) }}
                                                </small>
                                            </div>

                                            <div class="input-group w-120 point-input mr-2 disabled">
                                                <input type="text" class="form-control mx-width-50 disabled" disabled value="{{ $assessment['gradedStudents'] }}" aria-label="{{ $assessment['gradedStudents'] }}" placeholder="{{ $assessment['gradedStudents'] }}">
                                                <div class="input-group-append ">
                                                    <span class="input-group-text">{{ $assessment['totalStudents'] }}</span>
                                                </div>
                                                <div class="auto-grade-lable">{{ __('teachers.grading.graded') }}</div>
                                            </div>

                                            <a href="{{ route('grading.assessments.board', base64_encode($assessment['assessmentId'])) }}" class="btn btn-primary auto-width">{{ __('teachers.assessment.grade') }}</a>

                                            <div class="more-ellips">
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-tpt dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">

                                                        <a class="dropdown-item d-flex align-items-center" href="{{ route('grading.preview.pdf', $assessment['assessmentId']) }}" target="_blank">{!! config('constants.icons.three-dot') !!} {{ __('teachers.report.questionPaper') }}</a>

                                                        <a class="dropdown-item dropdown-item d-flex align-items-center showShareLink " href="javascript:void(0)" data-href="{{ route('students.instructions', $assessment['assessmentId']) }}" class="" title="Share" data-toggle="modal" data-target="#shareData"> {!! config('constants.icons.share-icon') !!} {{ __('teachers.report.shareLink') }}</a>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center">
                                            {{ __("teachers.grading.noDueAssessment") }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="missing" role="tabpanel" aria-labelledby="missing-tab">
                            @if (isset($assessments['Graded']) && !empty($assessments['Graded']))
                            @foreach ($assessments['Graded'] as $assessment)
                            <div class="card" data-subject="{{ $assessment['subject'] }}" data-grade="{{ $assessment['grade'] }}" data-status="missing">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="icon">
                                                {!! config('constants.icons.add-response') !!}
                                            </div>
                                            <div class="sub-name">
                                                <a href="javascript:void(0)">{{ $assessment['assessmentName'] }}</a>
                                                <p title="{{ $assessment['board'] }}, {{ $assessment['grade'] }}, {{ $assessment['subject'] }} |  {{ __('teachers.grading.result') }} {{ localTimeZone($assessment['resultDateTime']) }}">{{ $assessment['board'] }}, {{ $assessment['grade'] }}, {{ $assessment['subject'] }} | {{ __('teachers.grading.result') }} {{ localTimeZone($assessment['resultDateTime']) }}
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-action-box">
                                            <div class="q-paper-pdf">
                                                <a href="{{ route('grading.preview.pdf', $assessment['assessmentId']) }}" data-toggle="tooltip" title="Question Paper" target="_blank">
                                                    {!! config('constants.icons.question-list-icon') !!}
                                                </a>
                                            </div>
                                            <div class="time">
                                                {{ $assessment['testDuration'] }}
                                                <small>{{ __('teachers.assessment.min') }}</small>
                                            </div>
                                            <div class="row-point">
                                                {{ $assessment['maximumMarks'] }}
                                                <small>{{ pointText($assessment['maximumMarks']) }}</small>
                                            </div>

                                            @if(!empty($assessment['classess']))
                                            @if(count($assessment['classess']) > 1)
                                            <div class="row-report {{ count($assessment['classess']) }}">
                                                <textarea class="d-none">{{ json_encode($assessment['classess']) }}</textarea>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#showReports" class="showReports" data-assessmentid="{{ $assessment['assessmentId'] }}" data-url="{{ route('ajax.pagination.classlist') }}"><span class="d-block" data-toggle="tooltip" title="Reports">
                                                        {!! config('constants.icons.report-icon') !!}
                                                    </span></a>
                                            </div>
                                            @else
                                            <div class="row-report {{ count($assessment['classess']) }}">
                                                @if($assessment['isGlobalEvent'] == 1 && $assessment['isResultPublished'] == 1)
                                                    <a href="{{ route('board.index', base64_encode($assessment['assessmentId'])) }}" data-toggle="tooltip" title="Reports" target="_blank">{!! config('constants.icons.report-icon') !!}</a>
                                                @else
                                                    <a href="{{ route('assessment.report', base64_encode($assessment['assessmentId'] .'_'. $assessment['classess'][0]['classId'])) }}" data-toggle="tooltip" title="Reports" target="_blank">{!! config('constants.icons.report-icon') !!}</a>
                                                @endif
                                            </div>
                                            @endif
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center">
                                            {{ __("teachers.grading.noGradedAssessment") }}
                                        </div>
                                    </div>
                                </div>
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
<!-- container-fluid end -->
</div>
<!-- The Modal -->
<div class="modal" id="showReports">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ __('teachers.dashboard.reports') }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body height-auto">
                <div id="loader-wrapper">
                    <div id="loader1"> {!! config('constants.icons.loader-icon') !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal confirm" id="shareData">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
            <button type="button" class="close" data-dismiss="modal">
                {!! config("constants.icons.close-icon") !!}
            </button>
            <!-- Modal body -->
            <div class="modal-body">
                <h6 class="text-left">{{ __('teachers.feedback.getLink') }}</h6>
                <!-- question type table end -->
                <hr>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="copyclip" value="" id="sharelinkurl2">
                    <div class="input-group-append copyclip">
                        <span class="input-group-text btn-primary mw-auto cursor-pointer" onclick="copyFunction()">{{ __('teachers.feedback.copyLink') }}</span>
                    </div>
                </div>
                <br>
                <p class="text-left d-flex align-items-center">{{ __('teachers.feedback.shareWhatsApp') }}
                    <a href="https://web.whatsapp.com/send?text=" data-action="share/whatsapp/share" target="_blank">
                        {!! config("constants.icons.whatsapp-icon") !!}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection