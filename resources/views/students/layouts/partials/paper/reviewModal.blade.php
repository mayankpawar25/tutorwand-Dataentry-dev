<style>
	@media print {
		body * {
            visibility: hidden;
            width: auto;
            height: auto;
            margin: 0px;
            padding: 0px; 
        }
        .exam-warp {
            display: none;
        }
        #full-paper .modal-content * {
			visibility: visible !important;
			overflow: visible !important;
		}

        #full-paper .modal-header * {
			visibility: hidden;
		}

        #full-paper.modal {
			position: absolute;
			left: 0;
			top: 0;
			margin: 0;
			padding: 0;
			min-height: 550px;
			visibility: visible !important;
			overflow: visible !important; /* Remove scrollbar for printing. */
		}
		#full-paper .modal-dialog {
			visibility: visible !important;
			overflow: visible !important; /* Remove scrollbar for printing. */
		}
        table tr {
            page-break-inside: avoid; 
            page-break-after: always
        }
	}
</style>

<div class="modal" id="full-paper">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{__('students.viewFullPaper')}}</h4>
                
                <!-- <span class="print-btn mr-4 cursor-pointer text-disable" title="Print">
                    <i class="fa fa-print" aria-hidden="true"></i>
                </span> -->

                <span class="enlarge-popup-btn mr-4 cursor-pointer text-disable">
                    {!! config('constants.icons.enlarge-icon') !!}
                </span>

                <button type="button" class="close" data-dismiss="modal">
                    {!! config('constants.icons.close-icon') !!}
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="printable">
                    @if(isset($questionData['questions']) && !empty($questionData['questions']))
                        @foreach($questionData['questions'] as $key => $question)
                            @php
                                $question = decryptBlobData($question);
                            @endphp
                            <div class="question-block" id="quest{{ $question['questionTypeId'] }}">
                                <div class="question-text d-table w-100 mb-2 f-12">
                                    <div class="q-text d-table-cell v-top" data-id="{{ $question['questionId'] }}">
                                        <div class="question-list">
                                            <div class="q-serial">{{ $key+1 }}</div>
                                            {!! html_entity_decode($question['questionText']) !!}
                                            <div class="q-mark">{{ $question['weightage'] }} <small>{{ pointText($question['weightage']) }}</small></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step<?=$key+1?>">
                                    @include('students.pages.exam.question-types-options-modal.'.str_replace(" ","-",strtolower(getTemplateName($question['questionTypeId']))))
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="tool-instructions">
    <div class="modal-dialog">
        <div class="modal-content animate-bottom">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ __('students.toolInstructions') }}</h4>
                <span class="enlarge-popup-btn mr-4 cursor-pointer text-disable"> 
                    {!! config('constants.icons.enlarge-icon') !!}
                </span>
                <button type="button" class="close" data-dismiss="modal">
                    {!! config('constants.icons.close-icon') !!} 
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="">
                    <ul class="tool-instruction">
                        <li>{{ __('students.reviewModalPage.toolInstructionLine1') }}</li>
                        <li>{{ __('students.reviewModalPage.toolInstructionLine2') }}</li>
                        <li>{{ __('students.reviewModalPage.clickOnTheText') }} <img src="{{ asset('assets/images/students/q-paper-btn.png') }}" class="h-32"> {{ __('students.reviewModalPage.toolInstructionLine3') }} </li>
                        <li>{{ __('students.reviewModalPage.clickOnTheText') }} <img src="{{ asset('assets/images/students/report.png') }}" class="h-32"> {{ __('students.reviewModalPage.toolInstructionLine4') }} </li>
                        <li>{{ __('students.reviewModalPage.clickOnTheText') }} <img src="{{ asset('assets/images/students/bookmark.png') }}" class="h-32"> {{ __('students.reviewModalPage.toolInstructionLine5') }} </li>
                        <li>{{ __('students.reviewModalPage.clickOnTheText') }} <img src="{{ asset('assets/images/students/clearanswer.png') }}" class="h-32"> {{ __('students.reviewModalPage.toolInstructionLine6') }}</li>
                        <li>{{ __('students.reviewModalPage.toolInstructionLine7') }}
                            <ul>
                                <li><img src="{{ asset('assets/images/students/q-na.png') }}" class="h-32"> {{ __('students.reviewModalPage.toolInstructionLine8') }}
                                </li>
                                <li><img src="{{ asset('assets/images/students/q-ans.png') }}" class="h-32"> {{ __('students.reviewModalPage.toolInstructionLine9') }}
                                </li>
                                <li><img src="{{ asset('assets/images/students/q-na-bookmark.png') }}" class="h-32"> {{ __('students.reviewModalPage.toolInstructionLine10') }}
                                </li>
                                <li><img src="{{ asset('assets/images/students/q-a-bookmark.png') }}" class="h-32"> {{ __('students.reviewModalPage.toolInstructionLine11') }} 
                                </li>
                            </ul>
                        </li>
                        <li>{{ __('students.reviewModalPage.toolInstructionLine12') }} </li>
                        <li>{{ __('students.reviewModalPage.toolInstructionLine13') }} <img src="{{ asset('assets/images/students/next.png') }}" class="h-32"> {{ __('students.reviewModalPage.toolInstructionLine14') }} <img src="{{ asset('assets/images/students/prev.png') }}" class="h-32"> {{ __('students.reviewModalPage.toolInstructionLine15') }} </li>
                        <li>{{ __('students.reviewModalPage.toolInstructionLine16') }}</li>
                        <li>{{ __('students.reviewModalPage.clickOnTheText') }} <img src="{{ asset('assets/images/students/font-resize.png') }}" class="h-32"> {{ __('students.reviewModalPage.toolInstructionLine17') }} </li>
                        <li>{{ __('students.reviewModalPage.toolInstructionLine18') }}</li>
                        <li>{{ __('students.reviewModalPage.clickOnTheText') }} <img src="{{ asset('assets/images/students/finish.png') }}" class="h-32"> <img src="{{ asset('assets/images/students/finish2.png') }}" class="h-32"> {{ __('students.reviewModalPage.toolInstructionLine19') }} </li>
                        <li>{{ __('students.reviewModalPage.toolInstructionLine20') }}</li>
                        <li>{{ __('students.reviewModalPage.clickOnTheText') }} <img src="{{ asset('assets/images/students/submit.png') }}" class="h-32"> <img src="{{ asset('assets/images/students/submit2.png') }}" class="h-32"> {{ __('students.reviewModalPage.toolInstructionLine21') }} </li>
                    </ul>
                
                </div>
            </div>
        </div>
    </div>
