@extends('layout.backend.auth')

@section('content')
    <div class="page-wrapper card-body">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="content-page-header">
                    <h6>Add Attendance</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="quotation-card">
                                <div class="card-body">

                                    <form autocomplete="off" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group-item border-0 mb-0">
                                            <div class="row align-item-center">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label> Date <span class="text-danger">*</span></label>
                                                        <input type="date" class="datetimepicker form-control" placeholder="Select Date"
                                                            value="{{ $today }}" name="date" id="date"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Time <span class="text-danger">*</span></label>
                                                        <input type="time" class="datetimepicker form-control" placeholder="Select Date"
                                                            value="{{ $timenow }}" name="time" id="time"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-item-center">
                                                <div class="col-lg-12 col-md-12 col-sm-12" hidden>
                                                   <div class="form-group">
                                                      <div style="display: flex">
                                                         <div id="attendance_camera"></div>
                                                         <div id="captured_attendaceimage"></div>
                                                      </div>
                                                      <input type=button class=" btn btn-sm btn-soft-primary" value="Take a Snap - Photo" onClick="takeattendancesnapshot()">
                                                      <input type="hidden" class="form-control image-attendancecamera" name="attendance_photo" id="attendance_photo">
                                                   </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                   <div class="form-group">
                                                      <label>Photo</label>
                                                      <input type="file" class="form-control" name="attendance_photo" id="attendance_photo">
                                                   </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="text-end" style="margin-top:3%">
                                            <input type="submit" class="btn btn-primary" />
                                            <a href="{{ route('attendance.index') }}"
                                                class="btn btn-cancel btn-danger">Cancel</a>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
<script>
    Webcam.set({
            width: 300,
            height: 300,
            image_format: 'jpeg',
            jpeg_quality: 90,
            facingMode: 'environment'
        });

        Webcam.attach('#attendance_camera');

        function takeattendancesnapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-attendancecamera").val(data_uri);
                document.getElementById('captured_attendaceimage').innerHTML = '<img src="' + data_uri +
                    '" style="height: 220px !important;width: 300px !important;margin-top: 40px;margin-left: 40px;"/>';
            });
        }



$(document).ready(function() {
   $('input[type=file]#attendance_photo').change(function() {
      //alert('changed!');
      var image_two = $(this).val();


                $.ajax({
                    url: '/getemployee_photos/',
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response['data']);
                        var len = response['data'].length;

                        if (len > 0) {
                            for (var i = 0; i < len; i++) {

                                    var id = response['data'][i].id;
                                    var photo = response['data'][i].photo;




                                    Promise.all([
                                        faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
                                        faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
                                        faceapi.nets.faceRecognitionNet.loadFromUri('/models')
                                    ]).then(start);

                                    function start() {
                                        // Get the image elements
                                        const image1 = photo;
                                        const image2 = image_two;

                                        // Detect faces in the images
                                        Promise.all([
                                        faceapi.detectSingleFace(image1).withFaceLandmarks().withFaceDescriptor(),
                                        faceapi.detectSingleFace(image2).withFaceLandmarks().withFaceDescriptor()
                                        ]).then(([face1, face2]) => {
                                        if (face1 && face2) {
                                            // Compare the face descriptors
                                            const distance = faceapi.euclideanDistance(face1.descriptor, face2.descriptor);
                                            console.log('Face distance:', distance);

                                            // You can set a threshold for the distance to determine if faces match
                                            const threshold = 0.6;
                                            if (distance < threshold) {
                                            console.log('Faces match!');
                                            } else {
                                            console.log('Faces do not match.');
                                            }
                                        } else {
                                            console.log('One or both faces not detected.');
                                        }
                                        });
                                    }
                            }
                        }
                    }
                });
   });
});
</script>
    @endsection
