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
                @endphp
                @if ($option['isCorrect'] == true)
                    @php 
                        $correctSolution = 'checked'; 
                    @endphp
                @endif

                @if (isset($response['answer']['options'][$optionKey]['isCorrect']) && $response['answer']['options'][$optionKey]['isCorrect'] == true && $option['isCorrect'] == true)
                    @php 
                        $correctAnswer = 'checked-right'; 
                    @endphp
                @endif

                @if (isset($response['answer']['options'][$optionKey]['isCorrect']) && $response['answer']['options'][$optionKey]['isCorrect'] == true && $option['isCorrect'] == false)
                    @php 
                        $correctAnswer = 'checked-wrong'; 
                    @endphp
                @endif
                <div class="option-row {{ $correctAnswer }} {{ $correctSolution }}">
                    <label>
                        <span class="sr-no {{ isset($response['answer']['options'][$optionKey]['isCorrect']) && ($response['answer']['options'][$optionKey]['isCorrect'] == true) ? 'check-by-studen' : '' }}">{{ $alphabet }}</span> <p>{!! removeSpace($option['optionText']) !!}</p>
                    </label>    
                </div>
                @php 
                    $alphabet++; 
                @endphp
            @endforeach
        </div>
    </div>
@endif
