@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Billing</h6>
               <div class="list-btn">
                  <div style="display:flex;">
                     <ul class="filter-list">
                        <li>
                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".billing-modal-xl">
                              <i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Billing</a>
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
                                 <th style="width:15%">Date</th>
                                 <th style="width:15%">Customer</th>
                                 <th style="width:15%">Product</th>
                                 <th style="width:15%">Starting - Ending Date</th>
                                 @if(Auth::user()->role != 'Admin')
                                    <th style="width:15%">Employee</th>
                                 @endif
                                 <th style="width:20%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($Billingdata as $keydata => $billingdata)

                              @if(Auth::user()->role == 'Admin')
                                 @if(Auth::user()->emp_id == $billingdata['employee_id'])
                              <tr>
                                 <td>{{ date('d-m-Y', strtotime($billingdata['date'])) }}</td>
                                 <td>{{ $billingdata['customer'] }}</td>
                                 <td>{{ $billingdata['product'] }}</td>
                                 <td>{{ date('d M Y', strtotime($billingdata['starting_date'])) }} - {{ date('d M Y', strtotime($billingdata['ending_date'])) }}</td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                       <a class="badge bg-warning-light" href="#edit{{ $billingdata['unique_key'] }}" data-bs-toggle="modal"
                                          data-bs-target=".billing_edit-modal-xl{{ $billingdata['unique_key'] }}" style="color: #28084b;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $billingdata['unique_key'] }}" data-bs-toggle="modal"
                                          data-bs-target=".billingdelete-modal-xl{{ $billingdata['unique_key'] }}" class="badge bg-danger-light" style="color: #28084b;">Delete</a>
                                       </li>
                                    </ul>
                                 
                                 </td>
                              </tr>

                              <div class="modal fade billing_edit-modal-xl{{ $billingdata['unique_key'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="billing_editLargeModalLabel{{ $billingdata['unique_key']}}"
                                    aria-hidden="true">
                                    @include('page.backend.billing.edit')
                              </div>
                              <div class="modal fade billingdelete-modal-xl{{ $billingdata['unique_key'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="billingdeleteLargeModalLabel{{ $billingdata['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.billing.delete')
                              </div>

                                 @endif
                              @else


                              <tr>
                                 <td>{{ date('d-m-Y', strtotime($billingdata['date'])) }}</td>
                                 <td>{{ $billingdata['customer'] }}</td>
                                 <td>{{ $billingdata['product'] }}</td>
                                 <td>{{ date('d M Y', strtotime($billingdata['starting_date'])) }} - {{ date('d M Y', strtotime($billingdata['ending_date'])) }}</td>
                                 <td>{{ $billingdata['employee'] }}</td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                       <a class="badge bg-warning-light" href="#edit{{ $billingdata['unique_key'] }}" data-bs-toggle="modal"
                                          data-bs-target=".billing_edit-modal-xl{{ $billingdata['unique_key'] }}" style="color: #28084b;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $billingdata['unique_key'] }}" data-bs-toggle="modal"
                                          data-bs-target=".billingdelete-modal-xl{{ $billingdata['unique_key'] }}" class="badge bg-danger-light" style="color: #28084b;">Delete</a>
                                       </li>
                                    </ul>
                                 
                                 </td>
                              </tr>

                              <div class="modal fade billing_edit-modal-xl{{ $billingdata['unique_key'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="billing_editLargeModalLabel{{ $billingdata['unique_key']}}"
                                    aria-hidden="true">
                                    @include('page.backend.billing.edit')
                              </div>
                              <div class="modal fade billingdelete-modal-xl{{ $billingdata['unique_key'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="billingdeleteLargeModalLabel{{ $billingdata['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.billing.delete')
                              </div>

                              @endif
                           @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>
               
            </div>
         </div>


      </div>



      <div class="modal fade billing-modal-xl" tabindex="-1" role="dialog" aria-labelledby="billingLargeModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            @include('page.backend.billing.create')
        </div>



   </div>
</div>
@endsection