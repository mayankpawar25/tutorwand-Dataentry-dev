@if(!empty($question))
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
                    <h2>{{ __('admin.review') }}</h2>
                </div>
                <div class="col-md-3 mt-2">
                    <h5><strong>{{ __('admin.leftToReview') }} - {{ isset($questionCount) ? $questionCount : 0 }}  </strong></h5>
                </div>
                <div class="col-md-6 text-right">
                    <input type="hidden" name="" id="statusUrl" value="{{ route('review.change.question.status') }}">
                    <a href="{{ route('admin.edit.form') }}" class="btn btn-sm btn-outline-info mr-2" data-questionId="{{ isset($question['id']) ? $question['id'] : ''  }}">{{ __('admin.editBtnLabel') }}</a>
                    <button class="btn btn-danger btn-sm rejectBtn mr-2" data-statusId="J63opGxW"> {{ __('admin.rejectBtnLabel') }}</button>
                    <button class="btn btn-warning btn-sm holdBtn mr-2" data-statusId="c0p7s80s"> {{ __('admin.holdBtnLabel') }}</button>
                    @if(!in_array('Review Screen(status except approved)' , $roleAllowed) )
                        <button class="btn btn-success btn-sm approveBtn" data-statusId="QbgeuNsb">{{ __('admin.approveBtnLabel') }}</button>
                    @endif
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="card-content">
            @if(!empty($question))
                <input type="hidden" value="{{ $question['id'] }}" name="questionId">
                <input type="hidden" value="{{ getAdminUserId() }}" name="reviewerId">
                @php
                    $hideSolutionSection = false;
                    $view = strtolower(str_replace(' ', '-', $questionTypeName));
                    if (strpos($view, 'unseen-passage') !== false) {
                        $view = 'unseen-passage';
                        $hideSolutionSection=true;
                    } else if (strpos($view, 'multi-select') !== false) {
                        $view = 'multiple-select';
                    }
                @endphp
                @include('admin.review.question-type-question-answers.'.$view)
            @endif
            <br>
            <div class="row ">
                <div class="col-md-12 text-right">
                    @if($questionNumber > 1)
                        <button class="btn btn-outline-info mr-2 prev-btn">{{ __('admin.previous') }}</button>
                    @endif
                    @if( isset($questionCount) && $questionCount != $questionNumber)
                        <button class="btn btn-success btn-sm next-btn">{{ __('admin.next') }}</button>
                    @endif
                </div>
            </div>
            <br>
            <div class="clearfix"></div>
            @if(!empty($question) && !$hideSolutionSection)
                <hr>
                <div class="select_area mt-3">
                        @include('admin.review.question-type-solutions.'.$view)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p><strong>{{ __('admin.hintLabel') }}:</strong></p>
                                    <p>{!! $question['answerBlock']['hint'] !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p><strong>{{ __('admin.extendedSolnLabel') }}:</strong></p>
                                    <p>{!! $question['answerBlock']['extendedSolution'] !!}</p>
                                </div>
                            </div>
                        </div>
                </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('review.filter') }}" class="btn btn-success btn-sm">{{ __('admin.backbtnLabel') }}</a>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2>{{ __('admin.review') }}</h2>
                </div>
                <div class="card-body text-danger">
                    {{ __('admin.noQuestionErrorText') }}
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('review.filter') }}" class="btn btn-success btn-sm">{{ __('admin.backbtnLabel') }}</a>
                </div>
            </div>
        </div>
    </div>
@endif