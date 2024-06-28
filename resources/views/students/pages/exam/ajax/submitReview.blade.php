@if(isset($notAttempt) && !empty($notAttempt))
    <div id="unattempted">
        <h5 class="mt-4">{{ __('students.notAttemptedDescription') }}</h5>
        <ul class="question-pallet-review">
            @foreach($notAttempt as $notAttemptVal)
                <li id="{{ $notAttemptVal['questionId'] }}" class="reviewPaletteArea">
                    <button class="{{ (stripos(strtolower($notAttemptVal['className']), 'mark-review') !== false) ? 'bookmark' : '' }}"> {{ $notAttemptVal['id'] }}</button>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="clearfix"></div>
@endif

@if(isset($answered) && !empty($answered))
    <div id="answered">
        <h5 class="mt-4">{{ __('students.answeredDescription') }}</h5>
        <ul class="question-pallet-review">
            @foreach($answered as $answeredVal)
                <li id="{{ $answeredVal['questionId'] }}" class="reviewPaletteArea">
                    <button class="{{ (stripos(strtolower($answeredVal['className']), 'mark-review') !== false) ? 'bookmark' : '' }}">{{ $answeredVal['id'] }}</button>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="clearfix"></div>
@endif

@if(isset($markReview) && !empty($markReview))
    <div>
        <h5 class="mt-4">{{ __('students.markReviewDescription') }}</h5>
        <ul class="question-pallet-review">
            @foreach($markReview as $markReviewVal)
                <li id="{{ $markReviewVal['questionId'] }}" class="reviewPaletteArea">
                    <button class="bookmark">{{ $markReviewVal['id'] }}</button>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="clearfix"></div>
@endif