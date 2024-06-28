@extends('teachers.layouts.board')
@section('content')
<div class="w-100">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="canvas-area-full">
                <div class="canvas-inner">
                    <div class="tab-panel-box assissment-home">
                        {{ csrf_field() }}
                        <input type="hidden" id="gradeAllAjaxUrl" value="{{ route('grading.grade.all') }}">
                        <input type="hidden" name="paperId" id="assessmentId" value="{{ $paperId }}">
                        <input type="hidden" name="teacherId" id="teacherId" value="{{ $teacherId }}">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active total" id="in-progress-tab" data-toggle="tab" href="#in-progress" role="tab" aria-controls="home" aria-selected="true">{{ __('teachers.boardPage.all') }} <span class="badge "> {{ count($total) }} </span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link submitted" id="attempted-tab" data-toggle="tab" href="#attempted" role="tab" aria-controls="sample" aria-selected="false">{{ __('teachers.boardPage.ungraded') }} <span class="badge ">{{ count($submitted) }}</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link graded" id="graded-tab" data-toggle="tab" href="#graded" role="tab" aria-controls="sample" aria-selected="false">{{ __('teachers.boardPage.graded') }} <span class="badge ">{{ count($graded) }}</span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link draft" id="draft-tab" data-toggle="tab" href="#draft" role="tab" aria-controls="sample" aria-selected="false">{{ __('teachers.boardPage.draft') }} <span class="badge ">{{ count($draft) }}</span></a>
                            </li>

                        </ul>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="custom-control custom-checkbox mt-1 ml-12 d-none">
                                    <input type="checkbox" id="customCheck-all" name="questionBank" class="custom-control-input" value="previousYearQuestionPaper">
                                    <label class="custom-control-label" for="customCheck-all">
                                        {{ __("teachers.boardPage.checkAll") }}
                                    </label>
                                </div>
                            </div>
                            @if (isset($gradeStudents['isAutoEvaluation']) && $gradeStudents['isAutoEvaluation'] == true)
                                @php
                                    $disabled = "disabled";
                                @endphp
                                @if((isset($submitted) && count($submitted)) > 0 || (isset($draft) && count($draft) > 0))
                                    @php
                                        $disabled = "";
                                    @endphp
                                @endif
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <p class="mr-2 mb-0">{{ __('teachers.grading.gradeToAll') }}</p>
                                        <button href="#" class="btn btn-primary gradeToAll" {{ $disabled }}>{{ __('teachers.grading.grade') }}</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="in-progress" role="tabpanel" aria-labelledby="in-progress-tab">
                                @if (isset($total) && !empty($total))
                                    @foreach ($total as $key => $student)
                                        <div class="card gradingStatus" data-status="{{ $student['status'] }}" data-response="{{ $student['responseStatus'] }}">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="d-flex align-items-center">
                                                        <div class="custom-control custom-checkbox">
                                                            {{-- <input type="checkbox" id="customCheck{{ $key }}" name="questionBank" class="custom-control-input" value="{{ $student['profile']['id'] }}"> --}}
                                                            <label class="custom-control-label1" for="customCheck{{ $key }}">
                                                                <div class="sub-name">
                                                                    <div class="student-icon">
                                                                        <img src="{{ handleProfilePic($student['profile']['profilePicUrl']) }}">
                                                                        <p>{{ $student['profile']['name'] }}</p>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                        @if($student['gradingStatus'] == config('constants.draft'))
                                                            <div class="status-draft">
                                                                <i class="fa fa-circle blink"></i> {{ $student['status'] }}
                                                            </div>
                                                        @elseif($student['gradingStatus'] == config('constants.graded'))
                                                            <div class="status-graded">
                                                                <i class="fa fa-circle  blink"></i> {{ $student['status'] }}
                                                            </div>
                                                        @elseif($student['responseStatus'] == config('constants.notstarted'))
                                                            <div class="status-due">
                                                                <i class="fa fa-circle  blink"></i> {{ $student['status'] }}
                                                            </div>
                                                        @elseif($student['responseStatus'] == config('constants.absent'))
                                                            <div class="status-due">
                                                                <i class="fa fa-circle  blink"></i> {{ $student['status'] }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card-action-box">
                                                        <div class="input-group w-120 num-input mr-2 point-input green">
                                                            <input type="text" class="form-control mx-width-50" placeholder="{{ (isset($student['gradingStatus']) && $student['responseStatus'] == config('constants.submitted')) || ($student['gradedMarks'] > 0) ? $student['gradedMarks'] : '-' }}" aria-label="-" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">{{ $gradingData['maximumMarks'] }}</span>
                                                            </div>
                                                            <div class="auto-grade-lable">{{ __('teachers.grading.pointObtained') }}</div>
                                                        </div>
                                                        
                                                    @if ($student['responseStatus'] == config('constants.notstarted') || $student['responseStatus'] == config('constants.inProgress'))
                                                        <a href="#" class="btn btn-primary auto-width disabled">{{ $student['button'] == __('teachers.grading.disabled') ? __('teachers.grading.grade') : $student['button'] }}</a>
                                                    @else
                                                        <a href="{{ route('grading.assessments.index', base64_encode($student['profile']['id'].'_'.$paperId.'_'.$student['responseId']) ) }}" class="btn btn-primary auto-width {{ $student['button'] == __('teachers.grading.disabled') ? 'disabled' : ''}} {{  $gradingData['isResultPublished'] == true ? 'disabled' : '' }}" {{ $student['button'] == __('teachers.grading.disabled') ? 'disabled' : ''}} {{  $gradingData['isResultPublished'] == true ? 'disabled' : '' }}>{{ $student['button'] == __('teachers.grading.disabled') ? __('teachers.grading.grade') : $student['button'] }}</a>
                                                    @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex align-items-center">
                                                    {{ __('teachers.grading.noStudentAssessment') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="attempted" role="tabpanel" aria-labelledby="attempted-tab">
                                @if (isset($submitted) && !empty($submitted))
                                    @foreach ($submitted as $key => $student )
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="d-flex align-items-center">
                                                        <div class="custom-control custom-checkbox">
                                                            <label class="custom-control-label1" for="customCheck4"><div class="sub-name">
                                                                <div class="student-icon">
                                                                    <img src="{{ handleProfilePic($student['profile']['profilePicUrl']) }}">
                                                                    <p>{{ $student['profile']['name'] }}</p>
                                                                </div>
                                                            </div></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card-action-box">
                                                        <div class="input-group w-120 num-input mr-2 point-input green">
                                                            <input type="text" class="form-control mx-width-50" placeholder="{{ $student['gradedMarks'] }}" aria-label="-" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">{{ $gradingData['maximumMarks'] }}</span>
                                                            </div>
                                                            <div class="auto-grade-lable">{{ __('teachers.grading.pointObtained') }}</div>
                                                        </div>
                                                        @if($student['responseId'] == null)
                                                            <a href="#" class="btn btn-primary auto-width disabled">{{ $student['button'] == __('teachers.grading.disabled') ? __('teachers.grading.grade') : $student['button'] }}</a>
                                                        @else
                                                            <a href="{{ route('grading.assessments.index', base64_encode($student['profile']['id'].'_'.$paperId.'_'.$student['responseId'])) }}" class="btn btn-primary auto-width {{ $student['button'] == __('teachers.grading.disabled') ? 'disabled' : ''}} {{  $gradingData['isResultPublished'] == true ? 'disabled' : '' }}" {{ $student['button'] == __('teachers.grading.disabled') ? 'disabled' : ''}} {{  $gradingData['isResultPublished'] == true ? 'disabled' : '' }}>{{ $student['button'] == __('teachers.grading.disabled') ? __('teachers.grading.grade') : $student['button'] }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex align-items-center">
                                                    {{ __('teachers.grading.noStudentAssessment') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="graded" role="tabpanel" aria-labelledby="graded-tab">
                                @if (isset($graded) && !empty($graded))
                                    @foreach ($graded as $key => $student)
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="d-flex align-items-center">
                                                        <div class="custom-control custom-checkbox">
                                                            {{-- <input type="checkbox" id="customCheck3" name="questionBank" class="custom-control-input" value="previousYearQuestionPaper">--}}
                                                            <label class="custom-control-label1" for="customCheck3"><div class="sub-name">
                                                                <div class="student-icon">
                                                                    <img src="{{ handleProfilePic($student['profile']['profilePicUrl']) }}">
                                                                    <p>{{ $student['profile']['name'] }}</p>
                                                                </div>
                                                            </div></label>
                                                        </div>
                                                        <div class="status-graded">
                                                            <i class="fa fa-circle blink"></i> {{ $student['status'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card-action-box">
                                                        <div class="input-group w-120 num-input mr-2 point-input green">
                                                            <input type="text" class="form-control mx-width-50" placeholder="{{ $student['gradedMarks'] }}" aria-label="-" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">{{ $gradingData['maximumMarks'] }}</span>
                                                            </div>
                                                            <div class="auto-grade-lable">{{ __('teachers.grading.pointObtained') }}</div>
                                                        </div>
                                                        @if ($student['responseId'] == null)
                                                            <a href="#" class="btn btn-primary auto-width disabled">{{ $student['button'] == __('teachers.grading.disabled') ? __('teachers.grading.grade') : $student['button'] }}</a>
                                                        @else
                                                            <a href="{{ route('grading.assessments.index', base64_encode($student['profile']['id'].'_'.$paperId.'_'.$student['responseId'])) }}" class="btn btn-primary auto-width {{ $student['button'] == __('teachers.grading.disabled') ? 'disabled' : ''}} {{  $gradingData['isResultPublished'] == true ? 'disabled' : '' }}" {{ $student['button'] == __('teachers.grading.disabled') ? 'disabled' : ''}} {{  $gradingData['isResultPublished'] == true ? 'disabled' : '' }}>{{ $student['button'] == __('teachers.grading.disabled') ? __('teachers.grading.grade') : $student['button'] }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                @else
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex align-items-center">
                                                    {{ __('teachers.grading.noStudentAssessment') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="draft" role="tabpanel" aria-labelledby="upcoming-tab">
                                @if (isset($draft) && !empty($draft))
                                    @foreach ($draft as $key => $student)
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="d-flex align-items-center">
                                                        <div class="custom-control custom-checkbox">
                                                            {{-- 
                                                            <input type="checkbox" id="customCheck1" name="questionBank" class="custom-control-input" value="previousYearQuestionPaper">
                                                            --}}
                                                            <label class="custom-control-label1" for="customCheck1"><div class="sub-name">
                                                                <div class="student-icon">
                                                                    <img src="{{ handleProfilePic($student['profile']['profilePicUrl']) }}">
                                                                    <p>{{ $student['profile']['name'] }}</p>
                                                                </div>
                                                            </div></label>
                                                        </div>
                                                        <div class="status-draft">
                                                            <i class="fa fa-circle  blink"></i> {{ $student['status'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card-action-box">
                                                        <div class="input-group w-120 num-input mr-2 point-input green">
                                                            <input type="text" class="form-control mx-width-50" placeholder="{{ $student['gradedMarks'] }}" aria-label="-" disabled>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">{{ $gradingData['maximumMarks'] }}</span>
                                                            </div>
                                                            <div class="auto-grade-lable">{{ __('teachers.grading.pointObtained') }}</div>
                                                        </div>
                                                        @if ($student['responseId'] == null)
                                                            <a href="#" class="btn btn-primary auto-width disabled">{{ $student['button'] == __('teachers.grading.disabled') ? __('teachers.grading.grade') : $student['button'] }}</a>
                                                        @else
                                                            <a href="{{ route('grading.assessments.index', base64_encode($student['profile']['id'].'_'.$paperId.'_'.$student['responseId'])) }}" class="btn btn-primary auto-width {{  $student['button'] == __('teachers.grading.disabled') || $gradingData['isResultPublished'] == true ? 'disabled' : '' }}" {{  $gradingData['isResultPublished'] == true ? 'disabled' : '' }}>{{ $student['button'] == __('teachers.grading.disabled') ? __('teachers.grading.grade') : $student['button'] }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex align-items-center">
                                                    {{ __('teachers.grading.noStudentAssessment') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="canvas-footer">

                    </div>
                </div>

            </div>

        </div>
        <!-- row end -->
    </div>
    <!-- container-fluid end -->
</div>
<!-- main-body end -->
@endsection
