<div class="accordion" data-type="<?php echo e($questionType); ?>" data-id=<?php echo e($sno); ?>>
    <div class="card" >
        <div class="card-header" data-toggle="collapse" data-target="#collapse<?php echo e($sno); ?>" aria-expanded="true">     
            <span class="title"><span id="sequence"><?php echo e($sno+1); ?></span>. <span class="title-content">Fill in the blanks </span></span>
            <span style="float: right"><i class="fa fa-angle-down rotate-icon"></i></span>
        </div>
        <div id="collapse<?php echo e($sno); ?>" class="collapse show" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="post" id="passage-fill-in-the-blank-form-<?php echo e($sno); ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <label><a href="javascript:void(0)" id="passage-add-blank" data-id="<?php echo e($sno); ?>">Add blank space</a></label>
                                    <div class="form-group">
                                        <textarea class="form-control" id="passage-fnb-input-<?php echo e($sno); ?>" placeholder="Question"  data-color="cbf9db"><?php echo e(isset($s_questionText) ? $s_questionText : ''); ?></textarea>
                                    </div>
                                    <div class="passage-fnb-input-error text-danger"></div>
                                </div>
                            </div>
                            <div class="row add-inputs">
                                <div class="col-md-12">
                                    <div class="form-group">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="extendedsolution-<?php echo e($sno); ?>" name="extend_solution" placeholder="Extended Solution" data-color="fff2d9"></textarea>
                                    </div>
                                    <div class="extended-error error"></div>
                                </div>
                            </div><!-- Extended Solution -->
                            <input type="hidden" name="numberofanswers" class="counts-of-answers" value="0"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/forms/questiontypes/fillintheblanks.blade.php ENDPATH**/ ?>