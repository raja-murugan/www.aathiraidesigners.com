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


        Webcam.set({
            width: 150,
            height: 150,
            image_format: 'jpeg',
            jpeg_quality: 90,
            facingMode: 'environment'
        });

        Webcam.attach('#my_camera');

        function takesnapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-tagcamera").val(data_uri);
                document.getElementById('captured_cameraimage').innerHTML = '<img src="' + data_uri +
                    '" style="height: 110px !important;width: 150px !important;margin-top: 20px;margin-left: 20px;"/>';
            });
        }

        // Webcam.attach('#my_cameraone');

        // function takesnapshotone() {
        //     Webcam.snap(function(data_uri) {
        //         $(".image-tagcameraone").val(data_uri);
        //         document.getElementById('captured_cameraimageone').innerHTML = '<img src="' + data_uri +
        //             '" style="height: 110px !important;width: 150px !important;margin-top: 20px;"/>';
        //     });
        // }



      //   $('.admin_checkin_modal').on('show.bs.modal', function (e) {
      //     var $modal = $(this);
      //     var employeeID = $(e.relatedTarget).data('adminemployee_id');
      //     //alert(employeeID);

      //       Webcam.set({
      //         width: 350,
      //         height: 200,
      //         image_format: 'jpeg',
      //         jpeg_quality: 90,
      //         facingMode: 'environment'
      //       });

      //     Webcam.attach('#adminchecin_camera' + employeeID);

      //     $('#admintake_snapshot' + employeeID).click(function() {
      //       Webcam.snap(function(data_uri) {
      //               $('.adminimage-checincamera' + employeeID).val(data_uri);
      //               document.getElementById('admincaptured_checinimage' + employeeID).innerHTML = '<img src="' + data_uri +
      //                   '" style="height: 100px !important;width: 100px !important;margin-top: 20px;margin-left: 20px;"/>';
      //           });
      //       });


      // });

    // $('.admin_checkout_modal').on('show.bs.modal', function (e) {
    //       var $modal = $(this);
    //       var employeeID = $(e.relatedTarget).data('admincheckout_employee_id');
    //       //alert(employeeID);

    //         Webcam.set({
    //           width: 350,
    //           height: 200,
    //           image_format: 'jpeg',
    //           jpeg_quality: 90,
    //           facingMode: 'environment'
    //         });

    //       Webcam.attach('#admincheckout_camera' + employeeID);

    //       $('#admintakecheckout_snapshot' + employeeID).click(function() {
    //         Webcam.snap(function(data_uri) {
    //                 $('.adminimage-checkoutcamera' + employeeID).val(data_uri);
    //                 document.getElementById('admincaptured_checkoutimage' + employeeID).innerHTML = '<img src="' + data_uri +
    //                     '" style="height: 100px !important;width: 100px !important;margin-top: 20px;margin-left: 20px;"/>';
    //             });
    //         });
    //   });


  </script>


