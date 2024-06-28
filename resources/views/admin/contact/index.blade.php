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
                        <form action="{{ route('admin.contact') }}" id="filter-data" method="post" action="#">
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
                                        <th>Subject</th>
                                        <th>Message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($users) && !empty($users))
                                        @foreach($users as $key => $user)
                                            <tr>
                                                <td><span style="display:none;">{{ strtotime($user->created_at) }}</span>{{ date('d-m-Y h:i:s A', strtotime($user->created_at)) }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->contact }}</td>
                                                <td>{{ $user->subject }}</td>
                                                <td>{{ $user->message }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan='6'>No User Available</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email ID</th>
                                        <th>Contact No.</th>
                                        <th>Subject</th>
                                        <th>Message</th>
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

@endsection

@section('onPageJs')

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
    });
</script>

@endsection

