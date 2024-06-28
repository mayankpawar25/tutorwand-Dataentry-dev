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
        $('.subtopicWisePerformance').removeClass('d-none');
        $('#close-subtopic-chart').hide();
        subtopicGraph(topicData, 0);
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
    //$('.accordion-heading i').toggleClass(' ');
    $(e.target).prev('.accordion-heading').addClass('accordion-opened');
});

$(document).on('hide', '.accordion', function(e) {
    $(this).find('.accordion-heading').not($(e.target)).removeClass('accordion-opened');
    //$('.accordion-heading i').toggleClass('fa-chevron-right fa-chevron-down');
});

$(document).on('click', '.showall', function() {
    $(".paperData").fadeIn('800');
    $(this).addClass('showless').removeClass('showall').text(`${showLessText}`);
});

$(document).on('click', '.showless', function() {
    $(".paperData").fadeOut('800');
    $(this).addClass('showall').removeClass('showless').text(`${showAllText}`);
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
        averageData[ind] = dataVal['average'];
        comparitiveAverageData[ind] = dataVal['comparitiveAverage'];
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
    let comparitiveAveragColor = getColorArray(comparitiveAverageChunks[chunkId]);

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
                    stacked: true,
                    beginAtZero: true, // minimum value will be 0.
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
        averageData[ind] = dataVal['average'];
        comparitiveAverageData[ind] = dataVal['comparitiveAverage'];
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
                    beginAtZero: true, // minimum value will be 0.
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

$(document).on("change", "#sort-filter", function() {
    let sortData = $(this).val();
    if (sortData.length > 0) {
        var alphabeticallyOrderedDivs = $('.sortingCard').sort(function(a, b) {
            var stringFirst = $(a).data(`${sortData}`);
            var stringSec = $(b).data(`${sortData}`);
            if (!isNaN(stringFirst) && !isNaN(stringSec)) {

                if(stringSec > stringFirst) {
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