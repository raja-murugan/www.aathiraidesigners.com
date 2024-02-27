@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">


      <div class="page-header">
         <div class="content-page-header">
            <h6>New payoff</h6>
         </div>
      </div>


      <div class="row">
         <div class="col-sm-12">


            <div class="card">
               <div class="card-body">

                     <form autocomplete="off" method="POST" action="{{ route('payoff.store') }}" enctype="multipart/form-data">
                     @csrf
   

                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group-item border-0 mb-0">
                                 <div class="row align-item-center">

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Date <span class="text-danger">*</span></label>
                                          <input type="date" value="{{ $today }}" class="form-control"  name="date" id="date"  required>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Year <span class="text-danger">*</span></label>
                                          <select class="form-control salary_year select" name="salary_year" id="salary_year" required>
                                             <option value="" selected hidden class="text-muted">Select </option>
                                             @foreach ($years_arr as $years_array)
                                             <option value="{{ $years_array }} "@if ($years_array == $current_year) selected='selected' @endif>{{ $years_array }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Month<span class="text-danger">*</span></label>
                                          <input type="date" class="form-control"  name="delivery_date" id="delivery_date"  required>
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
                                                   <th style="width:14%">Rate / Qty</th>
                                                   <th style="width:19%">Total</th>
                                                   <th style="width:7%" class="no-sort">Action</th>
                                                </tr>
                                             </thead>
                                             <tbody class="billingold_products"></div>
                                             <tbody class="billing_products">

                                                <tr>
                                                   <td>
                                                      <input type="hidden" id="billingproducts_id" name="billingproducts_id[]" />
                                                      <input type="hidden" class="form-control customer_product_id" id="customer_product_id1" name="customer_product_id[]" />
                                                            <select
                                                                class="form-control  billing_product_id select js-example-basic-single"
                                                                name="billing_product_id[]" id="billing_product_id1" required>
                                                                <option value="" selected disabled class="text-muted">
                                                                    Select Product
                                                                </option>
                                                               
                                                            </select>
                                                   </td>
                                                   <td><input type="text" class="form-control billing_measurement" id="billing_measurement"
                                                          name="billing_measurement[]" placeholder="Measurement" /></td>

                                                   <td><input type="text" class="form-control billing_qty" id="billing_qty"
                                                          name="billing_qty[]" placeholder="Qty" /></td>

                                                   <td><input type="text" class="form-control billing_rateperqty" id="billing_rateperqty"
                                                          name="billing_rateperqty[]" placeholder="Rate / Qty" />
                                                         </td>

                                                   <td><input type="text" class="form-control billing_total" id="billing_total"
                                                          name="billing_total[]" readonly />
                                                      </td>

                                                   <td class="align-items-center">
                                                         <button class="additemplus_button addbillingproducts" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>
                                                         <button class="additemminus_button remove-billingtr" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button>
                                                   </td>
                                                </tr>

                                             </tbody>
                                             <tbody>
                                                <tr>
                                                   <td></td>
                                                   <td></td>
                                                   <td></td>
                                                   <td style="text-align:right;font-size:15px;">Total</td>
                                                   <td><input type="text" class="form-control total_amount"  name="total_amount" id="total_amount" readonly></td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </div>
                              </div>



                             


                        </div>













                           <div class="text-end" style="margin-top:3%">
                                          <input type="submit" class="btn btn-primary" />
                                          <a href="{{ route('billing.index') }}" class="btn btn-cancel btn-danger" >Cancel</a>
                           </div>
                       
      

                     </form>

               </div>
            </div>

         </div>
      </div>



   </div>
</div>


@endsection

