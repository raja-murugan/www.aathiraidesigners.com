@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Attendance</h6>
            <div style="display: flex;">
                <form autocomplete="off" method="POST" action="{{ route('admin_attendance.admin_datefilter') }}" style="display: flex;">
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
                                 <th style="width:15%">Photo</th>
                                 <th style="width:15%">Working Hours</th>
                                 <th style="width:15%">Time</th>
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
                              <td>
                              <img src="{{ asset('assets/photo/' . $Attendance_datas['photo']) }}" alt=""
                                    style="width: 40px !important; height: 40px !important;">
                              </td>
                              <td>
                                 @if ($Attendance_datas['status'] == 'Present')
                                    {{$Attendance_datas['total_time'] }}
                                 @endif
                              </td>
                              <td>
                              @if ($Attendance_datas['status'] == 'Present')
                                @if ($Attendance_datas['checkin_time'] != '')
                                {{ $Attendance_datas['checkin_time'] }} -
                                @endif

                                @if ($Attendance_datas['checkout_time'] != '')
                                {{ $Attendance_datas['checkout_time'] }}
                                @endif
                              @endif
                              </td>

                                 @if ($Attendance_datas['status'] == 'Present')
                                    <td><img src="{{ asset($Attendance_datas['checkin_photo']) }}" alt="" width="50" height="50"></td>
                                 @elseif ($Attendance_datas['status'] == 'Absent')
                                 <td></td>
                                 @else
                                 <td><a class="badge btn" href="#admin_checkin{{ $Attendance_datas['unique_key'] }}" data-bs-toggle="modal"
                                                data-bs-target=".admin_checkin-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                                data-employee_id ="{{ $Attendance_datas['employee_id'] }}" style="color: #333;background: #caccd7d9;">Check in</a></td>
                                 @endif


                                 @if ($Attendance_datas['status'] == 'Present')
                                    @if ($Attendance_datas['checkout_time'] != '')
                                    <td><img src="{{ asset($Attendance_datas['checkout_photo']) }}" alt="" width="50" height="50"></td>
                                    @else
                                    <td><a class="badge btn" href="#admin_checkout{{ $Attendance_datas['unique_key'] }}" data-bs-toggle="modal"
                                          data-bs-target=".admin_checkout-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                          data-employee_id ="{{ $Attendance_datas['employee_id'] }}"
                                          style="color: #333;background: #caccd7d9;">Check out</a></td>

                                    @endif

                                    
                                 @elseif ($Attendance_datas['status'] == 'Absent')
                                 <td></td>
                                 @else
                                 <td><a class="badge btn" href="#admin_checkout{{ $Attendance_datas['unique_key'] }}" data-bs-toggle="modal"
                                          data-bs-target=".admin_checkout-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                          data-employee_id ="{{ $Attendance_datas['employee_id'] }}"
                                          style="color: #333;background: #caccd7d9;">Check out</a></td>
                                 @endif



                            
                              <td>
                              
                                 <ul class="list-unstyled hstack gap-1 mb-0">
                                    
                                    @if ($Attendance_datas['status'] == 'Present')
                                       <li>
                                          <a class="badge btn"  data-bs-toggle="modal"
                                                data-bs-target=".admin_edit-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                                style="color: #333;background: #d8c730d9;">Edit</a>
                                       </li>
                                    @elseif ($Attendance_datas['status'] == 'Absent')  
                                       <li>
                                             <a class="badge" style="color: #28084b;background: #d55561;">Leave</a>
                                       </li>
                                    @else

                                       <li>
                                             <a href="#admin_leaveupdate{{ $Attendance_datas['unique_key'] }}" data-bs-toggle="modal"
                                             data-bs-target=".admin_leaveupdate-modal-xl{{ $Attendance_datas['unique_key'] }}" 
                                             class="badge" style="color: #28084b;background: #9ed2acd9;">Leave Update</a>
                                       </li>
                                    @endif

                                 </ul>

                              </td>
                           </tr>
                              <div class="modal checin_modal fade admin_checkin-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="admin_checkinLargeModalLabel{{ $Attendance_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.admin_attendance.admin_checkin')
                              </div>
                              <div class="modal checkout_modal fade  admin_checkout-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="admin_checkoutLargeModalLabel{{ $Attendance_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.admin_attendance.admin_checkout')
                              </div>
                              <div class="modal fade admin_edit-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="admin_editLargeModalLabel{{ $Attendance_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.admin_attendance.admin_edit')
                              </div>
                              <div class="modal fade admin_leaveupdate-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="admin_leaveupdateLargeModalLabel{{ $Attendance_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.admin_attendance.admin_leaveupdate')
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
