<div class="accordion" data-type="{{$questionType}}" data-id={{$sno}}>
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#collapse{{$sno}}" aria-expanded="true">
            <span class="title"><span id="sequence">{{$sno+1}}</span>. <span class="title-content">Mulitple blanks </span></span>
            <span style="float: right"><i class="fa fa-angle-down rotate-icon"></i></span>
        </div>
        <div id="collapse{{$sno}}" class="collapse show" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="post" id="multiple-blanks-form-{{$sno}}">
                            <div class="row">
                                <div class="col-md-12">
                                    <label><a href="javascript:void(0)" id="add-multiple-blank" data-id="{{$sno}}">Add blank space</a></label>
                                    <div class="form-group">
                                        <textarea class="form-control" id="multiple-blanks-input-{{$sno}}" placeholder="Question" data-color="cbf9db">{{ isset($questionText) ? $questionText : '' }}</textarea>
                                    </div>
                                    <div class="multiple-blanks-input-error text-danger error"></div>
                                </div>
                            </div>
                            <div class="row add-inputs">
                            @php
                                if(isset($answerBlock['options']) && count($answerBlock['options'])) {
                                    $alpha = 'A';
                                    $group = 0;
                                    foreach($answerBlock['options'] as $index => $option) {
                                        $roman = ($index == 0 ? 'i' : ($index == 1 ? 'ii' : ($index == 2 ? 'iii' : 'iii')));
                                        $group = (($index < 3) ? 0 : (($index < 6) ? 1 : (($index < 9) ? 2 : 3)));
                            @endphp
                            @php
                                    if($index % 3 === 0) {
                            @endphp
                                        <div class="col-md-12">
                                            <div class="form-group option-group">
                                                <p>Blank Option ({{$roman}})</p>
                            @php
                                    }
                            @endphp
                                                <div class="well pb-3" id="optionFibId-{{$sno}}-{{$index}}">
                                                    <input tabindex="1" type="radio" id="passage-radio-mb{{$sno}}-{{$index}}" name="passage-radio-mcq-{{$sno}}-{{$group}}"  {{$option["isCorrect"] ? "checked" : ""}}/>
                                                    <label for="passage-radio-mb{{$sno}}-{{$index}}">{{$alpha}}</label>
                                                    <textarea class="fillups form-control mb-8 multiple-blanks-option-{{$sno}}-{{$index}}" id="multiple-blanks-option-{{$sno}}-{{$index}}" data-id="{{$index}}" placeholder="Answer {{$alpha}}" data-color="dddddd">{{$option["optionText"]}}</textarea>
                                                    <span class="input-error{{$index}} error"></span>
                                                </div>
                            @php
                                if($index % 3 === 2) {
                            @endphp
                                            </div>
                                        </div>
                            @php
                                }
                                        ++$alpha;
                                    }   
                            @endphp
                                    <input type="hidden" name="questionid" id="questionid" value="{{$id}}"/>
                                    <input type="hidden" name="parentquestionid" id="parent-questionid" value="{{$parentQuestionId}}"/>
                            @php 
                                }
                            @endphp
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="extendedsolution-{{$sno}}" name="extend_solution" placeholder="Extended Solution" data-color="fff2d9">{{(isset($answerBlock['extendedSolution']) && !empty($answerBlock['extendedSolution'])) ? $answerBlock['extendedSolution'] : ''}}</textarea>
                                    </div>
                                    <div class="extended-error error"></div>
                                </div>
                            </div><!-- Extended Solution -->
                            <input type="hidden" name="numberofanswers" class="counts-of-answers" value="0" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>