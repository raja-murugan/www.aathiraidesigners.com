@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Expense</h6>

                     <div class="list-btn">
                        <div style="display: flex;">

                            <div class="page-btn">
                              <div style="display: flex;">
                                       <form autocomplete="off" method="POST" action="{{ route('expense.datefilter') }}">
                                          @method('PUT')
                                          @csrf
                                          <div style="display: flex">
                                             <div style="margin-right: 10px;"><input type="date" name="from_date"
                                                      class="form-control from_date" value="{{ $today }}"></div>
                                             <div style="margin-right: 10px;"><input type="submit" class="btn btn-success"
                                                      value="Search" /></div>
                                          </div>
                                       </form>
                              </div>
                           </div>
                    </div>
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
                                 <th style="width:20%">Date</th>
                                 <th style="width:25%">Reason</th>
                                 <th style="width:15%">Amount</th>
                                 <th style="width:20%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($data as $keydata => $datas)
                              <tr>
                                 <td>{{ ++$keydata }}</td>
                                 <td>{{ $datas->date }}</td>
                                 <td>{{ $datas->description }}</td>
                                 <td>{{ $datas->amount }}</td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                          <a class="badge bg-warning-light" href="#edit{{ $datas->unique_key }}" data-bs-toggle="modal" 
                                          data-bs-target=".expenseedit-modal-xl{{ $datas->unique_key }}" style="color: #28084b;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $datas->unique_key }}" data-bs-toggle="modal"
                                          data-bs-target=".expensedelete-modal-xl{{ $datas->unique_key }}" class="badge bg-danger-light" style="color: #28084b;">Delete</a>
                                       </li>
                                    </ul>

                                 </td>
                              </tr>

                              <div class="modal fade  expenseedit-modal-xl{{ $datas->unique_key }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="expenseeditLargeModalLabel{{ $datas->unique_key }}"
                                    aria-hidden="true">
                                    @include('page.backend.expense.edit')
                              </div>
                              <div class="modal fade expensedelete-modal-xl{{ $datas->unique_key }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="expensedeleteLargeModalLabel{{ $datas->unique_key }}"
                                    aria-hidden="true">
                                    @include('page.backend.expense.delete')
                              </div>
                           @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>

            </div>
         </div>
         <div class="col-sm-3">
                @include('page.backend.expense.create')
         </div>


      </div>





   </div>
</div>
@endsection
