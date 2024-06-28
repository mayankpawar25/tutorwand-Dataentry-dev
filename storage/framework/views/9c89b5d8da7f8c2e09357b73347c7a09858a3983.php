<div class="accordion" data-type="<?php echo e($questionType); ?>" data-id=<?php echo e($sno); ?>>
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#collapse<?php echo e($sno); ?>" aria-expanded="true">
            <span class="title"><span id="sequence"><?php echo e($sno+1); ?></span>. <span class="title-content">Mulitple blanks </span></span>
            <span style="float: right"><i class="fa fa-angle-down rotate-icon"></i></span>
        </div>
        <div id="collapse<?php echo e($sno); ?>" class="collapse show" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="post" id="multiple-blanks-form-<?php echo e($sno); ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <label><a href="javascript:void(0)" id="add-multiple-blank" data-id="<?php echo e($sno); ?>">Add blank space</a></label>
                                    <div class="form-group">
                                        <textarea class="form-control" id="multiple-blanks-input-<?php echo e($sno); ?>" placeholder="Question" data-color="cbf9db"><?php echo e(isset($questionText) ? $questionText : ''); ?></textarea>
                                    </div>
                                    <div class="multiple-blanks-input-error text-danger error"></div>
                                </div>
                            </div>
                            <div class="row add-inputs">
                            <?php
                                if(isset($answerBlock['options']) && count($answerBlock['options'])) {
                                    $alpha = 'A';
                                    $group = 0;
                                    foreach($answerBlock['options'] as $index => $option) {
                                        $roman = ($index == 0 ? 'i' : ($index == 1 ? 'ii' : ($index == 2 ? 'iii' : 'iii')));
                                        $group = (($index < 3) ? 0 : (($index < 6) ? 1 : (($index < 9) ? 2 : 3)));
                            ?>
                            <?php
                                    if($index % 3 === 0) {
                            ?>
                                        <div class="col-md-12">
                                            <div class="form-group option-group">
                                                <p>Blank Option (<?php echo e($roman); ?>)</p>
                            <?php
                                    }
                            ?>
                                                <div class="well pb-3" id="optionFibId-<?php echo e($sno); ?>-<?php echo e($index); ?>">
                                                    <input tabindex="1" type="radio" id="passage-radio-mb<?php echo e($sno); ?>-<?php echo e($index); ?>" name="passage-radio-mcq-<?php echo e($sno); ?>-<?php echo e($group); ?>"  <?php echo e($option["isCorrect"] ? "checked" : ""); ?>/>
                                                    <label for="passage-radio-mb<?php echo e($sno); ?>-<?php echo e($index); ?>"><?php echo e($alpha); ?></label>
                                                    <textarea class="fillups form-control mb-8 multiple-blanks-option-<?php echo e($sno); ?>-<?php echo e($index); ?>" id="multiple-blanks-option-<?php echo e($sno); ?>-<?php echo e($index); ?>" data-id="<?php echo e($index); ?>" placeholder="Answer <?php echo e($alpha); ?>" data-color="dddddd"><?php echo e($option["optionText"]); ?></textarea>
                                                    <span class="input-error<?php echo e($index); ?> error"></span>
                                                </div>
                            <?php
                                if($index % 3 === 2) {
                            ?>
                                            </div>
                                        </div>
                            <?php
                                }
                                        ++$alpha;
                                    }   
                            ?>
                                    <input type="hidden" name="questionid" id="questionid" value="<?php echo e($id); ?>"/>
                                    <input type="hidden" name="parentquestionid" id="parent-questionid" value="<?php echo e($parentQuestionId); ?>"/>
                            <?php 
                                }
                            ?>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="extendedsolution-<?php echo e($sno); ?>" name="extend_solution" placeholder="Extended Solution" data-color="fff2d9"><?php echo e((isset($answerBlock['extendedSolution']) && !empty($answerBlock['extendedSolution'])) ? $answerBlock['extendedSolution'] : ''); ?></textarea>
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
</div><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/forms/questiontypes/multipleblanks.blade.php ENDPATH**/ ?>