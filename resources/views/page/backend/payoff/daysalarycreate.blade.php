@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">


      <div class="page-header">
         <div class="content-page-header">
            <h6>Day Salary payoff</h6>
         </div>
      </div>


      <div class="row">
         <div class="col-sm-12">


            <div class="card">
               <div class="card-body">

                     <form autocomplete="off" method="POST" action="{{ route('payoff.daysalary_store') }}" enctype="multipart/form-data">
                     @csrf
   

                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group-item border-0 mb-0">
                                 <div class="row align-item-center">

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Date <span class="text-danger">*</span></label>
                                          <input type="date" value="{{ $today }}" class="form-control"  name="ds_date" id="ds_date"  required>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Year <span class="text-danger">*</span></label>
                                          <select class="form-control ds_salary_year select" name="ds_salary_year" id="ds_salary_year" required>
                                             <option value="" selected hidden class="text-muted">Select </option>
                                             @foreach ($years_arr as $years_array)
                                             <option value="{{ $years_array }} "@if ($years_array == $current_year) selected='selected' @endif>{{ $years_array }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label >Month<span class="text-danger">*</span></label>
                                          <select class="form-control js-example-basic-single ds_salary_month select" name="ds_salary_month" id="ds_salary_month"required>
                                             <option value="" selected hidden class="text-muted">Select Month </option>
                                             <option value="01">January</option>
                                             <option value="02">February</option>
                                             <option value="03">March</option>
                                             <option value="04">April</option>
                                             <option value="05">May</option>
                                             <option value="06">June</option>
                                             <option value="07">July</option>
                                             <option value="08">August</option>
                                             <option value="09">September</option>
                                             <option value="10">October</option>
                                             <option value="11">November</option>
                                             <option value="12">December</option>
                                          </select>
                                       </div>
                                    </div>
                                                  
                                                   
                                 </div>
                              </div>

                                          <br/>

                              <div class="form-group-item">
                                       <div class="table-responsive no-pagination">
                                          <table class="table table-center table-hover">
                                             <thead id="ds_headsalary_detailrow" style="background: linear-gradient(320deg, #DDCEFF 0%, #DBECFF 100%);display:none">
                                                <tr>
                                                   <th style="width:18%">Employee</th>
                                                   <th style="width:5%">Working<br/> Days</th>
                                                   <th style="width:15%">Total Hour</th>
                                                   <th style="width:13%">Salary Amount</th>
                                                   <th style="width:12%">Paid Salary</th>
                                                   <th style="width:12%">Balance</th>
                                                   <th style="width:12%">Amount</th>
                                                   <th style="width:13%">Note</th>
                                                </tr>
                                             </thead>
                                             <tbody id="ds_payoffsalary"></div>
                                          </table>
                                       </div>
                              </div>



                             


                        </div>





<script>
$(document).ready(function() {
     $('.ds_salary_month').on('change', function () {
        var salary_month = $(this).val();
        var salary_year = $(".ds_salary_year").val();
        //alert(salary_month);
        $.ajax({
            url: '/gettotal_daysalary/',
            type: 'get',
            data: {
                salary_month: salary_month,
                salary_year: salary_year
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                var len = response.length;
                $('#ds_payoffsalary').html('');
                for (var i = 0; i < len; i++) {

                        var column_0 = $('<td/>', {
                            html: '<input type="" value="' + response[i].employee + '" class="form-control" readonly/>' +
                                    '<input type="hidden" id="employee_id" name="employee_id[]" value="' + response[i].employeeid + '"/>',
                        });
                        var column_1 = $('<td/>', {
                            html: '<input type="" value="' + response[i].present_dayscount + '" class="form-control" readonly/>' +
                            '<input type="hidden" id="present_dayscount" name="present_dayscount[]" value="' + response[i].present_dayscount + '"/>',
                        });
                        var column_2 = $('<td/>', {
                            html: '<input type="" value="' + response[i].total_time + '" class="form-control" style="color: #6b00ff;" readonly/>' +
                                    '<input type="hidden" id="total_time" name="total_time[]" value="' + response[i].total_time + '"/>' +
                                    '<input type="hidden" id="perdaysalary" name="perdaysalary[]" value="' + response[i].perdaysalary + '"/>',
                        });
                        var column_3 = $('<td/>', {
                            html: '<input type="" value="' + response[i].emp_salary + '" class="form-control" readonly/>' +
                                    '<input type="hidden" id="emp_salary" name="emp_salary[]" value="' + response[i].emp_salary + '"/>',
                        });
                        var column_4 = $('<td/>', {
                            html: '<input type="" value="' + response[i].paid_salary + '" class="form-control" style="color: green;" readonly/>' +
                                    '<input type="hidden" id="paid_salary" name="paid_salary[]" value="' + response[i].paid_salary + '"/>',
                        });
                        var column_5 = $('<td/>', {
                            html: '<input type="" value="' + response[i].balanceSalaryAmount + '" class="form-control" style="color: red;" readonly/>' +
                                    '<input type="hidden" id="balanceSalaryAmount" name="balanceSalaryAmount[]" value="' + response[i].balanceSalaryAmount + '"/>',
                        });
                        var column_6 = $('<td/>', {
                            html: '<input type="text" id="amountgiven" name="amountgiven[]"  class="form-control amountgiven" ' + response[i].readonly + '  placeholder="' + response[i].placeholder + '"/>',
                        });
                        var column_7 = $('<td/>', {
                            html: '<textarea name="note[]" id="note" class="form-control" ' + response[i].readonly + '  placeholder="' + response[i].noteplaceholder + '"></textarea>',
                        });

                        var row = $('<tr id=salrydetailrow/>', {}).append(column_0, column_1, column_2,
                            column_3, column_4, column_5, column_6, column_7);

                        $('#ds_payoffsalary').append(row);
                        $('#ds_headsalary_detailrow').show();
                }
            }
        });
    });

   
});



</script>







                           <div class="text-end" style="margin-top:3%">
                                          <input type="submit" class="btn btn-primary" />
                                          <a href="{{ route('payoff.index') }}" class="btn btn-cancel btn-danger" >Cancel</a>
                           </div>
                       
      

                     </form>

               </div>
            </div>

         </div>
      </div>



   </div>
</div>


@endsection

