<div class="main-header">
    <div class="header-bg-strip">
        <nav class="navbar navbar-expand-lg navbar-light ">
            <div class="header-left">
                <div class="dropdown grading-inner-student-list">
                  <div class="student-icon dropdown-toggle " data-toggle="dropdown">
                      <ul>
                          @if (isset($selected) && !empty($selected))
                              <li><img src="{{ handleProfilePic($selected['profile']['profilePicUrl']) }}"></li>
                              <li><div class="s-name">{{ $selected['profile']['name'] }}</div></li>
                              <li><i class="fa fa-caret-down" aria-hidden="true"></i></li>
                          @endif
                      </ul>
                  </div>
                  <div class="dropdown-menu">
                    <div class="d-flex sort-box">
                        <ul class="d-flex order-section">
                            <li><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ __('teachers.grading.sortBy') }}</li>
                            <li class="sort-name {{ isset($sortOrder['sortBy']) && $sortOrder['sortBy'] == 'name' ? '' : 'disabled' }}" data-order="{{ isset($sortOrder['orderBy']) ? $sortOrder['orderBy'] : 'asc' }}"><i class="fa {{ isset($sortOrder['orderBy']) && $sortOrder['orderBy'] == 'asc' ? 'fa-long-arrow-down' : 'fa-long-arrow-up' }}" aria-hidden="true"></i> {{ __('teachers.grading.name') }}</li>
                            <li class="sort-status {{ isset($sortOrder['sortBy']) && $sortOrder['sortBy'] == 'status' ? '' : 'disabled' }}" data-order="{{ isset($sortOrder['orderBy']) ? $sortOrder['orderBy'] : 'asc' }}"><i class="fa {{ isset($sortOrder['orderBy']) && $sortOrder['orderBy'] == 'asc' ? 'fa-long-arrow-down' : 'fa-long-arrow-up' }}" aria-hidden="true"></i> {{ __('teachers.grading.status') }}</li>
                        </ul>
                    </div>
					<div class="student-lists">
						@if (isset($students) && !empty($students))
							@foreach ($students as $student)
								<div class="student-icon">
									<a href="{{ route('grading.assessments.index', base64_encode($student['profile']['id'].'_'.$paperId.'_'.$student['responseId'])) }}">
										<ul>
											<li><img src="{{ handleProfilePic($student['profile']['profilePicUrl']) }}"></li>
											<li><div class="s-name" data-studentid="{{ $student['profile']['id'] }}" data-id="{{ $student['profile']['name'] }}">{{ $student['profile']['name'] }}</div></li>
											<li class="s-status {{ strtolower($student['status']) }}">{{ $student['status'] }}</li>
										</ul>
									</a>
								</div>
							@endforeach
						@endif
                    </div>
                  </div>
                </div>
                @php
                    $maxMarks = 0;
                @endphp
                @if (isset($studentResponse['responses']))
                    @foreach ($studentResponse['responses'] as $response)
                        @php 
                          $maxMarks += $response['answer']['maximumMarks']; 
                        @endphp
                    @endforeach
                @endif
                <h4>{{ __('grading.totalPoints') }} - <strong><span class="obtainedMarks">{{ $studentResponse['gradedMarks'] }}</span>/{{ $maxMarks }}</strong></h4>
            </div>
            
            @include('teachers.layouts.partials.profile')

        </nav>
    </div>
    <!-- container-fluid end -->
    <div class="sub-header">
        <div class="row">
            <div class="col-sm-2 col-lg-2">
                <div class="d-flex">
                    <div class="form-group filter-dd-margin w-100">
                        <select class="selectpicker form-control responseStatusFilter" title="{{ __('grading.filterBy') }}">
                            <option value="answerStatus" selected>{{ __('grading.all') }}</option>
                            @foreach ($studentResponse['responseStatusList'] as $responseStatus)
                                <option value="{{ strtolower($responseStatus) }}">{{ __('grading.'.strtolower($responseStatus)) }}</option>
                            @endforeach
                    </select>
                    </div>
                    <div class="collapse-btn" data-toggle="tooltip" title="Collapse All">
                        <i class="fa fa-angle-up" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-6">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="dropdown mr-3 attachment" data-toggle="tooltip" title="{{ __('grading.globalAttachment') }}">
                        <button type="button" class="btn btn-primary btn-tpt dropdown-toggle" data-toggle="dropdown">
							{!! config('constants.icons.paper-clip-icon') !!}
                            <span class="badge badge-primary">{{ isset($studentResponse['globalFiles']) ? count($studentResponse['globalFiles']) : '0' }}</span>
                        </button>
                        @if (isset($studentResponse['globalFiles']) && !empty($studentResponse['globalFiles']))
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="uploaded-doc">
                                    @foreach ($studentResponse['globalFiles'] as $gFile)
                                        <li>
                                            <a href="javascript:void(0)" data-href="{{ $gFile['fileUrl'] }}" data-filename="{{ $gFile['fileName'] }}" class="viewFile">
                                              <div>{!! config('constants.icons.add-response') !!}</div>
                                              <div style="color: var(--dark);">{{ $gFile['fileName'] }}</div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="btn-group">

                        <button type="button" class="btn btn-primary auto-width saveStudentsGradingMarks" data-status="Graded"><i class=" left">{!! config('constants.icons.check-icon') !!}</i>{{ __('grading.grade') }}</button>

                        <button type="button" class="btn btn-primary dropdown-toggle dd-btn-joint" data-toggle="dropdown"><i class="fa fa-caret-down" aria-hidden="true"></i></button>

                        <div class="dropdown-menu menu-m-top dropdown-menu-right"><a href="{{ isset($back) ? $back : '#' }}" class="dropdown-item" data-status="Draft" href="#">{{ __('grading.assessmentBoard') }}</a></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal confirm" id="grade-confirmation">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">

			<!-- Modal Header -->
			<button type="button" class="close" data-dismiss="modal">
				{!! config("constants.icons.close-icon") !!}
			</button>

			<!-- Modal body -->
			<div class="modal-body">
				<h5 class="text-center mb-4"><b>{{ __('grading.gradingSure') }}</b></h5>
				<!-- question type table end -->
				<div class="mb-3 text-center">
					<button class="btn btn-outline-primary mr-2" data-dismiss="modal">{{ __('teachers.button.cancel') }}</button>
					<button class="btn btn-primary" id="submitGrade">{{ __('teachers.report.grade') }}</button>
				</div>
				<hr>
				<div class="text-left">
					@php 
						$commentArray = []; 
					@endphp
					@if (isset($studentResponse['overAllComment']) && !empty($studentResponse['overAllComment']))
						@php 
						$commentArray = explode("," , $studentResponse['overAllComment']); 
						@endphp
					@endif
					<label class="mb-2"><b>Overall Feedback</b></label>
					<textarea class="form-control" name="feedback">{{ isset($studentResponse['overAllComment']) && !empty($studentResponse['overAllComment']) ? $studentResponse['overAllComment'] : '' }}</textarea>
					<ul class="grading-checkbox">
						<li>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" id="customCheck1" name="questionBank" class="custom-control-input" value="Good job!" {{ in_array("Good job!" , $commentArray) ? 'checked' : '' }}>
							<label class="custom-control-label" for="customCheck1">{{ __('teachers.grading.goodJobLabel') }}</label>
						</div>
						</li>
						<li>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" id="customCheck2" name="questionBank" class="custom-control-input" value=" Brilliant!" {{ in_array(" Brilliant!" , $commentArray) ? 'checked' : '' }}>
							<label class="custom-control-label" for="customCheck2">{{ __('teachers.grading.brilliantLabel') }}</label>
						</div>
						</li>
						<li>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" id="customCheck3" name="questionBank" class="custom-control-input" value=" I'm impressed." {{ in_array(" I\'m impressed." , $commentArray) ? 'checked' : '' }}>
							<label class="custom-control-label" for="customCheck3">{!! __('teachers.grading.imImpressedLabel') !!}</label>
						</div>
						</li>
						<li>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" id="customCheck4" name="questionBank" class="custom-control-input" value=" Keep up the good work." {{ in_array(" Keep up the good work." , $commentArray) ? 'checked' : '' }}>
							<label class="custom-control-label" for="customCheck4">{{ __('teachers.grading.keepUpLabel') }}</label>
						</div>
						</li>
						<li>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" id="customCheck5" name="questionBank" class="custom-control-input" value=" You've improved a lot." {{ in_array(" You've improved a lot." , $commentArray) ? 'checked' : '' }}>
								<label class="custom-control-label" for="customCheck5">{{ __('teachers.grading.youveimprovedLabel') }}</label>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="sortStudent" id="sort-student"  value="{{ route('grading.sort.students') }}"/>
