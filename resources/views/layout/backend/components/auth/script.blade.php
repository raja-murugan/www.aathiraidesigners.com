<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<script src="{{ asset('assets/backend/js/jquery-3.7.0.min.js') }}"></script>

<script src="{{ asset('assets/backend/js/feather.min.js') }}"></script>

<script src="{{ asset('assets/backend/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('assets/backend/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/bootstrap-datetimepicker.min.js') }}"></script>


<script src="{{ asset('assets/backend/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/backend/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/apexchart/chart-data.js') }}"></script>

<script src="{{ asset('assets/backend/js/script.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
  <script src="https://cdn.jsdelivr.net/npm/face-api.js"></script>


  <script language="JavaScript">


    $('.checin_modal').on('show.bs.modal', function (e) {
          var $modal = $(this);
          var employeeID = $(e.relatedTarget).data('employee_id');
          //alert(employeeID);

            Webcam.set({
              width: 200,
              height: 200,
              image_format: 'jpeg',
              jpeg_quality: 90,
              facingMode: 'environment'
            });

          Webcam.attach('#checin_camera' + employeeID);

          $('#take_snapshot' + employeeID).click(function() {
            Webcam.snap(function(data_uri) {
                    $('.image-checincamera' + employeeID).val(data_uri);
                    document.getElementById('captured_checinimage' + employeeID).innerHTML = '<img src="' + data_uri +
                        '" style="height: 150px !important;width: 200px !important;margin-top: 23px;margin-left: 20px;"/>';
                });
            });


    });

    $('.checkout_modal').on('show.bs.modal', function (e) {
          var $modal = $(this);
          var employeeID = $(e.relatedTarget).data('employee_id');
          //alert(employeeID);

            Webcam.set({
              width: 200,
              height: 200,
              image_format: 'jpeg',
              jpeg_quality: 90,
              facingMode: 'environment'
            });

          Webcam.attach('#checkout_camera' + employeeID);

          $('#takecheckout_snapshot' + employeeID).click(function() {
            Webcam.snap(function(data_uri) {
                    $('.image-checkoutcamera' + employeeID).val(data_uri);
                    document.getElementById('captured_checkoutimage' + employeeID).innerHTML = '<img src="' + data_uri +
                        '" style="height: 150px !important;width: 200px !important;margin-top: 23px;margin-left: 20px;"/>';
                });
            });


    });


    $('.addemployee_modal').on('show.bs.modal', function (e) {

            Webcam.set({
              width: 200,
              height: 200,
              image_format: 'jpeg',
              jpeg_quality: 90,
              facingMode: 'environment'
            });

            Webcam.attach('#employee_camera');

            $('#takeemployeesnapshot').click(function() {
              Webcam.snap(function(data_uri) {
                      $('.image-employeetagcamera').val(data_uri);
                      document.getElementById('captured_employeeimage').innerHTML = '<img src="' + data_uri +
                          '" style="height: 150px !important;width: 200px !important;margin-top: 23px;margin-left: 20px;"/>';
                  });
              });


    });


    $('.editemployee_modal').on('show.bs.modal', function (e) {
          var $modal = $(this);
          var emp_id = $(e.relatedTarget).data('emp_id');
          //alert(emp_id);

            Webcam.set({
              width: 200,
              height: 200,
              image_format: 'jpeg',
              jpeg_quality: 90,
              facingMode: 'environment'
            });

          Webcam.attach('#empedit_camera' + emp_id);

          $('#takeempedit_snapshot' + emp_id).click(function() {
            Webcam.snap(function(data_uri) {
                    $('.image-empeditcamera' + emp_id).val(data_uri);
                    document.getElementById('captured_empeditimage' + emp_id).innerHTML = '<img src="' + data_uri +
                        '" style="height: 150px !important;width: 200px !important;margin-top: 23px;margin-left: 20px;"/>';
                });
            });


    });



    $('.salaryedit').on('show.bs.modal', function (e) {
          var $modal = $(this);
          var employeeID = $(e.relatedTarget).data('id');
          var month = $(e.relatedTarget).data('month');
          var year = $(e.relatedTarget).data('year');
          
          console.log(employeeID);


                $.ajax({
                    url: '/getEmployeePayoffs/',
                    type: 'get',
                    data: {
                      _token: "{{ csrf_token() }}",
                      employeeID: employeeID,
                      month: month,
                      year: year,
                    },
                    dataType: 'json',
                    success: function(response) {
                      console.log(response);

                      var len = response.length;
                      for (var i = 0; i < len; i++) {
                        $('.payoff_employee').val(response[i].employee);



                              var column_0 = $('<div/>', {
                              html: '<input type="text" style="background: #e0ddeb;" class="form-control term" id="term">',
                              });

                              var column_1 = $('<div/>', {
                              html: response[i].paidsalary,
                              });

                              var row = $('<div class="row"/>', {}).append(column_0, column_1);
                              $('.payoff_edits').append(row);
                      }
                     
                    }
                });

    });


    $(document).ready(function() {
      $('.js-example-basic-single').select2();

              $(".customerphoneno").keyup(function() {
                var query = $(this).val();

                if (query != '') {

                    $.ajax({
                        url: "{{ route('customer.checkduplicate') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            query: query
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response['data']);
                            if(response['data'] != null){
                                alert('Customer Already Existed');
                                $('.customerphoneno').val('');
                            }
                        }
                    });
                }
              });

              $(".productname").keyup(function() {
                var query = $(this).val();

                if (query != '') {

                    $.ajax({
                        url: "{{ route('product.checkduplicate') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            query: query
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response['data']);
                            if(response['data'] != null){
                                alert('Product Name Already Existed');
                                $('.productname').val('');
                            }
                        }
                    });
                }
              });
    });

    var s = 1;
    var w = 1;

            $(document).on('click', '.addmeasurement', function() {
              ++s;

                $(".measurements_fields").append(
                    '<tr>' +
                    '<td><input type="hidden" id="product_measurements_id" name="product_measurements_id[]" />' +
                    '<select class="form-control  measurement_id select js-example-basic-single"  name="measurement_id[]" id="measurement_id' + s + '" required>' +
                    '<option value="" selected disabled class="text-muted">Select Measurement</option></select>' +
                    '</td>' +
                    '<td><button class="btn additemplus_button addmeasurement" style="margin-right: 3px;" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>' +
                    '<button class="btn additemminus_button remove-measurementtr" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button></td>' +
                    '</tr>'
                );
                $(".measurements_fields").find('.js-example-basic-single').select2();


                $.ajax({
                    url: '/getmeasurements/',
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        //console.log(response['data']);
                        var len = response['data'].length;

                        var selectedValues = new Array();

                        if (len > 0) {
                            for (var i = 0; i < len; i++) {

                                    var id = response['data'][i].id;
                                    var name = response['data'][i].measurement;
                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    selectedValues.push(option);
                            }
                        }
                        ++w;
                        $('#measurement_id' + w).append(selectedValues);
                        //add_count.push(Object.keys(selectedValues).length);
                    }
                });

            });


            $(document).on('click', '.remove-measurementtr', function() {
              $(this).parents('tr').remove();
            });





            $('#product_id' + 1).on('change', function() {
              var product_id = this.value;
                  $.ajax({
                    url: '/getproduct_Mesurements/' + product_id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response['data']);

                        var output = response['data'].length;
                        $('#customer_measurements' + 1).empty();
                            for (var i = 0; i < output; i++) {


                            var column_0 = $('<td/>', {
                                    html: '<input type="hidden" name="product_customer_mesasurementid[]" value=""/>' +
                                          '<input type="hidden" name="measurement_id[]" value="' + response['data'][i].measurement_id + '"/>' +
                                          '<input type="hidden" name="productid[]" value="' + product_id + '"/>' +
                                          '<input type="text" class="measurement_name form-control" id="measurement_name" name="measurement_name[]" value="' + response['data'][i].measurement + '" readonly>',
                                });
                                var column_1 = $('<td/>', {
                                    html: '<input type="text"  class=" form-control" id="measurement_no" name="measurement_no[]" placeholder="Enter Measurements"/>',
                                });
                                var row = $('<tr id=stages_tr/>', {}).append(column_0,
                                    column_1);

                                $('#customer_measurements' + 1).append(row);
                               
                            }

                      }
                    });
            });



    // Customer Products

    var i = 1;
    var j = 1;

            $(document).on('click', '.addproducts', function() {
              ++i;

                $(".product_fields").append(
                    '<tr>' +
                    '<td class=""><input type="hidden" id="customer_products_id" name="customer_products_id[]" />' +
                    '<select class="form-control  product_id select js-example-basic-single"  name="product_id[]" id="product_id' + i + '" required>' +
                    '<option value="" selected disabled class="text-muted">Select Product</option></select>' +
                    '</td>' +
                    '<td><table class="table " id="customer_measurementss' + i + '"></table></td>' +
                    '<td><button class="btn additemplus_button addproducts" style="margin-right: 3px;" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>' +
                    '<button class="btn additemminus_button remove-producttr" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button></td>' +
                    '</tr>'
                );
                $(".product_fields").find('.js-example-basic-single').select2();


                $.ajax({
                    url: '/getproducts/',
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        //console.log(response['data']);
                        var len = response['data'].length;

                        var selectedValues = new Array();

                        if (len > 0) {
                            for (var i = 0; i < len; i++) {

                                    var id = response['data'][i].id;
                                    var name = response['data'][i].name;
                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    selectedValues.push(option);
                            }
                        }
                        ++j;
                        $('#product_id' + j).append(selectedValues);
                        //add_count.push(Object.keys(selectedValues).length);
                    }
                });


                if(i == '2'){
                      $('#product_id' + i).on('change', function() {
                        var product_id = this.value;
                            $.ajax({
                              url: '/getproduct_Mesurements/' + product_id,
                              type: 'get',
                              dataType: 'json',
                              success: function(response) {
                                  console.log(response['data']);

                                  var output = response['data'].length;
                                  $('#customer_measurementss' + 2).empty();
                                      for (var f = 0; f < output; f++) {


                                      var column_0 = $('<td/>', {
                                              html: '<input type="hidden" name="product_customer_mesasurementid[]" value=""/>' + 
                                                    '<input type="hidden" name="measurement_id[]" value="' + response['data'][f].measurement_id + '"/>' +
                                                      '<input type="hidden" name="productid[]" value="' + product_id + '"/>' +
                                                    '<input type="text" class="measurement_name form-control" id="measurement_name" name="measurement_name[]" value="' +
                                                      response['data'][f].measurement + '" readonly>',
                                          });
                                          var column_1 = $('<td/>', {
                                              html: '<input type="text"  class=" form-control" id="measurement_no" name="measurement_no[]" placeholder="Enter Measurements"/>',
                                          });
                                          var row = $('<tr id=stages_tr/>', {}).append(column_0,
                                              column_1);

                                          $('#customer_measurementss' + i).append(row);
                                        
                                      }

                                }
                              });
                      });
                }



                if(i == '3'){
                      $('#product_id' + i).on('change', function() {
                        var product_id = this.value;
                            $.ajax({
                              url: '/getproduct_Mesurements/' + product_id,
                              type: 'get',
                              dataType: 'json',
                              success: function(response) {
                                  console.log(response['data']);

                                  var output = response['data'].length;
                                  $('#customer_measurementss' + 3).empty();
                                      for (var f = 0; f < output; f++) {


                                      var column_0 = $('<td/>', {
                                              html: '<input type="hidden" name="product_customer_mesasurementid[]" value=""/>' + 
                                                      '<input type="hidden" name="measurement_id[]" value="' + response['data'][f].measurement_id + '"/>' +
                                                      '<input type="hidden" name="productid[]" value="' + product_id + '"/>' +
                                              '<input type="text" class="measurement_name form-control" id="measurement_name" name="measurement_name[]" value="' +
                                              response['data'][f].measurement + '" readonly>',
                                          });
                                          var column_1 = $('<td/>', {
                                              html: '<input type="text"  class=" form-control" id="measurement_no" name="measurement_no[]" placeholder="Enter Measurements"/>',
                                          });
                                          var row = $('<tr id=stages_tr/>', {}).append(column_0,
                                              column_1);

                                          $('#customer_measurementss' + i).append(row);
                                        
                                      }

                                }
                              });
                      });
                }



                if(i == '4'){
                      $('#product_id' + i).on('change', function() {
                        var product_id = this.value;
                            $.ajax({
                              url: '/getproduct_Mesurements/' + product_id,
                              type: 'get',
                              dataType: 'json',
                              success: function(response) {
                                  console.log(response['data']);

                                  var output = response['data'].length;
                                  $('#customer_measurementss' + 4).empty();
                                      for (var f = 0; f < output; f++) {


                                      var column_0 = $('<td/>', {
                                              html: '<input type="hidden" name="product_customer_mesasurementid[]" value=""/>' + 
                                                    '<input type="hidden" name="measurement_id[]" value="' + response['data'][f].measurement_id + '"/>' +
                                                      '<input type="hidden" name="productid[]" value="' + product_id + '"/>' +
                                                    '<input type="text" class="measurement_name form-control" id="measurement_name" name="measurement_name[]" value="' +
                                              response['data'][f].measurement + '" readonly>',
                                          });
                                          var column_1 = $('<td/>', {
                                              html: '<input type="text"  class=" form-control" id="measurement_no" name="measurement_no[]" placeholder="Enter Measurements"/>',
                                          });
                                          var row = $('<tr id=stages_tr/>', {}).append(column_0,
                                              column_1);

                                          $('#customer_measurementss' + i).append(row);
                                        
                                      }

                                }
                              });
                      });
                }



                if(i == '5'){
                      $('#product_id' + i).on('change', function() {
                        var product_id = this.value;
                            $.ajax({
                              url: '/getproduct_Mesurements/' + product_id,
                              type: 'get',
                              dataType: 'json',
                              success: function(response) {
                                  console.log(response['data']);

                                  var output = response['data'].length;
                                  $('#customer_measurementss' + 5).empty();
                                      for (var f = 0; f < output; f++) {


                                      var column_0 = $('<td/>', {
                                              html: '<input type="hidden" name="product_customer_mesasurementid[]" value=""/>' + 
                                                    '<input type="hidden" name="measurement_id[]" value="' + response['data'][f].measurement_id + '"/>' +
                                                      '<input type="hidden" name="productid[]" value="' + product_id + '"/>' +
                                                      '<input type="text" class="measurement_name form-control" id="measurement_name" name="measurement_name[]" value="' +
                                              response['data'][f].measurement + '" readonly>',
                                          });
                                          var column_1 = $('<td/>', {
                                              html: '<input type="text"  class=" form-control" id="measurement_no" name="measurement_no[]" placeholder="Enter Measurements"/>',
                                          });
                                          var row = $('<tr id=stages_tr/>', {}).append(column_0,
                                              column_1);

                                          $('#customer_measurementss' + i).append(row);
                                        
                                      }

                                }
                              });
                      });
                }



                if(i == '6'){
                      $('#product_id' + i).on('change', function() {
                        var product_id = this.value;
                            $.ajax({
                              url: '/getproduct_Mesurements/' + product_id,
                              type: 'get',
                              dataType: 'json',
                              success: function(response) {
                                  console.log(response['data']);

                                  var output = response['data'].length;
                                  $('#customer_measurementss' + 6).empty();
                                      for (var f = 0; f < output; f++) {


                                      var column_0 = $('<td/>', {
                                              html: '<input type="hidden" name="product_customer_mesasurementid[]" value=""/>' + 
                                                    '<input type="hidden" name="measurement_id[]" value="' + response['data'][f].measurement_id + '"/>' +
                                                    '<input type="hidden" name="productid[]" value="' + product_id + '"/>' +
                                                    '<input type="text" class="measurement_name form-control" id="measurement_name" name="measurement_name[]" value="' +
                                              response['data'][f].measurement + '" readonly>',
                                          });
                                          var column_1 = $('<td/>', {
                                              html: '<input type="text"  class=" form-control" id="measurement_no" name="measurement_no[]" placeholder="Enter Measurements"/>',
                                          });
                                          var row = $('<tr id=stages_tr/>', {}).append(column_0,
                                              column_1);

                                          $('#customer_measurementss' + i).append(row);
                                        
                                      }

                                }
                              });
                      });
                }







            });

            $(document).on('click', '.remove-producttr', function() {
              $(this).parents('tr').remove();
            });




            $(document).on('click', '.addpayoffeditfields', function() {

                $(".payoffeditdata").append(
                    '<tr>' +
                    '<td class=""><input type="hidden" name="payoffdata_id[]" value="" />' +
                    '<input type="date" class="form-control payoffedit_date" id="payoffedit_date"  name="payoffedit_date[]"  value=""/>' +
                    '</td>' +
                    '<td><input type="text" class="form-control payoffedit_amount" id="payoffedit_amount" name="payoffedit_amount[]"  value=""/></td>' +
                    '<td><input type="text" class="form-control payoffedit_note" id="payoffedit_note" name="payoffedit_note[]"  value=""/></td>' +
                    '<td><button class="btn additemplus_button addpayoffeditfields" style="margin-right: 3px;" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>' +
                    '<button class="btn additemminus_button remove-payoffedit" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button></td>' +
                    '</tr>'
                );
            });

            $(document).on('click', '.remove-payoffedit', function() {
              $(this).parents('tr').remove();
            });



