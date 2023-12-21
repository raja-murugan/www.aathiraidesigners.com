<div class="modal-dialog modal-dialog-centered modal-md">
   <div class="modal-content">

      <div class="modal-header border-0 pb-0">
         <div class="form-header modal-header-title text-start mb-0">
            <h6 class="mb-0">Add Employee</h6>
         </div>
         <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span class="align-center" aria-hidden="true">&times;</span>
         </button>
      </div>
      <form autocomplete="off" method="POST" action="{{ route('employee.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="modal-body">
         <div class="row">
               <div class="col-lg-12 col-md-12">
                  <div class="form-group">
                     <label>Name <span class="text-danger">*</span></label>
                     <input type="text" class="form-control" placeholder="Enter Employee Name" name="name" id="name" required>
                  </div>
               </div>
               <div class="col-lg-12 col-md-12">
                  <div class="form-group">
                     <label>Phone Number<span class="text-danger">*</span></label>
                     <input type="text" class="form-control employee_phoneno" placeholder="Enter Employee Contact No" name="phone_number" id="phone_number" required>
                  </div>
               </div>
               <div class="col-lg-12 col-md-12">
                  <div class="form-group">
                     <label>Address</label>
                     <input type="text" class="form-control" placeholder="Enter Employee Address" name="address" id="address">
                  </div>
               </div>
               <div class="col-lg-12 col-md-12">
                  <div class="form-group">
                     <label>Salary per Hour</label>
                     <input type="number" class="form-control" placeholder="Enter Employee Salary per Hour" name="salaray_per_hour" id="salaray_per_hour">
                  </div>
               </div>
               <div class="col-lg-12 col-md-12" hidden>
                  <div class="form-group">
                     <label>Photo</label>
                        <div class="col-sm-7">
                           <div style="display: flex">
                              <div id="my_camera"></div>
                              <div id="captured_cameraimage"></div>
                           </div>
                           <input type=button class=" btn btn-sm btn-soft-primary"value="Take a Snap - Photo"onClick="takesnapshot()">
                           <input type="hidden" class="form-control image-tagcamera" name="employee_photo">
                        </div>
                  </div>
               </div>

               <div class="col-lg-12 col-md-12">
                  <div class="form-group">
                     <label>Photo</label>
                     <input type="file" class="form-control" name="employee_photo">
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
<script>
    Webcam.set({
            width: 300,
            height: 300,
            image_format: 'jpeg',
            jpeg_quality: 90,
            facingMode: 'environment'
        });

        Webcam.attach('#my_camera');

        function takesnapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-tagcamera").val(data_uri);
                document.getElementById('captured_cameraimage').innerHTML = '<img src="' + data_uri +
                    '" style="height: 220px !important;width: 300px !important;margin-top: 40px;margin-left: 40px;"/>';
            });
        }
</script>
