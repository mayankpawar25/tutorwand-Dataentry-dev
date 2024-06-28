<div class="select_area">
    <ul class="question-list">
        <li>Q <?php echo e($questionNumber); ?>.</li>
        <li> <?php echo html_entity_decode($question['questionText']); ?> </li>
    </ul>
    <div class="option-list">
        <?php if(!empty($question['answerBlock']['options'])): ?>
            <?php $alphabet = 0; ?>
            <?php $__currentLoopData = $question['answerBlock']['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $alphabet++; ?>
                <div class="row">
                    <div class="form-group d-inline-flex">
                        <p class="pr-p">Answer <?php echo e($alphabet); ?>)</p>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/review/question-type-question-answers/fill-in-the-blank.blade.php ENDPATH**/ ?>