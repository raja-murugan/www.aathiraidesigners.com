@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Billing</h6>
                    <div class="list-btn">
                            <div style="display: flex;">

                            <div class="page-btn">
                              <div style="display: flex;">
                                       <form autocomplete="off" method="POST" action="{{ route('billing.datefilter') }}">
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
                                    <li><a class="btn btn-primary" href="{{ route('billing.create') }}"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Billing</a></li>
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
                                 <th style="width:10%">BillNo</th>
                                 <th style="width:20%">Customer</th>
                                 <th style="width:15%">Grand Total</th>
                                 <th style="width:15%">PaidAmount</th>
                                 <th style="width:15%">Due</th>
                                 <th style="width:20%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($Billing_data as $keydata => $Billing_datas)
                              <tr>
                                 <td>{{ ++$keydata }}</td>
                                 <td>{{ $Billing_datas['billno'] }}</td>
                                 <td>{{ $Billing_datas['customer'] }}</td>
                                 <td>{{ $Billing_datas['grand_total'] }}</td>
                                 <td>{{ $Billing_datas['total_paid_amount'] }}</td>
                                 <td>{{ $Billing_datas['total_balance_amount'] }}</td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                          <a href="{{ route('billing.edit', ['unique_key' => $Billing_datas['unique_key']]) }}"
                                             class="badge bg-warning-light" style="color:#28084b;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $Billing_datas['unique_key'] }}" data-bs-toggle="modal"
                                          data-bs-target=".billingdelete-modal-xl{{ $Billing_datas['unique_key'] }}" class="badge bg-danger-light" style="color: #28084b;">Delete</a>
                                       </li>
                                    </ul>

                                 </td>
                              </tr>

                             
                              <div class="modal fade billingdelete-modal-xl{{ $Billing_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="billingdeleteLargeModalLabel{{ $Billing_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.billing.delete')
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
