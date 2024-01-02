@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Attendance</h6>
               <div class="list-btn">
                  <div style="display:flex;">
                     <ul class="filter-list">
                        <li>
                        <a class="btn btn-primary" href="{{ route('attendance.create') }}"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Attendance</a>
                        </li>
                     </ul>
                  </div>
                  
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
                                 <th style="width:5%">S.No</th>
                                 <th style="width:15%">Date</th>
                                 <th style="width:15%">Employee</th>
                                 <th style="width:15%">Working Hour</th>
                                 <th style="width:15%">Present / Absent</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($Attendance_data as $keydata => $Attendance_datas)
                              <tr>
                                 <td>{{ ++$keydata }}</td>
                                 <td>{{ $Attendance_datas['date'] }}</td>
                                 <td>{{ $Attendance_datas['employee'] }}</td>
                                 <td>{{ $Attendance_datas['hour'] }}</td>
                                 <td>{{ $Attendance_datas['status'] }}</td>
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