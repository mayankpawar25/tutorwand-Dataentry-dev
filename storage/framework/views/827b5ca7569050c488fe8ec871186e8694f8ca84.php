<?php if(!empty($question)): ?>
    <div class="card">
        <div class="card-header">Update Filters</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="IMAGE_UPLOAD_URL" id="IMAGE_UPLOAD_URL" value="<?php echo e(route('upload.ckeditor')); ?>">
                    <input type="hidden" name="URL_UPLOAD_URL" id="URL_UPLOAD_URL" value="<?php echo e(route('upload.url.ckeditor')); ?>">
                    <input type="hidden" name="selectFilterUrl" value="<?php echo e(route('get.live.data')); ?>" id="selectFilterUrl">
                    <input type="hidden" name="s_questionTypeId" value="<?php echo e(isset($s_questionTypeId) ? $s_questionTypeId : ''); ?>" id="s_questionTypeId">
                    <input type="hidden" name="userName" value="<?php echo e(isset($username) ? $username : config('constants.ownerId')); ?>" id="userName">
                    <input type="hidden" name="questionId" value="<?php echo e(isset($s_questionId) ? $s_questionId : ''); ?>" id="s_questionId">
                    <input type="hidden" name="submitUrl" value="<?php echo e(route('update.form.data')); ?>" id="submitUrl">
                    <input type="hidden" name="redirectUrl" value="<?php echo e(route('review.question.new')); ?>" id="redirectUrl">
                    <textarea style="display: none" name="question_response"><?php echo e(json_encode($question)); ?></textarea>
                    <div class="form-group d-none">
                        <select class="form-control onChangeSelect boards" name="boards" data-type="grades" data-selecttype="boardId">
                            <option value="">Select board</option>
                            <?php $__currentLoopData = $boards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($board['boardId']); ?>" <?php echo e(isset($s_board) && $s_board == $board['boardId'] ? 'selected' : ''); ?>><?php echo e($board['boardName']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 d-none">
                    <div class="form-group">
                        <select class="form-control onChangeSelect grades" name="grades" data-type="subjects" data-selecttype="gradeId">
                            <option value="">Select grade</option>
                            <?php if(isset($grades) && isset($s_grade)): ?>
                                <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($grade['id']); ?>" <?php echo e(isset($s_grade) && $s_grade == $grade['id'] ? "selected" : ""); ?>><?php echo e($grade['name']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>


                <div class="col-md-12 d-none">


                    <div class="form-group">


                        <select class="form-control onChangeSelect subjects" name="subjects" data-type="topics" data-selecttype="subjectId">


                            <option value="">Select subject</option>


                            <?php if(isset($subjects) && isset($s_subject)): ?>


                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                    <option value="<?php echo e($subject['id']); ?>" <?php echo e(isset($s_subject) && $subject['id'] == $s_subject ? "selected" : ""); ?>><?php echo e($subject['name']); ?></option>


                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            <?php endif; ?>


                        </select>


                    </div>


                </div>


            </div>


            <div class="row">


                <div class="col-md-12">


                    <div class="form-group">


                        <select class="form-control onChangeSelect topics" name="topics" data-type="subtopics" data-selecttype="topicId">


                        <option value="">Select topic</option>


                        <?php if(isset($topics)  && isset($s_topic)): ?>


                            <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                <option value="<?php echo e($topic['id']); ?>" <?php echo e(isset($s_topic) && $topic['id'] == $s_topic ? "selected" : ""); ?>><?php echo e($topic['name']); ?></option>


                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <?php endif; ?>


                    </select>


                    </div>


                </div>


                <div class="col-md-12">


                    <div class="form-group">


                        <select class="form-control subtopics" name="subtopics">


                        <option value="">Select subtopic</option>


                        <?php if(isset($subtopics)): ?>


                            <?php $__currentLoopData = $subtopics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtopic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                <option value="<?php echo e($subtopic['id']); ?>" <?php echo e(isset($s_subtopic) && $subtopic['id'] == $s_subtopic ? "selected" : ""); ?>><?php echo e($subtopic['name']); ?></option>


                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <?php endif; ?>


                    </select>


                    </div>


                </div>





                <div class="col-md-12">


                    <div class="form-group">


                        <select class="form-control difficulty_level" name="difficulty_level">


                            <option value="">Select difficulty level</option>


                            <?php $__currentLoopData = $questionDifficulties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                <option value="<?php echo e($diff['value']); ?>" <?php echo e((isset($s_difficultyLevel) && $s_difficultyLevel == $diff['value']) ? "selected" : ""); ?>>Difficulty level - <?php echo e($diff['value']); ?></option>


                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </select>


                    </div>


                </div>


                <div class="col-md-12  d-none">


                    <div class="form-group">


                        <input type="text" class="form-control source" name="source" placeholder="Source" value="<?php echo e(isset($s_source) ? $s_source : ''); ?>">


                    </div>


                </div>


                    


                <div class="col-md-12 d-none">


                    <div class="form-group">


                        <select class="form-control question_type" name="question_type">


                            <?php $__currentLoopData = $questionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                <option value="<?php echo e(str_replace(' ', '-', strtolower($value['questionTypeName']))); ?>" data-id="<?php echo e($value['questionTypeId']); ?>" <?php echo e(isset($s_questionTypeId) && ($value['questionTypeId'] == $s_questionTypeId) ? "selected" : ""); ?>><?php echo e($value['questionTypeName']); ?></option>


                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </select>





                        <input type="text" name="year" class="form-control" placeholder="Appeared in Previous Year Exams:" value="<?php echo e(isset($s_askedYear) ? implode(',', $s_askedYear) : ''); ?>">





                        <textarea class="form-control" placeholder="Question" name="inputQuestion"><?php echo e(isset($s_questionText) ? $s_questionText : ""); ?></textarea>





                        <textarea class="form-control" placeholder="Question" name="inputAnswer"><?php echo e(isset($s_answer) ? $s_answer : ""); ?></textarea>

                        <?php
                            if(isset($s_answer_variations) && str_replace(' ','-', strtolower($s_questionTypeName)) == 'short-question-with-multiple-correct-answers'){
                                foreach($s_answer_variations as $k => $answer_variation){
                        ?>
                                    <input type="text" data-count="<?php echo e($k); ?>" class="form-control mta-variations" name="variation_short_answer[]" placeholder="Solution Variation" id="mta-variation-<?php echo e($k); ?>" value="<?php echo e($answer_variation); ?>"/>
                        <?php
                                }
                            } 
                        ?>

                        <textarea class="form-control" name="extendedsolution"><?php echo e(isset($s_extendedSolution) ? $s_extendedSolution : ""); ?></textarea>


                         


                        <textarea class="form-control" name="hint" placeholder="Hint"><?php echo e(isset($s_hint) ? $s_hint : ""); ?></textarea>





                        <?php if(isset($s_options) && !empty($s_options)): ?>


                            <?php $__currentLoopData = $s_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="well2">
                                        <input tabindex="1" type="radio" id="flat-radio-mcq<?php echo e($i+1); ?>" name="flat-radio-<?php echo e($i); ?>" <?php echo e(($option['isCorrect']) ? "checked" : ""); ?>>
                                        <label for="flat-radio-mcq<?php echo e($i+1); ?>">Select correct option <?php echo e($i+1); ?></label>
                                        <div class="form-group">
                                            <div class="">
                                                <textarea class="form-control mcq_options" placeholder="Option <?php echo e($i+1); ?>" name="option" id="option<?php echo e($i+1); ?>" onpaste="return false"><?php echo e($option['optionText']); ?></textarea>
                                            </div>
                                            <div class="option1-error error"></div>
                                        </div>
                                    </div>
                                </div>


                                </div><!-- Option <?php echo e($i+1); ?> -->


                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <?php endif; ?>





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


                    <h2><?php echo e(__('admin.detailsLabel')); ?></h2>


                </div>


            </div>


            <div class="clearfix"></div>


        </div>


        <div class="card-content">


            <div class="">


                <?php if(!empty($question)): ?>


                    <div class="select_area">


                        <div class="row">


                            <div class="col-md-12">


                                <div class="form-group">


                                    <p><strong><?php echo e(__('admin.questionId')); ?>:</strong> #<?php echo e($question['id']); ?></p>





                                </div>


                            </div>


                        </div>


                        <div class="row">


                            <div class="col-md-12">


                                <div class="form-group">


                                    <p><strong><?php echo e(__('admin.dataEntryPersonLabel')); ?>: </strong> <?php echo e($question['creatorId']); ?></p>





                                </div>


                            </div>


                        </div>


                        <div class="row">


                            <div class="col-md-12">


                                <div class="form-group">


                                    <p><strong><?php echo e(__('admin.dateNTimeLabel')); ?>:</strong> <?php echo e(date('d-m-Y h:i A',  strtotime($question['creationTimeStamp']))); ?></p>





                                </div>


                            </div>


                        </div>


                        <hr>


                        <div class="row">


                            <div class="col-md-12">


                                <div class="form-group">


                                    <p><strong><?php echo e(__('admin.boardLabel')); ?>:</strong> <?php echo e($question['board']['boardName']); ?></p>





                                </div>


                            </div>


                            <div class="col-md-12">


                                <div class="form-group">


                                    <p><strong><?php echo e(__('admin.gradeLabel')); ?>:</strong> <?php echo e($question['grade']['gradeName']); ?></p>





                                </div>


                            </div>


                            <div class="col-md-12">


                                <div class="form-group">


                                    <p><strong><?php echo e(__('admin.subjectLabel')); ?>:</strong> <?php echo e($question['subject']['subjectName']); ?></p>


                                </div>


                            </div>


                            <div class="col-md-12">


                                <div class="form-group">


                                    <p><strong><?php echo e(__('admin.topicLabel')); ?>:</strong></p>


                                    <p><?php echo e($question['topic']['topicName']); ?></p>


                                </div>


                            </div>


                            <div class="col-md-12">


                                <div class="form-group">


                                    <p><strong><?php echo e(__('admin.subTopic')); ?>:</strong></p>


                                    <p><?php echo e(isset($question['subTopic']['subTopicName']) ? $question['subTopic']['subTopicName'] : ""); ?></p>


                                </div>


                            </div>


                        </div>


                        <hr>


                        <div class="row">


                            <div class="col-md-12">


                                <div class="form-group">


                                    <p><strong><?php echo e(__('admin.difficultyLevel')); ?>: <?php echo e($question['difficultyLevel']); ?></strong></p>





                                </div>


                            </div>


                            <div class="col-md-12">


                                <div class="form-group">


                                    <p><strong><?php echo e(__('admin.questionType')); ?>:</strong></p>


                                    <p><?php echo e($questionTypeName); ?></p>


                                </div>


                            </div>


                            <div class="col-md-12">


                                <div class="form-group">


                                    <p><strong><?php echo e(__('admin.appearedPreviousYear')); ?>:</strong></p>


                                    <p><?php echo e((!empty($question['askedYears'])) ? implode(',' , $question['askedYears']) : ""); ?></p>


                                </div>


                            </div>


                            <div class="col-md-12">


                                <div class="form-group">


                                    <p><strong><?php echo e(__('admin.sourceUrl')); ?>:</strong></p>


                                    <p><?php echo e($question['source']); ?></p>


                                </div>


                            </div>


                        </div>


                    </div>


                <?php endif; ?>


            </div>


        </div>


    </div>


<?php endif; ?><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/review/ajax/question-details.blade.php ENDPATH**/ ?>