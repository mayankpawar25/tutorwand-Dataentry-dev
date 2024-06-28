<div class="right-panel-section">
    <div class="well">
        <div class="form-group">
            <label>{{ __('questionLayout.assessmentName') }}</label>
            
            {{-- Form Input component --}}
            
            <x-forms.input type="text" class="form-control input-regular onchangeValue" placeholder="{{ __('questionLayout.assessmentName') }}" id="input-form" name="input_title" value="{{ (isset($session['inputTitle'])) ? $session['inputTitle'] : '' }}" maxlength="30" readonly/>
            
            {{-- Form Input component --}}

        </div>
        <hr>
        <div class="selectPanel">
            <div id="loader-wrapper">
                <div id="loader1"> {!! config('constants.icons.loader-icon') !!}</div>
            </div>
        </div>
        <hr>
        <div id="accordion-bar">
            <div class="">
                <div class="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-8">
                                <label class="label-heading">{{ __('teachers.general.setAssessmentOverallLabel') }}</label>
                                    <div class="form-group mt-2">
                                        <div class="range-slider-box">

                                            {{-- Form Input component --}}

                                            <x-forms.input type="text" class="w-100" placeholder="{{ __('questionLayout.assessmentName') }}" id="ex13" name="difficultyLevel" value="{{ (isset($session['inputTitle'])) ? $session['inputTitle'] : '' }}" data-slider-ticks="{{ json_encode($questionLayout['rightPanelData']['questionDifficulties']) }}" data-slider-ticks-snap-bounds="2"/>

                                            {{-- Form Input component --}}

                                            <div class="clearfix"></div>
                                            <span>{{ __('questionLayout.easy') }}</span> <span class="pull-right">{{ __('questionLayout.hard') }}</span>
                                        </div>
                                    </div>
                                    {{-- 
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" id="customCheck1" name="questionBank" class="custom-control-input" value="previousYearQuestionPaper" {{ isset($session['questionBank']) && $session['questionBank'] == 'previousYearQuestionPaper' ? 'checked' : '' }} >
                                            <label class="custom-control-label" for="customCheck1">{{ __('questionLayout.previousYearQuestionPaper') }}</label>
                                        </div>
                                    --}}

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- 
                                <label class="label-heading" for="">{{ __('teachers.general.questionsSource') }}</label>
                                <div class="custom-control custom-radio mb-1">
                                    <input type="radio" checked id="customRadio1" name="questionBank" class="custom-control-input" value="MagicBand" {{ isset($session['questionBank']) && $session['questionBank'] == 'MagicBand' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customRadio1">{{ __('questionLayout.tutorWandQuestionBank') }}</label>
                                </div>
                                <div class="custom-control custom-radio mb-1">
                                    <input type="radio" id="customRadio2" name="questionBank" class="custom-control-input" value="myQuestionBank" {{ isset($session['questionBank']) && $session['questionBank'] == 'myQuestionBank' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customRadio2">{{ __('questionLayout.onlyMyQuestionBank') }}</label>
                                </div>
                            --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- right panel end -->
    @php
        $isActive = false;
    @endphp
    <div class="defaultTemplateSection">
        <div class="well">
            <label for="" class="label-small">{{ __('questionLayout.selectBlueprint') }}</label>&nbsp;
                <i class="info-icon">{!! config("constants.icons.info-icon") !!}</i>
            <div class="relative test-format-outer mt-2">
                <div class="test-format-left">
                    <div class="" data-toggle="modal" data-target="#preview2">
                        <div class="template-outer-creat">
                            <a class="test-format-slider-link active">
                                <div class="template-box-creat" tabindex="0" role="button" data-toggle="modal" data-target="#preview2" >
                                    <div class="creat-icon">
                                        {!! config('constants.icons.create-pencil-icon') !!}
                                    </div>
                                    <div class="template-creat-text">{{ __('teachers.general.createFormat') }}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="test-format-right">
                    {{--
                        <div id="loader-wrapper">
                            <div id="loader1"> {!! config('constants.icons.loader-icon') !!}
                            </div>
                        </div>
                    --}}
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
