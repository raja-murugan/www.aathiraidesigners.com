<div class="modal-dialog modal-dialog-centered modal-l">
   <div class="modal-content">

      <div class="modal-header border-0 pb-0">
         <div class="form-header modal-header-title text-start mb-0">
            <h6 class="mb-0">Update Product</h6>
         </div>
         <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span class="align-center" aria-hidden="true">&times;</span>
         </button>
      </div>
      <form autocomplete="off" method="POST" action="{{ route('product.edit', ['unique_key' => $product_data->unique_key]) }}"  enctype="multipart/form-data">
      @csrf
      <div class="modal-body">
         <div class="row">
               <div class="col-lg-12 col-md-12">
                  <div class="form-group">
                     <label>Name <span class="text-danger">*</span></label>
                     <input type="text" class="form-control" placeholder="Enter Product Name" name="name" id="name" value="{{$product_data->name}}" required>
                  </div>
               </div>
               <div class="col-lg-12 col-md-12">
                  <div class="form-group">
                     <label>Description</label>
                     <textarea name="description" id="description" class="form-control" placeholder="Enter Description">{{$product_data->description}}</textarea>
                  </div>
               </div>
               <div class="col-lg-12 col-md-12">
                  <div class="form-group">
                     <label>Image</label>
                     <div style="display: flex">
                        <div><img src="{{ asset('assets/product_image/' . $product_data->image) }}" alt="" style="width: 150px !important; height: 150px !important; margin-right: 20px !important; "></div>
                      </div>
                     <input type="file" name="product_image" id="product_image" class="form-control product_image" />
                  </div>
               </div>
         </div>
      </div>

      <div class="modal-footer">
         <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Save</button>
         <button type="button" class="btn btn-cancel btn-danger" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
      </div>
      </form>
   </div>
</div>
