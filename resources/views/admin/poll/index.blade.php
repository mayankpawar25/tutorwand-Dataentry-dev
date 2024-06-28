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
                        <form action="{{ route('admin.poll') }}" id="filter-data" method="post" action="#">
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

        <section class="piechart-section">
            <div class="row">
                
                <div class="col-lg-8 col-md-8">
                    <div class="card z-index-2  ">
                        <div class="card-body">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Assessment Creation</th>
                                        <th>Grading</th>
                                        <th>Lesson Plan</th>
                                        <th>Other Administrative Work</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $assessmentCounter = 0;
                                        $gradingCounter = 0;
                                        $lessonCounter = 0;
                                        $otherCounter = 0;
                                    @endphp
                                    @if(isset($users) && !empty($users))
                                        @foreach($users as $key => $user)
                                            @php
                                                $tick1 = '';
                                                $tick2 = '';
                                                $tick3 = '';
                                                $tick4 = '';
                                                if($user->customCheck1 !== "") {
                                                    $tick1 = '<i class="material-icons">done</i>';
                                                    $assessmentCounter++; 
                                                }
                                                if($user->customCheck2 !== "") {
                                                    $tick2 = '<i class="material-icons">done</i>';
                                                    $gradingCounter++; 
                                                }
                                                if($user->customCheck3 !== "") {
                                                    $tick3 = '<i class="material-icons">done</i>';
                                                    $lessonCounter++; 
                                                }
                                                if($user->customCheck4 !== "") {
                                                    $tick4 = '<i class="material-icons">done</i>';
                                                    $otherCounter++; 
                                                }
                                            @endphp
                                            <tr>
                                                <td><span style="display:none;">{{ strtotime($user->created_at) }}</span>{{ date('d-m-Y h:i:s A', strtotime($user->created_at)) }}</td>
                                                <td class="text-center">{!! $tick1 !!}</td>
                                                <td class="text-center">{!! $tick2 !!}</td>
                                                <td class="text-center">{!! $tick3 !!}</td>
                                                <td class="text-center">{!! $tick4 !!}</td>
                                            </tr>
                                            @endforeach
                                    @else
                                        <tr>
                                            <td colspan='4'>No done Available</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th class="text-right assignmentCounter">{{ $assessmentCounter }}</th>
                                        <th class="text-right gradeCounter">{{ $gradingCounter }}</th>
                                        <th class="text-right lessonCounter">{{ $lessonCounter }}</th>
                                        <th class="text-right otherCounter">{{ $otherCounter }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="card z-index-2  ">
                        <div class="card-body">
                            <div class="col-lg-12 col-md-12">
                                <canvas id="chart-line" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="table-section">
            <div class="row">
                
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
        $('input[name="datetimesrange"]').daterangepicker({
            timePicker: true,
            startDate: $('input[name="datetimesrange"]').val() == '/' ? moment().startOf('hour').subtract(24, 'hour') : "{{ $startDate }}",
            endDate: $('input[name="datetimesrange"]').val() == '/' ? moment().startOf('hour') : "{{ $endDate }}",
            locale: {
                format: 'DD-MM-Y hh:mm A',
                cancelLabel: 'Clear'
            }
        });
        
        $('#example').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom: 'Blfrtip',
            buttons: [
                'csv', 'excel'
            ]
        });

        let assignmentCounter = parseInt($('.assignmentCounter').text());
        let gradeCounter = parseInt($('.gradeCounter').text());
        let lessonCounter = parseInt($('.lessonCounter').text());
        let otherCounter = parseInt($('.otherCounter').text());
        let total = assignmentCounter + gradeCounter + lessonCounter + otherCounter;

        let assignmentPercentage = (assignmentCounter * 100 / total).toFixed(2)
        let gradePercentage = (gradeCounter * 100 / total).toFixed(2)
        let lessonPercentage = (lessonCounter * 100 / total).toFixed(2)
        let otherPercentage = (otherCounter * 100 / total).toFixed(2)

        var ctx = $("#chart-line");
        var myLineChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Assessment", "Grade", "Lesson", "Other"],
                datasets: [{
                    data: [assignmentPercentage, gradePercentage, lessonPercentage, otherPercentage],
                    backgroundColor: ["rgba(255, 0, 0, 0.5)", "rgba(100, 255, 0, 0.5)", "rgba(200, 50, 255, 0.5)", "rgba(0, 100, 255, 0.5)"]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Poll'
                }
            }
        });
    });
</script>

@endsection

