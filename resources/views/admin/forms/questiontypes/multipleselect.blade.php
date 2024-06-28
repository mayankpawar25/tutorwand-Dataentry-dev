    <form action="" method="post" id="multi-select-form" data-type="{{$questionType}}" class="accordion">
        <h3>Multiple select</h3>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Question </label>
                        <div class="">
                            <textarea class="form-control" name="passage_question[]" id="multiple-select-question" placeholder="Question" rows="2" data-color="cbf9db">{{isset($questionText) ? $questionText : ''}}</textarea>
                        </div>
                        <div class="question-error error"></div>
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
                                        <input tabindex="1" type="checkbox" id="passage-checkbox-mcs{{$index+1}}" name="passage-checkbox-mcs" {{$option["isCorrect"] ? "checked" : ""}}>
                                        <label for="passage-checkbox-mcs{{$index+1}}">Select correct option {{$index+1}}</label>
                                        @if($index > 2)
                                        <a class="removePassageCheckboxOption float-right" data-rowid="passage-option{{$index+1}}">
                                            <i class="material-icons text-danger">delete</i>
                                        </a>
                                        @endif
                                        <div class="form-group">
                                            <div class="">
                                                <textarea class="form-control passage_options" placeholder="Option {{$index+1}}" name="passage_option1[]" id="passage-option{{$index+1}}" data-color="dddddd">{{$option["optionText"]}}</textarea>
                                            </div>
                                            <div class="passage-option{{$index+1}}-error error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- Dynamic Option -->
                @php
                        }   
                @endphp
                        <input type="hidden" name="questionid" id="questionid" value="{{$id}}"/>
                        <input type="hidden" name="parentquestionid" id="parent-questionid" value="{{$parentQuestionId}}"/>
                @php 
                    } else {
                @endphp
                    <div class="row">

                        <div class="col-md-12">

                            <div class="well2">

                            <input tabindex="1" type="checkbox" id="passage-checkbox-mcs1" name="passageanswer1" value="1"/>

                            <label for="passage-checkbox-mcs1">Select correct option 1</label>

                            <div class="form-group">

                                <div class="">

                                    <textarea class="form-control passage_options" placeholder="Option 1" name="passage_option1[]" id="passage-option1" data-color="dddddd"></textarea>

                                </div>

                                <div class="passage-option1-error error"></div>

                            </div>

                            </div>

                        </div>

                    </div><!-- Option 1 -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well2">
                            <input tabindex="1" type="checkbox" id="passage-checkbox-mcs2" name="passageanswer2" value="2"/>
                            <label for="passage-checkbox-mcs2">Select correct option 2</label>
                            <div class="form-group">
                                <div class="">
                                    <textarea class="form-control passage_options" placeholder="Option 2" name="passage_option1[]" id="passage-option2" data-color="dddddd"></textarea>
                                </div>
                                <div class="passage-option1-error error"></div>
                            </div>
                            </div>
                        </div>
                    </div><!-- Option 2 -->

                    <div class="row">

                        <div class="col-md-12">

                        <div class="well2">

                            <input tabindex="1" type="checkbox" id="passage-checkbox-mcs3" name="passageanswer3" value="3">

                            <label for="passage-checkbox-mcs3">Select correct option 3</label>

                            <div class="form-group">

                                <div class="">

                                    <textarea class="form-control passage_options" placeholder="Option 3" name="passage_option3[]" id="passage-option3" data-color="dddddd"></textarea>

                                </div>

                                <div class="option3-error error"></div>

                            </div>

                            </div>

                        </div>

                    </div><!-- Option 3 -->
                @php
                    }
                @endphp
                

                <div class="putNewCheckboxOption"></div>

                <!-- Add New Option -->

                <a href="javascript:void(0)" data-id="{{$sno}}" class="link addNewCheckboxOption">Add more options</a>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <label for="passage-extended" style="margin-top: 12px">Extended Solution</label>
                    <div class="form-group">
                        <textarea class="form-control" id="passage-extendedsolution" name="passage_extend_solution[]" placeholder="Extended Solution" data-color="fff2d9">{{isset($answerBlock['extendedSolution']) && !empty($answerBlock['extendedSolution']) ? $answerBlock['extendedSolution'] : ''}}</textarea>
                    </div>
                    <div class="extended-error error"></div>
                </div>
            </div><!-- Extended Solution -->

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <textarea id="msq-hint" class="form-control" placeholder="Hint" data-color="c9e1ff">{{isset($answerBlock['hint']) && !empty($answerBlock['hint']) ? $answerBlock['hint'] : ''}}</textarea> 
                    </div>
                </div>
            </div><!-- Hint solns -->

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group year-tag">
                    <input type="text" name="msq_year" class="form-control" placeholder="Appeared in Previous Year Exams:" value="{{ isset($askedYears) ? implode(',', $askedYears) : '' }}">
                    </div>
                </div>
            </div><!-- Appeared in Previous Year Exams -->

            @if(isset($answerBlock['options']) && count($answerBlock['options']))
                <div class="question-passage-preview"></div>
                <div class="question-preview row"></div>
                <div class="question-option-preview-0"></div>
            @endif    
        </div>     
</form>