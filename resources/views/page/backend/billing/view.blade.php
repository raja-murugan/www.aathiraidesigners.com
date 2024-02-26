<div class="modal-dialog modal-dialog-centered modal-xl">
   <div class="modal-content">

         <div class="modal-header border-0 pb-0">
            <div class="form-header modal-header-title text-start mb-0">
            <h6 class="mb-0" style="color:green">Billing</h6>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span class="align-center" aria-hidden="true">&times;</span>
            </button>
         </div>

        

            <div class="modal-body">
               <div class="content container-fluid border">

               


                           <div class="invoice-item invoice-item-date ">
                              <div class="row">
                                 <div class="col-md-3" >
                                    <p class="text-start invoice-details" style="color:#000;text-transform: uppercase;">
                                       Bill Number<span>: </span><strong style="color:red;"># {{ $Billing_datas['billno'] }}</strong>
                                    </p>
                                 </div>
                                 <div class="col-md-2">
                                    <p class="text-start invoice-details" style="color:#000;text-transform: uppercase;">
                                       Date<span>: </span><strong style="color:red;">{{ date('M d Y', strtotime($Billing_datas['date'])) }}</strong>
                                    </p>
                                 </div>
                                 <div class="col-md-3">
                                    <p class="invoice-details" style="color:#000;text-transform: uppercase;">
                                       Customer<span>: </span><strong style="color:red;text-transform: uppercase;">{{ $Billing_datas['customer'] }}</strong>
                                    </p>
                                 </div>
                                 <div class="col-md-4">
                                    <p class="invoice-details" style="color:#000;text-transform: uppercase;">
                                       Delivery Date & Time<span>: </span><strong style="color:red;text-transform: uppercase;">{{ date('M d Y', strtotime($Billing_datas['delivery_date'])) }}({{ date('h:i A', strtotime($Billing_datas['delivery_time'])) }})</strong>
                                    </p>
                                 </div>
                              </div>
                           </div>


                           <div class="invoice-item invoice-item-two">
                              <div class="" style="font-size: 16px;color: #198754;font-weight: 600;"><h7>PRODUCTS</h7></div>
                              
                              <div class="row">
                                 <div class="col-md-3 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; text-transform: uppercase;">Product</span>
                                 </div>
                                 <div class="col-md-3 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px;text-transform: uppercase; ">Measurement</span>
                                 </div>
                                 <div class="col-md-1 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px;text-transform: uppercase; ">Qty</span>
                                 </div><div class="col-md-2 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px;text-transform: uppercase; ">Rate / Qty</span>
                                 </div>
                                 <div class="col-md-2 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px;text-transform: uppercase; ">Total</span>
                                 </div>

                              </div>
                              <div class="row ">
                                 @foreach ($Billing_datas['productsarr'] as $index => $products_data)
                                    @if ($products_data['billing_id'] == $Billing_datas['id'])
                                    <div class="col-md-3 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px;text-transform: uppercase; ">{{ $products_data['product'] }}</span>
                                    </div>
                                    <div class="col-md-3 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px;text-transform: uppercase; ">{{ $products_data['billing_measurement'] }}</span>
                                    </div>
                                    <div class="col-md-1 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px;text-transform: uppercase; ">{{ $products_data['billing_qty'] }}</span>
                                    </div>
                                    <div class="col-md-2 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px;text-transform: uppercase; ">{{ $products_data['billing_rateperqty'] }}</span>
                                    </div>
                                    <div class="col-md-2 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; text-transform: uppercase;">{{ $products_data['billing_total'] }}</span>
                                    </div>
                                    @endif
                                 @endforeach
                              </div>


                           <div class="invoice-item invoice-item-two">
                              <div class="" style="font-size: 16px;color: #198754;font-weight: 600;"><h7>PAYMENTS</h7></div>
                              <div class="row">
                                 <div class="col-md-3 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; text-transform: uppercase;">Date</span>
                                 </div>
                                 <div class="col-md-3 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px;text-transform: uppercase; ">Amount</span>
                                 </div>
                                 <div class="col-md-3 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px;text-transform: uppercase; ">Term</span>
                                 </div><div class="col-md-3 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px;text-transform: uppercase; ">Payment Method</span>
                                 </div>

                              </div>
                              <div class="row ">
                                 @foreach ($Billing_datas['billing_payment_arr'] as $index => $billing_payment_arr)
                                    @if ($billing_payment_arr['billing_id'] == $Billing_datas['id'])
                                    <div class="col-md-3 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px;text-transform: uppercase; ">{{ $billing_payment_arr['payment_paid_date'] }}</span>
                                    </div>
                                    <div class="col-md-3 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px;text-transform: uppercase; ">{{ $billing_payment_arr['payment_paid_amount'] }}</span>
                                    </div>
                                    <div class="col-md-3 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px;text-transform: uppercase; ">{{ $billing_payment_arr['payment_term'] }}</span>
                                    </div>
                                    <div class="col-md-3 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px;text-transform: uppercase; ">{{ $billing_payment_arr['payment_method'] }}</span>
                                    </div>
                                    @endif
                                 @endforeach
                              </div>


                           </div>




                           <div class="terms-conditions">
                              <div class="row align-items-center justify-content-between">

                                    <div class="col-xl-6 col-lg-12">
                                       <div class="invoice-total-card  form-group-bank">
                                          <div class="invoice-total-box">
                                             <div class="invoice-total-inner">
                                                <p style="text-transform: uppercase;">Note <span >{{ $Billing_datas['note'] }}</span></p>
                                                <p style="text-transform: uppercase;">Total Amount<span >₹ {{ $Billing_datas['total_amount'] }}</span></p>
                                                <p style="text-transform: uppercase;">Discount<span>₹ {{ $Billing_datas['total_discountamount'] }}</span></p>
                                             </div>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-12">
                                       <div class="invoice-total-card  form-group-bank">
                                          <div class="invoice-total-box">
                                             <div class="invoice-total-inner">
                                                <p style="color: #0d6efd;text-transform: uppercase;">Grand Total <span style="color: #0d6efd;">₹ {{ $Billing_datas['grand_total'] }}</span></p>
                                                <p style="color:green;text-transform: uppercase;">Paid Amount <span style="color:green">₹ {{ $Billing_datas['total_paid_amount'] }}</span></p>
                                                <p style="color:red;text-transform: uppercase;">Balance Amount <span style="color:red">₹ {{ $Billing_datas['total_balance_amount'] }}</span></p>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                              </div>
                           </div>


  

               </div>
            </div>
   </div>
</div>

           
   </div>
</div>