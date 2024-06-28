@extends('teachers.layouts.report')
@section('content')
<div class="canvas-inner position-relative ">
    <div class="container-fluid">
        <div class="canvas-body">
            <div class="top-cards">
                <div class="row g-2">
                    <div class="col-md-4 ">
                        <div class="well pl-2 pt-4 pb-4 global-profile">
                            <div class="class-icon">{!! config('constants.icons.class-icon') !!}</div>
                            <div class="ml-4">
                                <h5 class="mt-2 mb-0 f-w600">{{ isset($globalClassPerformance['classRoomName']) ? $globalClassPerformance['classRoomName'] : 'Board ki Taiyari' }}</h5>
                                <h5 class="mt-2 mb-0">{{ __('teachers.report.board') }}: {{ $globalClassPerformance['board']['boardName'] }} | {{ __('teachers.report.grade') }}: {{ $globalClassPerformance['grade']['gradeName'] }}</h5>
                                <h5 class="mt-1 mb-1">{{ __('teachers.report.subject') }}: {{ $globalClassPerformance['subject']['subjectName'] }}</h5>
                                <h5 class="mb-0"><small>Total students: {{ $globalClassPerformance['totalStudent']}}/{{ $globalClassPerformance['attemptedStudent']}}</small></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="well global-point-card  mb-3 ">
                            <div class="icon">{!! config('constants.icons.points-icon') !!}</div>
                            <h5 class="mb-3">{{ __('teachers.report.points') }}</h5>
                            <div class="global-points-count">
                                <div class="class-count">
                                    <h2>{{ decimalHandler($globalClassPerformance['averageMarks']) }}/{{ $globalClassPerformance['maximumMarks'] }}</h2>
                                    <p class="mb-0">{{ __('teachers.report.classAverage') }}</p>
                                </div>
                                <div class="seprator-bdr"></div>
                                <div class="global-count">
                                    <h2>{{ decimalHandler($globalClassPerformance['globalAverageMarks']) }}/{{ $globalClassPerformance['maximumMarks'] }}</h2>
                                    <p class="mb-0">{{ __('teachers.report.globalClassAverage') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="well global-time-card">
                            <div class="icon">{!! config('constants.icons.time-icon') !!}</div>
                            <h5 class="mb-3 text-center">Time spent</h5>
                            <div class="global-time-count">
                                <div class="class-count">
                                    <h2>{{ convertTimeFormat($globalClassPerformance['averageExamDuration']) }}/{{ $globalClassPerformance['maximumExamDuration'] }}</h2>
                                    <p class="mb-0">{{ __('teachers.report.classAverage') }}</p>
                                </div>
                                <div class="seprator-bdr"></div>
                                <div class="global-count">
                                    <h2>{{ convertTimeFormat($globalClassPerformance['globalAverageExamDuration']) }}/{{ $globalClassPerformance['maximumExamDuration'] }}</h2>
                                    <p class="mb-0">{{ __('teachers.report.globalClassAverage') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="well circle-card">
                            <div class="progressbar">
                                <div class="second circle" data-percent="{{ ($globalClassPerformance['maximumMarks'] > 0) ? ($globalClassPerformance['averageMarks']*100) / $globalClassPerformance['maximumMarks'] : 0 }}">
                                    <strong></strong>
                                    <span class="">{{ __('teachers.report.average') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="well circle-card">
                            <div class="progressbar">
                                <div class="second circle" data-percent="{{ ($globalClassPerformance['maximumMarks'] > 0) ? ($globalClassPerformance['globalAverageMarks']*100) / $globalClassPerformance['maximumMarks'] : 0 }}">
                                    <strong></strong>
                                    <span class="">{{ __('teachers.report.globalClassAverage') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="well circle-card">
                            <div class="progressbar">
                                <div class="third median circle" data-percent="{{ $globalClassPerformance['median'] }}" data-valuemax="{{ $globalClassPerformance['maximumMarks'] }}">
                                    <strong></strong>
                                    <span>{{ __('teachers.report.median') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="well circle-card">
                            <div class="progressbar">
                                <div class="third median circle" data-percent="{{ $globalClassPerformance['globalMedian'] }}" data-valuemax="{{ $globalClassPerformance['maximumMarks'] }}">
                                    <strong></strong>
                                    <span>{{ __('teachers.report.global') }} {{ __('teachers.report.median') }}</span>
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
                    @if(isset($globalQuestionPerformance))
                    @foreach ($globalQuestionPerformance as $key => $questions)
                    @php
                    $autogradedArray = [config("constants.mcqId"), config("constants.trueFalseId"), config("constants.fibId")];

                    if( in_array($questions['questionType'], $autogradedArray) ) {
                    $label = __('teachers.report.classAccuracy');
                    $globalLabel = __('teachers.report.globalClassAccuracy');

                    $score = $questions['correctAttempted'] . '/' . $globalClassPerformance['attemptedStudent'];
                    $globalScore = $questions['globalCorrectAttempted'] . '/' . $globalClassPerformance['globalTotalStudent'];

                    } else {
                    $label = __('teachers.report.classAverage');
                    $globalLabel = __('teachers.report.globalClassAverage');
                    $globalScore = number_format($questions['globalClassAverage'], 2);
                    $score = number_format($questions['classAverage'], 2);
                    }
                    @endphp
                    <li class="{{ $key > 9 ? 'paperData d-none' : '' }}">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="q-count skipped">{{ $key+1 }}</div>
                            <div class="w-120">
                                <div class="ass-mark">
                                    {{ $questions['maximumMarks'].' '.pointText($questions['maximumMarks']) }}
                                </div>
                            </div>
                        </div><small>{{ getTemplateName($questions['questionType']) }}</small>
                        <hr>
                        <p class="mb-0"> {{ $label }}: <span class="badge badge-info">{{ $score }}</span></p><br>
                        <p class="mb-0"> {{ $globalLabel }}: <span class="badge badge-info">{{ $globalScore }}</span></p>
                    </li>
                    @endforeach
                </ul>
                @if ($key > 9)
                <a href="javascript:void(0)" class="btn-link float-right showall">{{ __('teachers.report.showAll') }}</a>
                @endif
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
                        <textarea class="graph-data d-none">{{ json_encode($globalTopicToSubTopicMatrix) }}</textarea>
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
                <div class="col-md-12">
                    <h5 class="mb-2 subtopic-title d-none">{{ __('teachers.report.subtopicWisePerformance') }}</h5>
                </div>
                <div class="col-md-12">
                    <div class="well">
                        <canvas id="canvas2" height="120" width="600"></canvas>
                        <div class="text-right">
                            <button class="btn btn-outline-primary btn-auto d-none" id="previous-subtopic-chart" data-id="0"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                            <button class="btn btn-outline-primary btn-auto d-none" id="next-subtopic-chart" data-id="0"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                            <button class="btn btn-outline-primary btn-auto d-none" id="close-subtopic-chart">{!! config('constants.icons.close-icon') !!}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-10 col-md-10">
                    <textarea class="d-none studentList"></textarea>
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
                                <div class="card sortingCard" data-name="{{ $student['studentName'] }}" data-point="{{ $student['obtaionedMarks'] }}">
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

                                        @if($student['isAttempted'])
                                        <div class="col-md-8">
                                            <div class="card-action-box">
                                                <div class="rank-badge">
                                                    <div>{!! config('constants.icons.rank-icon') !!}</div>
                                                    <h2>{{ $student['rank'] }} <br><small>Class</small></h2>
                                                </div>
                                                <div class="rank-badge ml-4">
                                                    <div>{!! config('constants.icons.rank-icon') !!}</div>
                                                    <h2 class="ml-2">{{ $student['globalRank'] }} <br>
                                                        <small>{{ __('teachers.report.global') }} </small>
                                                    </h2>
                                                </div>
                                                <div class="progressbar ml-4">
                                                    <div class="student-point circle" data-percent="{{ ($student['obtaionedMarks']*100) / $globalClassPerformance['maximumMarks'] }}">
                                                        <strong>{{ $student['obtaionedMarks'] }}</strong><span></span>
                                                    </div>
                                                </div>
                                                <div class="row-point-badge ml-2">Points- {{ $student['obtaionedMarks'] }} / {{ $globalClassPerformance['maximumMarks'] }}</div>

                                                <div class="row-time-badge ml-2">{!! config('constants.icons.time-icon') !!} {{ convertTimeFormat($student['timeTaken']) }} /{{ $globalClassPerformance['maximumExamDuration'] }} min</div>

                                                <a href="{{ route('board.student', base64_encode($assessment['assessmentId'].'_'.$student['studentId'])) }}" class="btn btn-primary auto-width ml-4"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-md-8">
                                            <div class="card-action-box">
                                                <div class="text-danger sub-name mt-2 mr-1">
                                                    <p class="mb-0"><strong>{{ __('teachers.grading.missed') }}</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
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
@section('onPageJs')
<script type="text/javascript">
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

    let topicWisePerformance = "{{ __('teachers.report.topicWisePerformance') }}";
    let subtopicWisePerformance = "{{ __('teachers.report.subtopicWisePerformance') }}";
    let assessmentWisePerformanceText = `{{ __('teachers.report.assessmentWisePerformance') }}`;
    let showLessText = "{{ __('teachers.report.showLess') }}";
    let showAllText = "{{ __('teachers.report.showAll') }}";
    let graphMax = `{{ config('constants.graphMax') }}`;
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
                    subtopicGraph(dataVal['subTopicComparisionMatrix'], nextid);
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
                    subtopicGraph(dataVal['subTopicComparisionMatrix'], nextid);
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

        canvas.onclick = function(evt) {
            let activePoints = topicGraphKey.getElementsAtEventForMode(evt, 'point', topicGraphKey.options);
            let firstPoint = activePoints['0'];
            if (firstPoint != undefined) {
                selectedLabel = topicGraphKey.data.labels[firstPoint.index];
                selectedValue = topicGraphKey.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
                $.each(topicData, function(ind, dataVal) {
                    if (dataVal['topicName'] == selectedLabel && parseInt(dataVal['comparitiveAverage']) == parseInt(selectedValue)) {
                        $('.subtopicWisePerformance').removeClass('d-none');
                        subtopicGraph(dataVal['globalSubTopicComparisionMatrix'], 0);
                        return
                    }
                });
            }
        };

        function topicGraph(chunkId) {
            let labels = [];
            let averageData = [];
            let comparitiveAverageData = [];
            let averageChunks = [];
            let comparitiveAverageChunks = [];
            let labelsChunks = [];
            $('.graph-title').text(`${topicWisePerformanceText}`);

            $.each(topicData, function(indVal, dataVal) {
                labels[indVal] = dataVal['topicName'];
                averageData[indVal] = dataVal['comparitiveAverage'];
                comparitiveAverageData[indVal] = dataVal['globalAverage'];
            });

            while (labels.length > 0) {
                averageChunks.push(averageData.splice(0, chunkSize));
                comparitiveAverageChunks.push(comparitiveAverageData.splice(0, chunkSize));
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
            let comparitiveAveragColor = "#d0ae5e";

            const data = {
                labels: labelsChunks[chunkId],
                datasets: [{
                        label: 'Global Performance',
                        data: comparitiveAverageChunks[chunkId],
                        borderColor: '#d0ae5e',
                        backgroundColor: comparitiveAveragColor,
                        type: 'line'
                    },
                    {
                        label: 'Class Performance',
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
                            stacked: true,
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
            let labelsChunks = [];
            $('.subtopic-title').removeClass('d-none');
            $('#close-subtopic-chart').removeClass('d-none');

            $.each(subtopic, function(ind, dataVal) {
                labels[ind] = dataVal['subTopicName'];
                averageData[ind] = dataVal['comparitiveAverage'];
                comparitiveAverageData[ind] = dataVal['globalAverage'];
            });

            while (labels.length > 0) {
                averageChunks.push(averageData.splice(0, chunkSize));
                comparitiveAverageChunks.push(comparitiveAverageData.splice(0, chunkSize));
                labelsChunks.push(labels.splice(0, chunkSize));
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
                        label: 'Global Performance',
                        data: comparitiveAverageChunks[chunkId],
                        borderColor: '#d0ae5e',
                        backgroundColor: '#d0ae5e',
                        type: 'line'
                    },
                    {
                        label: 'Class Performance',
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
                            stacked: true,
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

    $(document).on('click', '.showall', function() {
        $('.question-card-outer ul li:gt(9)').removeClass('d-none');
        $(this).addClass('showless').removeClass('showall').text('Show less...');
    });

    $(document).on('click', '.showless', function() {
        $('.question-card-outer ul li:gt(9)').addClass('d-none');
        $(this).addClass('showall').removeClass('showless').text('Show all...');
    });

    $(document).on("change", "#sort-filter", function() {
        let sortData = $(this).val();
        if (sortData.length > 0) {
            var alphabeticallyOrderedDivs = $('.sortingCard').sort(function(a, b) {
                var stringFirst = $(a).data(`${sortData}`);
                var stringSec = $(b).data(`${sortData}`);
                if (!isNaN(stringFirst) && !isNaN(stringSec)) {

                    if (stringSec > stringFirst) {
                        return 1;
                    } else if (stringSec < stringFirst) {
                        return -1;
                    } else {
                        return 0;
                    }

                    // return String.prototype.localeCompare.call(stringSec, stringFirst);
                } else {
                    return String.prototype.localeCompare.call(stringFirst.toLowerCase(), stringSec.toLowerCase());
                }
            });

            var container = $("#aphaOrder");
            container.detach().empty().append(alphabeticallyOrderedDivs);
            $('#putHere').append(container);

            if ($('.sortingCard').find('.circle').find('canvas').length > 0) {
                $('.sortingCard').find('.circle').find('canvas').remove();
                animateElements();
            }
        }

    });
</script>

@endsection