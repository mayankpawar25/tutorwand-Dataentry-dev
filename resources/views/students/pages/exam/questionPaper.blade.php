<div class="canvas-inner position-relative">
    <div class="canvas-body fuelux" id="questionWizard">
        <div class="wizard" data-initialize="wizard">
            <div class="step-content">
        		@if(!empty($questionData['questions']))
        			@foreach($questionData['questions'] as $key => $question)
                        @php
                            $question = decryptBlobData($question);
                        @endphp
        		        <div class="question-text w-100 mb-2 question-block step-pane sample-pane <?=$key == 0 ? 'active' : '' ?>" id="quest{{ $key+1 }}" data-questionID="<?=$question['questionId'] ?>" data-questionTypeId="{{ $question['questionTypeId'] }}" data-step="<?=$key+1?>">
        		            <div class="question-text d-table w-100 mb-4 f-12">
        		                <div class="q-text d-table-cell v-top" data-id="{{ $question['questionId'] }}">
        		                    <div class="question-list">
        		                        <div class="q-serial">{{ $key+1 }}</div>
        		                        {!! html_entity_decode($question['questionText']) !!}
                            			<div class="q-mark">{{ $question['weightage'] }} <small>{{ pointText($question['weightage']) }}</small></div>
        		                    </div>
        		                </div>
        		            </div>
                            <div class="mt-10" id="step<?=$key+1?>">
                                @include('students.pages.exam.question-types-options.'.str_replace(" ","-",strtolower(getTemplateName($question['questionTypeId']))))
                            </div>
        		        </div>
        	        @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<div class="canvas-footer">
    <div class="text-right">
        <a id="mob-right-panel-trigger" class="btn btn-outline-primary" href="#">
            {!! html_entity_decode(Config('constants.icons.dashboard-svg')) !!}
            <span class="d-lg-none d-md-none d-block">{{ __('students.questionPaper.pallet') }}</span>
        </a>    
        <button class="btn btn-outline-primary pull-left report-btn mr-2" tabindex="1">
            {!! html_entity_decode(Config('constants.icons.error-report-svg')) !!}
            <span class="hide-mob">{{ __('students.reportError') }}</span>
            <span class="d-lg-none d-md-none d-block">{{ __('students.questionPaper.report') }}</span>
        </button>

        <button class="btn btn-outline-primary pull-left mark-review-btn mr-2" tabindex="1">
            <i class="fa left fa-bookmark fill" aria-hidden="true"></i>
            <i class="left fa fa-bookmark-o outline" aria-hidden="true"></i>
            <span class="hide-mob">
            {{ __('students.bookmarks') }}</span>
            <span class="d-lg-none d-md-none d-block">{{ __('students.bookmarks') }}</span>
        </button>
        <button class="btn btn-outline-primary pull-left clear-data-btn mr-2" tabindex="1">
            {!! html_entity_decode(Config('constants.icons.clear-svg')) !!}
            <span class="hide-mob">{{ __('students.clearResponse') }}</span>
            <span class="d-lg-none d-md-none d-block">{{ __('students.questionPaper.clear') }}</span>
        </button>
        <span class="exam-primary-nav">
            <button class="btn btn-outline-primary btn-auto mr-2 prev-btn" tabindex="1"><i class="fa fa-angle-left left" aria-hidden="true"></i> {{ __('students.prev') }}</button>
            <button class="btn btn-primary btn-auto next-btn" tabindex="1"> {{ __('students.next') }} <i class="fa fa-angle-right right" aria-hidden="true"></i></button>
            <button class="btn btn-primary finishBtn btn-auto finish-btn SubmitAndReviewScreen" style="display: none;"><i class="fa fa-flag-checkered left" aria-hidden="true"></i> {{ __('students.finish') }} </button>
        </span>
    </div>
</div>
