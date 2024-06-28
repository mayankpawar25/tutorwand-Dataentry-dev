<div class="select_area">
    <ul class="question-list">
        <li>Q {{ $questionNumber }}.</li>
        <li> {!! html_entity_decode($question['questionText']) !!} </li>
    </ul>
    <div class="option-list">
        @if(!empty($question['answerBlock']['options']))
            @php $alphabet = "a"; @endphp
            @foreach($question['answerBlock']['options'] as $index => $option)
                <div class="custom-control form-check">
                    @php $resp = ''; @endphp
                    @if($option['isCorrect'])
                        @php $resp = 'checked'; @endphp
                    @endif
                    <input type="checkbox" id="customCheckbox1-{{$questionNumber}}-{{$index}}" name="customCheckbox{{$questionNumber}}" class="form-check-input" {{ $resp }} disabled/>
                    <label class="custom-control-label" for="customCheckbox1-{{$questionNumber}}-{{$index}}">
                        <ul class="answer-list">
                            <li>{{ $alphabet }})&nbsp;</li>
                            <li> {!! html_entity_decode($option['optionText']) !!}</li>
                        </ul>
                    </label>
                </div>
                @php $alphabet++; @endphp
            @endforeach
        @endif
    </div>
</div>