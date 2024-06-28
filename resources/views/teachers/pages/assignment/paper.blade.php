@extends('teachers.layouts.default')
@section('content')
        <div id="smartwizard" class="sw-main sw-theme-arrows position-relative">
            <ul class="nav nav-tabs step-anchor">
                <li id="reviewNav" class="nav-item active"><a href="#" class="nav-link">{{ __('teachers.general.review') }}<small>{{ __('teachers.general.reviewQuestions') }}</small></a></li>
                <li id="scheduleNav" class="nav-item done"><a href="#" class="nav-link">{{ __('teachers.general.schedule') }}<small>{{ __('teachers.general.scheduleAssignClass') }}</small></a></li>
            </ul>
            <ul class="list-unstyled nav-112">
                <li class="pull-right">
                    <button class="btn btn-outline-primary d-none mr-2" data-href="review" id="schedulePreviousTab">{{ __('questionLayout.previous') }}</button>
                    <button class="btn btn-primary d-none disabled" data-href="review" id="scheduleTab" disabled>{{ __('questionLayout.next') }} </button>
                    <button type="button" id="assign" class="btn btn-primary d-none"> {{ __('questionReview.assign') }}</button>
                </li>
            </ul>
        </div>
        <div class="tab-panel-outer position-relative">
            <!-- tab-panel-start -->
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane" id="reviewDiv">
                    <div class="oldpaper" data-isuntimed="{{ $canvasData['isUntimed'] }}" data-restrictresult="{{ $restrictResult }}"></div>
                    @php
                        if(!isset($canvasData['questions']) || empty($canvasData['questions'])) {
                    @endphp
                            <h4>No Data Available</h4>
                    @php
                        } else { 
                            $allowedQuestionTypes = ['529kWMwg', 'HH9Tu7BZ', 'nOFiSUZ8', 'Tqg3XB1M', '4NcrZAcU'];
                            $questionnumber = 1;
                            $data_id = 0;
                            foreach ($canvasData['questions'] as $id => $question) {
                                $question = decryptBlobData($question);
                                if (in_array($question['questionTypeId'], $allowedQuestionTypes)){
                                    @endphp
                                    <input type="hidden" name="paperId" id="newPaperId" value="{{ $canvasData['questionPaperId'] }}">
                                    <input type="hidden" name="input_title" id="newPaperName" value="{{ $canvasData['questionPaperName'] }}">
                                    <input type="hidden" name="selected_board" id="selectedBoard" value="{{ $canvasData['board'] }}">
                                    <input type="hidden" name="selected_grade" id="selecteGrade" value="{{ $canvasData['grade'] }}">
                                    <input type="hidden" name="selected_subject" id="selectedSubject" value="{{ $canvasData['subject'] }}">
                                    <input type="hidden" name="maximumMarks" id="maximumMarks" value="{{ $canvasData['maximumMarks'] }}">
                                    <input type="hidden" name="testDuration" id="testDuration" value="{{ $canvasData['testDuration'] }}">
                                    <input type="hidden" name="paperId" id="newPaperId" value="{{ $canvasData['questionPaperId'] }}">
                                    <div class="question-block" id="quest{{ $questionnumber }}">
                                        <div class="question-text d-table w-100 mb-2">
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
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @php
                                                if($question['questionTypeId'] == config("constants.mcqId") || $question['questionTypeId'] == config("constants.trueFalseId")) {
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
                                                }
                                            @endphp                
                                        </div>
                                    </div>
                                    <hr>
                                    @php
                                    $data_id++;
                                    $questionnumber++;
                                }
                            }
                        }
                    @endphp
                </div>
                <div class="tab-pane" id="review">
                    <div id="scheduleDiv"></div>
                </div>
            </div>
            <!-- tab panel end -->
        </div>
    </div>

    <div class="modal confirm" id="confirm" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body">

                    <h5>{{ __("teachers.general.submitAssessmentConfirm") }}</h5>
                    <!-- question type table end -->
                    <hr>
                    <button class="btn btn-outline-primary mr-2" data-dismiss="modal" id="close-confirm">{{ __("teachers.button.cancel") }}</button>
                    <button class="btn btn-primary assign-confirm">{{ __("teachers.button.confirm") }}</button>
                </div>
                <!-- Modal footer -->
            </div>
        </div>
    </div>
@stop
