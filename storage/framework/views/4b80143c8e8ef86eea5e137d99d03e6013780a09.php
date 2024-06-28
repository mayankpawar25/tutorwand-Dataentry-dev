<head>
    <?php $__env->startSection('title', __('Page not found')); ?>
    <?php echo $__env->make('../teachers.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body>
    <div class="d-table w-100 vh-100" >
        <div class="d-table-cell align-middle text-center">
            <a href="<?php echo e(url('/')); ?>">
                <img src="<?php echo e(asset('assets/images/errors/404.jpg')); ?>" alt="" class="img-fluid">
            </a>
        </div>
    </div>
</body><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/errors/404.blade.php ENDPATH**/ ?>