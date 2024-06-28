@extends('admin.layout.master')


@section('title', "Dashboard")


@section('content')


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">


    <div id="page-content-wrapper">


        <div class="page-content">


            <!-- Content Header (Page header) -->
            <!-- page section -->


            <div class="container-fluid">


                @if(empty($question))


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


                @else


                    <input type="hidden" class="questionNumber" value="{{ $questionNumber }}">


                    <input type="hidden" class="creatorId" id="creatorId" value="{{ $question['creatorId'] }}">


                    <div class="row">


                        <!-- ./counter Number -->


                        <!-- chart -->


                        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12" id="ajaxQuestions">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h2>{{ __('admin.review') }}</h2>
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            <h5><strong>{{ __('admin.leftToReview') }} - {{ isset($questionCount) ? $questionCount : 0 }}  </strong></h5>
                                        </div>
                                        <div class="col-md-7 text-right flex-space-between">
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
                        </div>
                        <!-- ./form end -->
                        {{-- Filter Details --}}
                        <div class="col-lg-3 col-md-4 col-xs-12" id="ajaxDetails">
                            <div class="card">
                                <div class="card-header">Update Filters</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="IMAGE_UPLOAD_URL" id="IMAGE_UPLOAD_URL" value="{{ route('upload.ckeditor') }}">
                                            <input type="hidden" name="URL_UPLOAD_URL" id="URL_UPLOAD_URL" value="{{ route('upload.url.ckeditor') }}">
                                            <input type="hidden" name="selectFilterUrl" value="{{ route('get.live.data') }}" id="selectFilterUrl">
                                            <input type="hidden" name="s_questionTypeId" value="{{ isset($s_questionTypeId) ? $s_questionTypeId : '' }}" id="s_questionTypeId">
                                            <input type="hidden" name="userName" value="{{ isset($username) ? $username : config('constants.ownerId') }}" id="userName">
                                            <input type="hidden" name="questionId" value="{{ isset($s_questionId) ? $s_questionId : '' }}" id="s_questionId">
                                            <input type="hidden" name="submitUrl" value="{{ route('update.form.data') }}" id="submitUrl">
                                            <input type="hidden" name="redirectUrl" value="{{ route('review.question.new') }}" id="redirectUrl">
                                            <textarea style="display:none" name="question_response">{{json_encode($question)}}</textarea>
                                            <div class="form-group d-none">
                                                <select class="form-control onChangeSelect boards" name="boards" data-type="grades" data-selecttype="boardId">
                                                    <option value="">Select board</option>
                                                    @foreach($boards as $board)
                                                        <option value="{{ $board['boardId'] }}" {{ isset($s_board) && $s_board == $board['boardId'] ? 'selected' : '' }}>{{ $board['boardName'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 d-none">
                                            <div class="form-group">
                                                <select class="form-control onChangeSelect grades" name="grades" data-type="subjects" data-selecttype="gradeId">
                                                    <option value="">Select grade</option>
                                                    @if(isset($grades) && isset($s_grade))
                                                        @foreach($grades as $grade)
                                                            <option value="{{ $grade['id'] }}" {{ isset($s_grade) && $s_grade == $grade['id'] ? "selected" : "" }}>{{ $grade['name'] }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 d-none">
                                            <div class="form-group">
                                                <select class="form-control onChangeSelect subjects" name="subjects" data-type="topics" data-selecttype="subjectId">
                                                    <option value="">Select subject</option>
                                                    @if(isset($subjects) && isset($s_subject))
                                                        @foreach($subjects as $subject)
                                                            <option value="{{ $subject['id'] }}" {{ isset($s_subject) && $subject['id'] == $s_subject ? "selected" : "" }}>{{ $subject['name'] }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control onChangeSelect topics" name="topics" data-type="subtopics" data-selecttype="topicId">
                                                <option value="">{{ __('admin.select') }} {{ __('admin.topic') }}</option>
                                                @if(isset($topics)  && isset($s_topic))
                                                    @foreach($topics as $topic)
                                                        <option value="{{ $topic['id'] }}" {{ isset($s_topic) && $topic['id'] == $s_topic ? "selected" : "" }}>{{ $topic['name'] }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control subtopics" name="subtopics">
                                                <option value="">{{ __('admin.select') }} {{ __('admin.subtopic') }}</option>
                                                @if(isset($subtopics))
                                                    @foreach($subtopics as $subtopic)
                                                        <option value="{{ $subtopic['id'] }}" {{ isset($s_subtopic) && $subtopic['id'] == $s_subtopic ? "selected" : "" }}>{{ $subtopic['name'] }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control difficulty_level" name="difficulty_level">
                                                    <option value="">{{ __('admin.select') }} {{ __('admin.difficultyLevel') }}</option>
                                                    @foreach($questionDifficulties as $diff)
                                                        <option value="{{ $diff['value'] }}" {{ (isset($s_difficultyLevel) && $s_difficultyLevel == $diff['value']) ? "selected" : "" }}>Difficulty level - {{ $diff['value'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12  d-none">
                                            <div class="form-group">
                                                <input type="text" class="form-control source" name="source" placeholder="Source" value="{{ isset($s_source) ? $s_source : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 d-none">
                                            <div class="form-group">
                                                <select class="form-control question_type" name="question_type">
                                                    @foreach($questionTypes as $value)
                                                        <option value="{{ str_replace(' ', '-', strtolower($value['questionTypeName'])) }}" data-id="{{ $value['questionTypeId'] }}" {{ isset($s_questionTypeId) && ($value['questionTypeId'] == $s_questionTypeId) ? "selected" : "" }}>{{ $value['questionTypeName'] }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="text" name="year" class="form-control" placeholder="Appeared in Previous Year Exams:" value="{{ isset($s_askedYear) ? implode(',', $s_askedYear) : '' }}">
                                                <textarea class="form-control" placeholder="Question" name="inputQuestion">{{ isset($s_questionText) ? $s_questionText : "" }}</textarea>
                                                <textarea class="form-control" placeholder="Question" name="inputAnswer">{{ isset($s_answer) ? $s_answer : "" }}</textarea>
                                                @php
                                                    if(isset($s_answer_variations) && str_replace(' ','-', strtolower($s_questionTypeName)) == 'short-question-with-multiple-correct-answers'){
                                                        foreach($s_answer_variations as $k => $answer_variation){
                                                @endphp
                                                            <input type="text" data-count="{{$k}}" class="form-control mta-variations" name="variation_short_answer[]" placeholder="Solution Variation" id="mta-variation-{{$k}}" value="{{$answer_variation}}"/>
                                                @php
                                                        }
                                                    } 
                                                @endphp
                                                <textarea class="form-control" name="extendedsolution">{{ isset($s_extendedSolution) ? $s_extendedSolution : "" }}</textarea>
                                                <textarea class="form-control" name="hint" placeholder="Hint">{{ isset($s_hint) ? $s_hint : "" }}</textarea>
                                                @if(isset($s_options) && !empty($s_options))
                                                    @foreach($s_options as $i => $option)
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="well2">
                                                                <input tabindex="1" type="radio" id="flat-radio-mcq{{ $i+1 }}" name="flat-radio{{$i + 1}}" {{ ($option['isCorrect']) ? "checked" : "" }}>
                                                                <label for="flat-radio-mcq{{ $i+1 }}">Select correct option {{ $i+1 }}</label>
                                                                <div class="form-group">
                                                                    <div class="">
                                                                        <textarea class="form-control mcq_options" placeholder="Option {{ $i+1 }}" name="option" id="option{{ $i+1 }}" onpaste="return false">{{ $option['optionText'] }}</textarea>
                                                                    </div>
                                                                    <div class="option1-error error"></div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- Option {{ $i+1 }} -->
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-none">
                                    <button type="button" class="btn btn-success updateFilters">Update</button>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2>{{ __('admin.detailsLabel') }}</h2>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="card-content">
                                    <div class="">
                                        @if(!empty($question))
                                            <div class="select_area">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <p><strong>{{ __('admin.questionId') }}:</strong> #{{ $question['id'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <p><strong>{{ __('admin.dataEntryPersonLabel') }}: </strong> {{ $question['creatorId'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <p><strong>{{ __('admin.dateNTimeLabel') }}:</strong> {{ localTimeZone($question['creationTimeStamp']) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <p><strong>{{ __('admin.boardLabel') }}:</strong> {{ $question['board']['boardName'] }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <p><strong>{{ __('admin.gradeLabel') }}:</strong> {{ $question['grade']['gradeName'] }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <p><strong>{{ __('admin.subjectLabel') }}:</strong> {{ $question['subject']['subjectName'] }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">


                                                        <div class="form-group">


                                                            <p><strong>{{ __('admin.topicLabel') }}:</strong></p>


                                                            <p>{{ $question['topic']['topicName'] }}</p>


                                                        </div>


                                                    </div>


                                                    <div class="col-md-12">


                                                        <div class="form-group">


                                                            <p><strong>{{ __('admin.subTopic') }}:</strong></p>


                                                            <p>{{ isset($question['subTopic']['subTopicName']) ? $question['subTopic']['subTopicName'] : ""  }}</p>


                                                        </div>


                                                    </div>


                                                </div>


                                                <hr>


                                                <div class="row">


                                                    <div class="col-md-12">


                                                        <div class="form-group">


                                                            <p><strong>{{ __('admin.difficultyLevel') }}: {{ $question['difficultyLevel'] }}</strong></p>





                                                        </div>


                                                    </div>


                                                    <div class="col-md-12">


                                                        <div class="form-group">


                                                            <p><strong>{{ __('admin.questionType') }}:</strong></p>


                                                            <p>{{ $questionTypeName }}</p>


                                                        </div>


                                                    </div>


                                                    <div class="col-md-12">


                                                        <div class="form-group">


                                                            <p><strong>{{ __('admin.appearedPreviousYear') }}:</strong></p>


                                                            <p>{{ (!empty($question['askedYears'])) ? implode(',' , $question['askedYears']) : "" }}</p>


                                                        </div>


                                                    </div>


                                                    <div class="col-md-12">


                                                        <div class="form-group">


                                                            <p><strong>{{ __('admin.sourceUrl') }}:</strong></p>


                                                            <p>{{ $question['source'] }}</p>


                                                        </div>


                                                    </div>


                                                </div>


                                            </div>


                                        @endif


                                    </div>


                                </div>


                            </div>


                        </div>


                        {{-- Filter Details --}}





                    </div>


                    <!-- ./row -->


                @endif


            </div>


            <!-- ./cotainer -->


        </div>


        <!-- ./page-content -->


    </div>


@endsection


@section('onPageJs')


    @include('admin.layout.partials.reviewScript')


    <script type="text/javascript" src="{{ asset('assets/admin/dist/js/review-form.js') }}"></script>


    <script type="text/javascript" src="{{ asset('assets/plugins/mathjax/tex-mml-chtml.js') }}"></script>


@endsection