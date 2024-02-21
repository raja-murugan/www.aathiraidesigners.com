@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Employee</h6>
               <div class="list-btn">
                  <div style="display:flex;">
                     <ul class="filter-list">
                        <li>
                           <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".employee-modal-xl">
                              <i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Employee</a>
                        </li>
                     </ul>
                  </div>

               </div>
         </div>
      </div>

      <div class="row">
         <div class="col-sm-12">
            <div class="card">

                  <div class="card-body">
                     <div class="table-responsive">
                        <table class="table table-center table-hover datatable table-striped">
                           <thead class="thead-light">
                              <tr>
                                 <th style="width:5%">S.No</th>
                                 <th style="width:15%">Department</th>
                                 <th style="width:15%">Name</th>
                                 <th style="width:15%">Photo</th>
                                 <th style="width:15%">Phone No</th>
                                 <th style="width:15%">Address</th>
                                 <th style="width:15%">Salary Per Hour</th>
                                 <th style="width:20%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($Employee_data as $keydata => $Employee_datas)
                              <tr>
                                 <td>{{ ++$keydata }}</td>
                                 <td>{{ $Employee_datas['departmentname'] }}</td>
                                 <td>{{ $Employee_datas['name'] }}</td>
                                 <td>
                                 <img src="{{ asset($Employee_datas['photo']) }}" alt=""
                                    style="width: 50px !important; height: 50px !important;">
                                 </td>
                                 <td>{{ $Employee_datas['phone_number'] }}</td>
                                 <td>{{ $Employee_datas['address'] }}</td>
                                 <td>{{ $Employee_datas['salaray_per_hour'] }}</td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                          <a class="badge bg-warning-light" href="#edit{{ $Employee_datas['unique_key'] }}" data-bs-toggle="modal"  data-emp_id ="{{ $Employee_datas['id'] }}"
                                          data-bs-target=".employeeedit-modal-xl{{ $Employee_datas['unique_key'] }}" style="color: #28084b;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $Employee_datas['unique_key'] }}" data-bs-toggle="modal"
                                          data-bs-target=".employeedelete-modal-xl{{ $Employee_datas['unique_key'] }}" class="badge bg-danger-light" style="color: #28084b;">Delete</a>
                                       </li>
                                       <li>
                                          <a href="{{ route('employee.view', ['unique_key' => $Employee_datas['unique_key']]) }}"
                                             class="badge" style="color:#28084b;background: #6bdda7;">View</a>
                                       </li>
                                    </ul>

                                 </td>
                              </tr>

                              <div class="modal fade  editemployee_modal employeeedit-modal-xl{{ $Employee_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="employeeeditLargeModalLabel{{ $Employee_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.employee.edit')
                              </div>
                              <div class="modal fade employeedelete-modal-xl{{ $Employee_datas['unique_key'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="employeedeleteLargeModalLabel{{ $Employee_datas['unique_key'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.employee.delete')
                              </div>
                           @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>

            </div>
         </div>


      </div>





      <div class="modal fade addemployee_modal employee-modal-xl" tabindex="-1" role="dialog" aria-labelledby="employeeLargeModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            @include('page.backend.employee.create')
        </div>

   </div>
</div>
@endsection
