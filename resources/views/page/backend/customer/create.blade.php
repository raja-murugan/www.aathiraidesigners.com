@extends('layout.backend.auth')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">


            <div class="page-header">
                <div class="content-page-header">
                    <h6>New Customer</h6>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">


                    <div class="card">
                        <div class="card-body">

                            <form autocomplete="off" method="POST" action="{{ route('customer.store') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group-item border-0 mb-0">


                                    <div class="row align-item-center">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Customer <span class="text-danger">*</span></label>
                                                <input type="text" value="" class="form-control"
                                                    placeholder="Enter Customer Name" name="name" id="name"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Contact Number <span class="text-danger">*</span></label>
                                                <input type="text" value="" class="form-control customerphoneno"
                                                    placeholder="Enter Contact Number" name="phone_number"
                                                    id="phone_number"required>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group-item border-0 mb-0">
                                    <div class="row align-item-center">
                                        <div class="col-lg-12 col-md-12 col-sm-12">


                                            <div class="table-responsive no-pagination">
                                                <table class="table table-center table-hover">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th style="width:15%;">Product</th>
                                                            <th style="width:80%;">Measurements</th>
                                                            <th style="width:5%;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="product_fields">
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" id="customer_products_id"
                                                                    name="customer_products_id[]" />
                                                                <select
                                                                    class="form-control  product_id select js-example-basic-single"
                                                                    name="product_id[]" id="product_id1" required>
                                                                    <option value="" selected disabled
                                                                        class="text-muted">
                                                                        Select Product
                                                                    </option>
                                                                    @foreach ($products as $products_arr)
                                                                        <option value="{{ $products_arr->id }}">
                                                                            {{ $products_arr->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="text" class="form-control measurements"
                                                                    id="measurements" name="measurements[]"
                                                                    placeholder="Measurement" /></td>

                                                            <td>
                                                                <button class="btn additemplus_button addproducts"
                                                                    type="button" id="" value="Add"><i
                                                                        class="fe fe-plus-circle"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="text-end" style="margin-top:3%">
                                    <input type="submit" class="btn btn-primary" />
                                    <a href="{{ route('customer.index') }}" class="btn btn-cancel btn-danger">Cancel</a>
                                </div>



                            </form>

                        </div>
                    </div>

                </div>
            </div>



        </div>
    </div>
@endsection
