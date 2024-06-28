@extends('teachers.layouts.ajax')
@section('content')
    @php
        if (!isset($canvasData['questions']) || empty($canvasData['questions'])) {
    @endphp
            <h4>No Data Available</h4>
    @php
        } else { 
            $allowedQuestionTypes = ['529kWMwg', 'HH9Tu7BZ', 'nOFiSUZ8', 'Tqg3XB1M', '4NcrZAcU'];
            $questionnumber = 1;
            $data_id = 0;
        @endphp
            <input type="hidden" name="paperId" id="newPaperId" value="{{ $canvasData['questionPaperId'] }}">
        @php
            foreach ($canvasData['questions'] as $id => $question) {
                $question = decryptBlobData($question);
                if (in_array($question['questionTypeId'], $allowedQuestionTypes)){
                    @endphp
                    <div class="question-block" id="quest{{ $questionnumber }}">
                        <div class="question-text d-table w-100">
                            <div class="q-text d-table-cell v-top" data-id="{{ $question['id'] }}">
                                <div class="question-list">
                                    <div class="q-serial">{{ $questionnumber }}</div>
                                   {!! html_entity_decode($question['questionText']) !!}
                                </div>
                            </div>
                            <div class="q-action-block d-table-cell pull-right">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button class="btn point-badge ">{{ $question['weightage'] }}
                                        <small>{{ pointText($question['weightage']) }}</small>
                                    </button>
                                    <button class="btn btn-secondary swap-question btn-tpt" data-questionnumber="{{ $questionnumber }}" data-questionid="{{ $question['id'] }}" data-paperid="{{ $canvasData['questionPaperId'] }}">
                                        <i class="fa fa-refresh" data-toggle="tooltip" title="Swap" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn btn-secondary slide-jump btn-tpt" data-id="{{ $data_id }}">
                                        <i class="fa fa-eye" aria-hidden="true" data-toggle="tooltip" title="Preview" ></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                            @php
                                if($question['questionTypeId'] == config("constants.mcqId")) {
                            @endphp
                                <div class="row mt-2">
                            @php
                                    $alphabet = 'A';
                                    foreach ($question['answerBlock']['options'] as $pid => $option) {
                            @endphp
                                        <div class="col-sm-12 mb-1" data-id="{{ $option['id'] }}">
                                            <div class="option-list option-radio">
                                                <label>
                                                    <span class="sr-no">{{ $alphabet }}</span> {!! $option['optionText'] !!}
                                                </label>
                                            </div>
                                        </div>
                            @php
                                        $alphabet++;
                                    }
                            @endphp
                                </div>
                            @php
                                } elseif($question['questionTypeId'] == config("constants.trueFalseId")) {
                            @endphp
                                <div class="row mt-2">
                            @php
                                    $alphabet = 'A';
                                    foreach ($question['answerBlock']['options'] as $pid => $option) {
                            @endphp
                                        <div class="col-sm-12 mb-1" data-id="{{ $option['id'] }}">
                                            <div class="option-list option-radio">
                                                <label>
                                                    <span class="sr-no">{{ $alphabet }}</span> <p>{!! $option['optionText'] !!}</p>
                                                </label>
                                            </div>
                                        </div>
                            @php
                                        $alphabet++;
                                    }
                            @endphp
                                </div>
                            @php
                                }
                            @endphp                
                    </div>
                    <hr>
                    @php
                    $data_id++;
                    $questionnumber++;
                }
            }
        }
    @endphp
@stop
{{-- preview-modal --}}
<div class="modal" id="preview">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{-- Modal Header --}}
            <div class="modal-header">
                <h4 class="modal-title text-brand"> {{ __('questionReview.preview') }} </h4>
                <div class="enlarge-popup-btn1 mr-4 cursor-pointer"> 
                    <div class="btn-group">
                        <button type="button" class="btn btn-tpt swap-question-modal has-modal">
                            <i class="fa fa-refresh" aria-hidden="true" data-toggle="tooltip" title="Swap" ></i>
                        </button>
                        <button type="button"  class="btn btn-tpt dropdown-toggle after-none flag-btn" data-toggle="question-option-checkboxes">
                            <i class="fa fa-flag" data-toggle="tooltip" title="Report" ></i>
                        </button>
                        <div id="question-option-checkboxes" class="dropdown-menu  dropdown-menu-right dropdownmenu-content pl-2 pr-2 min-width-250">
                            @php
                                if(isset($issueTypes) && !empty($issueTypes)){
                                    foreach($issueTypes as $issue) {
                            @endphp
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck{{ $issue['issueId'] }}" value="{{ $issue['issueId'] }}">
                                            <label class="custom-control-label" for="customCheck{{ $issue['issueId'] }}"> {{ $issue['issueName'] }}</label>
                                        </div>
                            @php
                                    }
                                }
                            @endphp
                            <div class="text-right">
                                <button class="btn btn-primary report-button" aria-hidden="true">{{ __('teachers.questionReview.report') }}</button>
                            </div>
                        </div>
                    </div> 
                    <span class="enlarge-popup-btn cursor-pointer" data-toggle="tooltip" title="Full screen" > 
                        {!! config('constants.icons.enlarge-icon') !!}
                    </span>
                </div>
                <button type="button" class="close close-preview" aria-label="Close">
                    {!! config('constants.icons.close-icon') !!}
                </button>
            </div>
            {{-- Modal body --}}
            @php
                $questionFilters = \App\Models\Questions::getQuestionFilters();
            @endphp
            <div class="modal-body">
                <div class="owl-carousel owl-theme" id="owl-carousel-review"></div>
            </div>
            {{-- Modal footer --}}
        </div>
    </div>
</div>
{{-- preview-modal --}}
