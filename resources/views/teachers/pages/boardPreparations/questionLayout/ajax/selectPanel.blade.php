<div class="row">
    <div class="col-md-7">
        <div class="row">
            <div class="col-sm-4">
                <label class="label-heading">{{ __('teachers.questionLayout.board') }}</label>
                <select class="form-control selectpicker onchangeValue get_curl_data" name="select_board" data-get="select_grade" >
                    <option value="">{{ __('questionLayout.selectBoard') }}</option>
                    @if (isset($questionLayout['rightPanelData']['Board']))
                        @foreach ($questionLayout['rightPanelData']['Board'] as $key => $board)
                            <option value="{{ $board['boardId'] }}" {{ isset($session['selectBoard']) && ($session['selectBoard']) == $board['boardId'] ? 'selected' : '' }}>{{ $board['boardName'] }}</option>
                        @endforeach
                    @endif
                </select>
            </div> 
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-md-12">
                        <label class="label-heading">{{ __('teachers.questionLayout.grade') }}</label>
                    </div>
                    <div class="col-md-12 div-select_grade">
                    @php
                    $disabled = "disabled";
                    if (isset($questionLayout['rightPanelData']['isPrevious']) && $questionLayout['rightPanelData']['isPrevious'] == true) {
                        $disabled = "";
                    }

                    if (isset($session['selectGrade']) && !empty($session['selectGrade'])) {
                        $disabled = "";
                    }
                @endphp
                        <select class="form-control selectpicker onchangeValue get_curl_data" name="select_grade" data-get="select_subject" {{ $disabled }}>
                            <option value="">{{ __('questionLayout.selectGrade') }}</option>
                            @if (isset($questionLayout['rightPanelData']['Grade']) && !empty($questionLayout['rightPanelData']['Grade']) && isset($session['selectGrade']))
                                @foreach ($questionLayout['rightPanelData']['Grade'] as $value)
                                    @if(config('constants.selectedGradeId') == $value['id'])
                                        <option value="{{ $value['id'] }}" {{ isset($session['selectGrade']) && ($session['selectGrade'] == $value['id']) ? 'selected' : '' }}>{{ $value['name'] }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-md-12">
                        <label class="label-heading">{{ __('teachers.questionLayout.subject') }}</label>
                    </div>
                    <div class="col-md-12 div-select_subject">
                    <select class="form-control selectpicker onchangeValue get_curl_data" name="select_subject" data-get="select_topic" {{ $disabled }}>
                        <option value="">{{ __('questionLayout.selectSubject') }}</option>
                        @if (isset($questionLayout['rightPanelData']['Subject']) && !empty($questionLayout['rightPanelData']['Subject']))
                            @foreach ($questionLayout['rightPanelData']['Subject'] as $keyVal => $value)
                                <option value="{{ $value['id'] }}" {{ isset($session['selectSubject']) && ($session['selectSubject']) == $value['id']? 'selected' : '' }}>{{ $value['name'] }}</option>
                            @endforeach
                        @endif
                    </select>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-5">
        <label class="label-heading">{{ __('teachers.questionLayout.topicAndSubtopic') }}</label>
        <div class="div-select_topic" >
            @php
                $selectedTopic = [];
                $disabled = "disabled";
            @endphp
            <select class="selectOptGroup d-none onchangeValue get_curl_data" data-label="Select Topic" multiple name="select_topic" {{ $disabled }}>
            </select>
        </div>
    </div>
</div>
