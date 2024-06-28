@extends('teachers.layouts.grading')
@section('content')
	<div class="canvas-area hide-right-panel">
        <div class="canvas-inner position-relative">
            <div class="canvas-body">
                <!-- accordion box -->
                <div class="accordion" id="accordiongrading">
                    {{ csrf_field() }}
                    @if (isset($studentResponse['responses']) && !empty($studentResponse['responses']))
                        <input type="hidden" name="studentListUrl" value="{{ route('grading.studentListUrl') }}">
                        <input type="hidden" name="gradingUrl" value="{{ route('grading.save') }}">
                        <input type="hidden" name="assessmentId" value="{{ $studentResponse['paperId'] }}">
                        <input type="hidden" name="studentId" value="{{ $studentResponse['studentId'] }}">
                        <input type="hidden" name="responseId" value="{{ $studentResponse['responseId'] }}">
                        @foreach ($studentResponse['responses'] as $responseKey => $response)
                            @php 
                                $response = decryptBlobData($response); 
                            @endphp

                            <div class="card {{ strtolower($response['answer']['status']) }} answerStatus" id="question_{{ $response['questionId'] }}" data-status="{{ strtolower($response['answer']['status']) }}" data-autograded="{{ strtolower($response['answer']['isAutoGraded']) }}">
                                {{-- Question Section --}}
                                <div class="card-header" id="heading{{ $responseKey }}">
                                    <div class="question-text d-table w-100 ">
                                        <div class="q-text d-table-cell v-top">
                                            <div class="question-list">
                                                <div class="q-serial">{{ $responseKey + 1 }}</div>
                                                {!! removeSpace($response['questionText']) !!}
                                            </div>
                                        </div>
                                        <div class="q-action-block d-table-cell pull-right ">

                                            <div class="pull-right toggle-btn" data-toggle="collapse" data-target="#collapse{{ $responseKey }}" aria-expanded="true" aria-controls="collapse{{ $responseKey }}"><i class="fa"></i></div>

                                            <div class="w-120 pull-right">
                                                <div class="input-group point-input">
                                                    
                                                    <input type="text" class="form-control mx-width-50 calculateGradeMarks" placeholder="-" value="{{ (strtolower($response['answer']['status']) == 'ungraded') ? '' : $response['answer']['gradedMarks'] }}" data-questionId="{{ $response['questionId'] }}" data-sequence="{{ $responseKey + 1 }}" aria-label="{{ $response['answer']['gradedMarks'] }}" data-maxMarks="{{ $response['answer']['maximumMarks'] }}" data-oldmarks="{{ $response['answer']['gradedMarks'] }}" maxlength="2">
                                                    
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">{{ $response['answer']['maximumMarks'] }}</span>
                                                    </div>
                                                    @if ($response['answer']['status'] == 'Graded' && $response['answer']['isAutoGraded'] == true)
                                                        <div class="auto-grade-lable auto-over-riden updateNewStatus">{{ __('grading.override') }}</div>
                                                    @elseif ($response['answer']['status'] == 'AutoGraded')
                                                        <div class="auto-grade-lable updateNewStatus">{{ __('grading.'.strtolower($response['answer']['status'])) }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                            @if (isset($response['errored']) && $response['errored'] == true)
                                                <div class="repot-q float-lg-right" data-toggle="tooltip" title="Question Reported">
                                                    {!! config('constants.icons.error-report-svg') !!}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Option Section --}}
                                <div id="collapse{{ $responseKey }}" class="collapse show" aria-labelledby="heading{{ $responseKey }}" data-parent="#accordionExample">
                                    <div class="card-body">

                                        @include('teachers.pages.grading.options.'.strtolower(str_replace(" ","-",getTemplateName($response['questionType']))))

                                    </div>

                                    {{-- Timer and Award Icons --}}
                                    <div class="card-footer d-flex justify-content-between">
                                        <div class="timer">
                                            {!! config('constants.icons.timer-icon') !!}
                                            @php
                                                $seconds = $response['timeSpent'];
                                                $minutes = floor($seconds/60);
                                                $secondsleft = $seconds%60;
                                                if($minutes<10)
                                                    $minutes = "0" . $minutes;
                                                if($secondsleft<10)
                                                    $secondsleft = "0" . $secondsleft;
                                            @endphp
                                            <span>{{ $minutes . ':' . $secondsleft }} {{ __('grading.minutes') }}</span>
                                        </div>
                                        <div class="badges d-flex">
                                            @php

                                                $good_d_none = "";
                                                $good_d_block = "";

                                                $excellent_d_none = "";
                                                $excellent_d_block = "";

                                                $awesome_d_none = "";
                                                $awesome_d_block = "";
                                            @endphp
                                            @if (isset($response['answer']['badge']) && !empty($response['answer']['badge']))

                                                @if (in_array('Excellent', $response['answer']['badge']))
                                                    @php 
                                                        $good_d_none = "d-none";
                                                        $good_d_block = "d-block";
                                                    @endphp
                                                @endif

                                                @if (in_array('Perfect', $response['answer']['badge']))
                                                    @php 
                                                        $excellent_d_none = "d-none";
                                                        $excellent_d_block = "d-block";
                                                    @endphp
                                                @endif

                                                @if (in_array('VeryCreative', $response['answer']['badge']))
                                                    @php 
                                                        $awesome_d_none = "d-none";
                                                        $awesome_d_block = "d-block";
                                                    @endphp
                                                @endif
                                            @endif

                                            <div class="badge-award click-event-badge award" data-toggle="tooltip" data-title="Excellent" data-questionid="{{ $response['questionId'] }}">
                                                <span class="normal {{ $good_d_none }}">
                                                    {!! config('constants.icons.award-one') !!}
                                                </span>

                                                <span class="coloured {{ $good_d_block }}">
                                                    {!! config('constants.icons.award-one-coloured') !!}
                                                </span>
                                            </div>
                                            <div class="badge-award click-event-badge shield" data-toggle="tooltip" data-title="Perfect" data-questionid="{{ $response['questionId'] }}">
                                                <span class="normal {{ $excellent_d_none }}">
                                                    {!! config('constants.icons.award-two') !!}
                                                </span>

                                                <span class="coloured {{ $excellent_d_block }}">   
                                                    {!! config('constants.icons.award-two-coloured') !!}              
                                                </span>
                                            </div>
                                            <div class="badge-award click-event-badge madel" data-toggle="tooltip" data-title="Very Creative" data-questionid="{{ $response['questionId'] }}">
                                                <span class="normal {{ $awesome_d_none }}">
                                                    {!! config('constants.icons.award-three') !!}
                                                </span>

                                                <span class="coloured {{ $awesome_d_block }}">
                                                    {!! config('constants.icons.award-three-coloured') !!}
                                                </span>
                                            </div>
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
    @include('teachers.layouts.partials.rightPanel')

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
    <script type="text/javascript">
        let warningMaximumMarks = "{{ __('teachers.grading.awardedMore') }}";
    </script>
@endsection