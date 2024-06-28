<?php if(isset($response)): ?>
    <option value=""><?php echo e($label); ?></option>
    <?php $__currentLoopData = $response; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($resp['id']); ?>"><?php echo e($resp['name']); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/selectbox.blade.php ENDPATH**/ ?>