<div class="select_area">
    <ul class="question-list">
        <li><?php echo e($questionNumber); ?>.</li>
        <li> <?php echo html_entity_decode($question['questionText']); ?> </li>
    </ul>
</div>
<?php $__currentLoopData = $question['childrenQuestions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <hr/>
    <?php
        $questionNumber = $index+1;
        if($question['questionTypeId'] === "kc8fmydg") { // Multiple Select
    ?>
            <?php echo $__env->make('admin.review.question-type-question-answers.multiple-select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php
        } else if($question['questionTypeId'] === "529kWMwg"){ // Multiple Choice
    ?>
            <?php echo $__env->make('admin.review.question-type-question-answers.multi-choice', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php
        }
    ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mt-4">
                <p><strong><?php echo e(__('admin.extendedSolnLabel')); ?>:</strong></p>
                <p><?php echo $question['answerBlock']['extendedSolution']; ?></p>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/review/question-type-question-answers/unseen-passage.blade.php ENDPATH**/ ?>