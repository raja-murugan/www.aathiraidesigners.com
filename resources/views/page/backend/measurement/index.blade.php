@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Measurements</h6>
         </div>
      </div>

      <div class="row">
         <div class="col-sm-9">
            <div class="card">

                  <div class="card-body">
                     <div class="table-responsive">
                        <table class="table table-center table-hover datatable table-striped">
                           <thead class="thead-light">
                              <tr>
                                 <th style="width:10%">S.No</th>
                                 <th style="width:20%">Measurement</th>
                                 <th style="width:20%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($data as $keydata => $datas)
                              <tr>
                                 <td>{{ ++$keydata }}</td>
                                 <td>{{ $datas->measurement }}</td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                          <a class="badge bg-warning-light" href="#edit{{ $datas->id }}" data-bs-toggle="modal" 
                                          data-bs-target=".measurementedit-modal-xl{{ $datas->id }}" style="color: #28084b;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $datas->id }}" data-bs-toggle="modal"
                                          data-bs-target=".measurementdelete-modal-xl{{ $datas->id }}" class="badge bg-danger-light" style="color: #28084b;">Delete</a>
                                       </li>
                                    </ul>

                                 </td>
                              </tr>

                              <div class="modal fade  measurementedit-modal-xl{{ $datas->id }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="incomeeditLargeModalLabel{{ $datas->id }}"
                                    aria-hidden="true">
                                    @include('page.backend.measurement.edit')
                              </div>
                              <div class="modal fade measurementdelete-modal-xl{{ $datas->id }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="incomedeleteLargeModalLabel{{ $datas->id }}"
                                    aria-hidden="true">
                                    @include('page.backend.measurement.delete')
                              </div>
                           @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>

            </div>
         </div>
         <div class="col-sm-3">
                @include('page.backend.measurement.create')
         </div>


      </div>





   </div>
</div>
@endsection
