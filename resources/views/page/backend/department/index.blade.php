@extends('layout.backend.auth')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="content-page-header">
                    <h6>Department</h6>
                    <div class="list-btn">
                        {{-- <div style="display:flex;">
                            <ul class="filter-list">
                                <li>
                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".employee-modal-xl">
                                        <i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Department</a>
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div style="display: flex"></div>
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width:5%">S.No</th>
                                            <th style="width:15%">Name</th>
                                            <th style="width:20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $keydata => $datas)
                                            <tr>
                                                <td>{{ ++$keydata }}</td>
                                                <td>{{ $datas->name }}</td>
                                                <td>
                                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                                        <li>
                                                            <a class="badge bg-warning-light"
                                                                href="#edit{{ $datas['unique_key'] }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target=".employeeedit-modal-xl{{ $datas['unique_key'] }}"
                                                                style="color: #28084b;">Edit</a>
                                                        </li>
                                                        <li>
                                                            <a href="#delete{{ $datas['unique_key'] }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target=".employeedelete-modal-xl{{ $datas['unique_key'] }}"
                                                                class="badge bg-danger-light"
                                                                style="color: #28084b;">Delete</a>
                                                        </li>
                                                    </ul>

                                                </td>
                                            </tr>

                                            <div class="modal fade employeeedit-modal-xl{{ $datas['unique_key'] }}"
                                                tabindex="-1" role="dialog" data-bs-backdrop="static"
                                                aria-labelledby="employeeeditLargeModalLabel{{ $datas['unique_key'] }}"
                                                aria-hidden="true">
                                                @include('page.backend.department.edit')
                                            </div>
                                            <div class="modal fade employeedelete-modal-xl{{ $datas['unique_key'] }}"
                                                tabindex="-1" role="dialog"data-bs-backdrop="static"
                                                aria-labelledby="employeedeleteLargeModalLabel{{ $datas['unique_key'] }}"
                                                aria-hidden="true">
                                                @include('page.backend.department.delete')
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <form autocomplete="off" method="POST" action="{{ route('department.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Department Name" name="name" id="name"
                                                    required>
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
                </div>
            </div>
            {{-- <div class="modal fade employee-modal-xl" tabindex="-1" role="dialog" aria-labelledby="employeeLargeModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            @include('page.backend.department.create')
        </div> --}}
        </div>
    </div>
@endsection
