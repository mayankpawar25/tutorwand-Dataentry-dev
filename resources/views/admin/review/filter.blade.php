@extends('admin.layout.master')


@section('title', "Dashboard")


@section('content')


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


                            <input type="hidden" name="urlChange" id="urlChange" value="{{ route('review.filter.on.change') }}">


                            <form action="{{ route('review.question') }}" id="filter-data" method="post" action="#">


                                {{ csrf_field() }}


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


                                                    @foreach($dataEntryUsers as $user)


                                                        <option value="{{ $user['userId'] }}">{{ $user['userName'] }} {{-- $user['email'] --}}</option>


                                                    @endforeach


                                                </select>


                                            </div>


                                        </div>


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control" name="statusId" required>


                                                    <option value="">Status</option>


                                                    @foreach($questionStatus as $key => $status)


                                                        <option value="{{ $status['statusId'] }}" {{ isset($selected['statusId']) && $selected['statusId'] == $status['statusId'] ? 'selected' : ($key == 0 ? 'selected' : '') }}>{{ $status['statusName'] }}</option>


                                                    @endforeach


                                                </select>


                                            </div>


                                        </div>


                                    </div>


                                    <div class="row">


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control" name="questionTypeId">


                                                    <option value="">Question type </option>


                                                    @foreach($questionTypes as $questionType)


                                                        <option value="{{ $questionType['questionTypeId'] }}" {{ isset($selected['typeId']) && $selected['typeId'] == $questionType['questionTypeId'] ? 'selected' : '' }}>{{ $questionType['questionTypeName'] }}</option>


                                                    @endforeach


                                                </select>


                                            </div>


                                        </div>


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control filterChange boards" data-selected="boards" data-reflecton="grades" name="boardId">


                                                    <option value="">Select board</option>


                                                    @foreach($boards as $board)


                                                        <option value="{{ $board['boardId'] }}" {{ isset($selected['boardId']) && $selected['boardId'] == $board['boardId'] ? 'selected' : '' }}>{{ $board['boardName'] }}</option>


                                                    @endforeach


                                                </select>


                                            </div>


                                        </div>


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control grades filterChange" data-selected="grades" data-reflecton="subjects" name="gradeId" {{ isset($selected['gradeId']) ? '' : 'disabled' }}>


                                                    <option value=""> Select grade</option>


                                                    @if(isset($grades))


                                                        @foreach($grades as $grade)


                                                            <option value="{{ $grade['id'] }}" {{ isset($selected['gradeId']) && $selected['gradeId'] == $grade['id'] ? 'selected' : '' }}>{{ $grade['name'] }}</option>


                                                        @endforeach


                                                    @endif


                                                </select>


                                            </div>


                                        </div>


                                    </div>


                                    <div class="row">


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control subjects filterChange" data-selected="subjects" data-reflecton="topics" name="subjectId" {{ isset($selected['subjectId']) ? '' : 'disabled' }}>


                                                    <option value="" selected>Select subject</option>


                                                    @if(isset($subjects))


                                                        @foreach($subjects as $subject)


                                                            <option value="{{ $subject['id'] }}" {{ isset($selected['subjectId']) && $selected['subjectId'] == $subject['id'] ? 'selected' : '' }}>{{ $subject['name'] }}</option>


                                                        @endforeach


                                                    @endif


                                                </select>


                                            </div>


                                        </div>


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control topics filterChange" data-selected="topics" data-reflecton="subtopics" name="topicId" {{ isset($selected['topicIds']) ? '' : 'disabled' }}>


                                                    <option value="" selected>Select topic</option>


                                                    @if(isset($topics))


                                                        @foreach($topics as $topic)


                                                            <option value="{{ $topic['id'] }}" {{ isset($selected['topicIds'])  && in_array($topic['id'], $selected['topicIds']) ? 'selected' : '' }}>{{ $topic['name'] }}</option>


                                                        @endforeach


                                                    @endif


                                                </select>


                                            </div>


                                        </div>


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <select class="form-control subtopics" name="subTopicId" {{ isset($selected['subTopicIds']) ? '' : 'disabled' }}>


                                                    <option value="" selected>Select subtopic</option>


                                                    @if(isset($subtopics))


                                                        @foreach($subtopics as $subtopic)


                                                            <option value="{{ $subtopic['id'] }}" {{ isset($selected['subTopicIds']) && in_array($subtopic['id'], $selected['subTopicIds']) ? 'selected' : '' }}>{{ $subtopic['name'] }}</option>


                                                        @endforeach


                                                    @endif


                                                </select>


                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control difficultyLevel" name="difficultyLevel" >
                                                    <option value="" selected>Select difficulty level</option>
                                                    @if(isset($questionDifficulties))
                                                        @foreach($questionDifficulties as $questionDifficulty)
                                                            <option value="{{ $questionDifficulty['value'] }}" {{ isset($selected['difficultyLevel']) && in_array($questionDifficulty['value'], $selected['questionDifficulties']) ? 'selected' : '' }}>{{ $questionDifficulty['value'] }}</option>
                                                        @endforeach
                                                    @endif
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


@endsection


@section('onPageJs')


    <script type="text/javascript" src="{{ asset('assets/admin/dist/js/review-form.js') }}"></script>


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


@endsection