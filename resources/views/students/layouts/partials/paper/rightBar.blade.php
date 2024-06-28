<div class="right-panel-exam">
    <div class="fixed-side-panel-trigger-right"><i class="fa fa-caret-right" aria-hidden="true"></i></div>
    <div class="d-block right-panel-body">
        <div class="mob-panel-header d-block d-lg-none">
            <h4 class="hide-mob">{{ __('students.questionInformation') }}</h4>
        </div>
        <div id="accordion-bar">
            <button class="btn btn-outline-primary  btn-block mb-3" data-toggle="modal" data-target="#tool-modal">{{ __('students.assessmentInstructions') }}</button>
        </div>

        <hr class="hide-mob">
        <h5>{{ __('students.fileUpload') }}</h5>
        <div class="uploaded-file-block">
            <ul class="uploaded-doc" style="display:none;">
            </ul>
            <form id="globalForm" action="#" method="post" enctype="multipart/form-data">
                <input type="file" name="files[]" accept=".doc, .docx, .pdf, .jpeg, .jpg, .xls, .png" class="uploadGlobalFile d-none" multiple>
            </form>
            <button class="btn btn-outline-primary uploadGlobalFileBtn  btn-block mb-3"><i class="fa fa-plus"></i> {{ __('students.addResponse') }}</button>
        </div>
        <!-- legend end -->
        <hr class="mt-2">
        <div class="clearfix"></div>
        <!-- accordion end -->
        <h5>{{ __('students.question') }}</h5>
        <div class="row">
            <div class="col-6 col-sm-6 col-md-6  pr-1">
                <div class="form-group">
                    <select class="form-control select-legend select-attempted-type">
                        <option value="{{ __('students.allQuestion') }}">{{ __('students.allQuestion') }}</option>
                        <option value="{{ __('students.unattempted') }}">{{ __('students.unattempted') }}</option>
                        <option value="{{ __('students.attempted') }}">{{ __('students.attempted') }}</option>
                        <option value="{{ __('students.bookmarked') }}">{{ __('students.bookmarked') }}</option>
                    </select>
                </div>            
            </div>
            <div class="col-6 col-sm-6 col-md-6  pl-1">
                <div class="form-group">
                    <select class="form-control select-question-type">
                        <option value="">{{ __('students.allQuestionTypes') }}</option>
                        @if(isset($questionData['questionFormat']))
                            @php
                                $formatIds = [];
                            @endphp
                            @foreach($questionData['questionFormat'] as $format)
                                @php
                                    $formatIds[] = $format['questionTypeId'];
                                @endphp
                            @endforeach
                            @php
                                $formatIds = array_unique($formatIds);
                            @endphp
                            @foreach($formatIds as $questionTypeId)
                                <option value="{{ $questionTypeId }}">{{ getTemplateName($questionTypeId) }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <!-- select end -->
        <ul class="question-pallet">
             @if(!empty($questionData['questions']))
                @foreach($questionData['questions'] as $key => $question)
                    <li id="{{ $question['questionId'] }}" class="showQuestionArea" data-question="{{ $question['questionTypeId'] }}"><button class="unattempted">{{$key + 1}}</button></li>
                @endforeach
            @endif
        </ul>
        <input type="hidden" name="totalQuestion" id="totalQuestion" value="{{ isset($questionData['questions']) ? count($questionData['questions']) : 0 }}">

        <div class="legend-outer-with-heading">
            <h5 class="mt-2 hide-mob">{{ __('students.legend') }}</h5>
            <div class="legend-outer">
                <div class="legend unattempted ">
                    <span class="unattempted-icon"></span> {{ __('students.unattempted') }}
                </div> 
                <div class="legend attempted ">
                    <span class="attempted-icon"></span> {{ __('students.attempted') }}
                </div> 
                <div class="legend bookmark ">
                    <i class="fa fa-bookmark fill" aria-hidden="true"></i> {{ __('students.bookmarked') }}
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>