@extends('admin.layout.master')

@section('title', "Dashboard")

@section('content')

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
                        <form action="{{ route('admin.competition.dashboard') }}" id="filter-data" method="post" action="#">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" placeholder="Select Date Range" name="datetimesrange" class="form-control" requried value={{ $datetimesrange != '' ? $datetimesrange : ''}} />
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

        <section class="filter">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card z-index-2  ">
                        <div class="card-header">
                            <h2>Counters</h2>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-account-multiple widget-icon"></i>
                                            </div>
                                            <h3 class="text-muted fw-normal mt-0" title="Teacher onboard">Teacher's onboard</h3>
                                            <h3 class="mt-3 mb-3">{{ $resp['countOfOnBoardedTeacher'] }}</h3>
                                           
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->

                                <div class="col-sm-3">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-cart-plus widget-icon"></i>
                                            </div>
                                            <h3 class="text-muted fw-normal mt-0" title="Student onboard<">Student's onboard</h3>
                                            <h3 class="mt-3 mb-3">{{ $resp['countOfOnBoardedStudent'] }}</h3>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->

                                <div class="col-sm-3">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-account-multiple widget-icon"></i>
                                            </div>
                                            <h3 class="text-muted fw-normal mt-0" title="Test Created">Test Created</h3>
                                            <h3 class="mt-3 mb-3">{{ $resp['countOfOnTestCreated'] }}</h3>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->

                                <div class="col-sm-3">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-cart-plus widget-icon"></i>
                                            </div>
                                            <h3 class="text-muted fw-normal mt-0" title="Test assigned to number of students">Test assigned to students</h3>
                                            <h3 class="mt-3 mb-3">{{ $resp['totalStudentsAssignedExam'] }}</h3>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->

                                <div class="col-sm-3">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-cart-plus widget-icon"></i>
                                            </div>
                                            <h3 class="text-muted fw-normal mt-0" title="Student submitted test">Student submitted test</h3>
                                            <h3 class="mt-3 mb-3">{{ $resp['totalStudentsSubmittedExam'] }}</h3>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->

                                <div class="col-sm-3">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-cart-plus widget-icon"></i>
                                            </div>
                                            <h3 class="text-muted fw-normal mt-0" title="Tests graded/result publishes ">Tests graded/result publishes </h3>
                                            <h3 class="mt-3 mb-3">{{ $resp['countOfPublishedExam'] }}</h3>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="table-section">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card z-index-2  ">
                        <div class="card-header">
                            <h2>Test Status</h2>
                        </div>
                        <div class="card-body">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email ID</th>
                                        <th>Test Status</th>
                                        <th>No. of Student Assigned</th>
                                        <th>Students submitted test</th>
                                        <th>Students graded</th>
                                        <th>Result published date and time </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($resp['assessmentList']) && !empty($resp['assessmentList']))
                                        @foreach($resp['assessmentList'] as $key => $assessment)
                                            @php
                                                $newCreationDate = new DateTime($assessment['creationDate']); 
                                                $newCreationDate->setTimezone(new DateTimeZone("IST")); 
                                                $creationDateIST = $newCreationDate->format("d-m-Y h:i:s A");

                                                $newResultPublishDate = new DateTime($assessment['resultPublishDate']); 
                                                $newResultPublishDate->setTimezone(new DateTimeZone("IST")); 
                                                $resultPublishDateIST = $newResultPublishDate->format("d-m-Y h:i:s A");
                                            @endphp
                                            <tr>
                                                <td><span style="display:none;">{{ strtotime($assessment['creationDate']) }}</span>{{ $creationDateIST }}</td>
                                                <td>{{ $assessment['assessmentName'] }}</td>
                                                <td>{{ $assessment['teacherEmail'] }}</td>
                                                <td>{{ $assessment['examStaus'] }}</td>
                                                <td>{{ $assessment['studentCount'] }}</td>
                                                <td>{{ $assessment['attemptedStudentCount'] }}</td>
                                                <td>{{ $assessment['examStaus'] === 'PUBLISHED' ? $assessment['attemptedStudentCount'] : 0 }}</td>
                                                <td>{{ $assessment['examStaus'] === 'PUBLISHED' ? ($resultPublishDateIST): '' }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan='8'>No Assessment Data Available</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email ID</th>
                                        <th>Test Status</th>
                                        <th>No. of Student Assigned</th>
                                        <th>Students submitted test</th>
                                        <th>Students graded</th>
                                        <th>Result published date and time </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="table-section">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card z-index-2  ">
                        <div class="card-header">
                            <h2>Teachers onboarded (signed in)</h2>
                        </div>
                        <div class="card-body">
                            <canvas id="teacher-onboard" height="80px"></canvas>
                            <div class="d-none">
                                <textarea id="teacher-graph-count">{{json_encode($resp['teacherCount'])}}</textarea>
                                <textarea id="teacher-graph-date">{{json_encode($resp['teacherDate'])}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="table-section">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card z-index-2  ">
                        <div class="card-header">
                            <h2>Students onboarded (signed in)</h2>
                        </div>
                        <div class="card-body">
                            <canvas id="student-onboard" height="80px"></canvas>
                            <div class="d-none">
                                <textarea id="student-graph-count">{{json_encode($resp['studentCount'])}}</textarea>
                                <textarea id="student-graph-date">{{json_encode($resp['studentDate'])}}</textarea>
                            </div>
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

@endsection

@section('onPageJs')

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
<script>
    $(function() {
        var date2 = new Date();
        date2.setDate(date2.getDate());
        $('input[name="datetimesrange"]').daterangepicker({
            timePicker: false,
            startDate: $('input[name="datetimesrange"]').val() == '/' ? moment().startOf('hour').subtract(24, 'hour') : "{{ $startDate }}",
            endDate: $('input[name="datetimesrange"]').val() == '/' ? moment().startOf('hour') : "{{ $endDate }}",
            locale: {
                format: 'DD/MM/Y',
                cancelLabel: 'Clear'
            },
            maxDate:date2,
        });
        
        $('#example').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom: 'Blfrtip',
            buttons: [
                'csv', 'excel'
            ]
        });

        const studentCanvas = $("#student-onboard");
        const teacherCanvas = $("#teacher-onboard");

        let teacherSpeedData = {
            labels: JSON.parse($('#teacher-graph-date').val()),//["1 Sep", "5 Sep", "10 Sep", "15 Sep", "20 Sep", "25 Sep", "30 Sep"],
            datasets: [{
                label: "Onboarded",
                data: JSON.parse($('#teacher-graph-count').val())//[0, 59, 75, 20, 20, 55, 40]
            }]
        };
        let studentSpeedData = {
            labels: JSON.parse($('#student-graph-date').val()),//["1 Sep", "5 Sep", "10 Sep", "15 Sep", "20 Sep", "25 Sep", "30 Sep"],
            datasets: [{
                label: "Onboarded",
                data: JSON.parse($('#student-graph-count').val())//[0, 59, 75, 20, 20, 55, 40]
            }]
        };

        let lineChart1 = new Chart(studentCanvas, {
            type: 'line',
            data: studentSpeedData
        });

        let lineChart = new Chart(teacherCanvas, {
            type: 'line',
            data: teacherSpeedData
        });
    });
</script>

@endsection

