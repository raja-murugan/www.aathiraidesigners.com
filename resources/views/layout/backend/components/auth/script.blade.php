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
          var employeeID = $(e.relatedTarget).data('employee-id');
          alert(employeeID);

          Webcam.set({
              width: 350,
              height: 200,
              image_format: 'jpeg',
              jpeg_quality: 90,
              facingMode: 'environment'
          });

          Webcam.attach('#checin_camera' + employeeID);

            function takechecinsnapshot(employeeID) {
                Webcam.snap(function(data_uri) {
                    $('.image-checincamera' + employeeID).val(data_uri);
                    document.getElementById('captured_checinimage' + employeeID).innerHTML = '<img src="' + data_uri +
                        '" style="height: 220px !important;width: 300px !important;margin-top: 40px;margin-left: 40px;"/>';
                });
            }
        });
  </script>


