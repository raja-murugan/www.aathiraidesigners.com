@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">


      <div class="page-header">
         <div class="content-page-header">
            <h6>Update Customer</h6>
         </div>
      </div>


      <div class="row">
         <div class="col-sm-12">


            <div class="card">
               <div class="card-body">

                    <form autocomplete="off" method="POST" action="{{ route('customer.update', ['unique_key' => $CustomerData->unique_key]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
   
                        <div class="form-group-item border-0 mb-0">


                           <div class="row align-item-center">
                                 <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                       <label >Customer <span class="text-danger">*</span></label>
                                       <input type="text" value="{{$CustomerData->name}}" class="form-control" placeholder="Enter Customer Name" name="name" id="name" required>
                                    </div>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                       <label >Contact Number <span class="text-danger">*</span></label>
                                       <input type="text" value="{{$CustomerData->phone_number}}" class="form-control customerphoneno" placeholder="Enter Contact Number" name="phone_number" id="phone_number"required>
                                    </div>
                                 </div>
                           </div>
                        </div>



                                 <div class="form-group-item border-0 mb-0">
                                    <div class="row align-item-center">
                                       <div class="col-lg-12 col-md-12 col-sm-12">


                                          <div class="table-responsive no-pagination">
                                            <table class="table table-center table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                            <th style="width:35%;">Product</th>
                                                            <th style="width:50%;">Measurements</th>
                                                            <th style="width:10%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="product_fields">
                                                @foreach ($CustomerProducts as $index => $CustomerProductsarr)
                                                    <tr>
                                                        <td>
                                                        <input type="hidden" id="customer_products_id" name="customer_products_id[]" value="{{ $CustomerProductsarr->id }}"/>
                                                            <select
                                                                class="form-control  product_id select js-example-basic-single"
                                                                name="product_id[]" id="product_id1" disabled>
                                                                <option value="" selected disabled class="text-muted">
                                                                    Select Product
                                                                </option>
                                                                @foreach ($products as $products_arr)
                                                                    <option value="{{ $products_arr->id }}"@if ($products_arr->id === $CustomerProductsarr->product_id) selected='selected' @endif>
                                                                        {{ $products_arr->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <table class="table">
                                                                  @foreach ($CustomerProductMeasurements as $index => $CustomerProductMeasurementss)
                                                                     @if($CustomerProductMeasurementss->customer_product_id == $CustomerProductsarr->id)
                                                                        <tr>
                                                                           <td>
                                                                              <input type="hidden" name="product_customer_mesasurementid[]" value="{{ $CustomerProductMeasurementss->id }}"/>
                                                                              <input type="hidden" name="measurement_id[]" value="{{ $CustomerProductMeasurementss->measurement_id }}"/>
                                                                              <input type="hidden" name="productid[]" value="{{ $CustomerProductMeasurementss->product_id }}"/>
                                                                              <input type="text" class="measurement_name form-control" id="measurement_name" name="measurement_name[]" 
                                                                              value="{{ $CustomerProductMeasurementss->measurement_name }}" readonly>
                                                                           </td>
                                                                           <td>
                                                                              <input type="text"  class=" form-control" id="measurement_no" name="measurement_no[]"
                                                                               value="{{ $CustomerProductMeasurementss->measurement_no }}" placeholder="Enter Measurements"/>
                                                                           </td>
                                                                        </tr>
                                                                     @endif
                                                                  @endforeach
                                                            </table>
                                                            <table class="table"  id="customer_measurements1"></table>
                                                         </td>
                                                        
                                                        <td>
                                                            <button class="btn additemplus_button addproducts" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>
                                                            <button class="btn additemminus_button remove-producttr" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button>
                                                        </td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                          </div>


                                       </div>
                                    </div>
                                 </div>
                                 <hr>

                           <div class="text-end" style="margin-top:3%">
                                          <input type="submit" class="btn btn-primary" />
                                          <a href="{{ route('customer.index') }}" class="btn btn-cancel btn-danger" >Cancel</a>
                           </div>
                       
      

                     </form>

               </div>
            </div>

         </div>
      </div>



   </div>
</div>


@endsection











