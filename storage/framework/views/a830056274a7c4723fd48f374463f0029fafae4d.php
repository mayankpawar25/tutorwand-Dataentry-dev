<div class="select_area">
    <ul class="question-list">
        <li>Q <?php echo e($questionNumber); ?>.</li>
        <li> <?php echo html_entity_decode($question['questionText']); ?> </li>
    </ul>
    <div class="option-list">
        <?php if(!empty($question['answerBlock']['options'])): ?>
            <?php $alphabet = "a"; ?>
            <?php $__currentLoopData = $question['answerBlock']['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="custom-control custom-radio">
                    <?php $resp = ''; ?>
                    <?php if($option['isCorrect']): ?>
                        <?php $resp = 'checked'; ?>
                    <?php endif; ?>
                    <input type="radio" id="customRadio1-<?php echo e($questionNumber); ?>-<?php echo e($index); ?>" name="customRadio<?php echo e($questionNumber); ?>" class="custom-control-input" <?php echo e($resp); ?> disabled/>
                    <label class="custom-control-label" for="customRadio1-<?php echo e($questionNumber); ?>-<?php echo e($index); ?>">
                        <ul class="answer-list">
                            <li><?php echo e($alphabet); ?>)&nbsp;</li>
                            <li> <?php echo html_entity_decode($option['optionText']); ?></li>
                        </ul>
                    </label>
                </div>
                <?php $alphabet++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/review/question-type-question-answers/multi-choice.blade.php ENDPATH**/ ?>