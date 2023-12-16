@extends('layout.backend.auth')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

                <div class="page-header">
                    <div class="content-page-header">
                        <div class="page-title">
                            <h4>Dashboard</h4>
                        </div>

                        <div class="page-btn">
                            <div style="display: flex;">
                                    <form autocomplete="off" method="POST" action="{{ route('home.datefilter') }}">
                                        @method('PUT')
                                        @csrf
                                        <div style="display: flex">
                                            <div style="margin-right: 10px;"><input type="date" name="from_date"
                                                    class="form-control from_date" value="{{ $today }}"></div>
                                            <div style="margin-right: 10px;"><input type="submit" class="btn btn-success"
                                                    value="Search" /></div>
                                        </div>
                                    </form>
                            </div>


                        </div>
                    </div>
                </div>
            <div class="row">


            @if(Auth::user()->role == 'Super-Admin')
                <div class="col-xl-4 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('employee.index') }}"><div class="dash-widget-header">
                                <span class="dash-widget-icon bg-1">
                                    <i class="far fa-user"></i>
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Total Employees</div>
                                    <div class="dash-counts">
                                        <p> {{$total_Employee}}</p>
                                    </div>
                                </div>
                            </div></a>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-xl-4 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('customer.index') }}"><div class="dash-widget-header">
                                <span class="dash-widget-icon bg-2">
                                    <i class="fas fa-user"></i>
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Total Customers</div>
                                    <div class="dash-counts">
                                        <p>{{$total_Customer}}</p>
                                    </div>
                                </div>
                            </div></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 col-12">
                    <div class="card" >
                        <div class="card-body">
                            <a href="{{ route('product.index') }}"><div class="dash-widget-header">
                                <span class="dash-widget-icon bg-3">
                                    <i class="fas fa-user"></i>
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Total Products</div>
                                    <div class="dash-counts">
                                        <p> {{$total_Product}}</p>
                                    </div>
                                </div>
                            </div></a>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                {{-- <div class="col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-center">
                                <div class="col">
                                    <h5 class="card-title"> Bills</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-stripped table-hover border">

                                    <thead class="thead-light ">

                                        <tr>
                                            <th class="border">Customer</th>
                                            <th class="border">Product</th>
                                            @if(Auth::user()->role != 'Admin')
                                            <th class="border">Employee</th>
                                            @endif
                                            <th class="border">Starting - Ending Date</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                    @foreach ($Billingdata as $keydata => $billingdata)
                                        @if(Auth::user()->role == 'Admin')
                                            @if(Auth::user()->emp_id == $billingdata['employee_id'])
                                        <tr>
                                            <td class="border" style="font-weight: 700;">{{ $billingdata['customer'] }}</td>
                                            <td class="border">{{ $billingdata['product'] }}</td>
                                            <td class="border">{{ date('d M Y', strtotime($billingdata['starting_date'])) }} - {{ date('d M Y', strtotime($billingdata['ending_date'])) }}</td>
                                        </tr>
                                            @endif
                                        @else
                                        <tr>
                                            <td class="border" style="font-weight: 700;">{{ $billingdata['customer'] }}</td>
                                            <td class="border">{{ $billingdata['product'] }}</td>
                                            <td class="border" style="color: red;">{{ $billingdata['employee'] }}</td>
                                            <td class="border">{{ date('d M Y', strtotime($billingdata['starting_date'])) }} - {{ date('d M Y', strtotime($billingdata['ending_date'])) }}</td>
                                        </tr>
                                        @endif
                                        @endforeach

                                    </tbody>




                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-center">
                                <div class="col">
                                    <h5 class="card-title">Upcoming Followups</h5>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover border">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border">PreviousCall Date</th>
                                            <th class="border">Customer</th>
                                            @if(Auth::user()->role != 'Admin')
                                            <th class="border">Employee</th>
                                            @endif
                                            <th class="border">Call Details</th>
                                            <th class="border">Next Call Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($followupdata as $keydata => $followupdatas)
                                        @if(Auth::user()->role == 'Admin')
                                            @if(Auth::user()->emp_id == $followupdatas['employee_id'])
                                            <tr>
                                                <td class="border">{{ date('d M Y', strtotime($followupdatas['date'])) }}</td>
                                                <td class="border" style="font-weight: 700;">{{ $followupdatas['customer'] }}</td>
                                                <td class="border">{{ $followupdatas['description'] }}</td>
                                                <td class="border">{{ date('d M Y', strtotime($followupdatas['next_call_date'])) }}</td>
                                            </tr>
                                            @endif
                                        @else
                                            <tr>
                                                <td class="border">{{ date('d M Y', strtotime($followupdatas['date'])) }}</td>
                                                <td class="border" style="font-weight: 700;">{{ $followupdatas['customer'] }}</td>
                                                <td class="border" style="color: red;">{{ $followupdatas['employee'] }}</td>
                                                <td class="border">{{ $followupdatas['description'] }}</td>
                                                <td class="border">{{ date('d M Y', strtotime($followupdatas['next_call_date'])) }}</td>
                                            </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>





        </div>
    </div>
@endsection
