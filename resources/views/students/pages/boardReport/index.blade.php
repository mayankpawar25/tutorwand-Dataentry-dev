@extends('students.layouts.default')
@section('title', __('students.siteTitle') )
@section('content')
<div class="container-fluid global-report">
    <div class="row g-2">
        <div class="col-md-3 text-center">
            <div class="well global-profile">
                <div class="student-icon-card">
                    <img src="{!! getStudentProfileImage() !!}">
                </div>
                <div class="global-profile-meta">
                <p class="mb-0"> {{ getStudentName() }} </p>
                <p class="mb-0">{{ __('teachers.report.board') }}:  {{ $board['boardName'] }}  </p>
                <p class="mb-0">{{ __('teachers.assessment.grade') }}:  {{ $grade['gradeName'] }} </p>
                </div>
            </div>
        </div>
        <div class="col-md-3 attempt-count text-center">
            <div class="well global-assessment-count">
                <div><p class="mb-0">{{ __('teachers.report.assessmentAttempted') }}</p></div>
                <div><h1 class="mb-1">{{ $attemptedAssessment . '/' . $totalAssessment }}</h1></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="well point-card pt-3 pb-3 ">
                <div class="icon">{!! config('constants.icons.points-icon') !!}</div>
                <div class="point-count">
                    <h3><span>Total {{ __('teachers.report.points') }}</span>
                        <font class="counter-count">{{$obtainMaxMarks}}</font>/{{$totalMaxMarks}}</h3>
                        
                        
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- topic -->
        <div class="col-md-12 mt-1">
            <h5 class="mb-2">{{ __('teachers.report.assessmentWisePerformance') }}</h5>
        </div>
        <div class="col-md-12">
            <div class="well graph-height">
                <textarea class="assessment-graph-data d-none">{{ json_encode($assessmentPerformanceMatrix) }}</textarea>
                <canvas id="assessmentGraph" width="300" height="250"></canvas>
                <div class="text-right">
                    <button class="btn btn-outline-primary btn-auto d-none" id="previous-assessment-chart" data-id="0"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                    <button class="btn btn-outline-primary btn-auto d-none" id="next-assessment-chart" data-id="0"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
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
                @if(isset($assessmentPerformanceMatrix) && !empty($assessmentPerformanceMatrix))
                    @foreach($assessmentPerformanceMatrix as $assessment)
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
                                            @if(isset($assessment['isAttempted']) && $assessment['isAttempted'])
                                                <p> {{ sprintf(__('teachers.report.submittedOn'), utcToDate($assessment['submissionDate'])) }} | {{ sprintf(__('teachers.report.resultOn'), utcToDate($assessment['resultDate'])) }} </p>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-action-box">
                                        @if(isset($assessment['isAttempted']) && $assessment['isAttempted'])
                                            <div class="progressbar ml-4">
                                                @php 
                                                    $perc = ($assessment['optainedMark']*100)/$assessment['totalMark'];
                                                @endphp
                                                <div class="student-point circle" data-percent="{{$perc}}">
                                                    <strong>{{$perc}}%</strong>
                                                    <span></span>
                                                </div>
                                            </div>

                                            <div class="row-point-badge ml-2">
                                                <span class="d-none d-lg-block d-md-block">Points:</span> {{ $assessment['optainedMark'] }} / {{ $assessment['totalMark'] }}
                                            </div>
                                            <a href="{{ route('students.class.subject.report', base64_encode($assessment['assessmentId'])) }}" class="btn btn-primary auto-width ml-4"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                                        @else
                                            <p class="text-danger mb-0 text-right"><strong>{{ __('teachers.grading.missed') }}</strong></p>
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
@endsection
@section('onPageJs')
<script type="text/javascript" src="{{ asset('assets/plugins/progressbar/circle-progress.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/chartjs/chart.js') }}"></script>
<script>
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
    $(document).ready(function(){
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
            assessmentGraphData(0);
        }
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
        assessmentGraphData(currentAssessmentPage);
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
        assessmentGraphData(currentAssessmentPage);
    });

    function assessmentGraphData(indexId) {
        let labels = [];
        let averageData = [];
        let averageChunks = [];
        let comparitiveAverageData = [];
        let comparitiveAverageChunks = [];
        let globalAverageChunks = [];
        let globalAverageData = [];
        let labelsChunks = [];
        $('.assessment-graph-title').text(assessmentWisePerformanceText);

        assessmentData = JSON.parse($('.assessment-graph-data').val());
        $.each(assessmentData, function (ind, dataVal) {
            labels[ind] = dataVal['assessmentName'];
            averageData[ind] = (dataVal['optainedMark'] * 100) / dataVal['totalMark'];
            comparitiveAverageData[ind] = (dataVal['classAverage'] * 100) / dataVal['totalMark'];
            globalAverageData[ind] = (dataVal['globalAverage'] * 100) / dataVal['totalMark'];
        });

        while (labels.length > 0) {
            averageChunks.push(averageData.splice(0, chunkSize));
            comparitiveAverageChunks.push(comparitiveAverageData.splice(0, chunkSize));
            globalAverageChunks.push(globalAverageData.splice(0, chunkSize));
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
                    label: 'Global Average',
                    data: globalAverageChunks[indexId],
                    borderColor: '#D1AD6A',
                    backgroundColor: "#D1AD6A",
                    type: 'line',
                    barPercentage: 0.7,
                    barThickness: 25,
                    maxBarThickness: 25,
                    minBarLength: 2,
                },
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
                        stacked: true
                    }
                }
            }, 
        });
    }

</script>
@endsection