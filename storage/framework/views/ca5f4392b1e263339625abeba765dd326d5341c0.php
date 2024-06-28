<?php $__env->startSection('title', "Dashboard"); ?>


<?php $__env->startSection('content'); ?>


<div id="page-content-wrapper">


    <div class="page-content">


        <!-- Content Header (Page header) -->





        <!-- page section -->





        <div class="container-fluid">


            <div class="row">


                <!-- ./counter Number -->


                <!-- chart -->


                <div class="col-lg-12">


                    <div class="row">


                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4 d-none">


                            <div class="panel cardbox bg-white bg-success2">


                                <div class="panel-body card-item panel-refresh">


                                    <span class="refresh">


                                        <span class="fa fa-refresh" aria-hidden="true"></span>


                                    </span>


                                    <a class="" href="form.html">





                                        <div class="refresh-container"><i class="refresh-spinner fa fa-spinner fa-spin fa-5x"></i></div>


                                        <div class="timer" data-to="0" data-speed="1500">0</div>


                                        <div class="cardbox-icon">


                                            <i class="material-icons">assignment_turned_in</i>


                                        </div>


                                        <div class="card-details">


                                            <h4>Count of approved questions </h4>





                                        </div>


                                    </a>


                                </div>


                            </div>


                        </div>


                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-4 d-none">


                            <div class="panel cardbox bg-white bg-danger">


                                <div class="panel-body card-item panel-refresh">


                                    <span class="refresh">


                                        <span class="fa fa-refresh" aria-hidden="true"></span>


                                    </span>


                                    <a class="" href="form.html">








                                        <div class="refresh-container"><i class="refresh-spinner fa fa-spinner fa-spin fa-5x"></i></div>


                                        <div class="timer" data-to="0" data-speed="1500">0</div>


                                        <div class="cardbox-icon">


                                            <i class="material-icons">assignment_turned_in</i>


                                        </div>


                                        <div class="card-details">


                                            <h4>Count of unapproved questions</h4>





                                        </div>


                                    </a>


                                </div>


                            </div>


                        </div>


                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 mb-4 d-none">


                            <div class="panel cardbox bg-white bg-blue">


                                <div class="panel-body card-item panel-refresh">


                                    <span class="refresh">


                                        <span class="fa fa-refresh" aria-hidden="true"></span>


                                    </span>


                                    <a class="" href="form.html">








                                        <div class="refresh-container"><i class="refresh-spinner fa fa-spinner fa-spin fa-5x"></i></div>


                                        <div class="timer" data-to="0" data-speed="1500">0</div>


                                        <div class="cardbox-icon">


                                            <i class="material-icons">assignment_turned_in</i>


                                        </div>


                                        <div class="card-details">


                                            <h4>......</h4>





                                        </div>


                                    </a>


                                </div>


                            </div>


                        </div>


                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 mb-4 d-none">


                            <div class="panel cardbox bg-white bg-yellow">


                                <div class="panel-body card-item panel-refresh">


                                    <span class="refresh">


                                        <span class="fa fa-refresh" aria-hidden="true"></span>


                                    </span>


                                    <a class="" href="form.html">








                                        <div class="refresh-container"><i class="refresh-spinner fa fa-spinner fa-spin fa-5x"></i></div>


                                        <div class="timer" data-to="0" data-speed="1500">0</div>


                                        <div class="cardbox-icon">


                                            <i class="material-icons">assignment_turned_in</i>


                                        </div>


                                        <div class="card-details">


                                            <h4>.....</h4>





                                        </div>


                                    </a>


                                </div>


                            </div>


                        </div>


                    </div>


                </div>


                <!-- ./counter Number -->


                <!-- chart -->


                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                    <div class="card">


                        <div class="card-header">


                            <div class="row">


                                <div class="col-md-6">


                                    <h2>Question review filter</h2>


                                </div>





                            </div>


                            <div class="clearfix"></div>


                        </div>


                        <div class="card-content">


                            <input type="hidden" name="urlChange" id="urlChange" value="<?php echo e(route('review.filter.on.change')); ?>">


                            <form action="<?php echo e(route('review.question')); ?>" id="filter-data" method="post" action="#">


                                <?php echo e(csrf_field()); ?>



                                <div class="well">


                                    <div class="row">


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <input type="text" class="form-control" placeholder="Question Id:" name="questionId">


                                            </div>


                                        </div>


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control" name="creatorId">


                                                    <option value="">Data-entry user</option>


                                                    <?php $__currentLoopData = $dataEntryUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                        <option value="<?php echo e($user['userId']); ?>"><?php echo e($user['userName']); ?> </option>


                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                </select>


                                            </div>


                                        </div>


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control" name="statusId" required>


                                                    <option value="">Status</option>


                                                    <?php $__currentLoopData = $questionStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                        <option value="<?php echo e($status['statusId']); ?>" <?php echo e(isset($selected['statusId']) && $selected['statusId'] == $status['statusId'] ? 'selected' : ($key == 0 ? 'selected' : '')); ?>><?php echo e($status['statusName']); ?></option>


                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                </select>


                                            </div>


                                        </div>


                                    </div>


                                    <div class="row">


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control" name="questionTypeId">


                                                    <option value="">Question type </option>


                                                    <?php $__currentLoopData = $questionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $questionType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                        <option value="<?php echo e($questionType['questionTypeId']); ?>" <?php echo e(isset($selected['typeId']) && $selected['typeId'] == $questionType['questionTypeId'] ? 'selected' : ''); ?>><?php echo e($questionType['questionTypeName']); ?></option>


                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                </select>


                                            </div>


                                        </div>


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control filterChange boards" data-selected="boards" data-reflecton="grades" name="boardId">


                                                    <option value="">Select board</option>


                                                    <?php $__currentLoopData = $boards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                        <option value="<?php echo e($board['boardId']); ?>" <?php echo e(isset($selected['boardId']) && $selected['boardId'] == $board['boardId'] ? 'selected' : ''); ?>><?php echo e($board['boardName']); ?></option>


                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                </select>


                                            </div>


                                        </div>


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control grades filterChange" data-selected="grades" data-reflecton="subjects" name="gradeId" <?php echo e(isset($selected['gradeId']) ? '' : 'disabled'); ?>>


                                                    <option value=""> Select grade</option>


                                                    <?php if(isset($grades)): ?>


                                                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                            <option value="<?php echo e($grade['id']); ?>" <?php echo e(isset($selected['gradeId']) && $selected['gradeId'] == $grade['id'] ? 'selected' : ''); ?>><?php echo e($grade['name']); ?></option>


                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                    <?php endif; ?>


                                                </select>


                                            </div>


                                        </div>


                                    </div>


                                    <div class="row">


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control subjects filterChange" data-selected="subjects" data-reflecton="topics" name="subjectId" <?php echo e(isset($selected['subjectId']) ? '' : 'disabled'); ?>>


                                                    <option value="" selected>Select subject</option>


                                                    <?php if(isset($subjects)): ?>


                                                        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                            <option value="<?php echo e($subject['id']); ?>" <?php echo e(isset($selected['subjectId']) && $selected['subjectId'] == $subject['id'] ? 'selected' : ''); ?>><?php echo e($subject['name']); ?></option>


                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                    <?php endif; ?>


                                                </select>


                                            </div>


                                        </div>


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control topics filterChange" data-selected="topics" data-reflecton="subtopics" name="topicId" <?php echo e(isset($selected['topicIds']) ? '' : 'disabled'); ?>>


                                                    <option value="" selected>Select topic</option>


                                                    <?php if(isset($topics)): ?>


                                                        <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                            <option value="<?php echo e($topic['id']); ?>" <?php echo e(isset($selected['topicIds'])  && in_array($topic['id'], $selected['topicIds']) ? 'selected' : ''); ?>><?php echo e($topic['name']); ?></option>


                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                    <?php endif; ?>


                                                </select>


                                            </div>


                                        </div>


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control subtopics" name="subTopicId" <?php echo e(isset($selected['subTopicIds']) ? '' : 'disabled'); ?>>


                                                    <option value="" selected>Select subtopic</option>


                                                    <?php if(isset($subtopics)): ?>


                                                        <?php $__currentLoopData = $subtopics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtopic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                            <option value="<?php echo e($subtopic['id']); ?>" <?php echo e(isset($selected['subTopicIds']) && in_array($subtopic['id'], $selected['subTopicIds']) ? 'selected' : ''); ?>><?php echo e($subtopic['name']); ?></option>


                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                    <?php endif; ?>


                                                </select>


                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control difficultyLevel" name="difficultyLevel" >
                                                    <option value="" selected>Select difficulty level</option>
                                                    <?php if(isset($questionDifficulties)): ?>
                                                        <?php $__currentLoopData = $questionDifficulties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $questionDifficulty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($questionDifficulty['value']); ?>" <?php echo e(isset($selected['difficultyLevel']) && in_array($questionDifficulty['value'], $selected['questionDifficulties']) ? 'selected' : ''); ?>><?php echo e($questionDifficulty['value']); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Source Url:" name="sourceUrl">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">


                                        <div class="col-md-6">


                                            <div class="form-group">


                                                <input type="text" class="form-control fromDate datepicker" width="276" placeholder="From Date" name="fromDate">


                                            </div>


                                        </div>


                                        <div class="col-md-6">


                                            <div class="form-group">


                                                <input type="text" class="form-control toDate datepicker" width="276" placeholder="To Date" name="toDate">


                                            </div>


                                        </div>


                                    </div>


                                </div>


                                <hr>


                                <div class="row mb-0">


                                    <div class="col-md-12 mt-2 text-right">


                                        <button type="submit" class="btn btn-success">Submit</button>


                                    </div>


                                </div>


                            </form>


                        </div>


                    </div>


                </div>


                <!-- ./form end -->


            </div>


        </div>


    </div>


</div>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('onPageJs'); ?>


    <script type="text/javascript" src="<?php echo e(asset('assets/admin/dist/js/review-form.js')); ?>"></script>


    <script type="text/javascript">


        $(document).on("change" , ".fromDate, .toDate", function(){


            let fromDate = $(".fromDate").val();


            let toDate = $(".toDate").val();


            if(toDate != "" && fromDate != ""){


                $(".fromDate").attr({'required': true});


                $(".toDate").attr({'required': true});


                if(!(new Date(fromDate) <= new Date(toDate))) {


                    toastr["error"](`To Date must be greater than From Date`);


                    $(".toDate").val("");


                }


            } else if(toDate != "" || fromDate != ""){


                $(".fromDate").attr({'required': true});


                $(".toDate").attr({'required': true});


            } else {


                $(".fromDate").attr({'required': false});


                $(".toDate").attr({'required': false});


            }


        });


    </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/review/filter.blade.php ENDPATH**/ ?>