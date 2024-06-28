<div class="select_area">
    <ul class="question-list">
        <li>Q <?php echo e($questionNumber); ?>.</li>
        <li> <?php echo html_entity_decode($question['questionText']); ?> </li>
    </ul>
    <div class="option-list que-mp d-none">
        <p>Answer</p>
        <?php echo html_entity_decode($question['answerBlock']['answer']); ?>
    </div>
</div><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/review/question-type-question-answers/long-question.blade.php ENDPATH**/ ?>