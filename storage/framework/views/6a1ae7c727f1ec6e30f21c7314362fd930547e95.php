<div class="accordion" data-type="<?php echo e($questionType); ?>" data-id=<?php echo e($sno); ?>>
    <div class="card" >
        <div class="card-header" data-toggle="collapse" data-target="#collapse<?php echo e($sno); ?>" aria-expanded="true">     
            <span class="title"><span id="sequence"><?php echo e($sno+1); ?></span>. <span class="title-content">Multi select </span></span>
            <span style="float: right"><i class="fa fa-angle-down rotate-icon"></i></span>
        </div>
        <div id="collapse<?php echo e($sno); ?>" class="collapse show" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Question </label>

                            <div class="">

                                <textarea class="form-control" name="passage_question[]" id="passage-question-<?php echo e($sno); ?>" placeholder="Question" rows="2" data-color="cbf9db"></textarea>

                            </div>

                            <div class="question<?php echo e($sno); ?>-error error"></div>

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
                    <div class="row">

                        <div class="col-md-12">

                            <div class="well2">

                            <input tabindex="1" type="checkbox" id="passage-checkbox-mcq1" name="passageanswer1" value="1"/>

                            <label for="passage-checkbox-mcq1">Select correct option 1</label>

                            <div class="form-group">

                                <div class="">

                                    <textarea class="form-control passage_options" placeholder="Option 1" name="passage_option1[]" id="passage-option1-<?php echo e($sno); ?>" data-color="dddddd"></textarea>

                                </div>

                                <div class="passage-option1-error error"></div>

                            </div>

                            </div>

                        </div>

                    </div><!-- Option 1 -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="well2">
                            <input tabindex="1" type="checkbox" id="passage-checkbox-mcq2" name="passageanswer2" value="2"/>
                            <label for="passage-checkbox-mcq2">Select correct option 2</label>
                            <div class="form-group">
                                <div class="">
                                    <textarea class="form-control passage_options" placeholder="Option 2" name="passage_option1[]" id="passage-option2-<?php echo e($sno); ?>" data-color="dddddd"></textarea>
                                </div>
                                <div class="passage-option1-error error"></div>
                            </div>
                            </div>
                        </div>
                    </div><!-- Option 2 -->

                    <div class="row">

                        <div class="col-md-12">

                        <div class="well2">

                            <input tabindex="1" type="checkbox" id="passage-checkbox-mcq3" name="passageanswer3" value="3">

                            <label for="passage-checkbox-mcq3">Select correct option 3</label>

                            <div class="form-group">

                                <div class="">

                                    <textarea class="form-control passage_options" placeholder="Option 3" name="passage_option3[]" id="passage-option3-<?php echo e($sno); ?>" data-color="dddddd"></textarea>

                                </div>

                                <div class="option3-error error"></div>

                            </div>

                            </div>

                        </div>

                    </div><!-- Option 3 -->

                    <div class="row">

                        <div class="col-md-12">

                        <div class="well2">

                            <input tabindex="1" type="checkbox" id="passage-checkbox-mcq4" name="passageanswer4" value="4">

                            <label for="passage-checkbox-mcq4">Select correct option 4</label>

                            <div class="form-group">

                                <div class="">

                                    <textarea class="form-control passage_options" placeholder="Option 4" name="passage_option4[]" id="passage-option4-<?php echo e($sno); ?>" data-color="dddddd"></textarea>

                                </div>

                                <div class="passage-option4-error error"></div>

                            </div>

                            </div>

                        </div>

                    </div><!-- Option 4 -->

                    <div class="putNewCheckboxOption"></div>

                    <!-- Add New Option -->

                    <a href="javascript:void(0)" data-id="<?php echo e($sno); ?>" class="link d-block addNewCheckboxOption">Add more options</a>

                </div>

                <div class="row">

                    <div class="col-md-12">
                        <label for="passage-extended" style="margin-top: 12px">Extended Solution</label>
                        <div class="form-group">
                            <textarea class="form-control" id="passage-extendedsolution-<?php echo e($sno); ?>" name="passage_extend_solution[]" placeholder="Extended Solution" data-color="fff2d9"></textarea>
                        </div>
                        <div class="extended-error error"></div>
                    </div>

                </div><!-- Extended Solution -->
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/forms/questiontypes/multiselect.blade.php ENDPATH**/ ?>