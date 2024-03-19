@extends('layout.backend.auth')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="content-page-header">
                    <h6>Update Department</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form autocomplete="off" method="POST" action="{{ route('employee.update_emp_department') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">


                                   
                                <div class="row">
                                    <div class="table-responsive col-lg-12 col-sm-12 col-12">
                                       <table class="table">
                                          <thead>
                                                <tr style="background: #f8f9fa;">
                                                   <th style="font-size:15px; width:10%;">S.No</th>
                                                   <th style="font-size:15px; width:30%;">Employee</th>
                                                   <th style="font-size:15px; width:40%;">Department</th>
                                                   <th style="font-size:15px; width:10%;">(Day / Hour) Salary</th>
                                                   <th style="font-size:15px; width:10%;">OT Salary / Hr</th>
                                                </tr>
                                          </thead>
                                          <tbody class="">
                                                @foreach ($Employee as $keydata => $employees)
                                                   <tr>
                                                      <td>{{ ++$keydata }}.</td>
                                                      <td>
                                                            <input type="hidden" id="employee_id" name="employee_id[]"
                                                               value="{{ $employees->id }}" />
                                                            <input type="text" id="employee_name" name="employee_name[]"
                                                               value="{{ $employees->name }}" readonly class="form-control" />
                                                      </td>
                                                      <td>
                                                            <div style="display: flex">
                                                            @foreach ($department as $departments)
                                                               <div class="input-group" style="margin-right: 5px;">
                                                                  <div class="input-group-text">
                                                                        <input class="form-check-input" type="radio" value="{{ $departments->id }}"
                                                                           id="department{{ $employees->id }}{{ $departments->id }}" {{ $employees->department_id == $departments->id ? 'checked' : '' }}
                                                                           name="department[{{ $employees->id }}]"
                                                                           aria-label="Radio button for following text input">
                                                                  </div>
                                                                  <input type="text" class="form-control" value="{{ $departments->name }}" disabled
                                                                        aria-label="Text input with radio button">
                                                               </div>

                                                               <script>
                                                                    $('#department' + {{ $employees->id }}{{ $departments->id }}).click(function() {
                                                                        var department = $(this).val();
                                                                        //alert(department);

                                                                        if (department == 2) {
                                                                            $("#ot_div" + {{ $employees->id }}).show();
                                                                        } else if (department == 1) {
                                                                            $("#ot_div" + {{ $employees->id }}).hide();
                                                                            $("#ot_salary" + {{ $employees->id }}).val('');
                                                                        }
                                                                    });

                                                                </script>
                                                               @endforeach 
                                                            </div>
                                                      </td>
                                                      <td>
                                                      <input type="text" id="employee_salary" name="employee_salary[]"
                                                               value="{{ $employees->salaray_per_hour }}"  class="form-control" />
                                                      </td>
                                                      @if($employees->department_id == 2)
                                                      <td id="ot_div{{ $employees->id }}">
                                                      <input type="text" id="ot_salary{{ $employees->id }}" name="ot_salary[]"  class="form-control" value="{{ $employees->ot_salary }}"/>
                                                      </td>
                                                      @else
                                                      <td id="ot_div{{ $employees->id }}" style="display:none;">
                                                      <input type="text" id="ot_salary{{ $employees->id }}" name="ot_salary[]"  class="form-control" value="{{ $employees->ot_salary }}"/>
                                                      </td>
                                                      @endif
                                                   </tr>


                                                   
                                                @endforeach
                                          </tbody>
                                       </table>
                                    </div>
                              </div>
                    <br />


                                    <div class="text-end" style="margin-top:3%">
                                        <input type="submit" class="btn btn-primary" />
                                        <a href="{{ route('employee.index') }}" class="btn btn-cancel btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
