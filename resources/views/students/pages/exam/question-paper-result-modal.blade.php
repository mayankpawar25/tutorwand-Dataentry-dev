@if(!empty($questionData['questions']))
	@foreach($questionData['questions'] as $key => $question)
        <div class="question-text w-100 mb-2 step-pane sample-pane <?=$key == 0 ? 'active' : '' ?>" id="quest{{ $key+1 }}" data-questionID="<?=$question['questionId'] ?>" data-step="<?=$key+1?>">
            <div class="question-text d-table w-100 mb-2 f-12">
                <div class="q-text d-table-cell v-top" data-id="{{ $question['questionId'] }}">
                    <div class="question-list">
                        <div class="q-serial">{{ $key+1 }}</div>
                        <p>{!! html_entity_decode($question['questionText']) !!}</p>
                        <div class="q-mark">{{ $question['weightage'] }} <span>{{ pointText($question['weightage']) }}</span></div>
                    </div>
                </div>
            </div>
            <div  id="step<?=$key+1?>">
                @include('students.pages.exam.question-types-options-modal.'.str_replace(" ","-",strtolower(getTemplateName($question['questionTypeId']))))
            </div>
        </div>
    @endforeach
@endif