</div>
@php
    if(isset($questionData) ) {
@endphp
    <div class="modal" id="tool-modal">
        <div class="modal-dialog">
            <div class="modal-content animate-bottom">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-gray">{{ __('students.testInstructions') }}</h4>
                    <span class="enlarge-popup-btn mr-4 cursor-pointer text-disable">
                        {!! config('constants.icons.enlarge-icon') !!}
                    </span>
                    <button type="button" class="close" data-dismiss="modal">
                        {!! config('constants.icons.close-icon') !!}
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="">
                        <p class="ml-2"> {!! ($questionData['testInsructions']) ? $questionData['testInsructions'] : "Test Instructions" !!} </p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col">{{ __('students.review.questionNumber') }}</th>
                                <th scope="col">{{ __('students.review.questionType') }}</th>
                                <th scope="col">{{ __('students.review.count') }}</th>
                                <th scope="col">{{ __('students.review.pointsPerQuestions') }}</th>
                                <th scope="col">{{ __('students.review.negativePoints') }}</th>
                                <th scope="col">{{ __('students.review.total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @if(isset($questionData['questionFormat']))
                                    @foreach($questionData['questionFormat'] as $key => $questionFormat)
                                        <tr>
                                            <th scope="row">{{ $questionFormat['range'] }}</th>
                                            <td>{{ getTemplateName($questionFormat['questionTypeId']) }}</td>
                                            <td>{{ $questionFormat['numberOfQuestion'] }}</td>
                                            <td>{{ $questionFormat['weightage'] }}</td>
                                            <td></td>
                                            <td>{{ $questionFormat['weightage'] * $questionFormat['numberOfQuestion'] }}</td>
                                        </tr>
                                        @php
                                            $total += $questionFormat['weightage'] * $questionFormat['numberOfQuestion'];
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">{{ __('students.review.grandTotal') }}</th>
                                    <td>{{ $total }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@php
    }
@endphp
<div class="modal" id="global-popup-slider">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ __('students.review.globalFiles') }}</h4>
                <span class="enlarge-popup-btn mr-4 cursor-pointer text-disable">
                    {!! config('constants.icons.enlarge-icon') !!}
                </span>
                <button type="button" class="close" data-dismiss="modal">
                    {!! config('constants.icons.close-icon') !!}
                </button>
            </div>
            <div class="modal-body" style="padding-left:0px;padding-right:0px">
                <div id="global-carousel-slide" class="carousel slide" data-ride="carousel" style="display:flex;justify-content:center;align-items:center;flex-direction:row;width:100%">
                    <div style="width:2%">
                        <i href="#global-carousel-slide" data-slide="prev" class="fa fa-caret-left" aria-hidden="true" style="background-color: #178D8D; border-radius: 10px; color: #FFFFFF; width: 100%; display: flex; padding-left: 30%; align-items: center; height: 19px; cursor:pointer">
                        </i>
                    </div>
                    <div class="carousel-inner" style="width:94%">
                    </div>
                    <!-- Left and right controls -->
                    <div  style="width:2%">
                        <i href="#global-carousel-slide" data-slide="next" class="fa fa-caret-right" aria-hidden="true" style="background-color: #178D8D; border-radius: 10px; color: #FFFFFF; width: 100%; display: flex; justify-content: center; align-items: center; height: 19px; cursor:pointer">
                        </i>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal" id="question-popup-slider">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->

            <div class="modal-header">
                <h4 class="modal-title">{{ __('students.review.questionFileUploades') }}</h4>
                <span class="enlarge-popup-btn mr-4 cursor-pointer text-disable">
                    {!! config('constants.icons.enlarge-icon') !!}
                </span>
                <button type="button" class="close" data-dismiss="modal">
                    {!! config('constants.icons.close-icon') !!}
                </button>
            </div>
            <div class="modal-body" style="padding-left:0px;padding-right:0px">
                <div id="question-carousel-slide" class="carousel slide" data-ride="carousel" style="display:flex;justify-content:center;align-items:center;flex-direction:row;width:100%">
                    <div style="width:2%">
                        <i href="#question-carousel-slide" data-slide="prev" class="fa fa-caret-left" aria-hidden="true" style="background-color: #178D8D; border-radius: 10px; color: #FFFFFF; width: 100%; display: flex; padding-left: 30%; align-items: center; height: 19px; cursor:pointer">
                        </i>
                    </div>
                    <div class="carousel-inner" style="width:94%"></div>
                    <!-- Left and right controls -->
                    <div  style="width:2%">
                        <i  href="#question-carousel-slide" data-slide="next" class="fa fa-caret-right" aria-hidden="true" style="background-color: #178D8D; border-radius: 10px; color: #FFFFFF; width: 100%; display: flex; justify-content: center; align-items: center; height: 19px; cursor:pointer">
                        </i>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal modal-fullscreen" id="fileModalPreview" data-backdrop="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="fileModalTitle"></h4>
                <span class="enlarge-popup-btn mr-4 cursor-pointer text-disable">
                    {!! config('constants.icons.enlarge-big-icon') !!}
                </span>
                <button type="button" class="close" data-dismiss="modal">
                    {!! config('constants.icons.close-icon') !!}
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="fileModalBody"></div>
        </div>
    </div>
</div>

<div class="modal confirm" id="confirm" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">

                <h5>{{ __("students.notifications.wantToSubmitAssessmentText") }}</h5>
                <!-- question type table end -->
                <hr>
                <button class="btn btn-outline-primary mr-2" data-dismiss="modal" id="close-confirm">{{ __("students.cancel") }}</button>
                <button class="btn btn-primary submit-exam">{{ __("students.submit") }}</button>
            </div>
            <!-- Modal footer -->
        </div>
    </div>
</div>

<div class="modal confirm" id="removeAttachment" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">

                <h5>{{ __("students.wantToDeleteAttachmentText") }}</h5>
                <!-- question type table end -->
                <hr>
                <input type="hidden" name="className" value="">
                <button class="btn btn-outline-primary mr-2" data-dismiss="modal" id="close-confirm">{{ __("students.cancel") }}</button>
                <button class="btn btn-primary delete-attachment">{{ __("students.delete") }}</button>
            </div>
            <!-- Modal footer -->
        </div>
    </div>
</div>