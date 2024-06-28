<script type="text/javascript">
    // circle graph sawan
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
    let graphMax = `{{ config('constants.graphMax') }}`;

    $(document).ready(function($) {
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
            subtopicGraph(topicData, 0);
            $('#close-subtopic-chart').hide();
            $('.subtopicWisePerformance').removeClass('d-none');
        }
    });

    //counter
    $('.counter-count').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {

            //chnage count up speed here
            duration: 1000,
            easing: 'swing',
            step: function(now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    // smaple ans arrow
    $(document).on('show', '.accordion', function(e) {
        $(e.target).prev('.accordion-heading').addClass('accordion-opened');
    });

    $(document).on('hide', '.accordion', function(e) {
        $(this).find('.accordion-heading').not($(e.target)).removeClass('accordion-opened');
        //$('.accordion-heading i').toggleClass('fa-chevron-right fa-chevron-down');
    });


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
            if(dataVal['topicName'] == selectedLabel && parseInt(dataVal['comparitiveAverage']) == parseInt(selectedValue)) {
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
            if(dataVal['topicName'] == selectedLabel && parseInt(dataVal['comparitiveAverage']) == parseInt(selectedValue)) {
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
        $('.graph-title').text(`${topicWisePerformanceText}`);

        $.each(topicData, function (indVal, dataVal) { 
            labels[indVal] = dataVal['topicName'];
            averageData[indVal] = dataVal['comparitiveAverage'];
            comparitiveAverageData[indVal] = dataVal['average'];
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
            averageData[ind] = dataVal['studentAverage'];
            comparitiveAverageData[ind] = dataVal['classAverage'];
        });

        while (labels.length > 0) {
            averageChunks.push(averageData.splice(0, chunkSize));
            comparitiveAverageChunks.push(comparitiveAverageData.splice(0, chunkSize));
            labelsChunks.push(labels.splice(0, chunkSize));
        }

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
                plugins: {
                    title: {
                        display: true,
                        text: ``
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
                    }
                }
            }, 
        });
    }

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

    $(document).on ('click', '.showall', function() {
        $('.question-card-outer ul li:gt(9)').removeClass('d-none');
        $(this).addClass('showless').removeClass('showall').text('Show less...');
    });

    $(document).on ('click', '.showless', function() {
        $('.question-card-outer ul li:gt(9)').addClass('d-none');
        $(this).addClass('showall').removeClass('showless').text('Show all...');
    });

    function getColorArray (data) {
        let myColors = [];
        $.each(data, function( index,value ) {
            if(value > 0 && value <= 25){
                myColors[index]="#d05c4d";
            }else if(value > 25 && value <= 50){
                myColors[index]="#d0ae5e";
            }else if(value > 50 && value <= 75){
                myColors[index]="#19abd4";
            }else if(value > 75 && value <= 100){
                myColors[index]="#22ad8c";
            }else{
                myColors[index]="#d05c4d";
            }
        });
        return myColors;
    }

    $(document).on('click', '#answer-tab', function() {
        if ($.trim($('#answer').text()).length == 0 && answerSheet.length == 0) {
            $("#answer").html(`{{ view("teachers.includes.loader") }}`);

            let studentId = $('input[name=studentId]').val();
            let responseId = $('input[name=responseId]').val();
            let assessmentId = $('input[name=assessmentId]').val();

            let data = {'responseId': responseId, 'studentId': studentId, 'paperId': assessmentId};
            
            $.ajax({
                type: "POST",
                url: "{{ route('student.answersheet') }}",
                data: data,
                dataType: "html",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                success: function (response) {
                    $('#answer').html(response);
                }
            });
        } else {
            $("#answer").html(`{{ view("teachers.includes.loader") }}`);
            $('#answer').html(answerSheet);
        }
        return;
    });

    $(document).on('click', '#summary-tab', function() {
        answerSheet = $("#answer").html();
        $("#answer").html(``);
    });
</script>
