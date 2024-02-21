@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6 style="text-transform:uppercase;color:green;">{{$Employeedata->name}}</h6>
            <div class="page-btn">

                <div style="display: flex;">
                        <form autocomplete="off" method="POST" action="{{ route('employee.datefilter') }}">
                            @method('PUT')
                            @csrf
                            <div style="display: flex">
                                 <div style="margin-right: 10px;"><input type="date" name="from_date"
                                        class="form-control from_date" value="{{ $today }}">
                                       <input type="hidden" name="employee_uniquekey" value="{{$Employeedata->unique_key}}" ></div>
                                <div style="margin-right: 10px;"><input type="submit" class="btn btn-success"
                                        value="Search" /></div>
                            </div>
                        </form>
                </div>

            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-sm-12">
            <div class="card">

                  <div class="card-body">

                  <h5 style="text-transform:uppercase;text-align:center;margin-bottom:10px;">{{$curent_month}} - {{$year}}</h5>
                  <div class="row">
                     <div class="col-sm-2">
                           <table class="table ">
                              <thead>
                                    <tr>
                                       <th class="border">Date</th>
                                    </tr>
                                    <tr>
                                       <th class="border" style="padding: 9px;">Day</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                       <tr class="border"><td class="border" >Attendance</td></tr>
                                       <tr class="border"><td class="border" >Working Hour</td></tr>
                                 </tbody>
                              </table>
                     </div>
                     <div class="col-sm-10" style="overflow: auto;">
                        <table class="table" >
                           <thead>
                              <tr>
                                 @foreach ($list as $lists)
                                 @php 
                                 $date = $lists .' '. $c_month .' '. $year;
                                 @endphp
                                    <th class="border" style="text-align:center;color: #198754;" >{{ $lists }}</th>
                                 @endforeach
                                    <th class="border" style="text-align:center;text-transform:uppercase;" >Total</th>
                                    <th class="border" style="text-align:center;text-transform:uppercase;">Total Salary</th>
                              </tr>
                              <tr>
                              @foreach ($list as $lists_ass)
                                 @php 
                                                        
                                    $timestamp = strtotime($year .'-'. $month .'-'. $lists_ass); 
                                    $day = date('D', $timestamp);
                                 @endphp

                                                        
                                       <th class="border" style="text-align:center;text-transform:uppercase;">{{$day}}</th>
                              @endforeach
                                       <th class="border"></th>
                                       <th class="border"></th>
                              </tr>
                           </thead>
                           <tbody>
                                 <tr>
                                    @foreach ($attendence_Data as $attendence_Data_arr)

                                          @if ($attendence_Data_arr['attendence_status'] == 'P')

                                             <td class="border" style="color:green;text-align:center;" >{{ $attendence_Data_arr['attendence_status'] }}</td>

                                          @elseif ($attendence_Data_arr['attendence_status'] == 'A')

                                             <td class="border" style="color:red;text-align:center;" >{{ $attendence_Data_arr['attendence_status'] }}</td>

                                          @elseif($attendence_Data_arr['attendence_status'] == 'NULL')

                                             <td class="border" style="color:#76691b;font-weight: 800;">H</td>

                                          @else

                                             <td class="border" style="color:white">No</td>

                                          @endif
                                    @endforeach
                                             <td class="border" style="color:white"></td>
                                             <td class="border" style="color:white"></td>
                                 </tr>
                                 <tr>
                                 @foreach ($attendence_Data as $attendence_Data_arrs)

                                       @if ($attendence_Data_arrs['attendence_status'] == 'P')

                                             <td class="border">{{ $attendence_Data_arrs['workinghour'] }}</td>

                                          @elseif ($attendence_Data_arrs['attendence_status'] == 'A')

                                             <td class="border" style="color:white"></td>

                                          @else

                                             <td class="border" style="color:white">No</td>

                                          @endif
                                 @endforeach
                                             <td class="border" style="color:black">{{$total_time}}</td>
                                             <td class="border" style="color:black">{{$total_salary}}</td>
                                 </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
                        
                  </div>

            </div>
         </div>


      </div>





    
   </div>
</div>
@endsection
