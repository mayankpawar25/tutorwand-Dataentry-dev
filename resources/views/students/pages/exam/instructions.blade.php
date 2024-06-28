@extends('students.layouts.default')
@section('title', "Exam Instructions")
@section('content')
<div class="fixed-side-panel-trigger"><i class="fa fa-caret-right" aria-hidden="true"></i></div>
<div class="container-fluid">
    <div class="row" id="instructionsPage">
        <div class="col-md-8 col-lg-9">
            <div class="canvas-area">
                <div class="canvas-inner">
                    <div class="canvas-inner-header">
					    <div class="row">
                            <button id="openExamPopup" class="d-none">{{ __('students.instruction.startExam') }}</button>
                            {{ csrf_field() }}
                            <input type="hidden" id="isUntimed" name="isUntimed" value="{{ $questionData['header']['isUntimed'] }}">
                            <input type="hidden" id="submitResponseUrl" name="submitResponseUrl" value="{{ route('students.question.response') }}">
                            <input type="hidden" id="paperID" name="paperID" value="{{ $questionData['questionPaperId'] }}">
                            <input type="hidden" id="studentID" name="studentID" value="{{ getStudentUserId() }}">
					        <div class="col-md-9 col-6">
					            <p class="mb-1 f-14 f-w600">{{ __('students.class') }}: {{ $questionData['header']['class']['gradeName'] }}</p>
					            <p class="mb-1 f-14 f-w600">{{ __('students.subject') }}: {{ $questionData['header']['subject']['subjectName'] }}</p>
					        </div>
					        <div class="col-md-3 col-6 text-right">
					            <p class="text-gray f-14 mb-1 f-w400">{{ __('students.maxmarks') }}: {{ $questionData['header']['maximumMarks'] }}</p>
                                @php
                                    if(isset($questionData['header']['testDuration']) && !empty($questionData['header']['testDuration']) && $questionData['header']['testDuration'] > 0){
                                @endphp
        					            <p class="text-gray f-14 mb-1 f-w400">{{ __('students.time') }}: {{ $questionData['header']['testDuration'] }} minutes</p>
                                @php
                                    }
                                @endphp
					        </div>
					    </div>
					</div>

					<div class="canvas-body inst">
					    <h5 class="mt-0">{{ __('students.instructions') }}-</h5>
					    <p class="ml-2"> {!! ($questionData['testInsructions']) ? $questionData['testInsructions'] : "Test Instructions" !!} </p>
                       <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('teachers.assessment.questionNumbers') }}</th>
                                        <th scope="col">{{ __('teachers.assessment.questionType') }}</th>
                                        <th scope="col">{{ __('teachers.assessment.count') }}</th>
                                        <th scope="col">{{ __('teachers.assessment.pointsPerQuestions') }}</th>
                                        <th scope="col">{{ __('teachers.assessment.total') }}</th>
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
                                        <th colspan="4">{{ __('teachers.assessment.grandTotal') }}</th>
                                        <td>{{ $total }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                       </div>
					</div>
                </div>
                <div class="canvas-footer">
                    <div class="text-right">
                        <div class="custom-control custom-checkbox pull-left mt-1" tabindex="0">
                            <input type="checkbox" class="custom-control-input"  id="customCheck1" name="instructions" value="checked" tabindex="1" {{ ($questionData['examStatus'] == 'InProgress') ? 'checked disabled' : '' }}>
                            <label class="custom-control-label" for="customCheck1">
                            {{ __('students.instruction.iAgreeLabel') }} <a href="#" class="text-brand" data-toggle="modal" data-target="#tC-Modal"><u>{{ __('students.instruction.termsAndConditions') }}</u></a>
                                <!-- {{ __('students.tnc') }} -->
                            </label>
                        </div>
                        <span class="instruction-page-btn">
                        <a class="btn btn-outline-primary mr-2" href="#" data-toggle="modal" data-target="#tool-instructions">
                            <i class="fa fa-eye left" aria-hidden="true"></i>
                            <span class="hide-mob">{{ __('students.viewToolInstructions') }}</span>
                            <span class="d-block d-md-none d-lg-none">Tool Instructions</span>
                        </a>
                        <button class="btn btn-primary startExamBtn {{ ($questionData['examStatus'] == 'UpComing') ? 'disabled' : '' }}" data-href="{{ route('students.exam') }}"><span class="buttonTitle">{{ __('students.start') }}</span> <i class="fa fa-angle-right right" aria-hidden="true"></i></button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="right-panel">
                <img src="{{ asset('assets/images/students/img-right.png') }}" class="motive-img" alt="mb">
            </div>
        </div>
    </div>
</div><!-- container-fluid end -->

<!-- terms and condition modal -->
<div class="modal" id="tC-Modal">
    <div class="modal-dialog">
        <div class="modal-content animate-bottom">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ __('students.termsAndCondition') }}</h4>
                <span class="enlarge-popup-btn mr-4 cursor-pointer text-disable"> 
                    {!! config('constants.icons.enlarge-icon') !!}
                </span>
                <button type="button" class="close" data-dismiss="modal">
                    {!! config('constants.icons.close-icon') !!} 
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                {!! __('students.instruction.termsAndConditionContent') !!}
            </div>
        </div>
    </div>
</div>
<!-- end terms and condition modal -->
@endsection
