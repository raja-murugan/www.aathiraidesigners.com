@extends('layout.backend.auth')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">


            <div class="page-header">
                <div class="content-page-header">
                    <h6>Update Product</h6>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">


                    <div class="card">
                        <div class="card-body">

                            <form autocomplete="off" method="POST"  action="{{ route('product.update', ['unique_key' => $ProductData->unique_key]) }}"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf

                                <div class="form-group-item border-0 mb-0">


                                    <div class="row align-item-center">
                                        <div class="col-lg-5 col-md-5 col-sm-5">
                                            <div class="form-group">
                                                <label>Product <span class="text-danger">*</span></label>
                                                <input type="text"  class="form-control"
                                                    placeholder="Enter Product Name" name="product" id="product"  value="{{$ProductData->name}}"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group-item border-0 mb-0">
                                    <div class="row align-item-center">
                                        <div class="col-lg-9 col-md-9 col-sm-9">


                                            <div class="table-responsive no-pagination">
                                                <table class="table table-center ">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th style="width:50%;">Measurements</th>
                                                            <th style="width:15%;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="measurements_fields">
                                                    @foreach ($ProductMeasurements as $index => $ProductMeasurementsarr)
                                                        <tr class="">
                                                                  
                                                            <td>
                                                            <input type="hidden" id="product_measurements_id"
                                                                    name="product_measurements_id[]" value="{{ $ProductMeasurementsarr->id }}"/>
                                                                            <select
                                                                                    class="form-control  measurement_id select js-example-basic-single"
                                                                                    name="measurement_id[]" id="measurement_id1" required>
                                                                                    <option value="" selected disabled
                                                                                        class="text-muted">
                                                                                        Select Measurement
                                                                                    </option>
                                                                                    @foreach ($measurements as $measurementsarr)
                                                                                        <option value="{{ $measurementsarr->id }}" @if ($measurementsarr->id === $ProductMeasurementsarr->measurement_id) selected='selected' @endif>
                                                                                            {{ $measurementsarr->measurement }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                            </td>
                                                            <td> <button class="btn additemplus_button addmeasurement" type="button" id="" value="Add"><i
                                                                class="fe fe-plus-circle"></i></button>
                                                                <button class="btn additemminus_button remove-measurementtr" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button></td>
                                                         </tr>
                                                         @endforeach
                                                      </tbody>
                                                                    
                                                </table>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="text-end" style="margin-top:3%">
                                    <input type="submit" class="btn btn-primary" />
                                    <a href="{{ route('product.index') }}" class="btn btn-cancel btn-danger">Cancel</a>
                                </div>



                            </form>

                        </div>
                    </div>

                </div>
            </div>



        </div>
    </div>
@endsection









