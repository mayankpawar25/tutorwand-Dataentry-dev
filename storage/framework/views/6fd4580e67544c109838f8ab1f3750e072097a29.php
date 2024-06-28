<div class="row">

    <div class="col-md-12">

        <div class="form-group">

            <p><strong>Solution</strong></p>

            <?php echo $question['answerBlock']['answer']; ?>

            <br/>
            <?php if(isset($question['answerBlock']['additionalAnswers']) && count($question['answerBlock']['additionalAnswers'])): ?>
                <?php $__currentLoopData = $question['answerBlock']['additionalAnswers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $additionalAnswers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p><strong>Solution Variations <?php echo e($k + 1); ?></strong></p>
                    <?php echo $additionalAnswers; ?>

                    <br/>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

    </div>

</div><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/review/question-type-solutions/short-question-with-multiple-correct-answers.blade.php ENDPATH**/ ?>