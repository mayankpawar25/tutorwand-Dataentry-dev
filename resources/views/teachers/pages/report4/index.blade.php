@extends('teachers.layouts.common')
@section('content')
    <div class="row g-2">
        <div class="col-md-3 text-center">
            <div class="well">
                <div class="class-icon">
                    {!! config('constants.icons.class-icon') !!}
                </div>
                <h5 class="mt-2 mb-0 f-w600">{{ $googleClassroomName }}</h5>
                <h5 class="mt-1 mb-0">{{ __('teachers.report.board') }}: {{ $classReportBySubject['board']['boardName'] }} | {{ __('teachers.report.grade') }}: {{ $subjectData['grade']['gradeName'] }}</h5>
                <h5 class="mt-1 mb-0">{{ __('teachers.report.subject') }}: {{ $classReportBySubject['subject']['subjectName'] }}</h5>
                <h5 class="mb-0"><small>{{ __('teachers.report.totalstudents') }}: {{ isset($classReportBySubject['students']) ? count($classReportBySubject['students']) : $totalStudents }}</small></h5>
            </div>
        </div>
        <div class="col-md-3 total-attempt text-center">
            <div class="well pt-4 pb-4">
                <h1 class="mb-1">{{ isset($classReportBySubject['assessmentPerformance']) ? count($classReportBySubject['assessmentPerformance']) : $subjectData['assessmentCount'] }} </h1><br>
                <p>{{ __('teachers.report.totalassesssments') }}</p>
            </div>
        </div>
        <div class="col-md-3">

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h5 class="mb-2">{{ __('teachers.report.assessmentWisePerformance') }}</h5>
        </div>
        <div class="col-md-12">
            <div class="well">
                <textarea class="assessment-graph-data d-none">{{ json_encode($classReportBySubject['assessmentPerformance']) }}</textarea>
                <canvas id="assessmentGraph" height="120" width="600"></canvas>
                <div class="text-right mb-2">
                    <button class="btn btn-outline-primary btn-auto d-none" id="previous-assessment-chart" data-id="0"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                    <button class="btn btn-outline-primary btn-auto d-none" id="next-assessment-chart" data-id="0"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Topic -->
    <div class="row topicWisePerformance d-none">
        <!-- topic -->
        <div class="col-md-12 mt-4">
            <h5 class="mb-2">{{ __('teachers.report.topicWisePerformance') }}</h5>
        </div>

        <div class="col-md-12">
            <div class="well">
                <textarea class="graph-data d-none">{{ json_encode($classReportBySubject['topicWisePerformace']) }}</textarea>
                <canvas id="canvas" height="120" width="600"></canvas>
                <div class="text-right mb-2">
                    <button class="btn btn-outline-primary btn-auto d-none" id="previous-topic-chart" data-id="0"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                    <button class="btn btn-outline-primary btn-auto d-none" id="next-topic-chart" data-id="0"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- subtopic -->
    <div class="row subtopicWisePerformance d-none">
        <div class="col-md-12 mt-4"><h5 class="mb-2 subtopic-title d-none">{{ __('teachers.report.subtopicWisePerformance') }}</h5></div>
        <div class="col-md-12">
            <div class="well">
                <canvas id="canvas2" height="120" width="600"></canvas>
                <div class="text-right mb-2">
                    <button class="btn btn-outline-primary btn-auto d-none" id="previous-subtopic-chart" data-id="0"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                    <button class="btn btn-outline-primary btn-auto d-none" id="next-subtopic-chart" data-id="0"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                    <button class="btn btn-outline-primary btn-auto d-none" id="close-subtopic-chart" >
                        {!! config('constants.icons.close-icon') !!}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tab-panel-box mt-2">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="summary" aria-selected="true">{{ __('teachers.report.studentsList') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="assessment-tab" data-toggle="tab" href="#assessment" role="tab" aria-controls="assessment" aria-selected="false">{{ __('teachers.report.assessmentList') }}</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                        <div class="report-student-list-outer">
                            @if(isset($classReportBySubject['students']) && !empty($classReportBySubject['students']))
                                @foreach($classReportBySubject['students'] as $student)
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon">
                                                        <div class="student-icon">
                                                            <img src="{{ handleProfilePic($student['profileUrl']) }}" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="sub-name">
                                                        <p class="mb-0 pl-2">{{ $student['studentName'] }}</p>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-action-box">
                                                    <div class="rank-badge mr-4 d-none">
                                                        <div class="mt-1">{{ __('teachers.report.rank') }}</div>
                                                        <h2>5</h2>
                                                    </div>
                                                    <div class="w-120 pull-right">
                                                        <div class="input-group point-input">
                                                            <input type="text" class="form-control mx-width-50" placeholder="28" aria-label="-" disabled="" autocomplete="off" value="{{ $student['attemptedAssessment'] }}">          
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">{{ $student['totalAssessment'] }}</span>
                                                            </div>
                                                            <div class="auto-grade-lable updateNewStatus">{{ __('teachers.report.attemptedCount') }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="progressbar ml-4 d-none">
                                                        <div class="student-point circle assessment" data-percent="50">
                                                            <strong></strong>
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                    <p class="mb-0 mr-4 ml-12 d-none">{{ __('teachers.report.average') }}</p>
                                                    <a href="{{ route('assessment.report3' , base64_encode($student['studentId'].'_'.$encryptedId)) }}" class="btn btn-primary auto-width ml-4"><i class="fa fa-eye" aria-hidden="true"></i> {{ __('teachers.button.view') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-4">
                                            {{ __('students.noStudentAvailable') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="assessment" role="tabpanel" aria-labelledby="assessment-tab">
                        <div class="report-student-list-outer">
                            @foreach($classReportBySubject['assessmentPerformance'] as $assessmentData)
                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center">
                                                <div class="icon">
                                                    <div class="student-icon">
                                                        {!! config('constants.icons.add-response') !!}
                                                    </div>
                                                </div>
                                                <div class="sub-name">
                                                    <h5 class="mt-0 mb-1">{{ $assessmentData['assessmentName'] }}</h5>
                                                    @php 
                                                        $resultDate = isset($assessmentData['resultPublishedOn']) && !empty($assessmentData['resultPublishedOn']) ? utcToDateMonth($assessmentData['resultPublishedOn']) : date('d M');
                                                    @endphp
                                                    <p> {{ sprintf(__('teachers.report.resultPublishDate'), $resultDate) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-action-box">
                                                <div class="progressbar ml-4">
                                                    <div class="student-point circle assessment" data-percent="{{ isset($assessmentData['classAverage']) && $assessmentData['maximumMark'] > 0 ? (($assessmentData['classAverage'] * 100) / $assessmentData['maximumMark']) : 0 }}">
                                                        <strong></strong>
                                                        <span></span>
                                                    </div>
                                                </div>
                                                <p class="mb-0 mr-4 ml-12">{{ __('teachers.report.performance') }}</p>
                                                <div class="input-group w-120 point-input mr-2 disabled">
                                                    <input type="text" class="form-control mx-width-50 disabled" disabled="" value="{{ $assessmentData['attemptedCount'] }}" aria-label="0" placeholder="0" autocomplete="off">
                                                    <div class="input-group-append ">
                                                        <span class="input-group-text">{{ $assessmentData['studentCount'] }}</span>
                                                    </div>
                                                    <div class="auto-grade-lable">{{ __('teachers.report.attemptedCount') }}</div>
                                                </div>                                            
                                                <a href="{{ route('assessment.report', base64_encode($assessmentData['assessmentId'] .'_'. $ClassRoomId)) }}" class="btn btn-primary auto-width ml-4"><i class="fa fa-eye" aria-hidden="true"></i> {{ __('teachers.report.view') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("onPageJs")
    <script type="text/javascript">
        let topicWisePerformance = "{{ __('teachers.report.topicWisePerformance') }}";
        let subtopicWisePerformance = "{{ __('teachers.report.subtopicWisePerformance') }}";
        let assessmentWisePerformanceText = `{{ __('teachers.report.assessmentWisePerformance') }}`;
        let graphMax = `{{ config('constants.graphMax') }}`;
        let assessmentPagination = [];
        let currentAssessmentPage = 0;
        let totalAssessmentsSize = "";
    </script>
    <script type="text/javascript" src="{{ asset('assets/teachers/js/reportingGraph.js') }}"></script>
@endsection