<div class="accordion" data-type="{{$questionType}}" data-id={{$sno}}>
    <div class="card" >
        <div class="card-header" data-toggle="collapse" data-target="#collapse{{$sno}}" aria-expanded="true">     
            <span class="title"><span id="sequence">{{$sno+1}}</span>. <span class="title-content">Multi choice </span></span>
            <span style="float: right"><i class="fa fa-angle-down rotate-icon"></i></span>
        </div>
        <div id="collapse{{$sno}}" class="collapse show" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Question </label>
                            <div class="">
                                <textarea class="form-control" name="passage_question[]" id="passage-question-{{$sno}}" placeholder="Question" rows="2" data-color="cbf9db">{{isset($questionText) ? $questionText : ''}}</textarea>
                            </div>
                            <div class="question{{$sno}}-error error"></div>
                        </div>
                    </div>
                </div><!-- Question 1 -->
                <hr class="mb-3 mt-3">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div>
                            <a href="javascript:void(0)" class="d-block mb-2 paste_me_in_passage">Click to paste</a>
                        </div>
                    </div>
                </div><!-- Smart Paste Option -->

                <div class="existing-option">
                    @php
                        if(isset($answerBlock['options']) && count($answerBlock['options'])) {
                            foreach($answerBlock['options'] as $index => $option) {
                    @endphp
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="well2">
                                            <input tabindex="1" type="radio" id="passage-radio-mcq{{$index+1}}-{{$sno}}" name="passage-radio-mcq-{{$sno}}" {{$option["isCorrect"] ? "checked" : ""}}>
                                            <label for="passage-radio-mcq{{$index+1}}-{{$sno}}">Select correct option {{$index+1}}</label>
                                            @if($index > 3)
                                            <a class="removePassageOption float-right" data-rowid="passage-option{{$index+1}}-{{$sno}}">
                                                    <i class="material-icons text-danger">delete</i>
                                            </a>
                                            @endif
                                            <div class="form-group">
                                                <div class="">
                                                    <textarea class="form-control passage_options" placeholder="Option {{$index+1}}" name="passage_option1[]" id="passage-option{{$index+1}}-{{$sno}}" data-color="dddddd">{{$option["optionText"]}}</textarea>
                                                </div>
                                                <div class="passage-option{{$index+1}}-error error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- Dynamic Option -->
                    @php
                            }   
                    @endphp
                            <input type="hidden" name="questionid" id="questionid-{{$sno}}" value="{{$id}}"/>
                            <input type="hidden" name="parentquestionid" id="parent-questionid-{{$sno}}" value="{{$parentQuestionId}}"/>
                    @php 
                        } else {
                    @endphp
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well2">
                            <input tabindex="1" type="radio" id="passage-radio-mcq1-{{$sno}}" name="passage-radio-mcq-{{$sno}}">
                            <label for="passage-radio-mcq1-{{$sno}}">Select correct option 1</label>
                            <div class="form-group">
                                <div class="">
                                    <textarea class="form-control passage_options" placeholder="Option 1" name="passage_option1[]" id="passage-option1-{{$sno}}" data-color="dddddd"></textarea>
                                </div>
                                <div class="passage-option1-error error"></div>
                            </div>
                            </div>
                        </div>
                    </div><!-- Option 1 -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well2">
                                <input tabindex="1" type="radio" id="passage-radio-mcq2-{{$sno}}" name="passage-radio-mcq-{{$sno}}">
                                <label for="passage-radio-mcq2-{{$sno}}">Select correct option 2</label>
                                <div class="form-group">
                                    <div class="">
                                        <textarea class="form-control passage_options" placeholder="Option 2" name="passage_option2[]" id="passage-option2-{{$sno}}" data-color="dddddd"></textarea>
                                    </div>
                                    <div class="passage-option1-error error"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Option 2 -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well2">
                                <input tabindex="1" type="radio" id="passage-radio-mcq3-{{$sno}}" name="passage-radio-mcq-{{$sno}}">
                                <label for="passage-radio-mcq3-{{$sno}}">Select correct option 3</label>
                                <div class="form-group">
                                    <div class="">
                                        <textarea class="form-control passage_options" placeholder="Option 3" name="passage_option3[]" id="passage-option3-{{$sno}}" data-color="dddddd"></textarea>
                                    </div>
                                    <div class="option3-error error"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Option 3 -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="well2">
                                <input tabindex="1" type="radio" id="passage-radio-mcq4-{{$sno}}" name="passage-radio-mcq-{{$sno}}">
                                <label for="passage-radio-mcq4-{{$sno}}">Select correct option 4</label>
                                <div class="form-group">
                                    <div class="">
                                        <textarea class="form-control passage_options" placeholder="Option 4" name="passage_option4[]" id="passage-option4-{{$sno}}" data-color="dddddd"></textarea>
                                    </div>
                                    <div class="passage-option4-error error"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Option 4 -->
                    @php
                        }
                    @endphp

                    <div class="putNewOption"></div>

                    <!-- Add New Option -->

                    <a href="javascript:void(0)" data-id="{{$sno}}" class="link d-block addNewPassageOption">Add more options</a>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="passage-extended" style="margin-top: 12px">Extended Solution</label>
                        <div class="form-group">
                            <textarea class="form-control" id="passage-extendedsolution-{{$sno}}" name="passage_extend_solution[]" placeholder="Extended Solution" data-color="fff2d9">{{isset($answerBlock['extendedSolution']) && !empty($answerBlock['extendedSolution']) ? $answerBlock['extendedSolution'] : ''}}</textarea>
                        </div>
                        <div class="extended-error error"></div>
                    </div>
                </div><!-- Extended Solution -->
                @if(isset($answerBlock['options']) && count($answerBlock['options']))
                    <div class="question-passage-preview-{{$sno}}"></div>
                    <div class="question-preview-{{$sno}} row"></div>
                    <div class="question-option-preview-{{$sno}}"></div>
                @endif
            </div>
        </div>
    </div>
</div>
