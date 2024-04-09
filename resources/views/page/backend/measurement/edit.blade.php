<div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">

        <div class="modal-header border-0 pb-0">
            <div class="form-header modal-header-title text-start mb-0">
                <h6 class="mb-0">Update Measurements</h6>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span class="align-center" aria-hidden="true">&times;</span>
            </button>
        </div>
        <form autocomplete="off" method="POST"
            action="{{ route('measurement.edit', ['id' => $datas->id]) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
               <div class="row align-item-center">

                  <div class="col-lg-12 col-md-12 col-sm-12">
                     <div class="form-group">
                        <label >Measurement <span class="text-danger">*</span></label>
                        <input type="text"  class="form-control " name="measurement" id="measurement" value="{{$datas->measurement}}" required>
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
