<div class="right-panel-section">
    <div class="well">
        <div class="row">
            <div class="col-md-4">
                <label for="" class="label-small">{{ __('teachers.schedule.assigneeList') }} &nbsp; <i class="info-icon" data-toggle="tooltip" title="{{ __('teachers.schedule.selectClassStudent') }}">{!! config("constants.icons.info-icon") !!}</i></label>
                <select data-students class="selectAssignGroup d-none" multiple name="select_students">
                    @foreach ($studentGroups as $key => $studentGroup)
                        @if (isset($studentGroup['students']) && !empty($studentGroup['students']))
                            @if (count($studentGroup['students']) > 0)
                                <optgroup  data-type="courses" data-value="{{ $studentGroup['courseId'] }}" label="{{ $studentGroup['courseName'] }}">
                                @foreach ($studentGroup['students'] as $value)
                                    @if ($value['givenName'] != null)
                                        <option value="{{ $studentGroup['courseId'] }}_{{$value['googleId']}}" data-type="googleid" data-value="{{ $value['googleId'] }}" data-name="{{ $value['givenName'] }}" data-profilepic="{{ $value['photoUrl'] }}" data-email="{{ $value['emailId'] }}">{{ $value['givenName'] }}</option>
                                    @endif
                                @endforeach
                                </optgroup>
                            @endif
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="well {{ $pointEventNone }}">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="" class="label-small">{{ __('teachers.schedule.assementDuration') }}  <i class="info-icon d-none" data-toggle="tooltip" title="{{ __('teachers.schedule.quizInfo') }}">{!! config("constants.icons.info-icon") !!}</i>
                </label>
                    <div class="d-flex align-items-center">
                        <div class="assessment-type-q-box">
                            <div class="custom-control custom-radio">
                                <!-- <input type="checkbox" class="custom-control-input" id="customCheck1"> -->
                                <input type="radio" class="custom-control-input" id="customCheck101" name="assessment_type" value="quiz" checked>
                                <label class="custom-control-label" for="customCheck101">{{ __('teachers.schedule.quiz') }}</label>
                            </div>
                            <div class="input-group time-input ml-4">
                                <input type="number" class="form-control date-input" name="schedule_minutes" placeholder="{{ __('questionReview.inMinutes') }}" min="0" max="{{ config('constants.MaxMinutes') }}" step="5">
                                <div class="input-group-append">
                                    <span class="input-group-text date-pick-per">{{ __('teachers.schedule.minutes') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0"><small class="text-light-gray">{{ __('teachers.schedule.quizLabelExplaination') }}</small></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="custom-control custom-radio mt-4">
                    <input type="radio" class="custom-control-input" id="customCheck102" name="assessment_type" value="assignment">
                    <label class="custom-control-label" for="customCheck102">{{ __('teachers.schedule.assignment') }}</label>
                </div>
                <p class="mb-0 mt-2"><small class="text-light-gray">{{ __('teachers.schedule.assessmentLabelExplaination') }}</small></p>
            </div>
            <div class="clearfix"></div>
        </div>
        <hr class="mt-0">
        <div class="row">
            <div class="col-md-4">
                <div class="">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text date-pick-per">{{ __('teachers.schedule.scheduleDate') }}</span>
                        </div>
                        <input id="test-schedule-date" type="text" class="form-control date-input" onkeydown="return false">
                        <div class="input-group-append">
                            <span class="input-group-text date-pick-icon"><i class="fa fa-calendar" id="test-schedule-date-fa" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text date-pick-per">{{ __('teachers.schedule.dueDate') }}</span>
                        </div>
                        <input type="text" class="form-control date-input" id="test-due-date" onkeydown="return false">
                        <div class="input-group-append">
                            <span class="input-group-text date-pick-icon"><i class="fa fa-calendar" id="test-due-date-fa" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" value="{{ $restrictResult }}" id="isAutoEvaluation">
        @if ($restrictResult != true)
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <label for="" class="label-small">{{ __('teachers.schedule.publishResult') }} &nbsp; <i class="info-icon" data-toggle="tooltip" title="{{ __('teachers.schedule.scheduleResult') }}">{!! config("constants.icons.info-icon") !!}</i></label>
                        <div class="custom-control custom-checkbox date-end">
                            <input type="checkbox" class="custom-control-input scheduleResult" id="customCheck103" {{ $restrictResult ? 'disabled' : '' }}">
                            <label class="custom-control-label" for="customCheck103" >{{ __('teachers.schedule.onAssessmentCompletion') }}</label>
                        </div>
                </div>
            </div>
        @endif
        <div class="row d-none">
            <div class="col-md-4">
                <div class="test-date-detail mt-2" data-test-date="published-on">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text date-pick-per">{{ __('teachers.schedule.resultDate') }}</span>
                        </div>
                        <input id="test-published-on" type="text" class="form-control date-input" >
                        <div class="input-group-append">
                            <span class="input-group-text date-pick-icon"><i class="fa fa-calendar" id="test-published-on-fa" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="well">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="" class="label-small">{{ __('teachers.schedule.assessmentInstruction') }}</label>
                    <textarea id="testInstructions" name="testInstructions" rows="7" class="form-control " placeholder="All questions are required"></textarea>
                </div>
            </div>
            <div class="col-md-4">
                <p class=" d-block">{{ __('teachers.schedule.readyToUse') }}</p>
                <div class="form-group">
                    <div class="form-check custom-control custom-checkbox">
                        <input value="{{ __('teachers.schedule.allQuestionRequired') }}" data-question-checkbox class="form-check-input custom-control-input testinstructions" type="checkbox" checked id="questionsCheck">
                        <label class="form-check-label custom-control-label" for="questionsCheck">
                            {{ __('teachers.schedule.allQuestionRequired') }}
                        </label>
                    </div>
                    <div class="form-check custom-control custom-checkbox">
                        <input value="{{ __('teachers.schedule.readyToUseText1') }}" data-question-checkbox type="checkbox" class="custom-control-input testinstructions" id="readyToUseText1">
                        <label class="custom-control-label" for="readyToUseText1"> {{ __('teachers.schedule.readyToUseText1') }} </label>
                    </div>
                    <div class="form-check custom-control custom-checkbox">
                        <input value="{{ __('teachers.schedule.readyToUseText2') }}" data-question-checkbox type="checkbox" class="custom-control-input testinstructions" id="readyToUseText2">
                        <label class="custom-control-label" for="readyToUseText2"> {{ __('teachers.schedule.readyToUseText2') }} </label>
                    </div>
                    <div class="form-check custom-control custom-checkbox">
                        <input value="{{ __('teachers.schedule.doNotUseCalculator') }}" data-question-checkbox class="form-check-input custom-control-input testinstructions" type="checkbox"  id="dontUseCalculator"> 
                        <label class="form-check-label custom-control-label" for="dontUseCalculator">
                            {{ __('teachers.schedule.doNotUseCalculator') }}
                        </label>
                    </div>
            </div>
            </div>
        </div>
    </div>
</div>
