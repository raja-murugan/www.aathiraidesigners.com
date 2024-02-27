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
                     <div class="table-responsive">
                        <table class="table table-center table-hover datatable table-striped">
                           <thead class="thead-light">
                              <tr>
                                 <th style="width:5%">S.No</th>
                                 <th style="width:10%">Month</th>
                                 <th style="width:10%">Date</th>
                                 <th style="width:15%">Employee</th>
                                 <th style="width:15%">Total Working Hour</th>
                                 <th style="width:15%">Total Salary</th>
                                 <th style="width:15%">Paid Salary</th>
                                 <th style="width:20%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($Payoff_data as $keydata => $Payoff_datas)
                              <tr>
                                 <td>{{ ++$keydata }}</td>
                                 <td>{{ $Payoff_datas['month'] }}</td>
                                 <td>{{ $Payoff_datas['date'] }}</td>
                                 <td>{{ $Payoff_datas['employee'] }}</td>
                                 <td>{{ $Payoff_datas['total_working_hour'] }}</td>
                                 <td>{{ $Payoff_datas['salaryamount'] }}</td>
                                 <td>{{ $Payoff_datas['totalpaidsalary'] }}</td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                          <li>
                                             <a href="{{ route('payoff.edit', ['unique_key' => $Payoff_datas['unique_key']]) }}"
                                                class="badge bg-warning-light" style="color:#28084b;">Edit</a>
                                          </li>
                                          <li>
                                             <a href="#delete{{ $Payoff_datas['unique_key'] }}" data-bs-toggle="modal"
                                             data-bs-target=".payoffdelete-modal-xl{{ $Payoff_datas['unique_key'] }}" class="badge bg-danger-light" style="color: #28084b;">Delete</a>
                                          </li>

                                    </ul>

                                 </td>
                              </tr>

                             
                              <div class="modal fade payoffdelete-modal-xl{{ $Payoff_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="payoffdeleteLargeModalLabel{{ $Payoff_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.payoff.delete')
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
