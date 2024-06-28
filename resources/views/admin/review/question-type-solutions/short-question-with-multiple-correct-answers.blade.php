<div class="row">

    <div class="col-md-12">

        <div class="form-group">

            <p><strong>Solution</strong></p>

            {!! $question['answerBlock']['answer'] !!}
            <br/>
            @if(isset($question['answerBlock']['additionalAnswers']) && count($question['answerBlock']['additionalAnswers']))
                @foreach($question['answerBlock']['additionalAnswers'] as $k => $additionalAnswers)
                    <p><strong>Solution Variations {{ $k + 1 }}</strong></p>
                    {!! $additionalAnswers !!}
                    <br/>
                @endforeach
            @endif
        </div>

    </div>

</div>