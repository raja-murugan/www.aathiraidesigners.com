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
<script>
    var i = 1;
    var j = 1;
        $(document).ready(function() {
            $('.js-example-basic-single').select2();


            $("#phonenumber").keyup(function() {
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
                           // console.log(response['data']);
                            if(response['data'] != null){
                                alert('Already Existed');
                                $('#phonenumber').val('');
                            }
                        }
                    });
                }
            });


            $("#emp_phonenumber").keyup(function() {
                var query = $(this).val();

                if (query != '') {

                    $.ajax({
                        url: "{{ route('employee.checkduplicate') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            query: query
                        },
                        dataType: 'json',
                        success: function(response) {
                           // console.log(response['data']);
                            if(response['data'] != null){
                                alert('Already Existed');
                                $('#emp_phonenumber').val('');
                            }
                        }
                    });
                }
            });





            $(document).on('click', '.addfamilys', function() {
                ++i;
                let  rowIndex = $('.auto_num').length+1;
                let  rowIndexx = $('.auto_num').length+1;

                $(".family_fields").append(
                    '<tr>' +
                    '<td><input class="auto_num form-control"  type="text" readonly value="'+rowIndexx+'"/></td>' +
                    '<td><input type="hidden" name="family_id[]" value=""/><input type="text" class="form-control family_name"id="family_name" name="family_name[]" value="" /></td>' +
                    '<td><input type="text" class="form-control family_relationship"id="family_relationship" name="family_relationship[]" value=""  /></td>' +
                    '<td><input type="date" class="form-control family_dob"id="family_dob" name="family_dob[]"/></td>' +
                    '<td><input type="date" class="form-control family_weddingdate"id="family_weddingdate" name="family_weddingdate[]"/></td>' +
                    '<td><button class="btn btn-danger form-plus-btn remove-tr" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button></td>' +
                    '</tr>'
                );
            });


            $(document).on('click', '.remove-tr', function() {
                $(this).parents('tr').remove();
                regenerate_auto_num();
            });

            function regenerate_auto_num(){
                let count  = 1;
                $(".auto_num").each(function(i,v){
                $(this).val(count);
                count++;
              })
            }
        });


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#customer-img-tag').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".customer_photo").change(function(){
            readURL(this);
        });


        

        

</script>
