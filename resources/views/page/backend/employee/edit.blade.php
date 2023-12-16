<div class="modal-dialog modal-dialog-centered modal-xl">
   <div class="modal-content">

      <div class="modal-header border-0 pb-0">
         <div class="form-header modal-header-title text-start mb-0">
            <h6 class="mb-0">Update Employee</h6>
         </div>
         <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span class="align-center" aria-hidden="true">&times;</span>
         </button>
      </div>
      <form autocomplete="off" method="POST" action="{{ route('employee.edit', ['unique_key' => $employee_data->unique_key]) }}">
      @csrf
      <div class="modal-body">
         <div class="row">
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <label>Name <span class="text-danger">*</span></label>
                     <input type="text" class="form-control" placeholder="Enter Employee Name" name="name" id="name" required value="{{$employee_data->name}}">
                  </div>
               </div>
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <label>Phone Number <span class="text-danger">*</span></label>
                     <input type="text" class="form-control customer_phoneno" placeholder="Enter Employee Contact No" name="phonenumber" value="{{$employee_data->phonenumber}}" id="emp_phonenumber" required>
                  </div>
               </div>
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <label>Alternate Phone Number <span class="text-danger">*</span></label>
                     <input type="text" class="form-control customer_phoneno" placeholder="Enter Employee Alternate Contact No" name="alter_phonenumber" value="{{$employee_data->alter_phonenumber}}" id="alter_phonenumber">
                  </div>
               </div>
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <label>Email ID <span class="text-danger">*</span></label>
                     <input type="email" class="form-control" placeholder="Enter Employee E-Mail" name="email_id" id="email_id" value="{{$employee_data->email_id}}" required>
                  </div>
               </div>
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <label>Address</label>
                     <textarea name="address" id="address" class="form-control" placeholder="Enter Address">{{$employee_data->address}}</textarea>
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
