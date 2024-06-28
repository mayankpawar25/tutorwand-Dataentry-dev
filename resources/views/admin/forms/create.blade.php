@extends('admin.layout.master')

@section('title', "Dashboard")

@section('content')

<script src="//cdnjs.cloudflare.com/ajax/libs/mathjs/9.3.1/math.js"></script>

<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

<div id="page-content-wrapper"> <!-- page-content-wrapper -->

    <div class="page-content"> <!-- page section -->

        <div class="container-fluid">

            <div class="row">

                <!-- ./counter Number -->

                <!-- chart -->

                <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">

                    <div class="card">

                        <div class="card-header">

                            <div class="row">

                                <div class="col-md-6">

                                    <h2>Question bank Form</h2>

                                </div>

                                <div class="col-md-6 text-right">

                                    <button class="btn btn-success submitButton" data-id="multi-choice-form">

                                        <i class="hvr-buzz-out fa fa-save"></i> {{ __('admin.save') }} 

                                    </button>

                                </div>

                            </div>

                            <div class="clearfix"></div>

                        </div>

                        <div class="card-content">

                            <div id="multi-choice" class="select_area d-none">

                                <form action="" method="post" id="multi-choice-form">

                                    <h3 class="mt-2">Multi choice</h3>

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label>Question </label>

                                                <div class="">

                                                    <textarea class="form-control" name="question1" id="question1" placeholder="Question" rows="2" data-color="cbf9db"></textarea>

                                                </div>

                                                <div class="question1-error error"></div>

                                            </div>

                                        </div>

                                    </div><!-- Question 1 -->

                                    <hr class="mb-3 mt-3">

                                    <div class="row mb-2">

                                        <div class="col-md-12">

                                            <div>

                                                <a href="javascript:void(0)" class="d-block mb-2 paste_me">Click to paste</a>

                                            </div>

                                            <div id="smart-paste" class="collapse">

                                                <textarea type="text" class="form-control" id="smart_paste" placeholder="Paste here all the copy options" onpaste="return true"></textarea>

                                            </div>

                                        </div>

                                    </div><!-- Smart Paste Option -->



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="well2">

                                            <input tabindex="1" type="radio" id="flat-radio-mcq1" name="flat-radio">

                                            <label for="flat-radio-mcq1">Select correct option 1</label>

                                            <div class="form-group">

                                                <div class="">

                                                    <textarea class="form-control mcq_options" placeholder="Option 1" name="option" id="option1" data-color="dddddd"></textarea>

                                                </div>

                                                <div class="option1-error error"></div>

                                            </div>

                                            </div>

                                        </div>

                                    </div><!-- Option 1 -->



                                    <div class="row">

                                        <div class="col-md-12">

                                        <div class="well2">

                                            <input tabindex="1" type="radio" id="flat-radio-mcq2" name="flat-radio">

                                            <label for="flat-radio-mcq2">Select correct option 2</label>

                                            <div class="form-group">

                                                <div class="">

                                                    <textarea class="form-control mcq_options" placeholder="Option 2" name="option" id="option2" data-color="dddddd"></textarea>

                                                </div>

                                                <div class="option2-error error"></div>

                                            </div>

                                            </div>

                                        </div>

                                    </div><!-- Option 2 -->



                                    <div class="row">

                                        <div class="col-md-12">

                                        <div class="well2">

                                            <input tabindex="1" type="radio" id="flat-radio-mcq3" name="flat-radio">

                                            <label for="flat-radio-mcq3">Select correct option 3</label>

                                            <div class="form-group">

                                                <div class="">

                                                    <textarea class="form-control mcq_options" placeholder="Option 3" name="option" id="option3" data-color="dddddd"></textarea>

                                                </div>

                                                <div class="option3-error error"></div>

                                            </div>

                                            </div>

                                        </div>

                                    </div><!-- Option 3 -->



                                    <div class="row">

                                        <div class="col-md-12">

                                        <div class="well2">

                                            <input tabindex="1" type="radio" id="flat-radio-mcq4" name="flat-radio">

                                            <label for="flat-radio-mcq4">Select correct option 4</label>

                                            <div class="form-group">

                                                <div class="">

                                                    <textarea class="form-control mcq_options" placeholder="Option 4" name="option" id="option4" data-color="dddddd"></textarea>

                                                </div>

                                                <div class="option4-error error"></div>

                                            </div>

                                            </div>

                                        </div>

                                    </div><!-- Option 4 -->

                                    

                                    <div class="putNewOption"></div>

                                    <!-- Add New Option -->

                                    <a href="javascript:void(0)" class="link d-block" id="addNewOption">Add more options</a>



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <textarea class="form-control" id="extendedsolution1" name="extend_solution" placeholder="Extended Solution" data-color="fff2d9"></textarea>

                                            </div>

                                        </div>

                                    </div><!-- Extended Solution -->



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <textarea id="hint1" class="form-control" placeholder="Hint" data-color="c9e1ff"></textarea> 

                                            </div>

                                        </div>

                                    </div><!-- Hint solns -->



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group year-tag">

                                                <input type="text" name="year1" class="form-control" placeholder="Appeared in Previous Year Exams:">

                                            </div>

                                        </div>

                                    </div><!-- Appeared in Previous Year Exams -->

                                </form>

                            </div><!-- MCQ Test -->

                            <div id="true-or-false" class="select_area d-none">

                                <form action="" method="post" id="true-or-false-form">

                                    <h2 class="mt-2">True and false</h2>

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <textarea class="form-control" placeholder="Question" id="TrueFalseQue" name="true_false" data-color="cbf9db">{{ isset($s_questionText) ? $s_questionText : '' }}</textarea>

                                            </div>

                                            <div class="TrueFalseQue-error text-danger"></div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-2">

                                            <div class="form-group">

                                                <div class="input-group  mb-3">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text">

                                                            <input tabindex="0" type="radio" id="flat-radio-1" name="flat-radio" class="trueorfalse" value="True">

                                                            <label for="flat-radio-1"></label>

                                                        </span>

                                                    </div>

                                                    <input type="text" class="form-control" value="True" disabled tabindex="1">

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-2">

                                            <div class="form-group">

                                                <div class="input-group">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text">

                                                            <input tabindex="0" type="radio" id="flat-radio-2" name="flat-radio" class="trueorfalse"  value="False">

                                                            <label for="flat-radio-2"></label>

                                                        </span>

                                                    </div>

                                                    <input type="text" class="form-control" value="False" disabled tabindex="1">

                                                </div>

                                            </div>

                                        </div>

                                    </div>



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <textarea class="form-control" id="extendedsolution2" name="extend_solution" placeholder="Extended Solution" data-color="fff2d9"></textarea>

                                            </div>

                                        </div>

                                    </div><!-- Extended Solution -->



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <textarea id="hint2" class="form-control" placeholder="Hint"data-color="c9e1ff"></textarea> 

                                            </div>

                                        </div>

                                    </div><!-- Hint solns -->



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group year-tag">

                                                <input type="text" name="year2" class="form-control" placeholder="Appeared in Previous Year Exams:">

                                            </div>

                                        </div>

                                    </div><!-- Appeared in Previous Year Exams -->



                                </form>

                            </div><!-- True or False -->

                            <div id="fill-in-the-blank" class="select_area d-none">

                                <form action="" method="post" id="fill-in-the-blank-form">

                                    <h2 class="mt-2">Fill in the blanks</h2>

                                    <div class="row">

                                        <div class="col-md-12">

                                            <label><a href="#" id="add-blank">Add blank space</a></label>

                                            <div class="form-group">

                                                <textarea class="form-control" id="fnb-input" placeholder="Question"  data-color="cbf9db">{{ isset($s_questionText) ? $s_questionText : '' }}</textarea>

                                            </div>

                                            <div class="fnb-input-error text-danger"></div>

                                        </div>

                                    </div>

                                    <div class="row add-inputs">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                            </div>

                                        </div>

                                    </div>



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <textarea class="form-control" id="extendedsolution3" name="extend_solution" placeholder="Extended Solution" data-color="fff2d9"></textarea>

                                            </div>

                                        </div>

                                    </div><!-- Extended Solution -->



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <textarea id="hint3" class="form-control" placeholder="Hint" data-color="c9e1ff"></textarea> 

                                            </div>

                                        </div>

                                    </div><!-- Hint solns -->



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group year-tag">

                                                <input type="text" name="year3" class="form-control" placeholder="Appeared in Previous Year Exams:">

                                            </div>

                                        </div>

                                    </div><!-- Appeared in Previous Year Exams -->



                                </form>

                            </div><!-- Fill in the blanks -->

                            <div id="long-question" class="select_area d-none">

                                <form action="" method="post" id="long-question-form">

                                    <h2 class="mt-2">Long answer</h2>

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <textarea class="form-control" placeholder="Question" id="longQuestion" data-color="cbf9db">{{ isset($s_questionText) ? $s_questionText : '' }}</textarea>

                                            </div>

                                            <div class="longQuestion-error text-danger"></div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <textarea class="form-control" name="solution" id="longAnswer" placeholder="Solution" rows="8"></textarea>

                                            </div>

                                            <div class="longAnswer-error text-danger"></div>

                                        </div>

                                    </div>



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <textarea id="hint4" class="form-control" placeholder="Hint" data-color="c9e1ff"></textarea> 

                                            </div>

                                        </div>

                                    </div><!-- Hint solns -->



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group year-tag">

                                                <input type="text" name="year4" class="form-control" placeholder="Appeared in Previous Year Exams:">

                                            </div>

                                        </div>

                                    </div><!-- Appeared in Previous Year Exams -->



                                </form>

                            </div><!-- Long Question -->

                            <div id="short-question" class="select_area d-none">

                                <form action="" method="post" id="short-question-form">

                                    <h2 class="mt-2">Short answer</h2>

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <div class="form-group">

                                                    <textarea class="form-control" name="short_que" placeholder="Question" id="shortQuestions" data-color="cbf9db"></textarea>

                                                </div>

                                                <div class="shortQuestions-error text-danger"></div>

                                            </div>

                                        </div>

                                    </div>



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <div class="form-group">

                                                    <textarea class="form-control" name="short_answer" placeholder="Solution" id="shortAnswer"></textarea>

                                                </div>

                                                <div class="shortAnswer-error text-danger"></div>

                                            </div>

                                        </div>

                                    </div>



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <textarea id="hint5" class="form-control" placeholder="Hint" data-color="c9e1ff"></textarea> 

                                            </div>

                                        </div>

                                    </div><!-- Hint solns -->



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group year-tag">

                                                <input type="text" name="year5" class="form-control" placeholder="Appeared in Previous Year Exams:">

                                            </div>

                                        </div>

                                    </div><!-- Appeared in Previous Year Exams -->



                                </form>

                            </div><!-- Short Question -->

                            <div id="passage" class="select_area d-none">

                                <form action="" method="post" id="multi-choice-form">

                                    <h3 class="mt-2">Unseen Passage</h3>

                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label>Passage </label>

                                                <div class="">

                                                    <textarea class="form-control" name="passage" id="passage1" placeholder="Passage" rows="2" data-color="c9e1ff"></textarea>

                                                </div>

                                                <div class="passage-error error"></div>

                                            </div>

                                        </div>
                                    </div>
                                    <div id="passage-form"></div>
                                </form>
                                
                                <div id="passage-card">
                                    
                                </div>
                                <input type="hidden" name="mcq" id="get-template-url" value="{{ route('questiontype.template') }}" />
                            </div> <!-- Passage Test -->

                            <div id="short-question-with-multiple-correct-answers" class="select_area d-none">

                                <form action="" method="post" id="short-question-with-multiple-correct-answers-form">

                                    <h2 class="mt-2">Student Produced Response</h2>

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <div class="form-group">

                                                    <textarea class="form-control" name="short_que" placeholder="Question*" id="matQuestions" data-color="cbf9db"></textarea>

                                                </div>

                                                <div class="matQuestions-error text-danger"></div>

                                            </div>

                                        </div>

                                    </div>



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group block">

                                                <div class="form-group">
                                                    <label>Answer*</label>
                                                    <input class="form-control mta-variations" type="text" name="short_mca_answer" placeholder="Answer*" id="shortMCAAnswer" />
                                                </div>

                                                <div class="shortAnswer-error text-danger"></div>
                    
                                            </div>

                                        </div>

                                    </div>

                                    <div class="answervariations"></div>
                                    <div class="mb-2">
                                        <a href="javascript:void(0)" id="add-answer-variation">Click to add more solution variations</a>                
                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <textarea class="form-control" id="mat-extendedsolution" name="extend_solution" placeholder="Extended Solution*" data-color="fff2d9"></textarea>

                                            </div>

                                            <div class="extended-solution-error text-danger"></div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <textarea id="hint6" class="form-control" placeholder="Hint" data-color="c9e1ff"></textarea> 

                                            </div>

                                        </div>

                                    </div><!-- Hint solns -->



                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group year-tag">

                                                <input type="text" name="year6" class="form-control" placeholder="Appeared in Previous Year Exams:">

                                            </div>

                                        </div>

                                    </div><!-- Appeared in Previous Year Exams -->



                                </form>

                            </div><!-- SPR -->

                            <div id="other-types" class="select_area">
                            </div> <!-- other Question types -->
                            <hr>

                            <div class="row preview d-none">

                                <div class="col-md-12">

                                    <h3 class="question-list mt-2">Preview</h3>

                                    <div class="row">

                                        <div class="col-sm-1"><label>Q1.</label></div>

                                        <div class="col-sm-11 question_place mb-2"></div>

                                    </div>

                                    <div class="option-list option_place mt-2"></div>
                                    <div class="option-list solution_variation_place mt-2"></div>

                                </div>

                            </div><!-- preview screen -->

                            <div class="row mb-0">

                                <div class="col-md-12 mt-2 text-right">

                                    <button class="btn btn-success submitButton" data-id="multi-choice-form"><i class="hvr-buzz-out fa fa-save"></i> {{ __('admin.save') }}</button>

                                </div>

                            </div><!-- mb- -->

                        </div>

                    </div>

                </div>

                <!-- ./form end -->

                <div class="col-lg-3 col-md-4 col-xs-12">

                    <div class="well">

                        <div class="row">

                            <div class="col-md-12">

                                {{ csrf_field() }}

                                <input type="hidden" name="URL_UPLOAD_URL" id="URL_UPLOAD_URL" value="{{ route('upload.url.ckeditor') }}">

                                <input type="hidden" name="IMAGE_UPLOAD_URL" id="IMAGE_UPLOAD_URL" value="{{ route('upload.ckeditor') }}">

                                <input type="hidden" name="selectFilterUrl" value="{{ route('get.live.data') }}" id="selectFilterUrl">

                                <input type="hidden" name="s_questionTypeId" value="{{ isset($s_questionTypeId) ? $s_questionTypeId : '' }}" id="s_questionTypeId">

                                <input type="hidden" name="userName" value="{{ isset($username) ? $username : config('constants.ownerId') }}" id="userName">

                                <input type="hidden" name="questionId" value="{{ isset($s_questionId) ? $s_questionId : '' }}" id="s_questionId">

                                <input type="hidden" name="submitUrl" value="{{ route('submit.form.data') }}" id="submitUrl">

                                <input type="hidden" name="redirectUrl" value="{{ route('admin.form') }}" id="redirectUrl">

                                <div class="form-group">

                                    <select class="form-control onChangeSelect boards" name="boards" data-type="grades" data-selecttype="boardId">

                                        <option value="">{{ __('admin.select') }} {{ __('admin.board') }}</option>

                                        @foreach($boards as $board)

                                            <option value="{{ $board['boardId'] }}" {{ isset($s_board) && $s_board == $board['boardId'] ? 'selected' : '' }}>{{ $board['boardName'] }}</option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">

                                    <select class="form-control onChangeSelect grades" name="grades" data-type="subjects" data-selecttype="gradeId" {{ isset($s_grade) ? '' : 'disabled' }}>

                                        <option value="">{{ __('admin.select') }} {{ __('admin.grade') }}</option>

                                        @if(isset($grades) && isset($s_grade))

                                            @foreach($grades as $grade)

                                                <option value="{{ $grade['id'] }}" {{ isset($s_grade) && $s_grade == $grade['id'] ? 'selected' : '' }}>{{ $grade['name'] }}</option>

                                            @endforeach

                                        @endif

                                    </select>

                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">

                                    <select class="form-control onChangeSelect subjects" name="subjects" data-type="topics" {{ isset($s_topicTags) ? '' : 'disabled' }} data-selecttype="subjectId">

                                        <option value="">{{ __('admin.select') }} {{ __('admin.subject') }}</option>

                                        @if(isset($subjects) && isset($s_subject))

                                            @foreach($subjects as $subject)

                                                <option value="{{ $subject['id'] }}" {{ isset($s_subject) && $subject['id'] == $s_subject ? 'selected' : '' }}>{{ $subject['name'] }}</option>

                                            @endforeach

                                        @endif

                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-12">

                                <div class="form-group">

                                    <select class="form-control onChangeSelect topics" name="topics" data-type="subtopics" {{ isset($s_topicTags) ? '' : 'disabled' }}  data-selecttype="topicId">

                                    <option value="">{{ __('admin.select') }} {{ __('admin.topic') }}</option>

                                    @if(isset($topics)  && isset($s_topic))

                                        @foreach($topics as $topic)

                                            <option value="{{ $topic['id'] }}" {{ isset($s_topic) && $topic['id'] == $s_topic ? 'selected' : '' }}>{{ $topic['name'] }}</option>

                                        @endforeach

                                    @endif

                                </select>

                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group">

                                    <select class="form-control subtopics" name="subtopics" {{ isset($s_topicTags) ? '' : 'disabled' }}>

                                    <option value="">{{ __('admin.select') }} {{ __('admin.subtopic') }}</option>

                                    @if(isset($subtopics)  && isset($s_subtopic))

                                        @foreach($subtopics as $subtopic)

                                            <option value="{{ $subtopic['id'] }}" {{ isset($s_subtopic) && $subtopic['id'] == $s_subtopic ? 'selected' : '' }}>{{ $subtopic['name'] }}</option>

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

                                            <option value="{{ $diff['value'] }}" {{ ($diff['value'] == 3) ? 'selected' : '' }}>{{ $diff['value'] }}</option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            

                            <div class="col-md-12">

                                <div class="form-group">

                                    <input type="text" class="form-control source" name="source" placeholder="Source" value="{{ isset($s_source) ? $s_source : '' }}">

                                </div>

                            </div>



                            <div class="col-md-12">

                                <div class="form-group">

                                    <select class="form-control question_type" name="question_type">

                                        @foreach($questionTypes as $value)

                                            <option value="{{ str_replace(' ', '-', strtolower($value['questionTypeName'])) }}" data-id="{{ $value['questionTypeId'] }}" {{ isset($s_questionTypeId) && ($value['questionTypeId'] == $s_questionTypeId) ? 'selected' : '' }}>{{ $value['questionTypeName'] }}</option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>



                        </div>

                    </div>

                    <div class="card">

                        <div class="card-header">

                            <div class="row">

                                <div class="col-md-12">

                                    <h2>{{ __('admin.scratchPad') }} <button class="btn btn-outline-secondary clear-btn float-right">{{ __('admin.clear') }}</button></h2>

                                </div>

                            </div>

                            <div class="clearfix"></div>

                        </div>

                        <div class="card-content">

                            <div class="editable" id="clear-data" contentEditable="true"></div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ./row -->

        </div> <!-- ./cotainer -->

    </div> <!-- ./page-content -->

</div>

@endsection

@section('onPageJs')

    <script src="{{ asset('assets/admin/dist/js/common-form.js') }}" ></script>

@endsection