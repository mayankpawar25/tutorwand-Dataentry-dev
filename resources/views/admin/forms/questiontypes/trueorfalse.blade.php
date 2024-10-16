<div class="accordion" data-type="{{$questionType}}" data-id={{$sno}}>
    <div class="card" >
        <div class="card-header" data-toggle="collapse" data-target="#collapse{{$sno}}" aria-expanded="true">     
            <span class="title"><span id="sequence">{{$sno+1}}</span>. <span class="title-content">True or false </span></span>
            <span style="float: right"><i class="fa fa-angle-down rotate-icon"></i></span>
        </div>
        <div id="collapse{{$sno}}" class="collapse show" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="post" id="passage-true-or-false-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Question" id="passage-true-or-false-question-{{$sno}}" name="true_false" data-color="cbf9db"></textarea>
                                    </div>
                                    <div class="TrueFalseQue-error text-danger"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group  mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <input tabindex="0" type="radio" id="passage-flat-radio-{{$sno}}-1" name="tof-radio" class="trueorfalse" value="True">
                                                    <label for="passage-flat-radio-{{$sno}}-1"></label>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" value="True" disabled tabindex="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <input tabindex="0" type="radio" id="passage-flat-radio-{{$sno}}-2" name="tof-radio" class="trueorfalse" value="False">
                                                    <label for="passage-flat-radio-{{$sno}}-2"></label>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" value="False" disabled tabindex="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="passage-extendedsolution-{{$sno}}" name="extend_solution" placeholder="Extended Solution" data-color="fff2d9"></textarea>
                                    </div>
                                    <div class="extended-error error"></div>
                                </div>
                            </div><!-- Extended Solution -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
