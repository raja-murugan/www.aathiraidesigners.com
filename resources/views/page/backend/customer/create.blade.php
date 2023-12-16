@extends('layout.backend.auth')

@section('content')
    <div class="page-wrapper card-body">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="content-page-header">
                    <h6>Add Customer</h6>
                </div>
            </div>
            <form autocomplete="off" method="POST" action="{{ route('customer.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Basic Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group-item border-0 mb-0">
                                    <div class="row align-item-center">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Customer Name <span class="text-danger">*</span></label>
                                                <input type="text" value="" class="form-control"
                                                    placeholder="Enter Customer Name" name="name" id="name"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12"  @if(Auth::user()->role == 'Admin') hidden   @endif>
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
                                        <div class="col-lg-4 col-md-4 col-sm-12">
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
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Phone Number <span class="text-danger">*</span></label>
                                                <input type="text" value="" class="form-control"
                                                    placeholder="Enter Phone No" name="phonenumber" id="phonenumber"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Alter Phone Number</label>
                                                <input type="text" value="" class="form-control"
                                                    placeholder="Enter Alter Phone No" name="alter_phonenumber"
                                                    id="alter_phonenumber">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>E-Mail ID</label>
                                                <input type="text" value="" class="form-control"
                                                    placeholder="Enter E-Mail" name="email_id" id="email_id">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Date of Birth <span class="text-danger">*</span></label>
                                                <input type="date" value="" class="form-control" name="birth_date"
                                                    id="birth_date">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Wedding Date</label>
                                                <input type="date" value="" class="form-control"
                                                    name="wedding_date" id="wedding_date">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea name="address" id="address" class="form-control" placeholder="Enter Address"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label>Customer Photo <span class="text-danger">*</span></label>
                                                <input type="file" name="customer_photo" id="customer_photo"
                                                    class="form-control customer_photo" /><br /><br />
                                                <img src="#" id="customer-img-tag" width="150" height="100" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Family Details</h5>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive no-pagination">
                                        <table class="table table-center table-hover datatable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width:10%">S.No <span class="text-danger">*</span></th>
                                                    <th style="width:30%">Name <span class="text-danger">*</span></th>
                                                    <th style="width:20%">Relationship <span class="text-danger">*</span></th>
                                                    <th style="width:15%">Date of Birth <span class="text-danger">*</span></th>
                                                    <th style="width:15%">Wedding Date</th>
                                                    <th style="width:10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="family_fields">
                                                <tr>
                                                    <td>
                                                        <input id="#" name="#"
                                                            class="auto_num form-control" type="text" value="1"
                                                            readonly />
                                                    </td>
                                                    <td><input type="hidden" name="family_id[]" value="" />
                                                        <input type="text" class="form-control family_name"
                                                            id="family_name" name="family_name[]" required
                                                            value="" />
                                                    </td>
                                                    <td><input type="text" class="form-control family_relationship"
                                                            id="family_relationship" name="family_relationship[]"
                                                            value="" required /></td>
                                                    <td><input type="date" class="form-control family_dob"
                                                            id="family_dob" name="family_dob[]" required /></td>
                                                    <td><input type="date" class="form-control family_weddingdate"
                                                            id="family_weddingdate" name="family_weddingdate[]" /></td>
                                                    <td>
                                                        <button class="btn btn-primary form-plus-btn addfamilys"
                                                            type="button" id="" value="Add"><i
                                                                class="fe fe-plus-circle"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="text-end" style="margin-top:3%">
                        <input type="submit" class="btn btn-primary" />
                        <a href="{{ route('customer.index') }}" class="btn btn-cancel btn-danger">Cancel</a>
                    </div>


            </form>


        </div>
    </div>
@endsection
