<?php $__env->startSection('title', "Dashboard"); ?>

<?php $__env->startSection('content'); ?>

<div id="page-content-wrapper">

    <div class="page-content">

        <!-- Content Header (Page header) -->



        <!-- page section -->

        <div class="container-fluid">
        <section class="filter">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card z-index-2  ">
                        <div class="card-header">
                            <h2>Add Coupon</h2>
                        </div>
                        <form action="<?php echo e(route('admin.coupon.add')); ?>" id="filter-data" method="post" action="#">
                            <?php echo e(csrf_field()); ?>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6">
                                        <input type="text" placeholder="Coupon Name" name="name"  pattern="[a-zA-z0-9]{4,13}" class="form-control" required value='' />
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <select placeholder="Select Request Range" name="range" class="form-control" required>
                                            <option value="">Select Test Paper Range</option>
                                            <option value="1 to 50 Attempts">1 to 50 Attempts</option>
                                            <option value="51 to 200 Attempts">51 to 200 Attempts</option>
                                            <option value="201 to 500 Attempts">201 to 500 Attempts</option>
                                            <option value="500+">500+</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <input type="number" min="0" max="100" step="0.1" placeholder="Discount Percentage %" name="percentage" class="form-control" required value='' />
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <input type="number" min="0" max="365" step="1" placeholder="Coupon Valid till (in days)" name="validity" class="form-control" required value='' />
                                    </div>
                                    <div class="col-lg-3 col-md-6 mt-2">
                                        <select placeholder="Coupon use type" name="type" class="form-control" required>
                                            <option value="OncePerUser">Once per user</option>
                                            <option value="NTimesTotal">Multiple times</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6 mt-2">
                                        <input type="number" min="1" max="1000000" step="1" placeholder="No. of uses" name="quantity" class="form-control" required value='' />
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <p class="text-danger"><?php echo e(session()->get('message')); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-success">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="table-section">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card z-index-2  ">
                        <div class="card-body">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Creation Date</th>
                                        <th>Coupon Name</th>
                                        <th>Test Paper Range</th>
                                        <th>Discount %age</th>
                                        <th>Assigned to</th>
                                        <th>Coupon type</th>
                                        <th>No. of uses</th>
                                        <th>Expiry date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($couponLists) && !empty($couponLists)): ?>
                                        <?php $__currentLoopData = $couponLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        $type = '';
                                        if($coupon['type'] == 'OncePerUser') {
                                            $type = 'Once per user';
                                        } else if($coupon['type'] == 'NTimesTotal') {
                                            $type = 'Multiple times';
                                        }
                                        ?>
                                            <tr>
                                                <td><span style="display:none;"><?php echo e(strtotime($coupon['creadtedDate'])); ?></span><?php echo e(date('d-m-Y h:i:s A', strtotime($coupon['creadtedDate']))); ?></td>
                                                <td><?php echo e($coupon['couponCode']); ?></td>
                                                <td><?php echo e($coupon['minAttempts']); ?> - <?php echo e($coupon['maxAttempts']); ?></td>
                                                <td><?php echo e($coupon['discountPercentage']); ?></td>
                                                <td><?php echo e($coupon['couponUserEmailId']); ?></td>
                                                <td><?php echo e($type); ?></td>
                                                <td><?php echo e($coupon['quantityAvailable']); ?></td>
                                                <td><?php echo e(date('d-m-Y h:i:s A', strtotime($coupon['expiryDate']))); ?></td>
                                                <td><?php echo e($coupon['status']); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan='6'>No Coupon Available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Creation Date</th>
                                        <th>Coupon Name</th>
                                        <th>Test Paper Range</th>
                                        <th>Discount %age</th>
                                        <th>Assigned to</th>
                                        <th>Coupon type</th>
                                        <th>No. of uses</th>
                                        <th>Expiry date</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        </div>

        <!-- ./cotainer -->

    </div>

    <!-- ./page-content -->

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('onPageJs'); ?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script>
    $(function() {
            
        
        $('#example').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom: 'Blfrtip',
            buttons: [
                'csv', 'excel'
            ]
        });
    });
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/coupon/index.blade.php ENDPATH**/ ?>