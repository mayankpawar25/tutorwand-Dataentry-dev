<div class="question-block question{{ $indexId }}" data-id="{{ $indexId }}" data-questionid="{{ $question['id'] }}" data-paperid="{{ $paperId }}">
    <div class="question-text d-table w-100 mb-2">
        <div class="q-text d-table-cell v-top">
            <div class="question-list">
               <div class="q-serial">{{ $questionNumber }}</div> 
               {!! $question['questionText'] !!}
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
    @php
        $questionFilters = [];
        if (!empty($question['board'])){
            $board = $question['board'];
            $questionFilters[] = $board['boardName'];
        }
        if (!empty($question['grade'])){
            $grade = $question['grade'];
            $questionFilters[] = $grade['gradeName'];
        }
        if (!empty($question['askedYears'])){
            foreach($question['askedYears'] as $year)
            $questionFilters[] = $year;
        }
        
        if (isset($question['topic']) && !empty($question['topic'])){
            $questionFilters[] = $question['topic']['topicName'];
        }

        if (isset($question['subTopic']) && !empty($question['subTopic'])){
            $questionFilters[] = $question['subTopic']['subTopicName'];
        }

        $questionFilters[] = 'Difficulty Level - ' . $question['difficultyLevel'];
    @endphp        
        <div class="row option-radio">
            @if ($question['questionTypeId'] == config("constants.mcqId")) 
                @php
                    $alphabet = 'A';
                @endphp
                @foreach ($question['answerBlock']['options'] as $pid => $option) 
                    <div class="col-sm-12 mb-1" data-id="{{ $option['id'] }}">
                        <div class="option-list">
                            <div class=" {{ $option['isCorrect'] == true ? 'checked-right' : '' }}" >
                                <label>
                                    <span class="sr-no" >{{ $alphabet }}</span> {!! $option['optionText'] !!}
                                </label>
                            </div>    
                        </div>
                    </div>
                    @php
                        $alphabet++;
                    @endphp
                @endforeach
            @elseif ($question['questionTypeId'] == config("constants.trueFalseId")) 
                @foreach ($question['answerBlock']['options'] as $pid => $option) 
                    <div class="col-sm-12 mb-1" data-id="{{ $option['id'] }}">
                        <div class="option-list">
                        <div class="tf-h {{ $option['isCorrect'] == true ? 'checked-right' : '' }}" >
                                {!! $option['optionText'] !!}
                            </div>    
                        </div>
                    </div>
                @endforeach
            @elseif ($question['questionTypeId'] == config("constants.fibId"))
                <div class="clearfix"></div>
                    <div class="col-sm-12 mb-1">
                        <div class="option-list">
                            <strong>{{ __('teachers.questionSwap.correctAnswer') }}</strong>
                        </div>
                    </div>
                @php
                    $cnt = 1;
                @endphp
                @foreach ($question['answerBlock']['options'] as $pid => $option) 
                    <div class="col-sm-12 mb-1" data-id="{{ $option['id'] }}">
                        <div class="option-list">
                            <div class="p-first-none">
                            <p>Ans {{ $cnt }}:</p> {!! $option['optionText'] !!} 
                        </div>
                        </div>
                    </div>
                    @php
                        $cnt++;
                    @endphp
                @endforeach
            @else
                    <div class="col-sm-12 mb-1">
                        <div class="option-list">
                            <strong>{{ __('teachers.questionSwap.correctAnswer') }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-1">
                        <div class="option-list long-short-q-ans">
                        {!! $question["answerBlock"]["answer"] !!}
                        </div>
                    </div>
            @endif
        </div>
</div>
<div class="question-form-instructions" style="clear:both">
    <span></span>
    <ul class="question-filters list-inline mb-0">
        <li class="question-filter list-inline-item" data-value="{{ __('questionReview.questionInformation') }}">{{ __('questionReview.questionInfo') }}:</li>
        @foreach ($questionFilters as $questionFilter)
            <li class="question-filter list-inline-item" data-value="{{ $questionFilter }}"><span class="badge badge-secondary p-2">{{ $questionFilter }}</span></li>
        @endforeach
    </ul>
</div>
