@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Product</h6>
            <div class="list-btn">
                  <div style="display:flex;">
                     <ul class="filter-list">
                        <li><a class="btn btn-primary" href="{{ route('product.create') }}"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Product</a></li>
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
                                 <th style="width:15%">Product</th>
                                 <th style="width:30%">Measurements</th>
                                 <th style="width:20%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($Product_data as $keydata => $Product_datas)
                              <tr>
                                 <td>{{ ++$keydata }}</td>
                                 <td>{{ $Product_datas['name'] }}</td>
                                    <td style="text-transform:uppercase">
                                       @foreach ($Product_datas['measurementssarr'] as $index => $terms_array)
                                                    @if ($terms_array['product_id'] == $Product_datas['id'])
                                                    {{ $terms_array['measurement'] }},
                                                    @endif
                                                    @endforeach
                                 </td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                       <a href="{{ route('product.edit', ['unique_key' => $Product_datas['unique_key']]) }}"
                                             class="badge bg-warning-light" style="color:#28084b;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $Product_datas['unique_key'] }}" data-bs-toggle="modal"
                                          data-bs-target=".productdelete-modal-xl{{ $Product_datas['unique_key'] }}" class="badge bg-danger-light" style="color: #28084b;">Delete</a>
                                       </li>
                                    </ul>

                                 </td>
                              </tr>

                             
                              <div class="modal fade productdelete-modal-xl{{ $Product_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="productdeleteLargeModalLabel{{ $Product_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.product.delete')
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
