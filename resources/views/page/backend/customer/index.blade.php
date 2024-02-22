@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Customer</h6>
                    <div class="list-btn">
                            <div style="display: flex;">
                                <ul class="filter-list">
                                    <li><a class="btn btn-primary" href="{{ route('customer.create') }}"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Customer</a></li>
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
                                 <th style="width:10%">S.No</th>
                                 <th style="width:20%">Name</th>
                                 <th style="width:15%">Phone No</th>
                                 <th style="width:20%">Products</th>
                                 <th style="width:20%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($Customer_data as $keydata => $Customer_datas)
                              <tr>
                                 <td>{{ ++$keydata }}</td>
                                 <td>{{ $Customer_datas['name'] }}</td>
                                 <td>{{ $Customer_datas['phone_number'] }}</td>
                                 <td style="text-transform:uppercase">
                                       @foreach ($Customer_datas['productsarr'] as $index => $terms_array)
                                                    @if ($terms_array['customer_id'] == $Customer_datas['id'])
                                                    {{ $terms_array['product'] }} -  {{ $terms_array['measurements'] }} <br/>
                                                    @endif
                                                    @endforeach
                                 </td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                          <a href="{{ route('customer.edit', ['unique_key' => $Customer_datas['unique_key']]) }}"
                                             class="badge bg-warning-light" style="color:#28084b;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $Customer_datas['unique_key'] }}" data-bs-toggle="modal"
                                          data-bs-target=".customerdelete-modal-xl{{ $Customer_datas['unique_key'] }}" class="badge bg-danger-light" style="color: #28084b;">Delete</a>
                                       </li>
                                    </ul>

                                 </td>
                              </tr>

                             
                              <div class="modal fade customerdelete-modal-xl{{ $Customer_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="customerdeleteLargeModalLabel{{ $Customer_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.customer.delete')
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
