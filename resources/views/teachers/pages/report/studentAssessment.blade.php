@extends('teachers.layouts.report')
@section('content')
    <div class="canvas-inner position-relative ">
        <div class="container-fluid">
            <div class="canvas-body">
                <div class="top-cards">
                    <div class="row g-2">
                        <input type="hidden" name="studentId" value="{{ isset($studentAssessmentReport['performance']['studentId']) ? $studentAssessmentReport['performance']['studentId'] : '0' }}">
                        <input type="hidden" name="responseId" value="{{ isset($studentAssessmentReport['performance']['studentResponseId']) ? $studentAssessmentReport['performance']['studentResponseId'] : '0' }}">
                        <input type="hidden" name="assessmentId" value="{{ isset($studentAssessmentReport['assessment']['assessmentId']) ? $studentAssessmentReport['assessment']['assessmentId'] : '0' }}">

                        <div class="col-md-3 text-center">
                            <div class="well ">
                                <div class="student-icon-card">
                                    @if(isset($studentAssessmentReport['performance']['profileUrl']) && !empty($studentAssessmentReport['performance']['profileUrl']))
                                        <img src="{!! handleProfilePic($studentAssessmentReport['performance']['profileUrl']) !!}">
                                    @else
                                        <img src="{{ asset('assets/images/teachers/user-icon.jpg') }}">
                                    @endif
                                </div>
                                <h5 class="mt-2  f-w600"> {{ isset($studentAssessmentReport['performance']['studentName']) && !empty($studentAssessmentReport['performance']['studentName']) ? $studentAssessmentReport['performance']['studentName'] : 'Student Name' }} </h5>
                                <h5 class="">{{ __('teachers.report.board') }}: {{ $studentAssessmentReport['performance']['board']['boardName'] }} | {{ __('teachers.assessment.grade') }}: {{ $studentAssessmentReport['performance']['grade']['gradeName'] }}</h5>
                                <h5 class="mb-1">{{ __('teachers.assessment.subject') }}: {{ $studentAssessmentReport['performance']['subject']['subjectName'] }}</h5>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="well point-card mb-3 pt-3 pb-3 ">
                                <div class="icon">{!! config('constants.icons.points-icon') !!}</div>
                                <div class="point-count">
                                    <h3><span>{{ __('teachers.report.points') }}</span>
                                        <font class="counter-count">{{ $studentAssessmentReport['performance']['optainedMark'] }}</font>/{{ $studentAssessmentReport['performance']['maximumMark'] }}</h3>
                                </div>
                            </div>
                            <div class="well rank-card pt-3 pb-3">
                                <div class="icon">
                                    {!! config('constants.icons.rank-icon') !!}
                                </div>
                                <div class="rank-count">
                                    <h3><span>{{ __('teachers.report.rank') }}</span> {{ $studentAssessmentReport['performance']['rank'] }}
                                        <font>/{{ isset($assessmentReport['totalAttemptedStudent']) ? $assessmentReport['totalAttemptedStudent'] : $studentAssessmentReport['performance']['totalNumberOfStudent'] }}</font>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="well time-card mb-3 pt-3 pb-3">
                                <div class="icon">
                                    {!! config('constants.icons.time-icon') !!}
                                </div>
                                <div class="time-count">
                                    <h3><span>{{ __('teachers.report.time') }} </span>
                                        <font>{{ convertTimeFormat($studentAssessmentReport['performance']['timeTaken']) }}</font>{{ ($studentAssessmentReport['performance']['maximumDuration'] > 0) ? '/'.$studentAssessmentReport['performance']['maximumDuration'] : '' }}
                                    </h3>
                                </div>
                            </div>
                            <div class="well badges-card pt-3 pb-3 ">
                                <div class="icon">
                                    {!! config('constants.icons.badges-icon') !!}
                                </div>
                                <div class="badges-count">
                                    <div class="badges-count-outer">
                                        <div class="badges-name">{{ __('teachers.report.badges') }}</div>
                                        <div class="badges-svg">
                                            <div class="badges-icon">
                                                <span class="badge badge-primary">{{ isset($studentAssessmentReport['performance']['badges'][0]['count']) ? $studentAssessmentReport['performance']['badges'][0]['count'] : 0 }}</span>
                                                <span class="coloured">{!! config('constants.icons.excellent-icon') !!}</span>
                                            </div>
                                            <div class="badges-icon">
                                                <span class="badge badge-primary">{{ isset($studentAssessmentReport['performance']['badges'][1]['count']) ? $studentAssessmentReport['performance']['badges'][1]['count'] : 0 }}</span>
                                                <span class="coloured">{!! config('constants.icons.perfect-icon') !!}</span>
                                            </div>
                                            <div class="badges-icon">
                                                <span class="badge badge-primary">{{ isset($studentAssessmentReport['performance']['badges'][2]['count']) ? $studentAssessmentReport['performance']['badges'][2]['count'] : 0 }}</span>
                                                <span class="coloured">{!! config('constants.icons.verycreative-icon') !!}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="well circle-card">
                                <div class="progressbar">
                                    <div class="second circle" data-percent="{{ round(($studentAssessmentReport['performance']['optainedMark']*100) / $studentAssessmentReport['performance']['maximumMark']) }}">
                                        <strong></strong>
                                        <span>{{ __('teachers.report.average') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="tab-panel-box ">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="summary" aria-selected="true">{{ __('teachers.report.summary') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="answer-tab" data-toggle="tab" href="#answer" role="tab" aria-controls="answer" aria-selected="false">{{ __('teachers.report.answerSheet') }}</a>
                                </li>
                        
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="mt-2 mb-2">{{ __('teachers.report.questionWisePerformance') }}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="q-performance-legend">
                        
                                                <div class="legend-lable">
                                                    <div class="q-correct"></div>
                                                    {{ __('teachers.report.correct') }}
                                                </div>
                                                <div class="legend-lable">
                                                    <div class="q-incorrect"></div>
                                                    {{ __('teachers.report.incorrect') }}
                                                </div>
                                                <div class="legend-lable">
                                                    <div class="q-manual"></div>
                                                    {{ __('teachers.report.manual') }}
                                                </div>
                                                <div class="legend-lable">
                                                    <div class="q-skipped"></div>
                                                    {{ __('teachers.report.skipped') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="question-card-outer mb-3">
                                        <ul>
                                            @foreach ($studentAssessmentReport['questionWisePerformance'] as $key => $questions)
                                                @php
                                                    switch($questions['status']) {
                                                        case 'Correct':
                                                            $qCountClass =  'correct';
                                                            break;
                                                        case 'Incorrect':
                                                            $qCountClass =  'wrong';
                                                            break;
                                                        case 'Skipped':
                                                            $qCountClass =  'skipped';
                                                            break;
                                                        default:
                                                            $qCountClass =  'correct';
                                                    }
                        
                                                    $autogradedArray = [config("constants.mcqId"), config("constants.trueFalseId"), config("constants.fibId")];
                                                    if( in_array($questions['questionType'], $autogradedArray) ) {
                                                        $totalStudents = isset($assessmentReport['totalAttemptedStudent']) ? $assessmentReport['totalAttemptedStudent'] : $studentAssessmentReport['performance']['totalNumberOfStudent'];
                                                        $label = __('teachers.report.classAccuracy');
                                                        $score = $questions['correctedCount'] . ' / ' . $totalStudents;
                                                    } else {
                                                        $label = __('teachers.report.classAverage');
                                                        $score = number_format($questions['classAverage'], 2);
                                                        $qCountClass = 'manual';
                                                    }
                                                @endphp
                                                <li class="{{ $key > 9 ? 'd-none' : '' }}">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="q-count {{ $qCountClass }}">{{ $key+1 }}</div>
                                                        <div class="w-120">
                                                            <div class="input-group point-input">
                                                                <input type="text" class="form-control mx-width-50" placeholder="{{ $questions['optainedMark'] }}" aria-label="{{ $questions['optainedMark'] }}" disabled>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">{{ $questions['maximumMark'] }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <small>{{ getTemplateName($questions['questionType']) }}</small>
                                                    <hr>
                                                    <p class="mb-0"> {{ $label }}: <span class="badge badge-info">{{ $score }}</span></p>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @if ($key > 9)
                                            <a href="#" class="btn-link float-right showall">{{ __('teachers.report.showAll') }}</a>
                                        @endif
                                    </div>
                                        
                                    <div class="clearfix"></div>

                                    <!-- topic -->
                                    <div class="row topicWisePerformance d-none">
                                        <div class="col-md-12"><h5 class="mb-2 graph-title">{{ __('teachers.report.topicWisePerformance') }} </h5></div>
                                        <div class="col-md-12">
                                            <div class="well">
                                               
                                                <textarea class="graph-data d-none">{{ json_encode($studentAssessmentReport['topicWisePerformace']) }}</textarea>
                                                <canvas id="canvas" height="120" width="600"></canvas>
                                                <div class="text-right">
                                                    <button class="btn btn-outline-primary btn-auto d-none" id="previous-topic-chart" data-id="0"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                                                    <button class="btn btn-outline-primary btn-auto d-none" id="next-topic-chart" data-id="0"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- subtopic -->
                                    <div class="row subtopicWisePerformance d-none">
                                        <div class="col-md-12"><h5 class="mb-2 subtopic-title d-none">{{ __('teachers.report.subtopicWisePerformance') }} </h5></div>
                                        <div class="col-md-12">
                                            <div class="well">
                                                <canvas id="canvas2" height="120" width="600"></canvas>
                                                <div class="text-right">
                                                    <button class="btn btn-outline-primary btn-auto d-none" id="previous-subtopic-chart" data-id="0"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                                                    <button class="btn btn-outline-primary btn-auto d-none" id="next-subtopic-chart" data-id="0"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                                                    <button class="btn btn-outline-primary btn-auto d-none" id="close-subtopic-chart" >
                                                        {!! config('constants.icons.close-icon') !!}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="tab-pane fade" id="answer" role="tabpanel" aria-labelledby="answer-tab">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("onPageJs")
    @include('teachers.pages.report.scripts')
@endsection
