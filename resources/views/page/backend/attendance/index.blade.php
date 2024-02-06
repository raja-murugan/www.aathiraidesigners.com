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
                                 <th style="width:15%">Photo</th>
                                 <th style="width:15%">Name</th>
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
                              <td>
                              <img src="{{ asset($Attendance_datas['photo']) }}" alt=""
                              style="width: 80px !important; height: 80px !important;">
                              </td>
                              <td>{{ $Attendance_datas['employee'] }}</td>
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
                                    <td><img src="{{ asset($Attendance_datas['checkin_photo']) }}" alt="" style="width: 70px !important; height: 70px !important;"></td>
                                 @elseif ($Attendance_datas['status'] == 'Absent')
                                 <td></td>
                                 @else
                                 <td><a class="badge btn" href="#checkin{{ $Attendance_datas['unique_key'] }}" data-bs-toggle="modal"
                                                data-bs-target=".checkin-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                                data-employee_id ="{{ $Attendance_datas['employee_id'] }}" style="color: #333;background: #caccd7d9;">Check in</a></td>
                                 @endif


                                 @if ($Attendance_datas['status'] == 'Present')
                                    @if ($Attendance_datas['checkout_time'] != '')
                                    <td><img src="{{ asset($Attendance_datas['checkout_photo']) }}" alt="" style="width: 70px !important; height: 70px !important;"></td>
                                    @else
                                    <td><a class="badge btn" href="#checkout{{ $Attendance_datas['unique_key'] }}" data-bs-toggle="modal"
                                          data-bs-target=".checkout-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                          data-employee_id ="{{ $Attendance_datas['employee_id'] }}"
                                          style="color: #333;background: #caccd7d9;">Check out</a></td>

                                    @endif


                                 @elseif ($Attendance_datas['status'] == 'Absent')
                                 <td></td>
                                 @else
                                 <td><a class="badge btn" href="#checkout{{ $Attendance_datas['unique_key'] }}" data-bs-toggle="modal"
                                          data-bs-target=".checkout-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                          data-employee_id ="{{ $Attendance_datas['employee_id'] }}"
                                          style="color: #333;background: #caccd7d9;">Check out</a></td>
                                 @endif




                              <td>

                                 <ul class="list-unstyled hstack gap-1 mb-0">

                                    @if ($Attendance_datas['status'] == 'Present')
                                       <li>
                                          <a class="badge btn"  data-bs-toggle="modal"
                                                data-bs-target=".attendanceedit-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                                style="color: #333;background: #d8c730d9;">Edit</a>
                                       </li>
                                    @elseif ($Attendance_datas['status'] == 'Absent')
                                       <li>
                                             <a class="badge" style="color: #28084b;background: #d55561;">Leave</a>
                                       </li>
                                    @else

                                       <li>
                                             <a href="#leaveupdate{{ $Attendance_datas['unique_key'] }}" data-bs-toggle="modal"
                                             data-bs-target=".leaveupdate-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                             class="badge" style="color: #28084b;background: #9ed2acd9;">Leave Update</a>
                                       </li>
                                    @endif

                                 </ul>

                              </td>
                           </tr>
                              <div class="modal checin_modal fade checkin-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="checkinLargeModalLabel{{ $Attendance_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.attendance.checkin')
                              </div>
                              <div class="modal checkout_modal fade  checkout-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="checkoutLargeModalLabel{{ $Attendance_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.attendance.checkout')
                              </div>
                              <div class="modal fade attendanceedit-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="attendanceeditLargeModalLabel{{ $Attendance_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.attendance.edit')
                              </div>
                              <div class="modal fade leaveupdate-modal-xl{{ $Attendance_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="leaveupdateLargeModalLabel{{ $Attendance_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.attendance.leaveupdate')
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
