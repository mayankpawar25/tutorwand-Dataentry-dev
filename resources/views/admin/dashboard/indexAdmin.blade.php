@extends('admin.layout.master')


@section('title', "Dashboard")


@section('content')


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


                                {{ csrf_field() }}


                                <div class="row">


                                    <div class="col-md-3">


                                        <div class="form-group">


                                            <input type="hidden" name="urlChange" id="urlChange" value="{{ route('review.filter.on.change') }}">


                                            <input type="hidden" name="postURL" id="postURL" value="{{ route('dashboard.filter.search.result') }}">


                                            <select class="form-control filterChange boards" data-selected="boards" data-reflecton="grades" name="boardId" id="boardId" required>


                                                <option value="">Select board</option>


                                                @foreach($boards as $key => $board)


                                                    <option value="{{ $board['boardId'] }}" {{ isset($selected['boardId']) && $selected['boardId'] == $board['boardId'] ? 'selected' : ($key == 0 ? 'selected' : '') }}>{{ $board['boardName'] }}</option>


                                                @endforeach


                                            </select>


                                        </div>


                                    </div>


                                    <div class="col-md-3">


                                        <div class="form-group">


                                            <select class="form-control grades filterChange" data-selected="grades" data-reflecton="subjects" name="gradeId" id="gradeId" {{ isset($selected['gradeId']) ? '' : 'disabled' }} required>


                                                <option value=""> Select grade</option>


                                                @if(isset($grades))


                                                    @foreach($grades as $grade)


                                                        <option value="{{ $grade['id'] }}" {{ isset($selected['gradeId']) && $selected['gradeId'] == $grade['id'] ? 'selected' : '' }}>{{ $grade['name'] }}</option>


                                                    @endforeach


                                                @endif


                                            </select>


                                        </div>


                                    </div>


                                    <div class="col-md-3">


                                        <div class="form-group">


                                            <select class="form-control subjects filterChange" data-selected="subjects" data-reflecton="topics" name="subjectId" id="subjectId" {{ isset($selected['subjectId']) ? '' : 'disabled' }} required>


                                                <option value="" selected>Select subject</option>


                                                @if(isset($subjects))


                                                    @foreach($subjects as $subject)


                                                        <option value="{{ $subject['id'] }}" {{ isset($selected['subjectId']) && $selected['subjectId'] == $subject['id'] ? 'selected' : '' }}>{{ $subject['name'] }}</option>


                                                    @endforeach


                                                @endif


                                            </select>


                                        </div>


                                    </div>


                                    <div class="col-md-3">


                                        <div class="form-group">


                                            <select class="form-control" name="statusId" id="statusId" required>


                                                <option value="">Status</option>


                                                @foreach($questionStatus as $key => $status)


                                                    <option value="{{ $status['statusId'] }}" >{{ $status['statusName'] }}</option>


                                                @endforeach


                                            </select>


                                        </div>


                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" name="difficultyLevel" id="difficultyLevel">
                                                <option value="0">Difficulty Level</option>
                                                @if(isset($questionDifficulties))
                                                    @foreach($questionDifficulties as $questionDifficulty)
                                                        <option value="{{ $questionDifficulty['value'] }}" {{ isset($selected['difficultyLevel']) && in_array($questionDifficulty['value'], $selected['questionDifficulties']) ? 'selected' : '' }}>{{ $questionDifficulty['value'] }}</option>
                                                    @endforeach
                                                @endif
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


@endsection


@section('onPageJs')


<script type="text/javascript" src="{{ asset('assets/admin/dist/js/review-dashboard.js') }}"></script>


@endsection


