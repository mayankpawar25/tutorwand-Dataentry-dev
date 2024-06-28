<div class="select_area">
    <ul class="question-list">
        <li>Q {{ $questionNumber }}.</li>
        <li> {!! html_entity_decode($question['questionText']) !!} </li>
    </ul>
    <div class="option-list">
        @if(!empty($question['answerBlock']['options']))
            @php $alphabet = 0; @endphp
            @foreach($question['answerBlock']['options'] as $option)
                @php $alphabet++; @endphp
                <div class="row">
                    <div class="form-group d-inline-flex">
                        <p class="pr-p">Answer {{ $alphabet }})</p>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>