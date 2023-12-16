<div class="modal-dialog modal-dialog-centered modal-l">
    <div class="modal-content">

        <div class="modal-header border-0 pb-0">
            <div class="form-header modal-header-title text-start mb-0">
                <h6 class="mb-0">Add Leads</h6>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span class="align-center" aria-hidden="true">&times;</span>
            </button>
        </div>
        <form autocomplete="off" method="POST" action="{{ route('lead.store') }}">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter Lead Name" name="name"
                                id="name" required>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control customer_phoneno"
                                placeholder="Enter Lead Contact No" name="phonenumber" id="phonenumber"
                                required>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                                       <label>Source From <span class="text-danger">*</span></label>
                                                <select class="form-control select source_from js-example-basic-single"
                                                    name="source_from" id="source_from" required>
                                                    <option value="" disabled selected hiddden>Select Source From
                                                    </option>
                                                    <option value="Facebook">Facebook</option>
                                                    <option value="OLX">OLX</option>
                                                </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12" @if(Auth::user()->role == 'Admin') hidden   @endif>
                        <div class="form-group">
                                 <label>Staff <span class="text-danger">*</span></label>
                                                <select class="form-control select employee_id js-example-basic-single"
                                                    name="employee_id" id="employee_id" required>
                                                    <option value="" disabled selected hiddden>Select Staff
                                                    </option>
                                                    @foreach ($employee as $employees)
                                                        <option value="{{ $employees->id }}" {{ Auth::user()->emp_id == $employees->id ? 'selected' : '' }}>{{ $employees->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
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
