<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <p><strong>Solution: </strong></p>
            <?php if(!empty($question['answerBlock']['options'])): ?>
                <?php $alphabet = 0; ?>
                <?php $__currentLoopData = $question['answerBlock']['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($option['isCorrect'] == true): ?>
                        <p><?php echo html_entity_decode($option['optionText']); ?></p>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
 </div><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/review/question-type-solutions/multiple-select.blade.php ENDPATH**/ ?>