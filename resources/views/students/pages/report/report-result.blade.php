@extends('students.layouts.default')
@section('content')
<div class="info-banner offline t-115">The comprehensive report will be available once teacher publishes the results.</div>
    <div class="canvas-inner position-relative ">
        <div class="container-fluid">
            <div class="canvas-body margin-top-50">
                <div class="top-cards">
                    <div class="row g-2">
                        <div class="col-md-3 text-center">
                            <div class="well pt-3">
                                <div class="student-icon-card">
                                    <img src="{!! getStudentProfileImage() !!}">
                                </div>
                                <h5 class="mt-2 mb-0"> {{ getStudentName() }} </h5>
                                <p class="mb-0"><small>{{ __('teachers.report.board') }}: {{ $boardName }} | {{ __('teachers.assessment.grade') }}: {{ $gradeName }}</small></p>
                                <p class="mb-0"><small>{{ __('teachers.assessment.subject') }}: {{ $subjectName }}</small></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="well point-card pt-3 pb-3 ">
                                <div class="icon">{!! config('constants.icons.points-icon') !!}</div>
                                <div class="point-count">
                                    <h3><span>{{ __('teachers.report.points') }}</span>
                                        <font class="counter-count">{{ isset($obtainedMarks) ? $obtainedMarks : '0' }}</font>{{ isset($maxMarks) ? '/'.$maxMarks : '' }}</h3>
                                </div>
                            </div>
                            <div class="well time-card pt-3 pb-3">
                                <div class="icon">
                                    {!! config('constants.icons.time-icon') !!}
                                </div>
                                <div class="time-count">
                                    <h3><span>{{ __('teachers.report.time') }} </span>
                                        <font class="counter-count">{{ isset($takenDuration) ? convertTimeFormat($takenDuration) : ' - ' }}</font>{{ isset($maxDuration) && $maxDuration > 0 ? '/' . $maxDuration : '' }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="well">
                                <div class="progressbar">
                                    <div class="second circle" data-percent="{{ isset($obtainedMarks) && isset($maxMarks) && $maxMarks > 0 ? round(($obtainedMarks*100) / $maxMarks) : 0 }}">
                                        <strong></strong>
                                        <span>{{ __('teachers.report.performance') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="tab-panel-box tab-list-auto">
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
                                        @if(isset($studentResponse['responses']) && !empty($studentResponse['responses']))
                                            <ul>
                                                @foreach ($studentResponse['responses'] as $key => $response)
                                                    @php 
                                                        $correctAnswer = '';
                                                    @endphp
                                                    @foreach ($response['solution']['options'] as $optionKey => $option) 
                                                        @if (isset($response['answer']['options'][$optionKey]['isCorrect']) && $response['answer']['options'][$optionKey]['isCorrect'] == true && $option['isCorrect'] == true)
                                                            @php 
                                                                $correctAnswer = 'correct'; 
                                                            @endphp
                                                        @endif

                                                        @if (isset($response['answer']['options'][$optionKey]['isCorrect']) && $response['answer']['options'][$optionKey]['isCorrect'] == true && $option['isCorrect'] == false)
                                                            @php 
                                                                $correctAnswer = 'incorrect';
                                                            @endphp
                                                        @endif

                                                    @endforeach
                                                    @if(!is_array($response['answer']['options']))
                                                        @php 
                                                            $correctAnswer = 'skipped';
                                                        @endphp
                                                    @endif

                                                    
                                                    @php
                                                        switch($correctAnswer) {
                                                            case 'correct':
                                                                $qCountClass = 'correct';
                                                                break;
                                                            case 'incorrect':
                                                                $qCountClass = 'wrong';
                                                                break;
                                                            case 'skipped':
                                                                $qCountClass = 'skipped';
                                                                break;
                                                            default:
                                                                $qCountClass = 'skipped';
                                                        }
                                                    @endphp
                                                    <li class="{{ $key > 9 ? 'd-none' : '' }}">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="q-count {{ $qCountClass }}">{{ $key+1 }}</div>
                                                            <div class="w-120">
                                                                <div class="input-group point-input">
                                                                    <input type="text" class="form-control mx-width-50" placeholder="{{ $response['answer']['gradedMarks'] }}" aria-label="{{ $response['answer']['gradedMarks'] }}" disabled>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">{{ $response['answer']['maximumMarks'] }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <small>{{ getTemplateName($response['questionType']) }}</small>
                                                    </li>
                                                
                                                @endforeach
                                            </ul>
                                            @if ($key > 9)
                                                <a href="#" class="btn-link float-right showall">Show all...</a>
                                            @endif
                                        @endif
                                        
                                    </div>
                                    
                                    <div class="clearfix"></div>

                                    <!-- topic -->
                                    <div class="row topicWisePerformance d-none">
                                        <div class="col-md-12">
                                            <h5 class="mt-2 graph-title">{{ __('teachers.report.topicWisePerformance') }}</h5>
                                        </div>
                                        <div class="col-md-12">
                                            <textarea class="graph-data d-none">{{ json_encode($studentResponse['topicToSubTopicComparison']) }}</textarea>
                                            <div class="well graph-height">
                                                <canvas id="canvas" height="250" width="300"></canvas>
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
                                            <div class="well graph-height">
                                                <canvas id="canvas2" height="250" width="300"></canvas>
                                                <div class="text-right">
                                                    <button class="btn btn-outline-primary btn-auto d-none" id="previous-subtopic-chart" data-id="0"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                                                    <button class="btn btn-outline-primary btn-auto d-none" id="next-subtopic-chart" data-id="0"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                                                    <button class="btn btn-outline-primary btn-auto d-none" id="close-subtopic-chart" >{!! config('constants.icons.close-icon') !!}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="answer" role="tabpanel" aria-labelledby="answer-tab">
                                    <div class="row mt-2">
                                        <div class="col-md-12 hide-badge">
                                            <h5>{{ __('teachers.report.answerSheet') }}</h5>
                                            @include('students.pages.report.answersheet')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-fullscreen" id="fileModalPreview" data-backdrop="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="fileModalTitle"></h4>
                    <span class="enlarge-popup-btn mr-4 cursor-pointer text-disable">
                        {!! config('constants.icons.enlarge-big-icon') !!}
                    </span>
                    <button type="button" class="close" data-dismiss="modal">
                        {!! config('constants.icons.close-icon') !!}
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" id="fileModalBody"></div>
            </div>
        </div>
    </div>

@endsection
@section('onPageJs')
    <script type="text/javascript" src="{{ asset('assets/plugins/progressbar/circle-progress.js') }}"></script>
       <script type="text/javascript" src="{{ asset('assets/plugins/chartjs/chart.js') }}"></script>
    <script type="text/javascript">
        let topicData = '';
        let data = "";
        let assessmentData = "";
        let chunkSize = 10;
        let topicGraphKey = '';
        let subTopicGraph = '';
        let assessmentBar = '';
        let selectedLabel = '';
        let selectedValue = '';
        let canvas = document.getElementById("canvas");
        let canvas2 = document.getElementById("canvas2");
        let graphMax = `{{ config('constants.graphMax') }}`;
        
        let topicWisePerformance = "{{ __('teachers.report.topicWisePerformance') }}";
        let subtopicWisePerformance = "{{ __('teachers.report.subtopicWisePerformance') }}";
        
        $(document).on ('click', '.showall', function() {
            $('.question-card-outer ul li:gt(9)').removeClass('d-none');
            $(this).addClass('showless').removeClass('showall').text('Show less...');
        });

        $(document).on ('click', '.showless', function() {
            $('.question-card-outer ul li:gt(9)').addClass('d-none');
            $(this).addClass('showall').removeClass('showless').text('Show all...');
        });
        $(document).ready(function() {


            function animateElements() {
                $('.progressbar').each(function() {
                    var elementPos = $(this).offset().top;
                    var topOfWindow = $(window).scrollTop();
                    var percent = $(this).find('.circle').attr('data-percent');
                    var animate = $(this).data('animate');
                    if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
                        $(this).data('animate', true);
                        $(this).find('.circle').circleProgress({
                            // startAngle: -Math.PI / 2,
                            value: percent / 100,
                            size: 400,
                            thickness: 40,
                            fill: {
                                color: '#22ad8c'
                            }
                        }).on('circle-animation-progress', function(event, progress, stepValue) {
                            $(this).find('strong').text((stepValue * 100).toFixed(0) + "%");
                        }).stop();
                    }
                });
            }
            animateElements();
            $(window).scroll(animateElements);
            $('[data-toggle="tooltip"]').tooltip();

            topicData = JSON.parse($('.graph-data').val());
            if(topicData.length > 3) {
                $('.topicWisePerformance').removeClass('d-none');
                topicGraph(0);
            } else {
                let subtopicsData = [];
                $.each(topicData, function (ind, dataVal) { 
                    $.each(dataVal['subTopicComparisionMatrix'], function (subind, subdataVal) { 
                        subtopicsData.push(subdataVal);
                    });
                });
                topicData = subtopicsData;
                $('.subtopicWisePerformance').removeClass('d-none');
                $('#close-subtopic-chart').hide();
                subtopicGraph(topicData, 0);
            }
        });

        canvas.onclick = function (evt) {
            let activePoints = topicGraphKey.getElementsAtEventForMode(evt, 'point', topicGraphKey.options);
            let firstPoint = activePoints['0'];
            if(firstPoint != undefined) {
                selectedLabel = topicGraphKey.data.labels[firstPoint.index];
                selectedValue = topicGraphKey.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
                $.each(topicData, function (ind, dataVal) { 
                    if(dataVal['topicName'] == selectedLabel && parseInt(dataVal['average']) == parseInt(selectedValue)) {
                        $('.subtopicWisePerformance').removeClass('d-none');
                        subtopicGraph(dataVal['subTopicComparisionMatrix'], 0);
                        return
                    }
                });
            }
        };

        $(document).on('click', '#next-topic-chart', function() {
            let nextid = parseInt($(this).attr('data-id')) + 1;
            let previousid = parseInt($(this).attr('data-id'));
            $(this).attr({'data-id': nextid});
            $('#previous-topic-chart').attr({'data-id': previousid});
            if(nextid > 0) {
                $('#previous-topic-chart').removeClass('d-none');
            } else {
                $('#previous-topic-chart').addClass('d-none');
            }
            topicGraph(nextid);
        });

        $(document).on('click', '#previous-topic-chart', function() {
            let nextid = parseInt($(this).attr('data-id'));
            let previousid = parseInt($(this).attr('data-id')) - 1;
            $(this).attr({'data-id': previousid});
            $('#next-topic-chart').attr({'data-id': nextid});
            if(previousid > 0) {
                $('#previous-topic-chart').removeClass('d-none');
            } else {
                $('#previous-topic-chart').addClass('d-none');
            }
            topicGraph(nextid);
        });

        $(document).on('click', '#next-subtopic-chart', function() {
            let nextid = parseInt($(this).attr('data-id')) + 1;
            let previousid = parseInt($(this).attr('data-id'));
            $(this).attr({'data-id': nextid});
            $('#previous-subtopic-chart').attr({'data-id': previousid});
            if(nextid > 0) {
                $('#previous-subtopic-chart').removeClass('d-none');
            } else {
                $('#previous-subtopic-chart').addClass('d-none');
            }
            $.each(topicData, function (ind, dataVal) { 
                if(dataVal['topicName'] == selectedLabel && parseInt(dataVal['average']) == parseInt(selectedValue)) {
                    subtopicGraph(dataVal['subTopicComparisionMatrix'], nextid);
                    return;
                }
            });

            if(topicData[0]['subTopicName'] != undefined) {
                subtopicGraph(topicData, nextid);
                return;
            }
        });

        $(document).on('click', '#previous-subtopic-chart', function() {
            let nextid = parseInt($(this).attr('data-id'));
            let previousid = parseInt($(this).attr('data-id')) - 1;
            $(this).attr({'data-id': previousid});
            $('#next-subtopic-chart').attr({'data-id': nextid});
            if(previousid > 0) {
                $('#previous-subtopic-chart').removeClass('d-none');
            } else {
                $('#previous-subtopic-chart').addClass('d-none');
            }
            $.each(topicData, function (ind, dataVal) { 
                if(dataVal['topicName'] == selectedLabel && parseInt(dataVal['average']) == parseInt(selectedValue)) {
                    subtopicGraph(dataVal['subTopicComparisionMatrix'], nextid);
                    return;
                }
            });

            if(topicData[0]['subTopicName'] != undefined) {
                subtopicGraph(topicData, nextid);
                return;
            }
        });

        $(document).on('click', '#close-subtopic-chart', function() {
            if(subTopicGraph){ 
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
            let labelsChunks = [];
            $('.graph-title').text(`${topicWisePerformance}`);
            $.each(topicData, function (ind, dataVal) { 
                var nameValue = dataVal['topicName'];
                labels[ind] = nameValue;
                averageData[ind] = dataVal['average'];
                comparitiveAverageData[ind] = dataVal['average'];
            });

            while (labels.length > 0) {
                averageChunks.push(averageData.splice(0, chunkSize));
                comparitiveAverageChunks.push(comparitiveAverageData.splice(0, chunkSize));
                labelsChunks.push(labels.splice(0, chunkSize));
            }
            
            if(labelsChunks.length > 1) {
                $('#next-topic-chart').removeClass('d-none');
            }

            if(labelsChunks.length-1 == chunkId) {
                $('#next-topic-chart').addClass('d-none');
            }

            if(labelsChunks.length-1 < 0) {
                $('#previous-topic-chart').addClass('d-none');
            }

            let averageColor = '#49D9F8';
            let comparitiveAveragColor = "black";

            const data = {
                labels: labelsChunks[chunkId],
                datasets: [
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

            if(topicGraphKey)
            { 
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
                                    if(width <= 1280) {
                                        parts = 15;
                                    }
                                    let text = labelsChunks[chunkId][index];
                                    let myRe = /\S[\s\S]{0,15}\S(?=\s|$)/g;
                                    let m;
                                    let result = new Array();
                                    if(text.length > parts) {
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

            $.each(subtopic, function (ind, dataVal) { 
                labels[ind] = dataVal['subTopicName'];
                averageData[ind] = dataVal['average'];
                comparitiveAverageData[ind] = dataVal['average'];
            });

            while (labels.length > 0) {
                averageChunks.push(averageData.splice(0, chunkSize));
                comparitiveAverageChunks.push(comparitiveAverageData.splice(0, chunkSize));
                labelsChunks.push(labels.splice(0, chunkSize));
            }

            if(labelsChunks.length > 1) {
                $('#next-subtopic-chart').removeClass('d-none');
            }

            if(labelsChunks.length-1 == chunkId) {
                $('#next-subtopic-chart').addClass('d-none');
            }

            if(labelsChunks.length-1 < 0) {
                $('#previous-subtopic-chart').addClass('d-none');
            }

            let averageColor = '#49D9F8';        
            const data = {
                labels: labelsChunks[chunkId],
                datasets: [
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

            if(subTopicGraph)
            { 
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
                                    if(width <= 1280) {
                                        parts = 15;
                                    }
                                    let text = labelsChunks[chunkId][index];
                                    let myRe = /\S[\s\S]{0,15}\S(?=\s|$)/g;
                                    let m;
                                    let result = new Array();
                                    if(text.length > parts) {
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

    </script>
@endsection
