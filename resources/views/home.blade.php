@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

                  <div class="page-header">
                    <div class="content-page-header">
                        <div class="page-title">
                            <h4  >Dashboard</h4>
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

                        <div class="col-xl-4 col-sm-6 col-12">
                           <div class="card">
                                 <div class="card-body">
                                    <a href="{{ route('employee.index') }}"><div class="dash-widget-header">
                                       <span class="dash-widget-icon bg-1">
                                             <i class="far fa-user"></i>
                                       </span>
                                       <div class="dash-count">
                                             <div class="dash-title"  >Total Employees</div>
                                             <div class="dash-counts"  >
                                                <p> {{$total_Employee}}</p>
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
                                             <div class="dash-title" >Total Products</div>
                                             <div class="dash-counts" >
                                                <p> {{$total_Product}}</p>
                                             </div>
                                       </div>
                                    </div></a>
                                 </div>
                           </div>
                        </div>

                        <div class="col-xl-4 col-sm-6 col-12">
                           <div class="card">
                                 <div class="card-body">
                                    <a href="{{ route('customer.index') }}"><div class="dash-widget-header">
                                       <span class="dash-widget-icon bg-2">
                                             <i class="fas fa-user"></i>
                                       </span>
                                       <div class="dash-count">
                                             <div class="dash-title" >Total Customers</div>
                                             <div class="dash-counts" >
                                                <p>{{$total_Customer}}</p>
                                             </div>
                                       </div>
                                    </div></a>
                                 </div>
                           </div>
                        </div>
                  </div>



                  <div class="row">
                     <div class="col-md-6 col-sm-6">
                        <div class="card">
                              <div class="card-header">
                                 <div class="row align-center">
                                    <div class="col">
                                          <h5 class="card-title" > Attendance</h5>
                                    </div>
                                 </div>
                              </div>
                              <div class="card-body">
                                 <div class="table-responsive">
                                    <table class="table table-stripped datatable table-hover border">

                                          <thead class="thead-light ">

                                             <tr>
                                                <th class="border">Employee</th>
                                                <th class="border">In - Time</th>
                                                <th class="border">Out Time</th>
                                                <th class="border">Total Time</th>
                                                <th class="border">Leave</th>
                                             </tr>
                                          </thead>
                                          <tbody >
                                          @foreach ($Attendance_data as $keydata => $Attendance_datas)
                                             <tr>
                                                <td class="border">{{ $Attendance_datas['employee'] }}</td>
                                                <td class="border">{{ $Attendance_datas['checkin_time'] }}</td>
                                                <td class="border">{{ $Attendance_datas['checkout_time'] }}</td>
                                                <td class="border">{{ $Attendance_datas['total_time'] }}</td>
                                                @if ($Attendance_datas['status'] == 'Absent')
                                                <td class="border">A</td>
                                                @elseif ($Attendance_datas['status'] == 'Present')
                                                <td class="border">P</td>
                                                @else
                                                <td class="border"></td>
                                                @endif
                                             </tr>
                                             @endforeach
                                          </tbody>
                                    </table>
                                 </div>
                              </div>
                        </div>
                     </div> 




                     <div class="col-md-6 col-sm-6">
                        <div class="card">
                              <div class="card-header">
                                 <div class="row align-center">
                                    <div class="col">
                                          <h5 class="card-title" >Today Delivery Products</h5>
                                    </div>
                                 </div>
                              </div>
                              <div class="card-body">
                                 <div class="table-responsive">
                                    <table class="table table-stripped datatable table-hover border">

                                          <thead class="thead-light ">

                                             <tr>
                                                <th class="border">Customer</th>
                                                <th class="border">Products</th>
                                                <th class="border">Total</th>
                                             </tr>
                                          </thead>
                                          <tbody >
                                          @foreach ($Billing_data as $keydata => $Billing_datas)
                                             <tr>
                                                <td class="border">{{ $Billing_datas['customer'] }}</td>
                                                <td class="border">
                                                @foreach ($Billing_datas['productsarr'] as $index => $productArr)
                                                    @if ($productArr['billing_id'] == $Billing_datas['id'])
                                                    <span class="badge bg-info-light" style="color: black">{{ $productArr['product'] }} - {{ $productArr['billing_measurement'] }}</span> <br/>
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td class="border">{{ $Billing_datas['grand_total'] }}</td>
                                             </tr>
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
