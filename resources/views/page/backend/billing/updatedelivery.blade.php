<div class="modal-dialog modal-dialog-centered modal-l">
      <div class="modal-content modal-filled">
         <div class="modal-body">
            <div class="form-header">
               <h6 class="text-black">Update Delivery Status</h6>
            </div>
            <div class="modal-btn delete-action">
               <div class="row">

                  <form autocomplete="off" method="POST" action="{{ route('billing.updatedelivery', [$Billing_datas['unique_key']]) }}">
                     @method('PUT')
                     @csrf
                     <div class="row">
                        <div class="col-lg-6 col-md-6">
                           <div class="form-group">
                              <label>Date <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" value="{{ $today }}" name="pb_date">
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-6 col-md-6">
                           <div class="form-group">
                              <button type="submit" class="btn btn-primary ">Yes, Delivered</button>
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                           <div class="form-group">
                              <a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel</a>
                           </div>
                        </div>
                     </div>

                  </form>

               </div>
            </div>
         </div>
      </div>
</div>
