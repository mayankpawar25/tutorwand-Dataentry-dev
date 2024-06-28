

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
                            <h2>Filter</h2>
                        </div>
                        <form action="<?php echo e(route('admin.planrequest')); ?>" id="filter-data" method="post" action="#">
                            <?php echo e(csrf_field()); ?>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" placeholder="Select Date Range" name="datetimesrange" class="form-control" requried value=<?php echo e($datetimesrange != '' ? $datetimesrange : ''); ?> />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-success">Search</button>
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
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email ID</th>
                                        <th>Contact No.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($users) && !empty($users)): ?>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><span style="display:none;"><?php echo e(strtotime($user->created_at)); ?></span><?php echo e(date('d-m-Y h:i:s A', strtotime($user->created_at))); ?></td>
                                                <td><?php echo e($user->name); ?></td>
                                                <td><?php echo e($user->email); ?></td>
                                                <td><?php echo e($user->phone); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan='4'>No User Available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email ID</th>
                                        <th>Contact No.</th>
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
            $('input[name="datetimesrange"]').daterangepicker({
                timePicker: true,
                startDate: $('input[name="datetimesrange"]').val() == '/' ? moment().startOf('hour').subtract(24, 'hour') : "<?php echo e($startDate); ?>",
                endDate: $('input[name="datetimesrange"]').val() == '/' ? moment().startOf('hour') : "<?php echo e($endDate); ?>",
                locale: {
                    format: 'DD-MM-Y hh:mm A'
                }
            });
        
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


<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/planrequest/index.blade.php ENDPATH**/ ?>