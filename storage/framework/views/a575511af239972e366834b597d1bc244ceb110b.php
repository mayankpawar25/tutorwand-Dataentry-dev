<?php $__env->startSection('title', "Dashboard"); ?>


<?php $__env->startSection('content'); ?>


<div id="page-content-wrapper">


    <div class="page-content">


        <!-- Content Header (Page header) -->





        <!-- page section -->


        <div class="container-fluid">


            <div class="row">


                <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">


                    <div class="card">


                        <div class="card-header">


                            <div class="row">


                                <div class="col-md-6">


                                    <h2>Question Count filter</h2>


                                </div>





                            </div>


                            <div class="clearfix"></div>


                        </div>


                        <div class="card-content">


                            <form method="post" id="dashboard-filter-form">


                                <?php echo e(csrf_field()); ?>



                                <div class="row">


                                    <div class="col-md-3">


                                        <div class="form-group">


                                            <input type="hidden" name="urlChange" id="urlChange" value="<?php echo e(route('review.filter.on.change')); ?>">


                                            <input type="hidden" name="postURL" id="postURL" value="<?php echo e(route('dashboard.filter.search.result')); ?>">


                                            <select class="form-control filterChange boards" data-selected="boards" data-reflecton="grades" name="boardId" id="boardId" required>


                                                <option value="">Select board</option>


                                                <?php $__currentLoopData = $boards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                    <option value="<?php echo e($board['boardId']); ?>" <?php echo e(isset($selected['boardId']) && $selected['boardId'] == $board['boardId'] ? 'selected' : ($key == 0 ? 'selected' : '')); ?>><?php echo e($board['boardName']); ?></option>


                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                            </select>


                                        </div>


                                    </div>


                                    <div class="col-md-3">


                                        <div class="form-group">


                                            <select class="form-control grades filterChange" data-selected="grades" data-reflecton="subjects" name="gradeId" id="gradeId" <?php echo e(isset($selected['gradeId']) ? '' : 'disabled'); ?> required>


                                                <option value=""> Select grade</option>


                                                <?php if(isset($grades)): ?>


                                                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                        <option value="<?php echo e($grade['id']); ?>" <?php echo e(isset($selected['gradeId']) && $selected['gradeId'] == $grade['id'] ? 'selected' : ''); ?>><?php echo e($grade['name']); ?></option>


                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                <?php endif; ?>


                                            </select>


                                        </div>


                                    </div>


                                    <div class="col-md-3">


                                        <div class="form-group">


                                            <select class="form-control subjects filterChange" data-selected="subjects" data-reflecton="topics" name="subjectId" id="subjectId" <?php echo e(isset($selected['subjectId']) ? '' : 'disabled'); ?> required>


                                                <option value="" selected>Select subject</option>


                                                <?php if(isset($subjects)): ?>


                                                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                        <option value="<?php echo e($subject['id']); ?>" <?php echo e(isset($selected['subjectId']) && $selected['subjectId'] == $subject['id'] ? 'selected' : ''); ?>><?php echo e($subject['name']); ?></option>


                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                <?php endif; ?>


                                            </select>


                                        </div>


                                    </div>


                                    <div class="col-md-3">


                                        <div class="form-group">


                                            <select class="form-control" name="statusId" id="statusId" required>


                                                <option value="">Status</option>


                                                <?php $__currentLoopData = $questionStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                    <option value="<?php echo e($status['statusId']); ?>" ><?php echo e($status['statusName']); ?></option>


                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                            </select>


                                        </div>


                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" name="difficultyLevel" id="difficultyLevel">
                                                <option value="0">Difficulty Level</option>
                                                <?php if(isset($questionDifficulties)): ?>
                                                    <?php $__currentLoopData = $questionDifficulties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $questionDifficulty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($questionDifficulty['value']); ?>" <?php echo e(isset($selected['difficultyLevel']) && in_array($questionDifficulty['value'], $selected['questionDifficulties']) ? 'selected' : ''); ?>><?php echo e($questionDifficulty['value']); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Source" id="source" name="source">
                                        </div>
                                    </div>

                                </div>


                                <hr>


                                <div class="row mb-0">


                                    <div class="col-md-12 mt-2 text-right">


                                        <button type="submit" class="btn btn-success get-report" role="button">Submit</button>


                                    </div>


                                </div>


                            </form>


                        </div>


                    </div>


                </div>


                <div class="col-lg-12 col-md-6 col-sm-12


                        col-xs-12">


                    <div class="card">


                        <div class="card-header">


                            <div class="row">


                                <div class="col-md-6">


                                    <h2>Search Result</h2>


                                </div>





                            </div>


                            <div class="clearfix"></div>


                        </div>


                        <div class="card-content search-dashboard">


                            <div class="">


                                <h5>Please select filter to see result </h5>


                            </div>


                        </div>


                    </div>


                </div>


                <!-- ./form end -->


            </div>


            <!-- ./row -->


        </div>


        <!-- ./cotainer -->


    </div>


    <!-- ./page-content -->


</div>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('onPageJs'); ?>


<script type="text/javascript" src="<?php echo e(asset('assets/admin/dist/js/review-dashboard.js')); ?>"></script>


<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/dashboard/indexAdmin.blade.php ENDPATH**/ ?>