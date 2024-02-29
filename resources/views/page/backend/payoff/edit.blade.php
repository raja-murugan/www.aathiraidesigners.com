<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

        <div class="modal-header border-0 pb-0">
            <div class="form-header modal-header-title text-start mb-0">
                <h6 class="mb-0">Update  Payoff</h6>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span class="align-center" aria-hidden="true">&times;</span>
            </button>
        </div>
        <form autocomplete="off" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
               <div class="row align-item-center">
                  <div class="col-lg-4 col-md-4 col-sm-4">
                     <div class="form-group">
                        <label >Name</label>
                        <input type="text"  class="form-control payoff_employee" value="" readonly>
                     </div>
                  </div>
               </div>

                  <div class="row align-item-center">
                     <div class="col-lg-12 col-md-12 col-sm-12">
                           <div class="form-group ">
                           <label >Salary</label>   
                                    <div class="payoff_edits">  
                                    </div>
                           </div>
                     </div>
                  </div>



            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Update</button>
                <button type="button" class="btn btn-cancel btn-danger" data-bs-dismiss="modal"
                    aria-label="Close">Cancel</button>
            </div>
        </form>
    </div>
</div>
