@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">


      <div class="page-header">
         <div class="content-page-header">
            <h6>Update Billing</h6>
         </div>
      </div>


      <div class="row">
         <div class="col-sm-12">


            <div class="card">
               <div class="card-body">

                     <form autocomplete="off" method="POST" action="{{ route('billing.update', ['unique_key' => $BillingData->unique_key]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
   

                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group-item border-0 mb-0">
                                 <div class="row align-item-center">
                                 
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >BillNo <span class="text-danger">*</span></label>
                                          <input type="text" value="{{$BillingData->billno}}" class="form-control"  name="billno" id="billno" readonly>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Date <span class="text-danger">*</span></label>
                                          <input type="date" value="{{$BillingData->date}}" class="form-control"  name="date" id="date"  required>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Time <span class="text-danger">*</span></label>
                                          <input type="time" value="{{$BillingData->time}}" class="form-control"  name="time" id="time" required>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Delivery Date <span class="text-danger">*</span></label>
                                          <input type="date" class="form-control"  name="delivery_date" id="delivery_date" value="{{$BillingData->delivery_date}}" required>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Delivery Time <span class="text-danger">*</span></label>
                                          <input type="time" class="form-control"  name="delivery_time" id="delivery_time" required value="{{$BillingData->delivery_time}}">
                                       </div>
                                    </div>
                                    
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Customer <span class="text-danger">*</span></label>
                                          <select  class="form-control  select js-example-basic-single billing_customerid" name="customer_id" id="customer_id" disabled>
                                             <option value="" selected disabled class="text-muted"> Select Customer </option>
                                             @foreach ($customers as $customers_arr)
                                                <option value="{{ $customers_arr->id }}"@if ($customers_arr->id === $BillingData->customer_id) selected='selected' @endif>{{ $customers_arr->name }}</option>
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
                                                            <th style="width:10%">Qty</th>
                                                            <th style="width:14%">Rate / Qty</th>
                                                            <th style="width:19%">Total</th>
                                                            <th style="width:7%" class="no-sort">Action</th>
                                                         </tr>
                                                      </thead>
                                                      <tbody class="billingold_products">
                                                      @foreach ($BillingProducts as $index => $BillingProductsarr)
                                                         <tr>
                                                            <td>
                                                               <input type="hidden" id="billingproducts_id" name="billingproducts_id[]" value="{{ $BillingProductsarr->id }}"/>
                                                               <input type="hidden" class="form-control customer_product_id" id="customer_product_id1" name="customer_product_id[]" value="{{ $BillingProductsarr->customer_product_id }}"/>
                                                                     <select
                                                                        class="form-control  billing_product_id select js-example-basic-single"
                                                                        name="billing_product_id[]" id="billing_product_id1" required>
                                                                        <option value="" selected disabled class="text-muted">
                                                                           Select Product
                                                                        </option>
                                                                        @foreach ($Customer_data as $Customer_datas)
                                                                        
                                                                           <option value="{{ $Customer_datas['id'] }}"@if ($Customer_datas['id'] === $BillingProductsarr->billing_product_id) selected='selected' @endif>
                                                                                 {{ $Customer_datas['name'] }}
                                                                           </option>
                                                                        @endforeach
                                                                     </select>
                                                            </td>

                                                            <td><input type="text" class="form-control billing_qty" id="billing_qty"
                                                                  name="billing_qty[]" placeholder="Qty" value="{{ $BillingProductsarr->billing_qty }}"/></td>

                                                            <td><input type="text" class="form-control billing_rateperqty" id="billing_rateperqty"
                                                                  name="billing_rateperqty[]" placeholder="Rate / Qty" value="{{ $BillingProductsarr->billing_rateperqty }}"/>
                                                                  </td>

                                                            <td><input type="text" class="form-control billing_total" id="billing_total"
                                                                  name="billing_total[]" readonly value="{{ $BillingProductsarr->billing_total }}"/>
                                                               </td>

                                                            <td class="align-items-center">
                                                                  <button class="additemplus_button addbillingproducts" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>
                                                                  <button class="additemminus_button remove-billingtr" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button>
                                                            </td>
                                                         </tr>
                                                         @endforeach
                                                      </div>
                                                      <tbody class="billing_products"></tbody>
                                                      <tbody>
                                                         <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td style="text-align:right;font-size:15px;">Total</td>
                                                            <td><input type="text" class="form-control total_amount"  name="total_amount" id="total_amount" value="{{ $BillingData->total_amount }}" readonly></td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                </div>
                                             </div>



                                          <div class="row">
                                             <div class="col-lg-4 col-md-6 col-sm-12" hidden>
                                                <div class="form-group">
                                                   <label >Discount Type<span class="text-danger">*</span></label>
                                                   <select  class="form-control  select js-example-basic-single billingdiscount_type" name="billingdiscount_type" id="billingdiscount_type" required>
                                                      <option value="none" selected > Select </option>
                                                         <option value="Fixed"@if ('Fixed' === $BillingData->discount_type) selected='selected' @endif>Fixed</option>
                                                   </select>
                                                </div>
                                             </div>
                                             <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="form-group">
                                                   <label >Discount Amount<span class="text-danger">*</span></label>
                                                   <input type="text" class="form-control billingdiscount"  name="discount" id="discount" placeholder="0"  value="{{ $BillingData->discount }}">
                                                </div>
                                             </div>


                                             <div class="col-lg-8 col-md-8 col-sm-12">
                                                <div class="row mb-4">
                                                   <div class="form-group">
                                                     
                                                         <div class="col-sm-9">
                                                            <table class="table-fixed col-12 " id="">
                                                                <tr>
                                                                    <th>Terms</th>
                                                                    <th>Amount</th>
                                                                    <th>Payment Method</th>
                                                                </tr>
                                                                @foreach ($BillingPayments as $index => $paymentdatas)
                                                                    <script>
                                                                        $(document).on("keyup", '#payable_amount' + {{ $paymentdatas->id }}, function() {
                                                                            var payableamount = $(this).val();
                                                                            var totalAmount = 0;
                                                                            $("input[name='payable_amount[]']").each(function() {
                                                                                //alert($(this).val());
                                                                                totalAmount = Number(totalAmount) + Number($(this).val());
                                                                                $('.billing_paidamount').val(totalAmount);
                                                                            });
                                                                            var total = $('.billing_grandtotalamount').val();
                                                                            var Balance = Number(total) - Number(totalAmount);
                                                                            $('.billing_balanceamount').val(Balance.toFixed(2));
                                                                            $('.billing_balance').text('₹ ' + Balance.toFixed(2));
                                                                        });
                                                                    </script>

                                                                    <tr>
                                                                        <td class="col-sm-3">
                                                                            <select class="form-control  select" name="payment_term[]">
                                                                                <option value="" selected class="text-muted">Terms</option>
                                                                                <option
                                                                                    value="Term I"{{ $paymentdatas->payment_term == 'Term I' ? 'selected' : '' }}>Term I</option>
                                                                                <option
                                                                                    value="Term II"{{ $paymentdatas->payment_term == 'Term II' ? 'selected' : '' }}>Term II</option>
                                                                                <option
                                                                                    value="Term III"{{ $paymentdatas->payment_term == 'Term III' ? 'selected' : '' }}>Term III</option>
                                                                            </select>
                                                                        </td>
                                                                        <td class="col-sm-3">
                                                                            <input type="text" class="form-control payable_amount"  id="payable_amount{{ $paymentdatas->id }}"
                                                                                value="{{ $paymentdatas->payment_paid_amount }}" name="payable_amount[]" placeholder="Enter here ">
                                                                            <input type="hidden" class="form-control payment_id" value="{{ $paymentdatas->id }}"  name="payment_id[]"
                                                                                placeholder="Enter here ">
                                                                        </td>
                                                                        <td class="col-sm-3">
                                                                            <select class="form-control  select" name="payment_method[]">
                                                                                <option value="" selected hidden class="text-muted">Select Payment Via </option>
                                                                                <option value="GPay"{{ $paymentdatas->payment_method == 'GPay' ? 'selected' : '' }}>GPay</option>
                                                                                 <option value="Cash"{{ $paymentdatas->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                                                                                 <option value="PhonePay"{{ $paymentdatas->payment_method == 'PhonePay' ? 'selected' : '' }}>PhonePay</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                                

                                                            </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>

                                                   


                                          <div class="form-group-item border-0 p-0 py-3">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-12">
                                                    <div class="form-group-bank">
                                                        <div class="form-group notes-form-group-info">
                                                            <label>Notes <span class="text-danger">*</span></label>
                                                            <textarea class="form-control" placeholder="Enter Notes" name="billing_note" id="billing_note" required>{{ $BillingData->note }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-12">
                                                    <div class="form-group-bank">
                                                        <div class="invoice-total-box">

                                                            <div class="invoice-total-footer">
                                                                <h4 style="text-transform:uppercase;">Total <span class="billing_totalamount"> {{ $BillingData->total_amount }} </span></h4>
                                                            </div>
                                                            <div class="invoice-total-footer">
                                                                <h4 style="text-transform:uppercase;">Discount <span class="billing_discount">  {{ $BillingData->total_discountamount }}</span></h4>
                                                                <input type="hidden" class="form-control billing_discountamount" name="billing_discountamount" id="billing_discountamount" value="{{ $BillingData->total_discountamount }}">

                                                            </div>
                                                            <div class="invoice-total-footer">
                                                                <h4 style="text-transform:uppercase;color:green;">Grand Total <span class="billing_grandtotal">  {{ $BillingData->grand_total }}</span></h4>
                                                                <input type="hidden" class="form-control billing_grandtotalamount" name="billing_grandtotalamount" id="billing_grandtotalamount" value="{{ $BillingData->grand_total }}">
                                                            </div>
                                                            <div class="invoice-total-footer py-2">
                                                                <h4 style="text-transform:uppercase;">Paid Amount <span class="">
                                                               <input type="text" class="form-control billing_paidamount"  readonly name="billing_paidamount" id="billing_paidamount" placeholder="Enter Payable Amount" value="{{ $BillingData->total_paid_amount }}"> </span></h4>
                                                            </div>
                                                            <div class="invoice-total-footer">
                                                                <h4 style="text-transform:uppercase;color:red;">Balance<span class="billing_balance">{{ $BillingData->total_balance_amount }} </span></h4>
                                                                <input type="hidden" class="form-control billing_balanceamount"  name="billing_balanceamount" id="billing_balanceamount" value="{{ $BillingData->total_balance_amount }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

