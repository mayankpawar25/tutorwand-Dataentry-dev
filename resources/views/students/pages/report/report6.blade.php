@extends('students.layouts.default')
@section('title', __('students.siteTitle'))
@section('content')
<div class="container-fluid">
    <div class="row g-2">
        <div class="col-md-3 text-center">
            <div class="well">
                <div class="student-icon-card">
                    <img src="{!! handleProfilePic($studentData['profilePicUrl']) !!}">
                </div>
                <h5 class="mt-2 mb-0"> {{ getStudentName() }} </h5>
                <h5 class="mt-2 mb-0">{{ __('teachers.report.board') }} {{ $studentReportBySubject['board']['boardName'] }} | {{ __('teachers.assessment.grade') }} {{ $studentReportBySubject['grade']['gradeName'] }}</h5>
                <h5 class="mt-2 mb-0">{{ __('teachers.assessment.subject') }} {{ $studentReportBySubject['subject']['subjectName'] }}</h5>
            </div>
        </div>
        <div class="col-md-3 attempt-count text-center">
            <div class="well pt-4 pb-4">
            <br>
                <h1 class="mb-1">{{ $studentReportBySubject['attemptedAssessment'] . '/' . $studentReportBySubject['totalAssessment'] }}</h1><br class="d-none d-lg-block d-md-block">
                <p>{{ __('teachers.report.assessmentAttempted') }}</p>
            </div>
        </div>
        <div class="col-md-3">

        </div>
    </div>
    @if(isset($studentReportBySubject))
        <div class="row">
            <!-- topic -->
            <div class="col-md-12 mt-4">
                <h5 class="mb-2">{{ __('teachers.report.assessmentWisePerformance') }}</h5>
            </div>
            <div class="col-md-12">
                <div class="well graph-height">
                    <textarea class="assessment-graph-data d-none">{{ json_encode($studentReportBySubject['assessmentPerformanceMatrix']) }}</textarea>
                    <canvas id="assessmentGraph" width="300" height="250"></canvas>
                    <div class="text-right">
                        <button class="btn btn-outline-primary btn-auto d-none" id="previous-assessment-chart" data-id="0"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                        <button class="btn btn-outline-primary btn-auto d-none" id="next-assessment-chart" data-id="0"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row topicWisePerformance d-none">
            <!-- topic -->
            <div class="col-md-12 mt-4">
                <h5 class="mb-2">{{ __('teachers.report.topicWisePerformance') }}</h5>
            </div>
            <div class="col-md-12">
                <div class="well graph-height">
                    <textarea class="graph-data d-none">{{ json_encode($studentReportBySubject['topicWisePerformaceMatrix']) }}</textarea>
                    <canvas id="canvas" width="300" height="250"></canvas>
                    <div class="text-right">
                        <button class="btn btn-outline-primary btn-auto d-none" id="previous-topic-chart" data-id="0"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                        <button class="btn btn-outline-primary btn-auto d-none" id="next-topic-chart" data-id="0"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- subtopic -->
        <div class="row  subtopicWisePerformance d-none">
            <div class="col-md-12"><h5 class="mb-2 subtopic-title d-none">{{ __('teachers.report.subtopicWisePerformance') }}</h5></div>
            <div class="col-md-12">
                <div class="well graph-height">
                    <canvas id="canvas2" height="250" width="300"></canvas>
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

        <div class="row mt-4">
            <div class="col-md-6">
                <h5 class="mb-2 mt-2">{{ __('teachers.report.assessmentList') }}</h5>
            </div>
            <div class="col-md-6 text-right">
                <div class="form-group mb-1 mx-120 float-right">
                </div>
            </div>
        </div>
        <div class="tab-panel-box">
           <div class="tab-content">
                <div class="report-student-list-outer">
                    @if(isset($studentReportBySubject['assessmentPerformanceMatrix']) && !empty($studentReportBySubject['assessmentPerformanceMatrix']))
                        @foreach($studentReportBySubject['assessmentPerformanceMatrix'] as $assessment)
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
                                                <h5 class="mt-0 mb-1">{{ $assessment['assessmentName'] }}</h5>
                                                @if($assessment['isAttempted'])
                                                    <p> {{ sprintf(__('teachers.report.submittedOn'), utcToDate($assessment['submissionDate'])) }} | {{ sprintf(__('teachers.report.resultOn'), utcToDate($assessment['resultDate'])) }} </p>
                                                @endif
                                            </div>
                        
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-action-box">
                                            @if($assessment['isAttempted'])
                                                <div class="rank-badge">
                                                    <div class="mt-1">{{ __('teachers.report.rank') }}</div>
                                                    <h2>{{ $assessment['rank'] }}</h2>
                                                </div>
                                                <div class="progressbar ml-4">
                                                    <div class="student-point circle" data-percent="{{ number_format(($assessment['optainedMark'] * 100) / $assessment['totalMark']) }}">
                                                        <strong></strong>
                                                        <span></span>
                                                    </div>
                                                </div>

                                                <div class="row-point-badge ml-2">
                                                    <span class="d-none d-lg-block d-md-block">{{ __('teachers.report.points') }}:</span> {{ $assessment['optainedMark'] }} / {{ $assessment['totalMark'] }}
                                                </div>
                                                <a href="{{ route('students.assessment.report', base64_encode($assessment['assessmentId'] .'_'. $ClassRoomId)) }}" class="btn btn-primary auto-width ml-4"><i class="fa fa-eye" aria-hidden="true"></i>  {{ __('teachers.report.view') }}</a>
                                            @else
                                                <div class="sub-name mt-2 mr-1"><p class="text-danger mb-0 text-right"><strong>{{ __('teachers.grading.missed') }}</strong></p></div>
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
    @endif
