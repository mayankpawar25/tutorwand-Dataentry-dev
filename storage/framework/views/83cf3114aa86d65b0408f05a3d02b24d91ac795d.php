<div class="">

    <h5 class="get-filter-data"> </h5>

    <div class="table-responsive ">

        <table width="100%" cellspacing="0" cellpadding="0" class="table table-bordered">
            <tr>
                <th>Topic</th>
                <th>Sub Topic</th>
                <th>MCQ</th>
                <th>Fill in the blanks</th>
                <th>True and False</th>
                <th>Short Answer</th>
                <th>Long Answer</th>
                <th>SPR</th>
                <th>Unseen Passage 3</th>
                <th>Unseen Passage 4</th>
                <th>Unseen Passage 5</th>
                <th>Unseen Passage 7</th>
                <th>Total</th>
            </tr>

            <?php $__currentLoopData = $reviewDashboardModels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reviewDashboard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($reviewDashboard['topic']); ?></td>
                    <td><?php echo e($reviewDashboard['subTopic']); ?></td>
                    <td><?php echo e($reviewDashboard['mcqCount']); ?></td>
                    <td><?php echo e($reviewDashboard['fibCount']); ?></td>
                    <td><?php echo e($reviewDashboard['tnfCount']); ?></td>
                    <td><?php echo e($reviewDashboard['shortAnswerCount']); ?></td>
                    <td><?php echo e($reviewDashboard['longAnswerCount']); ?></td>
                    <td><?php echo e($reviewDashboard['shortQuestionWithMulitpleCorrectAnswerCount']); ?></td>
                    <td><?php echo e($reviewDashboard['unseenPassage_3Count']); ?></td>
                    <td><?php echo e($reviewDashboard['unseenPassage_4Count']); ?></td>
                    <td><?php echo e($reviewDashboard['unseenPassage_5Count']); ?></td>
                    <td><?php echo e($reviewDashboard['unseenPassage_7Count']); ?></td>
                    <th><?php echo e($reviewDashboard['totalCount']); ?></th>
                </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <tr>
                <th colspan="2">Grand Total</th>
                <th><?php echo e($grandTotal['mcqCount']); ?></th>
                <th><?php echo e($grandTotal['fibCount']); ?></th>
                <th><?php echo e($grandTotal['tnfCount']); ?></th>
                <th><?php echo e($grandTotal['shortAnswerCount']); ?></th>
                <th><?php echo e($grandTotal['longAnswerCount']); ?></th>
                <th><?php echo e($grandTotal['shortQuestionWithMulitpleCorrectAnswerCount']); ?></th>
                <th><?php echo e($grandTotal['unseenPassage_3Count']); ?></th>
                <th><?php echo e($grandTotal['unseenPassage_4Count']); ?></th>
                <th><?php echo e($grandTotal['unseenPassage_5Count']); ?></th>
                <th><?php echo e($grandTotal['unseenPassage_7Count']); ?></th>
                <th><?php echo e($grandTotal['totalCount']); ?></th>
            </tr>

        </table>

    </div>

</div><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/dashboard/ajax/searchResult.blade.php ENDPATH**/ ?>