// Billing Products

var k = 1;
var l = 1;
            $(document).on('click', '.addbillingproducts', function() {
              ++k;

                $(".billing_products").append(
                    '<tr>' +
                    '<td class=""><input type="hidden" id="billingproducts_id" name="billingproducts_id[]" />' +
                    ' <input type="hidden" class="form-control customer_product_id" id="customer_product_id' + k + '" name="customer_product_id[]" />' +
                    '<select class="form-control  billing_product_id select js-example-basic-single"  name="billing_product_id[]" id="billing_product_id' + k + '" required>' +
                    '<option value="" selected disabled class="text-muted">Select Product</option></select>' +
                    '</td>' +
                    '<td><input type="text" class="form-control billing_qty" id="billing_qty" name="billing_qty[]" placeholder="qty" /></td>' +
                    '<td><input type="text" class="form-control billing_rateperqty" id="billing_rateperqty" name="billing_rateperqty[]" placeholder="Rate / Qty" /></td>' +
                    '<td><input type="text" class="form-control billing_total" id="billing_total" name="billing_total[]" placeholder="total"  />' +
                    '</td>' +
                    '<td><button class=" btn additemplus_button addbillingproducts" style="margin-right: 3px;" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>' +
                    '<button class=" btn additemminus_button remove-billingtr" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button></td>' +
                    '</tr>'
                );
                $(".billing_products").find('.js-example-basic-single').select2();

                var billing_customerid = $(".billing_customerid").val();
                  $.ajax({
                    url: '/getcustomerwiseproducts/',
                    type: 'get',
                    data: {
                      _token: "{{ csrf_token() }}",
                      billing_customerid: billing_customerid,
                    },
                    dataType: 'json',
                    success: function(response) {
                        //console.log(response['data']);
                        var len = response['data'].length;

                        var selectedValues = new Array();

                        if (len > 0) {
                            for (var i = 0; i < len; i++) {

                                    var id = response['data'][i].id;
                                    var name = response['data'][i].name;
                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    selectedValues.push(option);
                            }
                        }
                        ++l;
                        $('#billing_product_id' + l).append(selectedValues);
                        //add_count.push(Object.keys(selectedValues).length);
                    }
                  });




            });

            


            $(document.body).on("change", ".billing_customerid", function() {
              var billing_customerid = this.value;

              $.ajax({
                    url: '/getcustomerwiseproducts/',
                    type: 'get',
                    data: {
                      _token: "{{ csrf_token() }}",
                      billing_customerid: billing_customerid,
                    },
                    dataType: 'json',
                    success: function(response) {
                      console.log(response['data']);
                      var output = response['data'].length;

                      $('#billing_product_id' + 1).empty();

                          var $select = $('#billing_product_id' + 1).append(
                            $('<option>', {
                                value: '0',
                                text: 'Select'
                            }));
                          $('#billing_product_id' + 1).append($select);


                            for (var i = 0; i < output; i++) {
                                $('#billing_product_id' + 1).append($('<option>', {
                                    value: response['data'][i].id,
                                    text: response['data'][i].name
                                }));


                                $('#billing_product_id' + 1).on('change', function() {
                                  var billing_product_id = this.value;

                                  $.ajax({
                                    url: '/getmeasurementforproduct/',
                                    type: 'get',
                                    data: {
                                      _token: "{{ csrf_token() }}",
                                      billing_product_id: billing_product_id,
                                      billing_customerid: billing_customerid,
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                          $('#billing_measurement' + 1).val('');
                                          $('#billing_measurement' + 1).val(response['data']);
                                        }
                                    });
                                });



                            }
                    }
                });
            });



          // $(document.body).on("change", ".billing_customerid", function() {
          //   var customer_id = this.value;

          //       $.ajax({
          //           url: '/getCustomerProducts/',
          //           type: 'get',
          //           data: {
          //             _token: "{{ csrf_token() }}",
          //             customer_id: customer_id,
          //           },
          //           dataType: 'json',
          //           success: function(response) {
          //             $('.billingold_products').html('');

          //               console.log(response);
          //               if (response.status !== 'false') {

          //                 var len = response.length;
          //                 var h = -1;
          //                 for (var i = 0; i < len; i++) {
          //                   if(response[i].measurements != null){
          //                       var Measurement = response[i].measurements;
          //                   }else {
          //                     var Measurement = '';
          //                   }

          //                     var column_0 = $('<td/>', {
          //                     html: '<input type="hidden" id="billingproducts_id" name="billingproducts_id[]"/><input type="hidden" id="hiddenproducts_id' + i + '" name="hiddenproducts_id[]" class="hiddenproducts_id" value="' + response[i].product_id + '"/>' +
          //                           '<input type="hidden" class="form-control customer_product_id" id="customer_product_id' + i + '" name="customer_product_id[]" <input type="hidden" class="form-control customer_product_id" id="customer_product_id' + i + '" name="customer_product_id[]" value="' + response[i].id + '"/>' +
          //                             '<select class="form-control  billing_product_id select js-example-basic-single"  name="billing_product_id[]" id="billing_product_id' + i + '" required>' +
          //                             '<option value="" selected disabled class="text-muted">Select Product</option></select>',
          //                     });

          //                     var column_1 = $('<td/>', {
          //                     html: '<input type="text" class="form-control billing_measurement" id="billing_measurement" name="billing_measurement[]" placeholder="Measurement" value="' + Measurement + '"/>',
          //                     });

          //                     var column_2 = $('<td/>', {
          //                     html: '<input type="text" class="form-control billing_qty" id="billing_qty" name="billing_qty[]" placeholder="Qty" />',
          //                     });

          //                     var column_3 = $('<td/>', {
          //                     html: '<input type="text" class="form-control billing_rateperqty" id="billing_rateperqty" name="billing_rateperqty[]" placeholder="Rate / Qty" />',
          //                     });

          //                     var column_4 = $('<td/>', {
          //                     html: '<input type="text" class="form-control billing_total" id="billing_total" name="billing_total[]" readonly />',
          //                     });

          //                     var column_5 = $('<td/>', {
          //                     html: '<button class="btn additemplus_button addbillingproducts" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>' +
          //                           '<button class="btn additemminus_button remove-billingtr" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button>',
          //                     });

          //                     var row = $('<tr id=stages_tr/>', {}).append(column_0,
          //                                     column_1, column_2, column_3, column_4, column_5);

          //                                 $('.billingold_products').append(row);



          //                           $.ajax({
          //                           url: '/getproducts/',
          //                           type: 'get',
          //                           dataType: 'json',
          //                           success: function(response) {
          //                                 //console.log(response['data']);
          //                                 var len = response['data'].length;

          //                                 var selectedValues = new Array();
          //                                 ++h;
          //                                 if (len > 0) {
          //                                     for (var i = 0; i < len; i++) {
          //                                       var product_id = $('#hiddenproducts_id' + h).val();

          //                                             var id = response['data'][i].id;
          //                                             var name = response['data'][i].name;
          //                                             var option = '<option value="'+ id +'" '+ (id == product_id ? ' selected ' : '') +'>'+ name +'</option>';
          //                                             selectedValues.push(option);
          //                                     }
          //                                 }

          //                                 $('#billing_product_id' + h).append(selectedValues);
          //                                 //add_count.push(Object.keys(selectedValues).length);
          //                             }
          //                           });
          //                 }

          //               }


          //           }
          //       });
          // });




        $(document).on("keyup", "input[name*=billing_rateperqty]", function() {

              var billing_rateperqty = $(this).val();
              var billing_qty = $(this).parents('tr').find('.billing_qty').val();
              var total = billing_qty * billing_rateperqty;
              $(this).parents('tr').find('.billing_total').val(total);

              var sum = 0;
              $(".billing_total").each(function() {
                  sum += +$(this).val();
              });

              $(".total_amount").val(sum.toFixed(2));
              $('.billing_totalamount').text('₹ ' + sum.toFixed(2));


              var billingdiscount_type = $("#billingdiscount_type").val();
              var billingdiscount = $('.billingdiscount').val();

              if(billingdiscount_type == 'Fixed'){

                    $('.billing_discountamount').val(billingdiscount);
                    $('.billing_discount').text('₹ ' + billingdiscount);

                    var total_amount = $(".total_amount").val();
                    var discountq_price = Number(total_amount) - Number(billingdiscount);
                    $('.billing_grandtotalamount').val(discountq_price.toFixed(2));
                    $('.billing_grandtotal').text('₹ ' + discountq_price.toFixed(2));

              }else if(billingdiscount_type == 'Percentage'){

                    var total_amount = $(".total_amount").val();
                    var discountPercentageAmount = (billingdiscount / 100) * total_amount;
                    $('.billing_discountamount').val(discountPercentageAmount);
                    $('.billing_discount').text('₹ ' + discountPercentageAmount);

                    var discountq_price = Number(total_amount) - Number(discountPercentageAmount);
                    $('.billing_grandtotalamount').val(discountq_price.toFixed(2));
                    $('.billing_grandtotal').text('₹ ' + discountq_price.toFixed(2));

              }else if(billingdiscount_type == 'none'){

                    $('.billingdiscount').val(0);
                    $('.billing_discountamount').val(0);
                    $('.billing_discount').text('₹ ' + 0);
                    var total_amount = $(".total_amount").val();

                    $('.billing_grandtotalamount').val(total_amount);
                    $('.billing_grandtotal').text('₹ ' + total_amount);
              }



                var billing_paidamount = $('.billing_paidamount').val();
                var billing_grandtotalamount = $('.billing_grandtotalamount').val();
                var balance_amount = Number(billing_grandtotalamount) - Number(billing_paidamount);
                $('.billing_balanceamount').val(balance_amount.toFixed(2));
                $('.billing_balance').text('₹ ' + balance_amount.toFixed(2));
        });



        $(document).on("keyup", "input[name*=billing_qty]", function() {

              var billing_qty = $(this).val();
              var billing_rateperqty = $(this).parents('tr').find('.billing_rateperqty').val();
              var total = billing_qty * billing_rateperqty;
              $(this).parents('tr').find('.billing_total').val(total);

              var sum = 0;
              $(".billing_total").each(function() {
                  sum += +$(this).val();
              });

              $(".total_amount").val(sum.toFixed(2));
              $('.billing_totalamount').text('₹ ' + sum.toFixed(2));

              var billingdiscount_type = $("#billingdiscount_type").val();
              var billingdiscount = $('.billingdiscount').val();

              if(billingdiscount_type == 'Fixed'){

                    $('.billing_discountamount').val(billingdiscount);
                    $('.billing_discount').text('₹ ' + billingdiscount);

                    var total_amount = $(".total_amount").val();
                    var discountq_price = Number(total_amount) - Number(billingdiscount);
                    $('.billing_grandtotalamount').val(discountq_price.toFixed(2));
                    $('.billing_grandtotal').text('₹ ' + discountq_price.toFixed(2));

              }else if(billingdiscount_type == 'Percentage'){

                    var total_amount = $(".total_amount").val();
                    var discountPercentageAmount = (billingdiscount / 100) * total_amount;
                    $('.billing_discountamount').val(discountPercentageAmount);
                    $('.billing_discount').text('₹ ' + discountPercentageAmount);

                    var discountq_price = Number(total_amount) - Number(discountPercentageAmount);
                    $('.billing_grandtotalamount').val(discountq_price.toFixed(2));
                    $('.billing_grandtotal').text('₹ ' + discountq_price.toFixed(2));

              }else if(billingdiscount_type == 'none'){

                    $('.billingdiscount').val(0);
                    $('.billing_discountamount').val(0);
                    $('.billing_discount').text('₹ ' + 0);
                    var total_amount = $(".total_amount").val();

                    $('.billing_grandtotalamount').val(total_amount);
                    $('.billing_grandtotal').text('₹ ' + total_amount);
              }



                var billing_paidamount = $('.billing_paidamount').val();
                var billing_grandtotalamount = $('.billing_grandtotalamount').val();
                var balance_amount = Number(billing_grandtotalamount) - Number(billing_paidamount);
                $('.billing_balanceamount').val(balance_amount.toFixed(2));
                $('.billing_balance').text('₹ ' + balance_amount.toFixed(2));
        });



        $("#billingdiscount_type").on('change', function() {
              var billingdiscount_type = this.value;

              if(billingdiscount_type == 'Fixed'){

                $('.billingdiscount').val('');
                $('.billing_discountamount').val(0);
                $('.billing_discount').text('₹ ' + 0);

              }else if(billingdiscount_type == 'Percentage'){

                $('.billingdiscount').val('');
                $('.billing_discountamount').val(0);
                $('.billing_discount').text('₹ ' + 0);

              }else if(billingdiscount_type == 'none'){

                $('.billingdiscount').val('');
                $('.billing_discountamount').val(0);
                $('.billing_discount').text('₹ ' + 0);

                var total_amount = $(".total_amount").val();
                $('.billing_grandtotalamount').val(total_amount);
                $('.billing_grandtotal').text('₹ ' + total_amount);

                var billing_paidamount = $('.billing_paidamount').val();
                var billing_grandtotalamount = $('.billing_grandtotalamount').val();
                var balance_amount = Number(billing_grandtotalamount) - Number(billing_paidamount);
                $('.billing_balanceamount').val(balance_amount.toFixed(2));
                $('.billing_balance').text('₹ ' + balance_amount.toFixed(2));

              }
        });


      $(document).on("keyup", 'input.billingdiscount', function() {
          var billingdiscount = $(this).val();
          var billingdiscount_type = $("#billingdiscount_type").val();

          if(billingdiscount_type == 'Fixed'){

                $('.billing_discountamount').val(billingdiscount);
                $('.billing_discount').text('₹ ' + billingdiscount);

                var total_amount = $(".total_amount").val();
                var discountq_price = Number(total_amount) - Number(billingdiscount);
                $('.billing_grandtotalamount').val(discountq_price.toFixed(2));
                $('.billing_grandtotal').text('₹ ' + discountq_price.toFixed(2));

                var billing_paidamount = $('.billing_paidamount').val();
                var billing_grandtotalamount = $('.billing_grandtotalamount').val();
                var balance_amount = Number(billing_grandtotalamount) - Number(billing_paidamount);
                $('.billing_balanceamount').val(balance_amount.toFixed(2));
                $('.billing_balance').text('₹ ' + balance_amount.toFixed(2));

          }else if(billingdiscount_type == 'Percentage'){

                var total_amount = $(".total_amount").val();
                var discountPercentageAmount = (billingdiscount / 100) * total_amount;
                $('.billing_discountamount').val(discountPercentageAmount);
                $('.billing_discount').text('₹ ' + discountPercentageAmount);

                var discountq_price = Number(total_amount) - Number(discountPercentageAmount);
                $('.billing_grandtotalamount').val(discountq_price.toFixed(2));
                $('.billing_grandtotal').text('₹ ' + discountq_price.toFixed(2));

                var billing_paidamount = $('.billing_paidamount').val();
                var billing_grandtotalamount = $('.billing_grandtotalamount').val();
                var balance_amount = Number(billing_grandtotalamount) - Number(billing_paidamount);
                $('.billing_balanceamount').val(balance_amount.toFixed(2));
                $('.billing_balance').text('₹ ' + balance_amount.toFixed(2));

          }else if(billingdiscount_type == 'none'){

                $('.billingdiscount').val(0);
                $('.billing_discountamount').val(0);
                $('.billing_discount').text('₹ ' + 0);
                var total_amount = $(".total_amount").val();

                $('.billing_grandtotalamount').val(total_amount);
                $('.billing_grandtotal').text('₹ ' + total_amount);

                var billing_paidamount = $('.billing_paidamount').val();
                var billing_grandtotalamount = $('.billing_grandtotalamount').val();
                var balance_amount = Number(billing_grandtotalamount) - Number(billing_paidamount);
                $('.billing_balanceamount').val(balance_amount.toFixed(2));
                $('.billing_balance').text('₹ ' + balance_amount.toFixed(2));
          }
      });



      $(document).on("keyup", 'input.billing_paidamount', function() {

          var billing_paidamount = $(this).val();
          var billing_grandtotalamount = $(".billing_grandtotalamount").val();
          var billing_balanceamount = Number(billing_grandtotalamount) - Number(billing_paidamount);
          $('.billing_balanceamount').val(billing_balanceamount.toFixed(2));
          $('.billing_balance').text('₹ ' + billing_balanceamount.toFixed(2));

      });

      $(document).on("keyup", 'input.billing_paidamount', function() {
            var billing_paidamount = $(this).val();
            var billing_grandtotalamount = $(".billing_grandtotalamount").val();

            if (Number(billing_paidamount) > Number(billing_grandtotalamount)) {
                alert('You are entering Maximum Amount of Total');
                $('.billing_paidamount').val('');
                $('.billing_balanceamount').val('');
                $('.billing_balance').text('');
            }
        });



      $(document).on('click', '.remove-billingtr', function() {
        $(this).parents('tr').remove();

        var sum = 0;
              $(".billing_total").each(function() {
                  sum += +$(this).val();
              });

              $(".total_amount").val(sum.toFixed(2));
              $('.billing_totalamount').text('₹ ' + sum.toFixed(2));

              var billingdiscount_type = $("#billingdiscount_type").val();
              var billingdiscount = $('.billingdiscount').val();

              if(billingdiscount_type == 'Fixed'){

                    $('.billing_discountamount').val(billingdiscount);
                    $('.billing_discount').text('₹ ' + billingdiscount);

                    var total_amount = $(".total_amount").val();
                    var discountq_price = Number(total_amount) - Number(billingdiscount);
                    $('.billing_grandtotalamount').val(discountq_price.toFixed(2));
                    $('.billing_grandtotal').text('₹ ' + discountq_price.toFixed(2));

              }else if(billingdiscount_type == 'Percentage'){

                    var total_amount = $(".total_amount").val();
                    var discountPercentageAmount = (billingdiscount / 100) * total_amount;
                    $('.billing_discountamount').val(discountPercentageAmount);
                    $('.billing_discount').text('₹ ' + discountPercentageAmount);

                    var discountq_price = Number(total_amount) - Number(discountPercentageAmount);
                    $('.billing_grandtotalamount').val(discountq_price.toFixed(2));
                    $('.billing_grandtotal').text('₹ ' + discountq_price.toFixed(2));

              }else if(billingdiscount_type == 'none'){

                    $('.billingdiscount').val(0);
                    $('.billing_discountamount').val(0);
                    $('.billing_discount').text('₹ ' + 0);
                    var total_amount = $(".total_amount").val();

                    $('.billing_grandtotalamount').val(total_amount);
                    $('.billing_grandtotal').text('₹ ' + total_amount);
              }



                var billing_paidamount = $('.billing_paidamount').val();
                var billing_grandtotalamount = $('.billing_grandtotalamount').val();
                var balance_amount = Number(billing_grandtotalamount) - Number(billing_paidamount);
                $('.billing_balanceamount').val(balance_amount.toFixed(2));
                $('.billing_balance').text('₹ ' + balance_amount.toFixed(2));
      });



      $(document).on("keyup", "input[name*=payoffedit_amount]", function() {
        var payoffedit_amount = $(this).val();

        var totalAmount = 0;
            $("input[name='payoffedit_amount[]']").each(function() {
                totalAmount = Number(totalAmount) + Number($(this).val());
                $('.payoffedit_totalpaid').val(totalAmount);
            });
            var payoffedit_total = $('.payoffedit_total').val();
            var Balance = Number(payoffedit_total) - Number(totalAmount);
            $('.payoffedit_totalbal').val(Balance.toFixed(2));
      });


      $(document).on("keyup", "input[name*=payoffedit_amount]", function() {
        var payoffedit_amount = $(this).val();

        var totalAmount = 0;
            $("input[name='payoffedit_amount[]']").each(function() {
                totalAmount = Number(totalAmount) + Number($(this).val());
                $('.payoffedit_totalpaid').val(totalAmount);
            });

        var payoffedit_total = $('.payoffedit_total').val();
        if (Number(totalAmount) > Number(payoffedit_total)) {
          alert('!Paid Amount is More than of Total. Add Correct Values!');
            $(this).parents('tr').find('.payoffedit_amount').val('');
            $('.payoffedit_totalbal').val('');
            $('.payoffedit_totalpaid').val('');
        }
      });






  </script>


