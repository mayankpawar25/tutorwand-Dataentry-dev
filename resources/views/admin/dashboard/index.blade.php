@extends('admin.layout.master')


@section('title', "Dashboard")


@section('content')


<div id="page-content-wrapper">


    <div class="page-content">


        <!-- Content Header (Page header) -->





        <!-- page section -->


        <div class="container-fluid">


            <div class="row d-none">


                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">


                    <div class="panel cardbox bg-white bg-success2">


                        <div class="panel-body card-item panel-refresh">


                            <span class="refresh">


                                <span class="fa fa-refresh" aria-hidden="true"></span>


                            </span>


                            <a class="" href="form.php">





                                <div class="refresh-container"><i class="refresh-spinner fa fa-spinner fa-spin fa-5x"></i></div>


                                <div class="timer" data-to="0" data-speed="1500">0</div>


                                <div class="cardbox-icon">


                                    <i class="material-icons">assignment_turned_in</i>


                                </div>


                                <div class="card-details">


                                    <h4>Multi choice</h4>


                                </div>


                            </a>


                        </div>


                    </div>


                </div>


                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">


                    <div class="panel cardbox bg-white bg-danger">


                        <div class="panel-body card-item panel-refresh">


                            <span class="refresh">


                                <span class="fa fa-refresh" aria-hidden="true"></span>


                            </span>


                            <a class="" href="form.php">








                                <div class="refresh-container"><i class="refresh-spinner fa fa-spinner fa-spin fa-5x"></i></div>


                                <div class="timer" data-to="0" data-speed="1500">0</div>


                                <div class="cardbox-icon">


                                    <i class="material-icons">assignment_turned_in</i>


                                </div>


                                <div class="card-details">


                                    <h4>Fill in the blanks</h4>





                                </div>


                            </a>


                        </div>


                    </div>


                </div>


                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">


                    <div class="panel cardbox bg-white bg-blue">


                        <div class="panel-body card-item panel-refresh">


                            <span class="refresh">


                                <span class="fa fa-refresh" aria-hidden="true"></span>


                            </span>


                            <a class="" href="form.php">








                                <div class="refresh-container"><i class="refresh-spinner fa fa-spinner fa-spin fa-5x"></i></div>


                                <div class="timer" data-to="0" data-speed="1500">0</div>


                                <div class="cardbox-icon">


                                    <i class="material-icons">assignment_turned_in</i>


                                </div>


                                <div class="card-details">


                                    <h4>Short and Long answer</h4>





                                </div>


                            </a>


                        </div>


                    </div>


                </div>


                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">


                    <div class="panel cardbox bg-white bg-yellow">


                        <div class="panel-body card-item panel-refresh">


                            <span class="refresh">


                                <span class="fa fa-refresh" aria-hidden="true"></span>


                            </span>


                            <a class="" href="form.php">








                                <div class="refresh-container"><i class="refresh-spinner fa fa-spinner fa-spin fa-5x"></i></div>


                                <div class="timer" data-to="0" data-speed="1500">0</div>


                                <div class="cardbox-icon">


                                    <i class="material-icons">assignment_turned_in</i>


                                </div>


                                <div class="card-details">


                                    <h4>True and false</h4>





                                </div>


                            </a>


                        </div>


                    </div>


                </div>


                <!-- ./counter Number -->


                <!-- chart -->


                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                    <div class="card">


                        <div class="card-header">


                            <i class="fa fa-bar-chart fa-lg"></i>


                            <h2>Bar Chart</h2>


                        </div>


                        <div class="card-content">


                            <canvas id="lineChart" height="150"></canvas>


                        </div>


                    </div>


                </div>


                <!-- ./chart -->





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


