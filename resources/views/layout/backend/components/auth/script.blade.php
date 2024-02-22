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
                    '<td><input type="text" class="form-control measurements" id="measurements" name="measurements[]" placeholder="Measurement" /></td>' +
                    '<td><button class="additemplus_button addproducts" style="margin-right: 3px;" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>' +
                    '<button class="additemminus_button remove-tr" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button></td>' +
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

            });
    
            $(document).on('click', '.remove-tr', function() {
              $(this).parents('tr').remove();
            });
  </script>


