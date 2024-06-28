<div class="row">
    <div class="col-md-8 col-lg-9">
        <div class="canvas-inner position-relative">
            <div class="canvas-body">

                <input type="hidden" name="screen-name" value="review-screen">

                <h2 class="mt-0">{{ __('students.reviewAndSubmit') }}</h2>

                <p>{{ __('students.reviewAndSubmitDescription') }}</p>
                <div id="update-submit-review-status">
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
                </div>
            </div>
        </div>
    </div>
    
    <div class="canvas-footer">
        <div class="text-right">
            <button class="btn btn-primary submitBtn SubmitAndReviewScreen"><i class="fa fa-paper-plane left" aria-hidden="true"></i>{{ __('students.submit') }}</button>
        </div>
    </div>

    <div class="col-md-4 col-lg-3">
        <div class="right-panel ">
            <h5>{{ __('students.submitReview.uploadFilesWithQuestion') }}</h5>
            <div class="localfilesmsg">{{ __('students.submitReview.noFileLabel') }}</div>
            <div class="uploaded-file-block">
                <ul class="uploaded-doc questionFiles">
                </ul>

            </div>
            <hr>
            <h5>Global File Uploaded{{ __('students.submitReview.gobalFileLabel') }}</h5>
            <div class="globalfilesmsg">{{ __('students.submitReview.noFileLabel') }}</div>
            <div class="uploaded-file-block">
                <ul class="uploaded-doc globalUploades">
                </ul>
            </div>
        </div>
    </div>
</div>
