@extends('teachers.layouts.report')
@section('content')
    <div class="canvas-inner position-relative ">
        <div class="container-fluid">
            <div class="canvas-body">
                <div class="top-cards">
                    <div class="row g-2">
                        <div class="col-md-3 text-center">
                            <div class="well pt-2 pb-2">
                                <div class="class-icon">{!! config('constants.icons.class-icon') !!}</div>
                                <h5 class="mt-2 mb-0 f-w600">{{ isset($classRoomName) ? $classRoomName : '-' }}</h5>
                                <h5 class="mt-1 mb-0">{{ __('teachers.report.board') }}: {{ $performance['board']['boardName'] }} | {{ __('teachers.report.grade') }}: {{ $performance['grade']['gradeName'] }}</h5>
                                <h5 class="mt-1 mb-0">{{ __('teachers.report.subject') }}: {{ $performance['subject']['subjectName'] }}</h5>
                                <h5 class="mb-0"><small>Total students: {{ $performance['attemptedStudent'] }}/{{ $performance['totalStudent'] }}</small></h5>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="well point-card  mb-3 ">
                                <div class="icon">{!! config('constants.icons.points-icon') !!}</div>
                                <div class="point-count">
                                    <h3><span>{{ __('teachers.report.avgPoint') }} </span><font>{{ (is_numeric( $averagePoints ) && floor( $averagePoints ) != $averagePoints) ? number_format($averagePoints, 1) : $averagePoints }}</font>/{{ $assessmentPoints }}</h3>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="well time-card  ">
                                <div class="icon">{!! config('constants.icons.time-icon') !!}</div>
                                <div class="time-count">
                                    <h3><span>{{ __('teachers.report.avgTimeSpent') }}</span><font>{{ $averageTimeDuration }}</font>{{ ($assessmentDurations > 0) ? '/' . $assessmentDurations : '' }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="well circle-card">
                                <div class="progressbar">
                                    <div class="second circle" data-percent="{{ ($averagePoints > 0) ? ($averagePoints * 100) / $assessmentPoints : 0  }}">
                                        <strong></strong>
                                        <span class="">{{ __('teachers.report.classAverage') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="well circle-card">
                                <div class="progressbar">
                                    <div class="third median circle" data-percent="{{ $performance['median'] }}" data-valuemax="{{ $assessmentPoints }}">
                                        <strong></strong>
                                        <span>{{ __('teachers.report.median') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mt-2 mb-2">{{ __('teachers.report.questionWisePerformance') }}</h5>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="question-card-outer mb-3">
                    <ul>
                        @foreach ($questionWisePerformance as $key => $questions)
                            @php
                                $qCountClass =  'correct';

                                /* switch ($questions['status']) {
                                    case 'Correct':
                                        $qCountClass =  'correct';
                                        break;
                                    case 'InCorrect':
                                        $qCountClass =  'wrong';
                                        break;
                                    case 'Skipped':
                                        $qCountClass =  'skipped';
                                        break;
                                    case 'Correct':
                                        $qCountClass =  'correct';
                                        break;
                                    default:
                                        $qCountClass =  'correct';
                                } */
           
                                $autogradedArray = [config("constants.mcqId"), config("constants.trueFalseId"), config("constants.fibId")];

                                if( in_array($questions['questionType'], $autogradedArray) ) {
                                    $label = __('teachers.report.classAccuracy');
                                    $score = $questions['correctAttempted'] . '/' . $performance['attemptedStudent'];
                                } else {
                                    $score = number_format($questions['classAverage'], 2);
                                    $qCountClass = 'manual';
                                    $label = __('teachers.report.classAverage');
                                }
                            @endphp
                            <li class="{{ $key > 9 ? 'paperData' : '' }}" {{ $key > 9 ? 'style=display:none;' : '' }}>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="q-count skipped">{{ $key+1 }}</div>
                                    <div class="w-120">
                                        <div class="ass-mark">
                                            {{ $questions['maximumMarks'].' '.pointText($questions['maximumMarks']) }}
                                        </div>
                                    </div>
                                </div><small>{{ getTemplateName($questions['questionType']) }}</small><hr>
                                <p class="mb-0"> {{ $label }}: <span class="badge badge-info">{{ $score }}</span></p>
                            </li>
                        @endforeach
                    </ul>
                    @if ($key > 9)
                        <a href="javascript:void(0)" class="btn-link float-right showall">{{ __('teachers.report.showAll') }}</a>
                    @endif
                </div>
                <div class="clearfix"></div>
                <!-- Topic -->
                <div class="row topicWisePerformance d-none">
                    <!-- topic -->
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-2">{{ __('teachers.report.topicWisePerformance') }}</h5>
                    </div>

                    <div class="col-md-12">
                       <div class="well">
                            <textarea class="graph-data d-none">{{ json_encode($topicWisePerformace) }}</textarea>
                            <canvas id="canvas" height="120" width="600"></canvas>
                            <div class="text-right">
                                <button class="btn btn-outline-primary btn-auto d-none" id="previous-topic-chart" data-id="0"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                                <button class="btn btn-outline-primary btn-auto d-none" id="next-topic-chart" data-id="0"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                            </div>
                       </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <!-- subtopic -->
                <div class="row subtopicWisePerformance d-none">
                    <div class="col-md-12"><h5 class="mb-2 subtopic-title d-none">{{ __('teachers.report.subtopicWisePerformance') }}</h5></div>
                    <div class="col-md-12">
                        <div class="well">
                            <canvas id="canvas2" height="120" width="600"></canvas>
                            <div class="text-right">
                                <button class="btn btn-outline-primary btn-auto d-none" id="previous-subtopic-chart" data-id="0"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                                <button class="btn btn-outline-primary btn-auto d-none" id="next-subtopic-chart" data-id="0"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                                <button class="btn btn-outline-primary btn-auto d-none" id="close-subtopic-chart" >{!! config('constants.icons.close-icon') !!}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-10 col-md-10">
                        <textarea class="d-none studentList">{{ json_encode($students) }}</textarea>
                        <h5 class="mt-2">{{ __('teachers.report.studentsList') }}</h5>
                        @php
                            $sortings = ["name" => __('teachers.report.name'), "point" => __('teachers.report.points')];
                        @endphp
                       
                    </div>
                    <div class="col-lg-2 col-md-2 mb-2">
                        <select class="selectpicker form-control pull-right " id="sort-filter" title="{{ __('teachers.report.sortBy') }}">
                            <option value="" selected>{{ __('teachers.report.sortBy') }}</option>
                            @if (isset($sortings) && !empty($sortings))
                                @foreach ($sortings as $keyName => $sort)
                                    <option value="{{ $keyName }}">{{ $sort }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-12" id="putHere">
                        <div class="report-student-list-outer" id="aphaOrder">
                            @if (isset($students))
                                @foreach ($students as $student)
                                    <div class="card sortingCard" data-name="{{ $student['studentName'] }}" data-point="{{ ($student['isAttempted']) ? $student['obtaionedMarks'] : '-1' }}">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon">
                                                        <div class="student-icon">
                                                            <img src="{{ handleProfilePic($student['profileUrl']) }}" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="sub-name"><p class="mb-0 pl-2">{{ $student['studentName'] }}</p></div>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="card-action-box">
                                                    @if($student['isAttempted'])
                                                        <div class="rank-badge">
                                                            <div>{!! config('constants.icons.rank-icon') !!}</div>
                                                            <h2>{{ $student['rank'] }}</h2>
                                                        </div>
                                                        <div class="progressbar ml-4">
                                                            <div class="student-point circle" data-percent="{{ $student['totalPointPercentage'] }}">
                                                                <strong></strong><span></span>
                                                            </div>
                                                        </div>
                                                        <div class="row-point-badge ml-2">{{ __('teachers.report.points') }}- {{ $student['obtaionedMarks'] }} / {{ $performance['maximumMarks'] }}</div>
                                                        
                                                        <div class="row-time-badge ml-2">{!! config('constants.icons.time-icon') !!} {{ convertTimeFormat($student['timeTaken']) }} {{ ($performance['maximumExamDuration'] > 0) ? '/'. ($performance['maximumExamDuration']) : '' }} {{ __('teachers.report.min') }}</div>

                                                        <a href="{{ route('report', base64_encode($classRoomId . '_' . $assessment['assessmentId']. '_' . $student['studentId'])) }}" class="btn btn-primary auto-width ml-4"><i class="fa fa-eye" aria-hidden="true"></i> {{ __('teachers.report.view') }}</a>
                                                    @else
                                                        <div class="text-danger sub-name mt-2 mr-1"><p class="mb-0"><strong>{{ __('teachers.grading.missed') }}</strong></p></div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
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
        let showLessText = "{{ __('teachers.report.showLess') }}";
        let showAllText = "{{ __('teachers.report.showAll') }}";
        let graphMax = `{{ config('constants.graphMax') }}`;
    </script>
    <script type="text/javascript" src="{{ asset('assets/teachers/js/assessmentreport.js') }}"></script>
@endsection
