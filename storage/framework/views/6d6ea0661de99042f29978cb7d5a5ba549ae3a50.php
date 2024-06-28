
<?php $__env->startSection('title', "Dashboard"); ?>
<?php $__env->startSection('content'); ?>
<style>
    body {
        background-color: #fff;
        margin: 0px;
        padding: 0px;
    }
    
    .box12 {
        width: 320px;
        max-width: 100%;
        margin: 2% auto;
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
    }
    
    .w100 {
        width: 100%;
    }
</style>

<div id="page-content-wrapper"> <!-- page-content-wrapper -->
    <div class="page-content"> <!-- page section -->
        <div class="container-fluid">
            <div class="row">
                <!-- ./counter Number -->
                <!-- chart -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box12">
                                        <img src="<?php echo e(asset('assets/images/admin/oops.jpg')); ?>" alt="Not Supported" width="" height="" class="w100">
                                        <h2>Mobile not supported</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/forms/mobileNotSupport.blade.php ENDPATH**/ ?>