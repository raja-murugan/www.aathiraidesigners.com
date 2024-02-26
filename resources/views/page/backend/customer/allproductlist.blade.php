<div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">

        <div class="modal-header border-0 pb-0">
            <div class="form-header modal-header-title text-start mb-0">
                <h6 class="mb-0" style="text-transform:uppercase;color:red;">{{ $Customer_datas['name'] }} -  Products</h6>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span class="align-center" aria-hidden="true">&times;</span>
            </button>
        </div>

            <div class="modal-body">
                <div class="row py-2">

                           <div class="invoice-item ">
                              <div class="row">
                                 <div class="col-md-1 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">S.No</span>
                                 </div>
                                 <div class="col-md-3 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Product</span>
                                 </div>
                                 <div class="col-md-3 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Measurements</span>
                                 </div>
                                 <div class="col-md-1 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Qty</span>
                                 </div>
                                 <div class="col-md-2 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Rate</span>
                                 </div>
                                 <div class="col-md-2 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; ">Status</span>
                                 </div>

                              </div>
                              <div class="row ">
                                 @foreach ($Customer_datas['productsarr'] as $index => $productsarr)
                                    @if ($productsarr['customer_id'] == $Customer_datas['id'])

                                    <div class="col-md-1 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ ++$index }}</span>
                                    </div>
                                    <div class="col-md-3 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $productsarr['product'] }}</span>
                                    </div>
                                    <div class="col-md-3 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $productsarr['measurements'] }}</span>
                                    </div>
                                    <div class="col-md-1 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $productsarr['quantity'] }}</span>
                                    </div>
                                    <div class="col-md-2 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $productsarr['rate'] }}</span>
                                    </div>
                                    <div class="col-md-2 border">
                                          @if($productsarr['status'] == 'Delivered')
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:green;font-weight: 400;line-height: 35px; ">{{ $productsarr['status'] }}</span>
                                          @else
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; ">{{ $productsarr['status'] }}</span>
                                          @endif
                                          
                                    </div>
                                    @endif
                                 @endforeach
                              </div>
                           </div>


                </div>
            </div>

            
    </div>
</div>
