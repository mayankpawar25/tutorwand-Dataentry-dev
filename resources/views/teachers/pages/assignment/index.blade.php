@extends('teachers.layouts.default')
@section('content')
    <div class="canvas-inner">
        <div class="row">
            @if(isset($globalEvents) && !empty($globalEvents))
                @foreach($globalEvents as $key => $event)
                    <div class="col-md-6">
                        <div class="canvas-body">
                            <div class="board-outer-box">
                                <div class="icon-box">
                                    <img src="{{ asset('assets/images/teachers/board.png') }}" alt="">
                                    <h4 class="mt-1">{{ $event['eventDescription'] }}</h4>
                                    <a href="{{ route('boardPreparation') }}" class="btn btn-primary">{{ __('teachers.assessment.create') }}</a>
                                </div>
                                @php
                                $videoBtnLabel = '<i class="ft-home-tour-icon">'
                                        .config('constants.icons.tour-icon').
                                    '</i>
                                    <p>'. __('teachers.assessment.takeATour') .'</p>';
                                @endphp
                                <button data-toggle="modal" data-target="#videoModal" data-src="https://www.youtube.com/embed/sseoz6bYZDY" class="video-btn cursor-pointer btn btn-tpt tour-btn d-none" >
                                    <i class="ft-home-tour-icon">
                                        {!! config('constants.icons.tour-icon') !!}
                                    </i>
                                    <p> {!! __('teachers.assessment.takeATour') !!} </p>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="col-md-{{ (isset($globalEvents) && !empty($globalEvents)) ? '6' : '12' }}">
                <div class="canvas-body">
                    <div class="ft-outer-box">
                        <div class="icon-box">
                            {!! config('constants.icons.fastrack-icon') !!}
                            <h5>{{ __('teachers.assessment.fastrack') }}</h5>
                            <p>{{ __('teachers.assessment.createShareLabel') }}</p>
                            <a href="{{ route('fastrack') }}" class="btn btn-primary">{{ __('teachers.assessment.create') }}</a>
                        </div>
                        @php
                        $videoBtnLabel = '<i class="ft-home-tour-icon">'
                                .config('constants.icons.tour-icon').
                            '</i>
                            <p>'. __('teachers.assessment.takeATour') .'</p>';
                        @endphp
                        <button data-toggle="modal" data-target="#videoModal" data-src="https://www.youtube.com/embed/sseoz6bYZDY" class="video-btn cursor-pointer btn btn-tpt tour-btn d-none" >
                            <i class="ft-home-tour-icon">
                                {!! config('constants.icons.tour-icon') !!}
                            </i>
                            <p> {!! __('teachers.assessment.takeATour') !!} </p>
                        </button>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-6">
                <div class="canvas-body">
                    <div class="manual-outer-box">
                        <div class="icon-box">
                            {!! config('constants.icons.manual-icon') !!}
                            <h5>{{ __('teachers.assessment.manual') }}</h5>
                            <p>{{ __('teachers.assessment.createManuallyLabel') }}</p>
                            <button class="btn btn-outline-primary">{{ __('teachers.assessment.create') }}</button>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="tab-panel-box mt-4">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __('teachers.assessment.previouslyCreated') }}</a>
                </li>
                <li class="nav-item d-none">
                    <a class="nav-link" id="sample-tab" data-toggle="tab" href="#sample" role="tab" aria-controls="sample" aria-selected="false">{{ __('teachers.assessment.sample') }}</a>
                </li>
            </ul>
            <div class="filter-box">
                <div class="form-group ">

                    <div class="row">
                        <div class="col-md-6">
                            <select class="selectpicker form-control" name="subject_filter" id="subject-filter" title="Filter by Subject">
                                <option value=""> {{ __('teachers.assessment.filterBy') }} {{ __('teachers.assessment.subject') }}</option>
                                @php
                                    foreach($previouslyCreated['subjects'] as $subject) {
                                @endphp
                                        <option>{{ $subject }}</option>
                                @php
                                    }
                                @endphp
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="selectpicker form-control" name="grade_filter" id="grade-filter" title="Filter by Grade">
                                <option value=""> {{ __('teachers.assessment.filterBy') }} {{ __('teachers.assessment.grade') }}</option>
                                @php
                                    foreach($previouslyCreated['grades'] as $grade) {
                                @endphp
                                        <option>{{ $grade }}</option>
                                @php
                                    }
                                @endphp
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="accordion" id="card-list">
                        @php
                            if(isset($previouslyCreated['assignments']) && !empty($previouslyCreated['assignments'])) {  
                                foreach($previouslyCreated['assignments'] as $key => $assignment) {
                                    $subject = $assignment['subject'];
                                    $grade = $assignment['grade'];
                        @endphp
                                    <div class="accordion-group" data-subject="{{ $subject }}" data-grade="{{ $grade }}">
                                        <div class="accordion-heading">
                                            <div class="card">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center">
                                                            <div class="icon">
                                                                {!! config('constants.icons.add-response') !!}
                                                            </div>
                                                            <div class="sub-name">
                                                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="card-list" href="#sample{{ $key }}" tabindex="0" role="button">{{ $assignment['paperName'] }} </a>
                                                                <p> {{ $assignment['board'] }}, {{ $assignment['grade'] }}, {{ $assignment['subject'] }} | TutorWand question bank
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card-action-box">
                                                            <div class="time">
                                                                {{ $assignment['testDuration'] }}
                                                                <small>
                                                                    {{ __("teachers.assessment.min") }}
                                                                </small>
                                                            </div>
                                                            @php
                                                                $content = '';
                                                                if(!empty($assignment['assignmentFormat']['questionFormats'])) {
                                                                    $content = view('teachers.includes.content', ['data' => $assignment['assignmentFormat']['questionFormats']])->render();
                                                                }
                                                            @endphp
                                                            <div class="point" data-placement="top" data-placement="top" data-trigger="hover focus" data-toggle="popover" title="{{ !empty($assignment['assignmentFormat']['formatName']) ? $assignment['assignmentFormat']['formatName'] : '' }}" data-html="true" data-content="{!! $content !!}"  tabindex="0" role="button">
                                                                {{ $assignment['maximumMarks'] }}<small>{{ pointText($assignment['maximumMarks']) }}</small>
                                                            </div>
                                                            <a href="{{ route('paper', base64_encode($assignment['paperId'])) }}" class="btn btn-primary auto-width mr-3">{{ __("teachers.button.assign") }}</a>
                                                            <div class="accordion-toggle collapsed" data-toggle="collapse" data-parent="card-list" href="#sample{{ $key }}" tabindex="0" role="button">
                                                                <i class="fa"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div id="sample{{ $key }}" class="accordion-body collapse">
                                                    <div class="accordion-inner">
                                                        <table class="table table-bordered mb-0 mt-2">
                                                            <thead>
                                                                <tr>
                                                                    <th>{{ __('teachers.assessment.topic') }}</th>
                                                                    <th>{{ __('teachers.assessment.subtopic') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    foreach($assignment['topicToSubtopicMap'] as $topic => $subtopic) {
                                                                        $st =  implode(' | ',$subtopic);
                                                                @endphp
                                                                        <tr>
                                                                            <td>{{ $topic }}</td>
                                                                            <td>{{ $st }}</td>
                                                                        </tr>
                                                                @php
                                                                    }
                                                                @endphp
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        @php
                                }
                            } else {
                        @endphp
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center">
                                                    {{ __("teachers.assessment.noAssessmentAvailable") }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @php
                            }
                        @endphp
                    </div>

                </div>
            </div>
        </div>
        <div class="canvas-footer">

        </div>
    </div>

    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content"> 
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" tabindex="1" role="button">
                       {!! config('constants.icons.close-icon') !!}
                    </button>        
                        <!-- 16:9 aspect ratio -->
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="" id="videoplayer" allowfullscreen allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>     
@stop
