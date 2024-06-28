<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <p><strong>Solution: </strong></p>
            @if(!empty($question['answerBlock']['options']))
                @php $alphabet = 0; @endphp
                @foreach($question['answerBlock']['options'] as $option)
                    @if($option['isCorrect'] == true)
                        <p>{!! html_entity_decode($option['optionText']) !!}</p>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
 </div>