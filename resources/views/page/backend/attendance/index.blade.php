@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Attendance</h6>
               <div class="list-btn">
                  <div style="display:flex;">
                     <ul class="filter-list">
                        <li>
                            <input type="date" class="form-control employee_phoneno" name="phone_number" required>
                        </li>
                        <li>
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".employee-modal-xl">
                               Filter</a>
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
                                 <th style="width:10%">S.No</th>
                                 <th style="width:15%">Name</th>
                                 <th style="width:15%">Working Time</th>
                                 <th style="width:15%">Check-In Photo</th>
                                 <th style="width:15%">Check-Out Photo</th>
                                 <th style="width:30%">Action</th>
                              </tr>
                           </thead>
                           <tbody>

                           </tbody>
                        </table>
                     </div>
                  </div>

            </div>
         </div>


      </div>





      <div class="modal fade employee-modal-xl" tabindex="-1" role="dialog" aria-labelledby="employeeLargeModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            @include('page.backend.employee.create')
        </div>

   </div>
</div>
@endsection