@endsection
@section('onPageJs')
    <script type="text/javascript" src="{{ asset('assets/plugins/progressbar/circle-progress.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/chartjs/chart.js') }}"></script>
    <script type="text/javascript">
        let topicData = '';
        let data = "";
        let assessmentData = "";
        let assessmentPagination = [];
        let currentAssessmentPage = 0;
        let totalAssessmentsSize = "";
        let chunkSize = 10;
        let topicGraphKey = '';
        let subTopicGraph = '';
        let assessmentBar = '';
        let selectedLabel = '';
        let selectedValue = '';
        let canvas = document.getElementById("canvas");
        let canvas2 = document.getElementById("canvas2");
        let assessmentGraph = document.getElementById("assessmentGraph");
        let answerSheet = '';
        let graphMax = `{{ config('constants.graphMax') }}`;
        
        let topicWisePerformance = "{{ __('teachers.report.topicWisePerformance') }}";
        let subtopicWisePerformance = "{{ __('teachers.report.subtopicWisePerformance') }}";
        let assessmentWisePerformanceText = `{{ __('teachers.report.assessmentWisePerformance') }}`

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

            assessmentData = JSON.parse($('.assessment-graph-data').val());
            if(assessmentData.length > 0) {
                assessmentGraph2(0);
            }

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
                    if(dataVal['topicName'] == selectedLabel && parseInt(dataVal['comparitiveAverage']) == parseInt(selectedValue)) {
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

        $(document).on('click', '#next-assessment-chart', function() {
            currentAssessmentPage = currentAssessmentPage + 1;

            /* Next Button Hide / Show */
            if(currentAssessmentPage == 0 && currentAssessmentPage < totalAssessmentsSize.length - 1) {
                $('#next-assessment-chart').addClass('d-none');
            } else {
                $('#next-assessment-chart').removeClass('d-none');
            }

            /* Previous Hide / Show */
            if(currentAssessmentPage <= 0) {
                $('#previous-assessment-chart').addClass('d-none');
            } else {
                $('#previous-assessment-chart').removeClass('d-none');
            }
            assessmentGraph2(currentAssessmentPage);
        });

        $(document).on('click', '#previous-assessment-chart', function() {
            currentAssessmentPage = currentAssessmentPage - 1;

            /* Next Button Hide / Show */
            if(currentAssessmentPage == 0 && currentAssessmentPage < totalAssessmentsSize.length - 1) {
                $('#next-assessment-chart').addClass('d-none');
            } else {
                $('#next-assessment-chart').removeClass('d-none');
            }

            /* Previous Button Hide / Show */
            if(currentAssessmentPage == 0) {
                $('#previous-assessment-chart').addClass('d-none');
            } else {
                $('#previous-assessment-chart').removeClass('d-none');
            }
            assessmentGraph2(currentAssessmentPage);
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
                averageData[ind] = dataVal['comparitiveAverage'];
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
                        label: '{{__("students.reportPage.graphLabel1")}}',
                        data: comparitiveAverageChunks[chunkId],
                        borderColor: 'black',
                        backgroundColor: comparitiveAveragColor,
                        type: 'line'
                    },
                    {
                        label: '{{__("students.reportPage.graphLabel2")}}',
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
                    layout: {
                    padding: 0
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
                averageData[ind] = dataVal['comparitiveAverage'];
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
                    layout: {
                    padding: 0
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

        function assessmentGraph2(indexId) {
            let labels = [];
            let averageData = [];
            let comparitiveAverageData = [];
            let averageChunks = [];
            let comparitiveAverageChunks = [];
            let labelsChunks = [];
            $('.assessment-graph-title').text(assessmentWisePerformanceText);

            assessmentData = JSON.parse($('.assessment-graph-data').val());
            $.each(assessmentData, function (ind, dataVal) {
                labels[ind] = dataVal['assessmentName'];
                averageData[ind] = (dataVal['optainedMark'] * 100) / dataVal['totalMark'];
                comparitiveAverageData[ind] = (dataVal['classAverage'] * 100) / dataVal['totalMark'];
            });

            while (labels.length > 0) {
                averageChunks.push(averageData.splice(0, chunkSize));
                comparitiveAverageChunks.push(comparitiveAverageData.splice(0, chunkSize));
                labelsChunks.push(labels.splice(0, chunkSize));
            }
            
            if(labelsChunks.length > 1) {
                $('#next-assessment-chart').removeClass('d-none');
            }

            if(labelsChunks.length-1 == indexId) {
                $('#next-assessment-chart').addClass('d-none');
            }

            if(labelsChunks.length-1 < 0) {
                $('#previous-assessment-chart').addClass('d-none');
            }

            assessmentPagination = labelsChunks;
            totalAssessmentsSize = labelsChunks.length;

            let averageColor = "#49D9F8";
            let comparitiveAveragColor = "black";
            
            const graphData = {
                labels: labelsChunks[indexId],
                datasets: [
                    {
                        label: 'Class Average',
                        data: comparitiveAverageChunks[indexId],
                        borderColor: '#212121',
                        backgroundColor: comparitiveAveragColor,
                        type: 'line',
                        barPercentage: 0.7,
                        barThickness: 25,
                        maxBarThickness: 25,
                        minBarLength: 2,
                    },
                    {
                        label: 'Student Average',
                        data: averageChunks[indexId],
                        borderColor: 'black',
                        backgroundColor: averageColor,
                        type: 'bar',
                        barPercentage: 0.7,
                        barThickness: 25,
                        maxBarThickness: 25,
                        minBarLength: 2,
                    },
                    
                ]
            };

            if(assessmentBar)
            { 
                assessmentBar.destroy();
            }

            var ctx = assessmentGraph.getContext("2d");
            assessmentBar = new Chart(ctx, {  
                type: 'line',  
                data: graphData,
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: ``
                        }
                    },
                    layout: {
                    padding: 0
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
                        }
                    }
                }, 
            });
        }

    </script>
@endsection