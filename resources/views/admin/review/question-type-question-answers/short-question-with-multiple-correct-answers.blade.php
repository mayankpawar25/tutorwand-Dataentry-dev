<div class="select_area">
    <ul class="question-list">
        <li>Q {{ $questionNumber }}.</li>
        <li> {!! html_entity_decode($question['questionText']) !!} </li>
    </ul>
    <div class="option-list que-mp d-none">
        <p>Answer</p>
        {!! html_entity_decode($question['answerBlock']['answer']) !!}
    </div>
</div>