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
let assessmentGraph = document.getElementById("assessmentGraph");
let answerSheet = '';

function animateElements() {
    let colorName = "#22ad8c";
    $('.progressbar').each(function() {
        var elementPos = $(this).offset().top;
        var topOfWindow = $(window).scrollTop();
        var percent = $(this).find('.circle').attr('data-percent');
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
                value: percent / 100,
                size: 400,
                thickness: 40,
                fill: {
                    color: colorName
                }
            }).on('circle-animation-progress', function(event, progress, stepValue) {
                $(this).find('strong').text((stepValue * 100).toFixed(0) + "%");
            }).stop();
        }
    });
}

$(document).ready(function() {

    animateElements();

    assessmentData = JSON.parse($('.assessment-graph-data').val());
    if (assessmentData.length > 0) {
        assessmentGraph2(0);
    }

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
        $('.subtopicWisePerformance').removeClass('d-none');
        $('#close-subtopic-chart').hide();
        subtopicGraph(topicData, 0);
    }
});

canvas.onclick = function(evt) {
    let activePoints = topicGraphKey.getElementsAtEventForMode(evt, 'point', topicGraphKey.options);
    let firstPoint = activePoints['0'];
    if (firstPoint != undefined) {
        selectedLabel = topicGraphKey.data.labels[firstPoint.index];
        selectedValue = topicGraphKey.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
        $.each(topicData, function(ind, dataVal) {
            if (dataVal['topicName'] == selectedLabel && parseInt(dataVal['average']) == parseInt(selectedValue)) {
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
        if (dataVal['topicName'] == selectedLabel && parseInt(dataVal['average']) == parseInt(selectedValue)) {
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
        if (dataVal['topicName'] == selectedLabel && parseInt(dataVal['average']) == parseInt(selectedValue)) {
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

function topicGraph(chunkId) {
    let labels = [];
    let averageData = [];
    let comparitiveAverageData = [];
    let averageChunks = [];
    let comparitiveAverageChunks = [];
    let labelsChunks = [];
    $('.graph-title').text(`${topicWisePerformance}`);

    $.each(topicData, function(ind, dataVal) {
        var nameValue = dataVal['topicName'];
        labels[ind] = nameValue;
        averageData[ind] = dataVal['average'].toFixed(2);
        comparitiveAverageData[ind] = dataVal['comparitiveAverage'].toFixed(2);
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
    const data = {
        labels: labelsChunks[chunkId],
        datasets: [{
            label: 'Class Performance',
            data: averageChunks[chunkId],
            borderColor: '#49D9F8',
            backgroundColor: averageColor,
            type: 'bar',
            barPercentage: 0.7,
            barThickness: 25,
            maxBarThickness: 25,
            minBarLength: 2,
        }]
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
                    ticks: {
                        beginAtZero: true,
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
        averageData[ind] = dataVal['average'].toFixed(2);
        comparitiveAverageData[ind] = dataVal['comparitiveAverage'].toFixed(2);
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
                    ticks: {
                        beginAtZero: true,
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
                },
            }
        },
    });
}

function getColorArray(data) {
    let myColors = [];
    $.each(data, function(index, value) {
        if (value > 0 && value <= 25) {
            myColors[index] = "#d05c4d";
        } else if (value > 25 && value <= 50) {
            myColors[index] = "#d0ae5e";
        } else if (value > 50 && value <= 75) {
            myColors[index] = "#19abd4";
        } else if (value > 75 && value <= 100) {
            myColors[index] = "#22ad8c";
        } else {
            myColors[index] = "#d05c4d";
        }
    });
    return myColors;
}

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

function assessmentGraph2(indexId) {
    let labels = [];
    let averageData = [];
    let comparitiveAverageData = [];
    let averageChunks = [];
    let comparitiveAverageChunks = [];
    let labelsChunks = [];
    $('.assessment-graph-title').text(assessmentWisePerformanceText);

    assessmentData = JSON.parse($('.assessment-graph-data').val());
    $.each(assessmentData, function(ind, dataVal) {
        var avgData = (dataVal['classAverage'] * 100) / dataVal['maximumMark'];
        labels[ind] = dataVal['assessmentName'];
        averageData[ind] = Math.round(avgData);
        comparitiveAverageData[ind] = dataVal['classAverage'];
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

    let averageColor = "#49D9F8";

    const graphData = {
        labels: labelsChunks[indexId],
        datasets: [{
            label: "Class Performance",
            data: averageChunks[indexId],
            borderColor: '#49D9F8',
            backgroundColor: averageColor,
            type: 'bar',
            barPercentage: 0.7,
            barThickness: 25,
            maxBarThickness: 25,
            minBarLength: 2
        }]
    };

    if (assessmentBar) {
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
                },
                legend: {
                    align: 'start',
                    position: 'center',
                }
            },
            tooltips: {
                enabled: false,
            },
            scales: {
                y: {
                    stacked: true,
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
                            return labelsChunks[indexId][index].length > parts ? (labelsChunks[indexId][index]).split(' ') : (labelsChunks[indexId][index]);
                        }
                    }
                }
            }
        },
    });
}