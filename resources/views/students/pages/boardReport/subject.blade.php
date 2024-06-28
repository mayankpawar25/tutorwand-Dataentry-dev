@extends('students.layouts.default')
@section('title', __('students.siteTitle') )
@section('content')
<div class="canvas-inner position-relative ">
    <div class="container-fluid global-report">
        <div class="canvas-body">
            <div class="top-cards">
                <div class="row g-2">
                    <input type="hidden" name="studentId" value="{{ isset($performance['studentId']) ? $performance['studentId'] : '0' }}">
                    <input type="hidden" name="responseId" value="{{ isset($performance['studentResponseId']) ? $performance['studentResponseId'] : '0' }}">
                    <input type="hidden" name="assessmentId" value="{{ isset($studentAssessment['assessmentId']) ? $studentAssessment['assessmentId'] : '0' }}">

                    <div class="col-md-3">
                        <div class="well global-profile">
                            <div class="student-icon-card">
                                <img src="{!! getStudentProfileImage() !!}">
                            </div>
                            <div class="global-profile-meta ml-3">
                                <p class="mt-2 mb-0"> {{ getStudentName() }} </p>
                                <p class="mb-0">{{ __('teachers.report.board') }}: {{ $performance['board']['boardName'] }} | {{ __('teachers.assessment.grade') }}: {{ $performance['grade']['gradeName'] }}</p>
                                <p class="mb-0">{{ __('teachers.assessment.subject') }}: {{ $performance['subject']['subjectName'] }}</p>
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
                                            <span class="badge badge-primary">{{ isset($performance['badges'][0]['count']) ? $performance['badges'][0]['count'] : 0 }}</span>
                                            <span class="coloured">
                                                {!! config('constants.icons.excellent-icon') !!}
                                            </span>
                                        </div>
                                        <div class="badges-icon">
                                            <span class="badge badge-primary">{{ isset($performance['badges'][1]['count']) ? $performance['badges'][1]['count'] : 0 }}</span>
                                            <span class="coloured">
                                                {!! config('constants.icons.perfect-icon') !!}
                                            </span>
                                        </div>
                                        <div class="badges-icon">
                                            <span class="badge badge-primary">{{ isset($performance['badges'][2]['count']) ? $performance['badges'][2]['count'] : 0 }}</span>
                                            <span class="coloured">
                                                {!! config('constants.icons.verycreative-icon') !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="well global-point-card pt-3 pb-3 ">
                            <div class="icon">{!! config('constants.icons.points-icon') !!}</div>
                            <h5 class="mb-3">{{ __('teachers.report.points') }}</h5>
                            <div class="global-points-count">
                                <div class="class-count">
                                    <h2>{{ decimalHandler($performance['optainedMark']) }}/{{ $performance['maximumMark'] }}</h2>
                                    <p class="mb-0">{{ __('teachers.report.score') }} </p>
                                </div>
                                <div class="seprator-bdr"></div>
                                <div class="global-count">
                                    <h2>{{ decimalHandler($performance['globalAverage']) }}/{{ $performance['maximumMark'] }}</h2>
                                    <p class="mb-0">{{ __('teachers.report.global') }}  {{ __('teachers.report.average') }} </p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="well pt-3 pb-3">
                            <div class="progressbar">
                                <div class="second circle" data-percent="{{ ($performance['optainedMark']*100)/ $performance['maximumMark'] }}">
                                    <strong></strong>
                                    <span>{{ __('teachers.report.average') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="well pt-3 pb-3">
                            <div class="progressbar">
                                <div class="second circle" data-percent="{{ ($performance['globalAverage']*100)/ $performance['maximumMark'] }}">
                                    <strong></strong>
                                    <span>{{ __('teachers.report.global') }} {{ __('teachers.report.average') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-cards">
                <div class="row g-2">
                <div class="col-md-6">
                        <div class="well global-rank-card pt-3 pb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="d-flex align-items-center mob-icon-center">
                                        <div class="icon">
                                            {!! config('constants.icons.rank-icon') !!}
                                        </div>
                                        <h5 class="ml-2 mb-0 d-none d-lg-block d-md-block">Rank</h5>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex mw-100 justify-content-end">
                                        <div>
                                            <h5 class="mb-0 d-block d-lg-none d-md-none d-sm-block">{{ __('teachers.report.rank') }} </h5>
                                        </div>
                                        <div>
                                            <h3>{{ $performance['rank'] }}<font>/{{ $performance['attemptedStudentCount'] }}</font></h3>
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="col-md-6 col-6 bdr-left">
                                    <div class="d-flex align-items-center justify-content-between mw-100">
                                        <div>
                                            <h5 class="mb-0">{{ __('teachers.report.global') }} {{ __('teachers.report.rank') }}</h5>
                                        </div>
                                        <div>
                                            <h3> {{ $performance['globalRank'] }}<font>/{{ $performance['globalAttemptedStudentCount'] }}</font></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="well global-time pt-3 pb-3">
                            <div class="row">
                                <div class="col-md-4 col-lg-4 col-xl-3">
                                    <div class="d-flex align-items-center mob-icon-center">
                                        <div class="icon">
                                            {!! config('constants.icons.time-icon') !!}
                                        </div>
                                        <h5 class="ml-2 mb-0 d-none d-lg-block d-md-block">{{ __('teachers.report.time') }} spend <br></h5>
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-2 col-xl-3 col-6 text-center ">
                                    <div class="d-flex align-items-center mw-100">
                                        <div>
                                            <h5 class="mb-0 d-block d-lg-none d-md-none d-sm-block">{{ __('teachers.report.time') }} spend</h5>
                                        </div>
                                        <div>
                                            <h3> {{ convertTimeFormat($performance['timeTaken']) }}/{{ $performance['maximumDuration'] }}</h3>
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="col-md-6 col-6 bdr-left">
                                    <div class="d-flex align-items-center justify-content-between mw-100">
                                        <div>
                                            <h5 class="mb-0">{{ __('teachers.report.global') }} {{ __('teachers.report.average') }}  </h5>
                                        </div>
                                        <div>
                                            <h3> {{ convertTimeFormat($performance['globalTimeTaken']) }}/{{ $performance['maximumDuration'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="tab-panel-box tab-list-auto ">
                        <ul class="nav nav-tabs " id="myTab" role="tablist">
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
                                        @foreach ($questionWisePerformance as $key => $questions)
                                            @php
                                                switch($questions['status']) {
                                                    case 'Correct':
                                                        $qCountClass = 'correct';
                                                        break;
                                                    case 'Incorrect':
                                                        $qCountClass = 'wrong';
                                                        break;
                                                    case 'Skipped':
                                                        $qCountClass = 'skipped';
                                                        break;
                                                    default:
                                                        $qCountClass = 'correct';
                                                        break;
                                                }

                                                $autogradedArray = [config("constants.mcqId"), config("constants.trueFalseId"), config("constants.fibId")];
                                                if( in_array($questions['questionType'], $autogradedArray) ) {
                                                    $totalStudents = $performance['attemptedStudentCount'];

                                                    $label = __('teachers.report.classAccuracy');
                                                    $globalLabel = __('teachers.report.globalClassAccuracy');
                                                    $score = $questions['correctedCount'] . ' / ' . $totalStudents;
                                                    $globalScore = $questions['correctedCount'] . ' / ' . $performance['globalAttemptedStudentCount'];
                                                } else {
                                                    $label = __('teachers.report.classAverage');
                                                    $globalLabel = __('teachers.report.globalClassAverage');
                                                    $score = number_format($questions['classAverage'], 2);
                                                    $globalScore = number_format($questions['classAverage'], 2);
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
                                                <p class="mb-0"> {{ $label }}: <span class="badge badge-info">{{ $score }}</span></p><br>
                                                <p class="mb-0"> {{ $globalLabel }}: <span class="badge badge-info">{{ $globalScore }}</span></p>
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
                                    <div class="col-md-12">
                                        <h5 class="mb-2 graph-title">{{ __('teachers.report.topicWisePerformance') }} </h5>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="well graph-height">
                                            <textarea class="graph-data d-none">{{ json_encode($topicWisePerformace) }}</textarea>
                                            <canvas id="canvas" height="528" width="634"></canvas>
                                            <div class="text-right">
                                                <button class="btn btn-outline-primary btn-auto d-none" id="previous-topic-chart" data-id="0"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                                                <button class="btn btn-outline-primary btn-auto d-none" id="next-topic-chart" data-id="0"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- subtopic -->
                                <div class="row subtopicWisePerformance d-none">
                                    <div class="col-md-12">
                                        <h5 class="mb-2 subtopic-title d-none">{{ __('teachers.report.subtopicWisePerformance') }} </h5>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="well graph-height">
                                            <canvas id="canvas2" height="528" width="634"></canvas>
                                            <div class="text-right">
                                                <button class="btn btn-outline-primary btn-auto d-none" id="previous-subtopic-chart" data-id="0"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                                                <button class="btn btn-outline-primary btn-auto d-none" id="next-subtopic-chart" data-id="0"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                                                <button class="btn btn-outline-primary btn-auto d-none" id="close-subtopic-chart">
                                                    {!! config('constants.icons.close-icon') !!}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="answer" role="tabpanel" aria-labelledby="answer-tab"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('onPageJs')
<script type="text/javascript" src="{{ asset('assets/plugins/progressbar/circle-progress.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/chartjs/chart.js') }}"></script>
<script type="text/javascript">
    let topicWisePerformance = "{{ __('teachers.report.topicWisePerformance') }}";
    let subtopicWisePerformance = "{{ __('teachers.report.subtopicWisePerformance') }}";
    let assessmentWisePerformanceText = `{{ __('teachers.report.assessmentWisePerformance') }}`;
    let showLessText = "{{ __('teachers.report.showLess') }}";
    let showAllText = "{{ __('teachers.report.showAll') }}";
    let graphMax = `{{ config('constants.graphMax') }}`;

    let topicData = '';
    let chunkSize = 10;
    let myBar = '';
    let subTopicGraph = '';
    let selectedLabel = '';
    let selectedValue = '';
    let canvas = document.getElementById("canvas");
    let canvas2 = document.getElementById("canvas2");
    let answerSheet = '';
    let topicGraphKey = "";
    let topicWisePerformanceText = "{{ __('teachers.report.topicWisePerformance') }}";

    $(document).ready(function($) {
        animateElements();
        $(window).scroll(animateElements);
        $('[data-toggle="tooltip"]').tooltip();

        topicData = JSON.parse($('.graph-data').val());
        if (topicData.length > 3) {
            $('.topicWisePerformance').removeClass('d-none');
            topicGraph(0);
        } else {
            let subtopicsData = [];
            $.each(topicData, function(ind, dataVal) {
                $.each(dataVal['subTopicComparisionMatrix'], function(subind, subdataVal) {
                    subtopicsData.push(subdataVal);
                });
            });
            topicData = subtopicsData;
            subtopicGraph(topicData, 0);
            $('#close-subtopic-chart').hide();
            $('.subtopicWisePerformance').removeClass('d-none');
        }

    });

    function animateElements() {
        let colorName = "#22ad8c";
        $('.progressbar').each(function() {
            var elementPos = $(this).offset().top;
            var topOfWindow = $(window).scrollTop();
            var percent = $(this).find('.circle').attr('data-percent');
            var maxPercent = 100;
            if ($(this).find('.circle').attr('data-valuemax')) {
                maxPercent = $(this).find('.circle').attr('data-valuemax');
            }
            if ($(this).find('.circle').hasClass('second')) {
                colorName = "#22ad8c";
            } else if ($(this).find('.circle').hasClass('median')) {
                colorName = "#d0ae5e";
            } else if ($(this).find('.circle').hasClass('student-point')) {
                colorName = "#22ad8c";
            } else if ($(this).find('.circle').hasClass('student-time')) {
                colorName = "#6f69d0";
            }

            var animate = $(this).data('animate');
            if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
                $(this).data('animate', true);
                $(this).find('.circle').circleProgress({
                    // startAngle: -Math.PI / 2,
                    value: percent / maxPercent,
                    size: 400,
                    thickness: 40,
                    percent: -25,
                    fill: {
                        color: colorName
                    }
                }).on('circle-animation-progress', function(event, progress, stepValue) {
                    if ($(event.target).hasClass('median')) {
                        $(this).find('strong').text(percent);
                    } else {
                        $(this).find('strong').text((stepValue * 100).toFixed(0) + "%");
                    }
                }).stop();
            }
        });
    }

    $(document).on('click', '#next-topic-chart', function() {
        let nextid = parseInt($(this).attr('data-id')) + 1;
        let previousid = parseInt($(this).attr('data-id'));
        $(this).attr({
            'data-id': nextid
        });
        $('#previous-topic-chart').attr({
            'data-id': previousid
        });
        if (nextid > 0) {
            $('#previous-topic-chart').removeClass('d-none');
        } else {
            $('#previous-topic-chart').addClass('d-none');
        }
        topicGraph(nextid);
    });

    $(document).on('click', '#previous-topic-chart', function() {
        let nextid = parseInt($(this).attr('data-id'));
        let previousid = parseInt($(this).attr('data-id')) - 1;
        $(this).attr({
            'data-id': previousid
        });
        $('#next-topic-chart').attr({
            'data-id': nextid
        });
        if (previousid > 0) {
            $('#previous-topic-chart').removeClass('d-none');
        } else {
            $('#previous-topic-chart').addClass('d-none');
        }
        topicGraph(nextid);
    });

    $(document).on('click', '#next-subtopic-chart', function() {
        let nextid = parseInt($(this).attr('data-id')) + 1;
        let previousid = parseInt($(this).attr('data-id'));
        $(this).attr({
            'data-id': nextid
        });
        $('#previous-subtopic-chart').attr({
            'data-id': previousid
        });
        if (nextid > 0) {
            $('#previous-subtopic-chart').removeClass('d-none');
        } else {
            $('#previous-subtopic-chart').addClass('d-none');
        }
        $.each(topicData, function(ind, dataVal) {
            if (dataVal['topicName'] == selectedLabel && parseInt(dataVal['comparitiveAverage']) == parseInt(selectedValue)) {
                subtopicGraph(dataVal['globalSubTopicComparisionMatrix'], nextid);
                return;
            }
        });

        if (topicData[0]['subTopicName'] != undefined) {
            subtopicGraph(topicData, nextid);
            return;
        }
    });

    $(document).on('click', '#previous-subtopic-chart', function() {
        let nextid = parseInt($(this).attr('data-id'));
        let previousid = parseInt($(this).attr('data-id')) - 1;
        $(this).attr({
            'data-id': previousid
        });
        $('#next-subtopic-chart').attr({
            'data-id': nextid
        });
        if (previousid > 0) {
            $('#previous-subtopic-chart').removeClass('d-none');
        } else {
            $('#previous-subtopic-chart').addClass('d-none');
        }
        $.each(topicData, function(ind, dataVal) {
            if (dataVal['topicName'] == selectedLabel && parseInt(dataVal['comparitiveAverage']) == parseInt(selectedValue)) {
                subtopicGraph(dataVal['globalSubTopicComparisionMatrix'], nextid);
                return;
            }
        });

        if (topicData[0]['subTopicName'] != undefined) {
            subtopicGraph(topicData, nextid);
            return;
        }
    });

    $(document).on('click', '#close-subtopic-chart', function() {
        if (subTopicGraph) {
            $('.subtopicWisePerformance').addClass('d-none');
            subTopicGraph.destroy();
        }
        $('#next-subtopic-chart').addClass('d-none');
        $('#close-subtopic-chart').addClass('d-none');
        $('.subtopic-title').addClass('d-none');
    });

    function topicGraph(chunkId) {
        let labels = [];
        let averageData = [];
        let comparitiveAverageData = [];
        let averageChunks = [];
        let comparitiveAverageChunks = [];
        let globalAverageData = [];
        let globalAverageChunks = [];
        let labelsChunks = [];
        $('.graph-title').text(`${topicWisePerformanceText}`);

        $.each(topicData, function(indVal, dataVal) {
            labels[indVal] = dataVal['topicName'];
            comparitiveAverageData[indVal] = dataVal['comparitiveAverage'];
            averageData[indVal] = dataVal['average'];
            globalAverageData[indVal] = dataVal['globalAverage'];
        });

        while (labels.length > 0) {
            averageChunks.push(averageData.splice(0, chunkSize));
            comparitiveAverageChunks.push(comparitiveAverageData.splice(0, chunkSize));
            globalAverageChunks.push(globalAverageData.splice(0, chunkSize));
            labelsChunks.push(labels.splice(0, chunkSize));
        }

        if (labelsChunks.length > 1) {
            $('#next-topic-chart').removeClass('d-none');
        }

        if (labelsChunks.length - 1 == chunkId) {
            $('#next-topic-chart').addClass('d-none');
        }

        if (labelsChunks.length - 1 < 0) {
            $('#previous-topic-chart').addClass('d-none');
        }

        let averageColor = '#49D9F8';
        let comparitiveAveragColor = "black";
        const data = {
            labels: labelsChunks[chunkId],
            datasets: [{
                    label: 'Global Average',
                    data: globalAverageChunks[chunkId],
                    borderColor: '#d0ae5e',
                    backgroundColor: '#d0ae5e',
                    type: 'line'
                },
                {
                    label: 'Class Average',
                    data: comparitiveAverageChunks[chunkId],
                    borderColor: 'black',
                    backgroundColor: comparitiveAveragColor,
                    type: 'line'
                },
                {
                    label: 'Student Average',
                    data: averageChunks[chunkId],
                    borderColor: '#49D9F8',
                    backgroundColor: averageColor,
                    type: 'bar',
                    barPercentage: 0.7,
                    barThickness: 25,
                    maxBarThickness: 25,
                    minBarLength: 2,
                },
            ]
        };

        if (topicGraphKey) {
            topicGraphKey.destroy();
        }

        var ctx = canvas.getContext("2d");
        topicGraphKey = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: ''
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            min: 0,
                            max: 100,
                            stepSize: graphMax,
                            autoSkip: false,
                            callback: function(value, index, values) {
                                return `${value}%`;
                            }
                        },
                        title: {
                            display: true,
                            text: 'PERFORMANCE'
                        }
                    },
                    x: {
                        stacked: true,
                        ticks: {
                            callback: function(val, index) {
                                let width = screen.width;
                                let parts = 20;
                                if (width <= 1280) {
                                    parts = 15;
                                }
                                let text = labelsChunks[chunkId][index];
                                let myRe = /\S[\s\S]{0,15}\S(?=\s|$)/g;
                                let m;
                                let result = new Array();
                                if (text.length > parts) {
                                    while ((m = myRe.exec(text)) !== null) {
                                        result.push(m[0]);
                                    }
                                    return result;
                                } else {
                                    return text;
                                }
                            }
                        }
                    }
                }
            },
        });
    }

    function subtopicGraph(subtopic, chunkId) {
        let labels = [];
        let averageData = [];
        let comparitiveAverageData = [];
        let averageChunks = [];
        let comparitiveAverageChunks = [];
        let globalAverageData = [];
        let globalAverageChunks = [];
        let labelsChunks = [];
        $('.subtopic-title').removeClass('d-none');
        $('#close-subtopic-chart').removeClass('d-none');

        $.each(subtopic, function(ind, dataVal) {
            labels[ind] = dataVal['subTopicName'];
            averageData[ind] = dataVal['average'];
            comparitiveAverageData[ind] = dataVal['comparitiveAverage'];
            globalAverageData[ind] = dataVal['globalAverage'];
        });

        while (labels.length > 0) {
            averageChunks.push(averageData.splice(0, chunkSize));
            comparitiveAverageChunks.push(comparitiveAverageData.splice(0, chunkSize));
            labelsChunks.push(labels.splice(0, chunkSize));
            globalAverageChunks.push(globalAverageData.splice(0, chunkSize));
        }

        if (labelsChunks.length > 1) {
            $('#next-subtopic-chart').removeClass('d-none');
        }

        if (labelsChunks.length - 1 == chunkId) {
            $('#next-subtopic-chart').addClass('d-none');
        }

        if (labelsChunks.length - 1 < 0) {
            $('#previous-subtopic-chart').addClass('d-none');
        }

        let averageColor = '#49D9F8';
        const data = {
            labels: labelsChunks[chunkId],
            datasets: [{
                    label: 'Global Average',
                    data: globalAverageChunks[chunkId],
                    borderColor: '#d0ae5e',
                    backgroundColor: '#d0ae5e',
                    type: 'line'
                },
                {
                    label: 'Class Average',
                    data: comparitiveAverageChunks[chunkId],
                    borderColor: 'black',
                    backgroundColor: 'black',
                    type: 'line'
                },
                {
                    label: 'Student Average',
                    data: averageChunks[chunkId],
                    borderColor: '#49D9F8',
                    backgroundColor: '#49D9F8',
                    type: 'bar',
                    barPercentage: 0.7,
                    barThickness: 25,
                    maxBarThickness: 25,
                    minBarLength: 2,
                },

            ]
        };

        if (subTopicGraph) {
            subTopicGraph.destroy();
        }

        var ctx = canvas2.getContext("2d");
        subTopicGraph = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: ''
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            min: 0,
                            max: 100,
                            stepSize: graphMax,
                            autoSkip: false,
                            callback: function(value, index, values) {
                                return `${value}%`;
                            }
                        },
                        title: {
                            display: true,
                            text: 'PERFORMANCE'
                        }
                    },
                    x: {
                        stacked: true,
                        ticks: {
                            callback: function(val, index) {
                                let width = screen.width;
                                let parts = 20;
                                if (width <= 1280) {
                                    parts = 15;
                                }
                                let text = labelsChunks[chunkId][index];
                                let myRe = /\S[\s\S]{0,15}\S(?=\s|$)/g;
                                let m;
                                let result = new Array();
                                if (text.length > parts) {
                                    while ((m = myRe.exec(text)) !== null) {
                                        result.push(m[0]);
                                    }
                                    return result;
                                } else {
                                    return text;
                                }
                            }
                        }
                    }
                }
            },
        });
    }

    canvas.onclick = function(evt) {
        let activePoints = topicGraphKey.getElementsAtEventForMode(evt, 'point', topicGraphKey.options);
        let firstPoint = activePoints['0'];
        if (firstPoint != undefined) {
            selectedLabel = topicGraphKey.data.labels[firstPoint.index];
            selectedValue = topicGraphKey.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
            $.each(topicData, function(ind, dataVal) {
                if (dataVal['topicName'] == selectedLabel && parseInt(dataVal['average']) == parseInt(selectedValue)) {
                    $('.subtopicWisePerformance').removeClass('d-none');
                    subtopicGraph(dataVal['globalSubTopicComparisionMatrix'], 0);
                    return
                }
            });
        }
    };

    $(document).on('click', '.showall', function() {
        $('.question-card-outer ul li:gt(9)').removeClass('d-none');
        $(this).addClass('showless').removeClass('showall').text('Show less...');
    });

    $(document).on('click', '.showless', function() {
        $('.question-card-outer ul li:gt(9)').addClass('d-none');
        $(this).addClass('showall').removeClass('showless').text('Show all...');
    });

    $(document).on('click', '#answer-tab', function() {
        if ($.trim($('#answer').text()).length == 0 && answerSheet.length == 0) {
            $("#answer").html(`{{ view("teachers.includes.loader") }}`);

            let studentId = $('input[name=studentId]').val();
            let responseId = $('input[name=responseId]').val();
            let assessmentId = $('input[name=assessmentId]').val();

            let data = {
                'responseId': responseId,
                'studentId': studentId,
                'paperId': assessmentId
            };

            $.ajax({
                type: "POST",
                url: "{{ route('students.answersheet') }}",
                data: data,
                dataType: "html",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#answer').html(response);
                }
            });
        } else {
            $("#answer").html(`{{ view("teachers.includes.loader") }}`);
            $('#answer').html(answerSheet);
        }
        return;
    });
</script>
@endsection