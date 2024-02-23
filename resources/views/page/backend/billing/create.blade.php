@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">


      <div class="page-header">
         <div class="content-page-header">
            <h6>New Billing</h6>
         </div>
      </div>


      <div class="row">
         <div class="col-sm-12">


            <div class="card">
               <div class="card-body">

                     <form autocomplete="off" method="POST" action="{{ route('billing.store') }}" enctype="multipart/form-data">
                     @csrf
   

                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group-item border-0 mb-0">
                                 <div class="row align-item-center">
                                 
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >BillNo <span class="text-danger">*</span></label>
                                          <input type="text" value="{{$billno}}" class="form-control"  name="billno" id="billno" readonly>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Date <span class="text-danger">*</span></label>
                                          <input type="date" value="{{ $today }}" class="form-control"  name="date" id="date"  required>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Time <span class="text-danger">*</span></label>
                                          <input type="time" value="{{ $timenow }}" class="form-control"  name="time" id="time" required>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Delivery Date <span class="text-danger">*</span></label>
                                          <input type="date" class="form-control"  name="delivery_date" id="delivery_date"  required>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Delivery Time <span class="text-danger">*</span></label>
                                          <input type="time" class="form-control"  name="delivery_time" id="delivery_time" required>
                                       </div>
                                    </div>
                                    
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Customer <span class="text-danger">*</span></label>
                                          <select  class="form-control  select js-example-basic-single billing_customerid" name="customer_id[]" id="customer_id" required>
                                             <option value="" selected disabled class="text-muted"> Select Customer </option>
                                             @foreach ($customers as $customers_arr)
                                                <option value="{{ $customers_arr->id }}">{{ $customers_arr->name }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>
                                                  
                                                   
                                 </div>
                              </div>

                                          <br/>

                              <div class="form-group-item">
                                       <div class="table-responsive no-pagination">
                                          <table class="table table-center table-hover">
                                             <thead  style="background: linear-gradient(320deg, #DDCEFF 0%, #DBECFF 100%);">
                                                <tr>
                                                   <th style="width:25%">Product</th>
                                                   <th style="width:25%">Measurement</th>
                                                   <th style="width:10%">Qty</th>
                                                   <th style="width:16%">Rate / Qty</th>
                                                   <th style="width:16%">Total</th>
                                                   <th style="width:8%" class="no-sort">Action</th>
                                                </tr>
                                             </thead>
                                             <tbody class="billingold_products"></div>
                                             <tbody class="billing_products">

                                                <tr>
                                                   <td>
                                                      <input type="hidden" id="billingproducts_id" name="billingproducts_id[]" />
                                                            <select
                                                                class="form-control  billing_product_id select js-example-basic-single"
                                                                name="billing_product_id[]" id="billing_product_id1" required>
                                                                <option value="" selected disabled class="text-muted">
                                                                    Select Product
                                                                </option>
                                                                @foreach ($products as $products_arr)
                                                                    <option value="{{ $products_arr->id }}">
                                                                        {{ $products_arr->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                   </td>
                                                   <td><input type="text" class="form-control billing_measurement" id="billing_measurement"
                                                          name="billing_measurement[]" placeholder="Measurement" /></td>

                                                   <td><input type="text" class="form-control billing_qty" id="billing_qty"
                                                          name="billing_qty[]" placeholder="Qty" /></td>

                                                   <td><input type="text" class="form-control billing_rateperqty" id="billing_rateperqty"
                                                          name="billing_rateperqty[]" placeholder="Rate / Qty" /></td>

                                                   <td><input type="text" class="form-control billing_total" id="billing_total"
                                                          name="billing_total[]" readonly /></td>

                                                   <td class="align-items-center">
                                                         <button class="additemplus_button addbillingproducts" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>
                                                   </td>
                                                </tr>

                                             </tbody>
                                          </table>
                                       </div>
                              </div>







                           </div>
                        </div>













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

