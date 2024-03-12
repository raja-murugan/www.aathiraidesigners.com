@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Payoff</h6>
                    <div class="list-btn">
                            <div style="display: flex;">

                            <div class="page-btn">
                              <div style="display: flex;">
                                       <form autocomplete="off" method="POST" action="{{ route('payoff.datefilter') }}">
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

                                <ul class="filter-list">
                                    <li><a class="btn btn-primary" href="{{ route('payoff.create') }}"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Payoff</a></li>
                                </ul>
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
                        <div class="col-sm-3 col-lg-3 col-md-3">
                              <table class="table" style="background: #b7a9d8;">
                                 <thead>
                                       <tr>
                                          <th class="border" style="padding-left:17px;font-weight:700;text-transform:uppercase;">Date</th>
                                       </tr>
                                       <tr>
                                          <th class="border" style="padding: 17px;font-weight:700;text-transform:uppercase;">Day</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                             @foreach ($Employee as $datas_emp)
                                                        <tr class="border"></tr>
                                                        <td class="border" style="padding: 11px;font-weight:700;text-transform:uppercase;">{{$datas_emp->name}}</td>
                                                    @endforeach
                                                    
                                    </tbody>
                                 </table>
                        </div>
                        <div class="col-sm-9 col-lg-9 col-md-9"  style="overflow: auto;">
                           <table class="table" >
                           <thead>
                                 <tr>
                                       @foreach ($list as $lists)
                                          <th class="border" style="text-align:center;">{{ $lists }}</th>
                                       @endforeach
                                       <th class="border" style="text-align:center;text-transform:uppercase;" >Total</th>
                                       <th class="border" style="text-align:center;text-transform:uppercase;">Total Salary</th>
                                       <th class="border" style="text-align:center;text-transform:uppercase;">Paid Amount</th>
                                       <th class="border" style="text-align:center;text-transform:uppercase;">Balance</th>
                                       <th class="border" style="text-align:center;text-transform:uppercase;">Edit</th>
                                 </tr>
                                 <tr>
                                    @foreach ($list as $lists_ass)
                                       @php 
                                       
                                       $timestamp = strtotime($year .'-'. $month .'-'. $lists_ass); 
                                       $day = date('D', $timestamp);
                                       @endphp

                                    
                                             <th class="border" style="text-align:center;">
                                                <a class="btn" style="color: black;text-transform:uppercase;">{{$day}}</a>
                                             </th>
                                    @endforeach
                                          <th class="border"></th>
                                          <th class="border"></th>
                                          <th class="border"></th>
                                          <th class="border"></th>
                                          <th class="border"></th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach ($Employee as $employee)

                                    <tr>
                                       @foreach ($Payoff_data as $Payoff_data_arr)
                                          @if ($employee->id == $Payoff_data_arr['employeeid'])

                                             @if ($Payoff_data_arr['attendence_status'] == 'P')

                                                <td class="border" style="text-align:center;" >{{ $Payoff_data_arr['workinghour'] }}</td>

                                             @elseif ($Payoff_data_arr['attendence_status'] == 'A')

                                                <td class="border" style="text-align:center;color:red;font-weight:700;" >{{ $Payoff_data_arr['attendence_status'] }}</td>

                                             @elseif($Payoff_data_arr['attendence_status'] == 'NULL')

                                                <td class="border" style="color:#76691b;font-weight: 800;">H</td>

                                             @else

                                                <td class="border" style="color:white">No</td>

                                             @endif
                                          @endif
                                       @endforeach


                                       @foreach ($TotalData as $TotalDatas)
                                          @if ($employee->id == $TotalDatas['employeeid'])
                                                <td class="border" style="text-align:center;color:green;font-weight:700">{{ $TotalDatas['total_time'] }}</td>
                                                <td class="border" style="text-align:center;">{{ $TotalDatas['total_salary'] }}</td>
                                                <td class="border" style="text-align:center;">{{ $TotalDatas['paid_salary'] }}</td>
                                                <td class="border" style="text-align:center;">{{ $TotalDatas['balanceSalaryAmount'] }}</td>

                                                <td class="border" style="text-align:center;">

                                                <a href="{{ route('payoff.edit', ['id' => $TotalDatas['employeeid'], 'month' => $TotalDatas['month'], 'year' => $TotalDatas['year']]) }}"
                                                class="badge bg-warning-light" style="color:#28084b;">Edit</a>
                                                </td>

                                                
                                          @endif
                                       @endforeach
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
</div>
@endsection
