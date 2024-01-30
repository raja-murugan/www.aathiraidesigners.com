@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Attendance</h6>
            <div style="display: flex;">
                <form autocomplete="off" method="POST" action="{{ route('attendance.datefilter') }}" style="display: flex;">
                    @method('PUT')
                    @csrf
                    <div style="display: flex">
                        <div style="margin-right: 10px;"><input type="date" name="from_date" required
                                class="form-control from_date" value="{{ $today }}"></div>
                        <div style="margin-right: 10px;"><input type="submit" class="btn btn-primary" value="Search" />
                        </div>
                    </div>
                </form>
            </div>
               
         </div>
      </div>

      <div class="row">
         <div class="col-sm-12">
            <div class="card">

                  <div class="card-body">
                     <div class="table-responsive">
                        <table class="table table-center table-hover datatable table-striped">
                           <thead class="thead-light">
                              <tr>
                                 <th style="width:10%">S.No</th>
                                 <th style="width:15%">Name</th>
                                 <th style="width:15%">Working Time</th>
                                 <th style="width:15%">Check-In Photo</th>
                                 <th style="width:15%">Check-Out Photo</th>
                                 <th style="width:30%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($Attendance_data as $keydata => $Attendance_datas)
                           <tr>
                              <td>{{ ++$keydata }}</td>
                              <td>{{ $Attendance_datas['employee'] }}</td>
                              <td></td>
                              <td>
                              <a class="badge btn" href="#checkin{{ $Attendance_datas['unique_key'] }}" data-bs-toggle="modal"
                                          data-bs-target=".checkin-modal-xl{{ $Attendance_datas['unique_key'] }}" 
                                          data-employee-id ="{{ $Attendance_datas['employee_id'] }}" style="color: #28084b;background: #78d778;">Check in</a>
                              </td>
                              <td><a class="badge btn" href="#checkout{{ $Attendance_datas['unique_key'] }}" data-bs-toggle="modal"
                                          data-bs-target=".checkout-modal-xl{{ $Attendance_datas['unique_key'] }}" style="color: #28084b;background: #b5b5c3;">Check out</a></td>
                              <td></td>
                           </tr>
                              <div class="modal checin_modal fade checkin-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="checkinLargeModalLabel{{ $Attendance_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.attendance.checkin')
                              </div>
                              <div class="modal fade  checkout-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="checkoutLargeModalLabel{{ $Attendance_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.attendance.checkout')
                              </div>
     
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
