<?php if(!empty($question)): ?>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
                    <h2><?php echo e(__('admin.review')); ?></h2>
                </div>
                <div class="col-md-3 mt-2">
                    <h5><strong><?php echo e(__('admin.leftToReview')); ?> - <?php echo e(isset($questionCount) ? $questionCount : 0); ?>  </strong></h5>
                </div>
                <div class="col-md-6 text-right">
                    <input type="hidden" name="" id="statusUrl" value="<?php echo e(route('review.change.question.status')); ?>">
                    <a href="<?php echo e(route('admin.edit.form')); ?>" class="btn btn-sm btn-outline-info mr-2" data-questionId="<?php echo e(isset($question['id']) ? $question['id'] : ''); ?>"><?php echo e(__('admin.editBtnLabel')); ?></a>
                    <button class="btn btn-danger btn-sm rejectBtn mr-2" data-statusId="J63opGxW"> <?php echo e(__('admin.rejectBtnLabel')); ?></button>
                    <button class="btn btn-warning btn-sm holdBtn mr-2" data-statusId="c0p7s80s"> <?php echo e(__('admin.holdBtnLabel')); ?></button>
                    <?php if(!in_array('Review Screen(status except approved)' , $roleAllowed) ): ?>
                        <button class="btn btn-success btn-sm approveBtn" data-statusId="QbgeuNsb"><?php echo e(__('admin.approveBtnLabel')); ?></button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="card-content">
            <?php if(!empty($question)): ?>
                <input type="hidden" value="<?php echo e($question['id']); ?>" name="questionId">
                <input type="hidden" value="<?php echo e(getAdminUserId()); ?>" name="reviewerId">
                <?php
                    $hideSolutionSection = false;
                    $view = strtolower(str_replace(' ', '-', $questionTypeName));
                    if (strpos($view, 'unseen-passage') !== false) {
                        $view = 'unseen-passage';
                        $hideSolutionSection=true;
                    } else if (strpos($view, 'multi-select') !== false) {
                        $view = 'multiple-select';
                    }
                ?>
                <?php echo $__env->make('admin.review.question-type-question-answers.'.$view, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <br>
            <div class="row ">
                <div class="col-md-12 text-right">
                    <?php if($questionNumber > 1): ?>
                        <button class="btn btn-outline-info mr-2 prev-btn"><?php echo e(__('admin.previous')); ?></button>
                    <?php endif; ?>
                    <?php if( isset($questionCount) && $questionCount != $questionNumber): ?>
                        <button class="btn btn-success btn-sm next-btn"><?php echo e(__('admin.next')); ?></button>
                    <?php endif; ?>
                </div>
            </div>
            <br>
            <div class="clearfix"></div>
            <?php if(!empty($question) && !$hideSolutionSection): ?>
                <hr>
                <div class="select_area mt-3">
                        <?php echo $__env->make('admin.review.question-type-solutions.'.$view, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p><strong><?php echo e(__('admin.hintLabel')); ?>:</strong></p>
                                    <p><?php echo $question['answerBlock']['hint']; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p><strong><?php echo e(__('admin.extendedSolnLabel')); ?>:</strong></p>
                                    <p><?php echo $question['answerBlock']['extendedSolution']; ?></p>
                                </div>
                            </div>
                        </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="card-footer">
            <a href="<?php echo e(route('review.filter')); ?>" class="btn btn-success btn-sm"><?php echo e(__('admin.backbtnLabel')); ?></a>
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2><?php echo e(__('admin.review')); ?></h2>
                </div>
                <div class="card-body text-danger">
                    <?php echo e(__('admin.noQuestionErrorText')); ?>

                </div>
                <div class="card-footer text-right">
                    <a href="<?php echo e(route('review.filter')); ?>" class="btn btn-success btn-sm"><?php echo e(__('admin.backbtnLabel')); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/review/ajax/question.blade.php ENDPATH**/ ?>