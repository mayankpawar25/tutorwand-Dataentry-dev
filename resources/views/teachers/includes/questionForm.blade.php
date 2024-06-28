<div class="question-form">
    <form action="">
        <div class="form-group">
            Q. {{ $id + 1 }} : <input type="text" id="question-{{ $id + 1 }}-title" name="question-{{ $id + 1 }}-title"  class="form-control" value="{{ $question['questionText'] }} ?" />
        </div>
        <div class="row">
            @php
                $questionCorrectAnswer = array();
                if(isset($question['answerBlock']['options']) && !empty($question['answerBlock']['options'])) {
                    foreach ($question['answerBlock']['options'] as $pid => $option) {
                        @endphp
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" id="question-option-{{ $option['id'] }}-{{ $question['id'] }}" name="question-option-{{ $option['id'] }}-{{ $question['id'] }}"  class="form-control question-option" value="{{ $option['optionText'] }}" />
                                </div>
                            </div>
                        @php
                        if($option['isCorrect'] == true) {
                            array_push($questionCorrectAnswer, $option);
                        }
                    }
                }
            @endphp
        </div>

        <div class="form-group">
            <label for="question-{{ $id + 1 }}-correct-answrer">{{ __('teachers.questionForm.correctAnswer') }} </label>
            @php
                if(isset($question['answerBlock']['options']) && !empty($question['answerBlock']['options'])) {
                    foreach( $questionCorrectAnswer as $k => $correctAns) {
                        @endphp
                            <input type="text" id="question-{{ $id + 1 }}-correct-answrer" value="{{$correctAns['optionText']}}" name="question-{{ $id + 1 }}-correct-answer"  class="form-control" />            
                        @php
                    }
                } else {
                    @endphp
                        <input type="text" id="question-{{ $id + 1 }}-correct-answer" name="question-{{ $id + 1 }}-correct-answer"  class="form-control"  value="{{ $question['answerBlock']['answer'] }}"/>            
                    @php
                }
            @endphp
        </div>

        <div class="form-group pull-right">
            <input type="submit" value="submit" id="question-{{ $id }}-submit" name="question-{{ $id }}-submit"  class="form-control btn btn-primary"  />
        </div>

        <div class="form-group question-filters" style="clear:both">
            <label for="question-filter-{{ $id + 1 }}">{{ __('teachers.questionForm.questionInfo') }}: </label>

            <select style="width:100%" name="question-filter-{{ $id + 1 }}" id="question-filter-{{ $id + 1 }}" multiple="multiple" class="form-control">
                @foreach ($questionFilters as $questionFilter)
                    <option value="{{ $questionFilter }}" selected="selected">{{ $questionFilter }}</option>
                @endforeach
            </select>

            <script type="text/javascript">
                if($('#question-filter-{{ $id + 1 }}').length > 0) {
                    $('#question-filter-{{ $id + 1 }}').select2({
                        tags: true,
                        tokenSeparators: [','], 
                        selectOnClose: true, 
                        closeOnSelect: false
                    });
                }
            </script>
        </div>
    </form>
</div>
