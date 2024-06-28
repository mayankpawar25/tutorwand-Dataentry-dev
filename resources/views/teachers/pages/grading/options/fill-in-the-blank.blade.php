@if (isset($response['solution']['options']) && !empty($response['solution']['options']))
    <div class="list-outer">
        <div class="grading-option-list option-radio">
            @php 
                $alphabet = 'A'; 
            @endphp
            @foreach ($response['solution']['options'] as $optionKey => $option)
                @php 
                    $correctAnswer = '';
                    $correctSolution = '';
                    $correctAndChecked = '';
                @endphp

                @if ($option['isCorrect'] == true)
                    @php 
                        $correctAnswer = 'checked-right'; 
                        $correctAndChecked = 'checked-right'; 
                    @endphp
                @endif

                @if (isset($response['answer']['options']) && $response['answer']['options'][$optionKey]['isCorrect'] == false)
                    @php 
                        $correctAnswer = 'checked-wrong';
                        $correctAndChecked = '';
                    @endphp
                    @if (!empty($response['answer']['options'][$optionKey]['optionText']))
                        <div class="option-row {{ $correctAnswer }}">
                            <label>
                                <span class="sr-no">{{ $alphabet }}</span>{!! removeSpace($response['answer']['options'][$optionKey]['optionText']) !!}
                            </label>
                        </div>
                    @endif
                @endif
                @if(empty($response['answer']['options']))
                    @php 
                        $correctAndChecked = "";
                    @endphp
                @endif
                <div class="option-row checked {{ $correctAndChecked }}">
                    <label>
                        <span class="sr-no">{{ $alphabet }}</span>{!! removeSpace($option['optionText']) !!}
                    </label>
                </div>
                @php 
                    $alphabet++; 
                @endphp
            @endforeach
        </div>
    </div>
@endif
