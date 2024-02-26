<form autocomplete="off" method="POST" action="{{ route('income.store') }}" enctype="multipart/form-data">
@csrf
   <div class="card">
      <div class="card-body">
         <div class="form-group-item border-0 mb-0">
            <div class="row align-item-center">

                  <div class="col-lg-12 col-md-12 col-sm-12">
                     <div class="form-group">
                        <label >Date <span class="text-danger">*</span></label>
                        <input type="date" value="{{$today}}" class="form-control " name="date" id="date" required>
                     </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                     <div class="form-group">
                        <label >Time <span class="text-danger">*</span></label>
                        <input type="time" value="{{$timenow}}" class="form-control " name="time" id="time" required>
                     </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                     <div class="form-group">
                        <label >Amount <span class="text-danger">*</span></label>
                        <input type="text"  class="form-control " name="amount" id="amount" required>
                     </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                     <div class="form-group">
                        <label >Reason <span class="text-danger">*</span></label>
                        <textarea type="text" name="description" id="description" class="form-control " ></textarea>
                     </div>
                  </div>
            </div>
            <div class="text-end" style="margin-top:3%">
                           <input type="submit" class="btn btn-primary" /> </div>
         </div>
      </div>
   </div>

</form>