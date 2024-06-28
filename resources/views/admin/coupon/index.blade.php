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
                            <h2>Add Coupon</h2>
                        </div>
                        <form action="{{ route('admin.coupon.add') }}" id="filter-data" method="post" action="#">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6">
                                        <input type="text" placeholder="Coupon Name" name="name"  pattern="[a-zA-z0-9]{4,13}" class="form-control" required value='' />
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <select placeholder="Select Request Range" name="range" class="form-control" required>
                                            <option value="">Select Test Paper Range</option>
                                            <option value="1 to 50 Attempts">1 to 50 Attempts</option>
                                            <option value="51 to 200 Attempts">51 to 200 Attempts</option>
                                            <option value="201 to 500 Attempts">201 to 500 Attempts</option>
                                            <option value="500+">500+</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <input type="number" min="0" max="100" step="0.1" placeholder="Discount Percentage %" name="percentage" class="form-control" required value='' />
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <input type="number" min="0" max="365" step="1" placeholder="Coupon Valid till (in days)" name="validity" class="form-control" required value='' />
                                    </div>
                                    <div class="col-lg-3 col-md-6 mt-2">
                                        <select placeholder="Coupon use type" name="type" class="form-control" required>
                                            <option value="OncePerUser">Once per user</option>
                                            <option value="NTimesTotal">Multiple times</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6 mt-2">
                                        <input type="number" min="1" max="1000000" step="1" placeholder="No. of uses" name="quantity" class="form-control" required value='' />
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <p class="text-danger">{{ session()->get('message') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-success">Add</button>
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
                                        <th>Creation Date</th>
                                        <th>Coupon Name</th>
                                        <th>Test Paper Range</th>
                                        <th>Discount %age</th>
                                        <th>Assigned to</th>
                                        <th>Coupon type</th>
                                        <th>No. of uses</th>
                                        <th>Expiry date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($couponLists) && !empty($couponLists))
                                        @foreach($couponLists as $key => $coupon)
                                        @php
                                        $type = '';
                                        if($coupon['type'] == 'OncePerUser') {
                                            $type = 'Once per user';
                                        } else if($coupon['type'] == 'NTimesTotal') {
                                            $type = 'Multiple times';
                                        }
                                        @endphp
                                            <tr>
                                                <td><span style="display:none;">{{ strtotime($coupon['creadtedDate']) }}</span>{{ date('d-m-Y h:i:s A', strtotime($coupon['creadtedDate'])) }}</td>
                                                <td>{{ $coupon['couponCode'] }}</td>
                                                <td>{{ $coupon['minAttempts'] }} - {{ $coupon['maxAttempts'] }}</td>
                                                <td>{{ $coupon['discountPercentage'] }}</td>
                                                <td>{{ $coupon['couponUserEmailId'] }}</td>
                                                <td>{{ $type }}</td>
                                                <td>{{ $coupon['quantityAvailable'] }}</td>
                                                <td>{{ date('d-m-Y h:i:s A', strtotime($coupon['expiryDate'])) }}</td>
                                                <td>{{ $coupon['status'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan='6'>No Coupon Available</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Creation Date</th>
                                        <th>Coupon Name</th>
                                        <th>Test Paper Range</th>
                                        <th>Discount %age</th>
                                        <th>Assigned to</th>
                                        <th>Coupon type</th>
                                        <th>No. of uses</th>
                                        <th>Expiry date</th>
                                        <th>Status</th>
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

