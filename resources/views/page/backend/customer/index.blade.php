@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Customer</h6>
               <div class="list-btn">
                  <div style="display:flex;">
                     <ul class="filter-list">
                        <li>
                           <a class="btn btn-primary" href="{{ route('customer.create') }}"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Customer</a>
                        </li>
                     </ul>
                  </div>
                  
               </div>
               



         </div>
      </div>

      <div class="row">
         <div class="col-sm-12">
               <div class="profile-picture">
                 
                              <form id="csvimport_form" method="POST" action="{{ route('customer.excel_import') }}" enctype="multipart/form-data" class="form-horizontal">
                              @csrf
                                 <div style="display:flex;">
						                  <div class="upload-profile">
													<div class="add-profile">
														<input type="file" name="file" id="file" class="form-control"/>
													</div>
												</div>
												<div class="img-upload">
                                       <input type="hidden" name="hidden_field" value="1" />
                                          <input type="submit" name="import" id="import" class="btn btn-info" value="Import" />
												</div>	
                                 </div>	
                              </form>	
                  							
					</div>
            
            <div class="card">
               
               
                  <div class="card-body">
                     <div class="table-responsive">
                        <table class="table table-center table-hover datatable table-striped">
                           <thead class="thead-light">
                              <tr>
                                 <th style="width:15%">Customer</th>
                                 <th style="width:15%">Address</th>
                                 <th style="width:15%">Phone No</th>
                                 <th style="width:15%">Email</th>
                                 <th style="width:15%">Staff</th>
                                 <th style="width:20%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($Customer_data as $keydata => $customer_data)
                              @if(Auth::user()->role == 'Admin')
                                 @if(Auth::user()->emp_id == $customer_data['employee_id'])
                              <tr>
                                 <td>{{ $customer_data['name'] }}</td>
                                 <td>{{ $customer_data['address'] }}</td>
                                 <td>{{ $customer_data['phonenumber'] }}</td>
                                 <td>{{ $customer_data['email_id'] }}</td>
                                 <td>{{ $customer_data['employee'] }}</td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                          <a class="badge" href="#customerview{{ $customer_data['id'] }}" data-bs-toggle="modal"
                                          data-bs-target=".customerview-modal-xl{{ $customer_data['id'] }}" style="color: #f8f9fa;background: #8068dc;">View</a>
                                       </li>
                                       <li>
                                          <a href="{{ route('customer.edit', ['id' => $customer_data['id']]) }}"
                                                   class="badge bg-warning-light" style="color:#28084b;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $customer_data['id'] }}" data-bs-toggle="modal"
                                          data-bs-target=".customerdelete-modal-xl{{ $customer_data['id'] }}" class="badge bg-danger-light" style="color: #28084b;">Delete</a>
                                       </li>
                                    </ul>
                                 
                                 </td>
                              </tr>

                              <div class="modal fade customerview-modal-xl{{ $customer_data['id'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="customerviewLargeModalLabel{{ $customer_data['id'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.customer.view')
                              </div>
                              <div class="modal fade customerdelete-modal-xl{{ $customer_data['id'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="customerdeleteLargeModalLabel{{ $customer_data['id'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.customer.delete')
                              </div>
                                 @endif
                              @else


                              <tr>
                                 <td>{{ $customer_data['name'] }}</td>
                                 <td>{{ $customer_data['address'] }}</td>
                                 <td>{{ $customer_data['phonenumber'] }}</td>
                                 <td>{{ $customer_data['email_id'] }}</td>
                                 <td>{{ $customer_data['employee'] }}</td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                          <a class="badge" href="#customerview{{ $customer_data['id'] }}" data-bs-toggle="modal"
                                          data-bs-target=".customerview-modal-xl{{ $customer_data['id'] }}" style="color: #f8f9fa;background: #8068dc;">View</a>
                                       </li>
                                       <li>
                                          <a href="{{ route('customer.edit', ['id' => $customer_data['id']]) }}"
                                                   class="badge bg-warning-light" style="color:#28084b;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $customer_data['id'] }}" data-bs-toggle="modal"
                                          data-bs-target=".customerdelete-modal-xl{{ $customer_data['id'] }}" class="badge bg-danger-light" style="color: #28084b;">Delete</a>
                                       </li>
                                    </ul>
                                 
                                 </td>
                              </tr>

                              <div class="modal fade customerview-modal-xl{{ $customer_data['id'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="customerviewLargeModalLabel{{ $customer_data['id'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.customer.view')
                              </div>
                              <div class="modal fade customerdelete-modal-xl{{ $customer_data['id'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="customerdeleteLargeModalLabel{{ $customer_data['id'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.customer.delete')
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






   </div>
</div>
@endsection