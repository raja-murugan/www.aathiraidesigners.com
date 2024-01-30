<div class="modal-dialog modal-dialog-centered modal-md">
   <div class="modal-content">

      <div class="modal-header border-0 pb-0">
         <div class="form-header modal-header-title text-start mb-0">
            <h6 class="mb-0">CHECK IN</h6>
         </div>
         <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span class="align-center" aria-hidden="true">&times;</span>
         </button>
      </div>
      <form autocomplete="off" method="POST" action="{{ route('attendance.checkinstore') }}" enctype="multipart/form-data">
      @csrf
      <div class="modal-body">
         <div class="row">
               <div class="col-lg-6 col-md-6" hidden>
                  <div class="form-group">
                     <label>Date <span class="text-danger">*</span></label>
                     <input type="date" class="form-control"  name="date" id="date" value="{{$today}}" required>
                  </div>
               </div>
               <div class="col-lg-6 col-md-6" hidden>
                  <div class="form-group">
                     <label>Time <span class="text-danger">*</span></label>
                     <input type="time" class="form-control" name="time" id="time" value="{{$timenow}}">
                  </div>
               </div>
               <div class="col-lg-6 col-md-6">
                  <div class="form-group">
                     <input type="text" class="form-control" name="employee" id="employee" value="{{ $Attendance_datas['employee'] }}" readonly>
                  </div>
               </div>
               <div class="col-lg-6 col-md-6" hidden>
                  <div class="form-group">
                     <label>Employee ID</label>
                     <input type="text" class="form-control" name="employee_id" id="employee_id" value="{{ $Attendance_datas['id'] }}" readonly>
                  </div>
               </div>

               <div class="row align-item-center">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                              <div style="display: flex">
                                 <div id="checin_camera{{ $Attendance_datas['id'] }}"></div>
                                 <div id="captured_checinimage{{ $Attendance_datas['id'] }}"></div>
                              </div>
                              <input type="button" class=" btn btn-sm" value="Take a Snap" onClick="takechecinsnapshot()" style="background: #d8e4ce;">
                              <input type="hidden" class="form-control image-checincamera{{ $Attendance_datas['id'] }}" name="checkin_photo" id="checkin_photo">
                        </div>
                  </div>
               </div>
             
          

              
         </div>
      </div>

      <div class="modal-footer">
         <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Check-In</button>
      </div>
      </form>
   </div>
</div>

