<!-- Question Layout Template Carousal Area -->
<div class="well">
    @if (isset($questionLayout['savedQuestionTemplate']) && count($questionLayout['savedQuestionTemplate']) > 0)
        <label for="" class="label-small">{{ __('questionLayout.selectBlueprint') }} </label>&nbsp; 
        <i class="info-icon" data-toggle="tooltip" title="{{ __('teachers.assessment.blueprintInfo') }}">{!! config("constants.icons.info-icon") !!}</i>
        <div class="relative test-format-outer mt-2">
            <div class="test-format-left">
                <div class="">
                        <div class="template-outer-creat">
                            <a class="test-format-slider-link active">
                                <div class="template-box-creat cursor-pointer" tabindex="0" role="button"  data-toggle="modal" data-target="#preview2">
                                    <div class="creat-icon" >
                                        {!! config('constants.icons.create-pencil-icon') !!}
                                    </div>
                                    <div class="template-creat-text">{{ __('teachers.general.createFormat') }}</div>
                                </div>
                            </a>
                        </div>
                </div>
            </div>
            <div class="test-format-right">
                <div class="owl-carousel owl-carousel2 owl-theme">
                    @php
                        $carouselData = [];
                        foreach ($questionLayout['savedQuestionTemplate'] as $index => $qTemplate){
                            $active = '';
                            if($questionLayout['lastUsedTemplate'] == null && $index == 0) {
                                $active = 'active';
                            }

                            if ($questionLayout['lastUsedTemplate'] == $qTemplate['id']){
                                $active = 'active';
                            }

                            $totalMarks = 0;

                            foreach($qTemplate['questionFormats'] as $qFormat) {
                                $totalMarks += $qFormat['numberOfQuestion'] * $qFormat['weightage'];
                            }

                            if($totalMarks > 1) {
                                $pointStr = __("questionLayout.marks");
                            } else {
                                $pointStr = __("questionLayout.marks");
                            }
                            if ($qTemplate['ownerId'] == config('constants.defaultOwnerId')) {
                                // Default Template
                                $carousalItem = '<div class="item" data-target="#preview" data-id="'. $qTemplate['id'] .'" data-title="'. $qTemplate['formatName'] .'" data-type="defaultTemplate" data-index="'. $index .'" data-marks="'.$totalMarks.'">
                                    <a class="test-format-slider-link '. $active .'" href="javascript:void(0)" data-placement="top" data-trigger="hover focus" data-toggle="popover" title="' . $qTemplate['formatName'] . '" data-html="true" data-content="'. view('teachers.includes.content', ['data' => $qTemplate['questionFormats']])->render() .'">
                                        <div class="template-outer">
                                            <div class="template-box">
                                                <div class="author">
                                                    '.config('constants.icons.tutorwand-icon').'
                                                </div>
                                                <div class="marks-box">
                                                    '. $totalMarks .'
                                                    <small>'. $pointStr .'</small>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="carosel-caption">'. $qTemplate['formatName'] .'</p>
                                    </a>
                                </div>';                                            
                            } else {
                                $carousalItem = '<div class="item" data-target="#preview" data-id="'. $qTemplate['id'] .'" data-title="'. $qTemplate['formatName'] .'" data-type="defaultTemplate" data-index="'. $index .'" data-marks="'.$totalMarks.'">
                                    <a class="test-format-slider-link '. $active .'" href="javascript:void(0)" data-placement="top" data-trigger="hover focus" data-toggle="popover" title="'. $qTemplate['formatName'] .'" data-html="true" data-content="'. view('teachers.includes.content', ['data' => $qTemplate['questionFormats']])->render() .'">
                                        <div class="template-outer">
                                            <div class="template-box">
                                                <div class="author-teacher">
                                                    ' . $userProfile . '
                                                </div>
                                                <div class="marks-box">
                                                    '. $totalMarks .'
                                                    <small>'. $pointStr .'</small>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="carosel-caption">'. $qTemplate['formatName'] .'</p>
                                    </a>
                                </div>';
                            }
                            
                            if ($active == 'active') {
                                array_unshift($carouselData, $carousalItem);
                            } else {
                                array_push($carouselData, $carousalItem);
                            }
                        }
                        echo implode(' ', $carouselData);
                    @endphp
                </div>
            </div>
    @endif

    <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-3 col-lg-2 col-xl-2">

            </div>
            <div class="col-md-9 col-lg-10 col-xl-10">

            </div>
        </div>

    </div>
</div>
