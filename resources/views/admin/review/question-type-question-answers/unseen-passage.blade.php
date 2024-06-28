<div class="select_area">
    <ul class="question-list">
        <li>{{ $questionNumber }}.</li>
        <li> {!! html_entity_decode($question['questionText']) !!} </li>
    </ul>
</div>
@foreach($question['childrenQuestions'] as $index => $question)
    <hr/>
    @php
        $questionNumber = $index+1;
        if($question['questionTypeId'] === "kc8fmydg") { // Multiple Select
    @endphp
            @include('admin.review.question-type-question-answers.multiple-select')
    @php
        } else if($question['questionTypeId'] === "529kWMwg"){ // Multiple Choice
    @endphp
            @include('admin.review.question-type-question-answers.multi-choice')
    @php
        }
    @endphp
    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mt-4">
                <p><strong>{{ __('admin.extendedSolnLabel') }}:</strong></p>
                <p>{!! $question['answerBlock']['extendedSolution'] !!}</p>
            </div>
        </div>
    </div>
@endforeach