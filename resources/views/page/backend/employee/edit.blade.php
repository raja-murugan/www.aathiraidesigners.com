<div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">

        <div class="modal-header border-0 pb-0">
            <div class="form-header modal-header-title text-start mb-0">
                <h6 class="mb-0">Update Employee</h6>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span class="align-center" aria-hidden="true">&times;</span>
            </button>
        </div>
        <form autocomplete="off" method="POST"
            action="{{ route('employee.edit', ['unique_key' => $Employee_datas['unique_key']]) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter Employee Name" name="name"
                                id="name" required value="{{ $Employee_datas['name'] }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Phone Number<span class="text-danger">*</span></label>
                            <input type="text" class="form-control employee_phoneno"
                                placeholder="Enter Employee Contact No" name="phone_number" id="phone_number"
                                value="{{ $Employee_datas['phone_number'] }}" required>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" placeholder="Enter Employee Address"
                                name="address" id="address" value="{{ $Employee_datas['address'] }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Salary per Hour</label>
                            <input type="number" class="form-control" placeholder="Enter Employee Salary per Hour"
                                name="salaray_per_hour" id="salaray_per_hour"
                                value="{{ $Employee_datas['salaray_per_hour'] }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Aadhaar Card</label>
                            <input type="text" class="form-control" placeholder="Enter Aadhar Card" name="aadhaar_card" value="{{ $Employee_datas['aadhaar_card'] }}">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12" >
                        <div class="form-group">
                            <label>Photo</label>
                            <div class="col-lg-12 col-md-12">
                                <div style="display: flex">
                                    <div class="col-lg-4 col-md-4">
                                        <div><img src="{{ asset($Employee_datas['photo']) }}" alt=""
                                                style="width: 150px !important; height: 110px !important; margin-top: 20px !important;">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        {{-- <div id="my_cameraone"></div> --}}
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div id="captured_cameraimageone"></div>
                                    </div>
                                </div>
                                <input type=button class=" btn btn-sm btn-primary"value="Take a Snap - Photo"
                                    onClick="takesnapshotone()">
                                <input type="hidden" class="form-control image-tagcameraone" name="employee_photo">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12" hidden>
                        <div class="form-group">
                            <label>Photo</label>
                            <div class="col-sm-3">
                                <img src="{{ asset('assets/photo/' . $Employee_datas['photo']) }}" alt=""
                                    style="width: 200px !important; height: 150px !important; margin-right: 40px !important; margin-top: 25px !important;">
                            </div>
                            <input type="file" class="form-control" name="employee_photo">
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
