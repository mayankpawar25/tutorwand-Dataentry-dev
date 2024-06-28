    <div class="question-text d-table w-100">
        <div class="q-text d-table-cell v-top" data-id="{{ $question['id'] }}">
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
                <button class="btn btn-secondary swap-question btn-tpt"  data-questionnumber="{{ $questionNumber }}" data-questionid="{{ $question['id'] }}" data-paperid="{{ $paperId }}">
                    <i class="fa fa-refresh" data-toggle="tooltip" title="Swap" aria-hidden="true"></i>
                </button>
                <button class="btn btn-secondary slide-jump btn-tpt" data-toggle="modal" data-target="#preview" data-id="{{ $questionNumber-1 }}">
                    <i class="fa fa fa-eye" aria-hidden="true" data-toggle="tooltip" title="Preview" ></i>
                </button>
            </div>
        </div>
    </div>
        @php
            if ($question['questionTypeId'] == config("constants.mcqId")) {
        @endphp
        <div class="row mt-2">
        @php
                $alphabet = 'A';
                foreach ($question['answerBlock']['options'] as $pid => $option) {
        @endphp
            <div class="col-sm-12 mb-1" data-id="{{ $option['id'] }}">
                <div class="option-list option-radio">
                    <label>
                        <span class="sr-no">{{ $alphabet }}</span> {!! $option['optionText'] !!}
                    </label>
                </div>
            </div>
        @php
                    $alphabet++;
                }
        @endphp
            </div>
        @php
            }  elseif ($question['questionTypeId'] == config("constants.trueFalseId")) {
        @endphp
            <div class="row mt-2">
        @php
                $alphabet = 'A';
                foreach ($question['answerBlock']['options'] as $pid => $option) {
        @endphp
                    <div class="col-sm-12 mb-1" data-id="{{ $option['id'] }}">
                        <div class="option-list option-radio">
                            <label>
                                <span class="sr-no">{{ $alphabet }}</span> <p>{!! $option['optionText'] !!}</p>
                            </label>
                        </div>
                    </div>
        @php
                    $alphabet++;
                }
        @endphp
            </div>
        @php
            }
        @endphp 
