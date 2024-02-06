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

                                    <form autocomplete="off" method="POST" action="{{ route('attendance.store') }}" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group-item border-0 mb-0">
                                            <div class="row align-item-center">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label style="text-transform:uppercase;"> Date <span class="text-danger">*</span></label>
                                                        <input type="date" class="datetimepicker form-control" placeholder="Select Date"
                                                            value="{{ $today }}" name="date" id="date"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label style="text-transform:uppercase;">Time <span class="text-danger">*</span></label>
                                                        <input type="time" class="datetimepicker form-control" placeholder="Select Date"
                                                            value="{{ $timenow }}" name="time" id="time"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group-item border-0 mb-0">
                                            <div class="row align-item-center">
                                                <div class="table-responsive no-pagination">
                                                    <table class="table table-center table-hover datatable border">
                                                        <thead style="background: #d3c9ea;">
                                                            <tr class="border">
                                                                <th style="width:20%;text-transform:uppercase;">S.No</th>
                                                                <th style="width:30%;text-transform:uppercase;">Employee</th>
                                                                <th style="width:50%;text-transform:uppercase;">Check-In / Check Out</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="">
                                                        @foreach ($attendance as $keydata => $attendances)
                                                            <tr class="border">
                                                                <td>{{ ++$keydata }}</td>
                                                                <td style="text-transform:uppercase;">{{ $attendances['employee'] }}<input type="hidden" class="form-control employee_id"
                                                                    id="employee_id" name="employee_id[]" value="{{ $attendances['employee_id'] }}" required /></td>
                                                                <td>
                                                                    <div style="display:flex;">
                                                                    @if ($attendances['status'] == '')
                                                                        <div class="input-group" style="margin-right: 5px;">
                                                                            <div class="input-group-text">
                                                                                <input class="form-check-input" type="radio" value="1" id="attendance" name="attendance[{{ $attendances['employee_id'] }}]"
                                                                                    aria-label="Radio button for following text input" >
                                                                            </div>
                                                                            <input type="text" class="form-control" value="Check-In" disabled style="text-transform:uppercase;"
                                                                                aria-label="Text input with radio button">
                                                                        </div>
                                                                        <div class="input-group" style="margin-right: 5px;">
                                                                            <div class="input-group-text">
                                                                                <input class="form-check-input" type="radio" value="0" id="attendance" name="attendance[{{ $attendances['employee_id'] }}]"
                                                                                    aria-label="Radio button for following text input" >
                                                                            </div>
                                                                            <input type="text" class="form-control" value="Leave" disabled style="text-transform:uppercase;"
                                                                                aria-label="Text input with radio button">
                                                                        </div>
                                                                        @elseif ($attendances['status'] == 1)

                                                                        <div class="input-group" style="margin-right: 5px;">
                                                                            <div class="input-group-text">
                                                                                <input class="form-check-input" type="radio" value="2" id="attendance" name="attendance[{{ $attendances['employee_id'] }}]"
                                                                                    aria-label="Radio button for following text input">
                                                                            </div>
                                                                            <input type="text" class="form-control" value="Check-Out" disabled style="text-transform:uppercase;"
                                                                                aria-label="Text input with radio button" >
                                                                        </div>
                                                                        @elseif ($attendances['status'] == 2)

                                                                        <div class="input-group" style="margin-right: 5px;">
                                                                            <div class="input-group-text">
                                                                                <input class="form-check-input" type="radio" value="1" id="attendance" name="attendance[{{ $attendances['employee_id'] }}]"
                                                                                    aria-label="Radio button for following text input" >
                                                                            </div>
                                                                            <input type="text" class="form-control" value="Check-In" disabled style="text-transform:uppercase;"
                                                                                aria-label="Text input with radio button">
                                                                        </div>

                                                                        @elseif ($attendances['status'] == 0)
                                                                        <span style="color:red;">LEAVE</span>
                                                                            <input class="form-check-input" type="hidden" value="0" id="attendance" name="attendance[{{ $attendances['employee_id'] }}]"
                                                                                    aria-label="Radio button for following text input" checked>
                                                                        @endif

                                                                        
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- <div class="row align-item-center">
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
                                            </div> -->

                                        </div>

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
    // Webcam.set({
    //         width: 300,
    //         height: 300,
    //         image_format: 'jpeg',
    //         jpeg_quality: 90,
    //         facingMode: 'environment'
    //     });

    //     Webcam.attach('#attendance_camera');

    //     function takeattendancesnapshot() {
    //         Webcam.snap(function(data_uri) {
    //             $(".image-attendancecamera").val(data_uri);
    //             document.getElementById('captured_attendaceimage').innerHTML = '<img src="' + data_uri +
    //                 '" style="height: 220px !important;width: 300px !important;margin-top: 40px;margin-left: 40px;"/>';
    //         });
    //     }



//$(document).ready(function() {
//    $('input[type=file]#attendance_photo').change(function() {
//       //alert('changed!');
//       var image_two = $(this).val();


//                 $.ajax({
//                     url: '/getemployee_photos/',
//                     type: 'get',
//                     dataType: 'json',
//                     success: function(response) {
//                         console.log(response['data']);
//                         var len = response['data'].length;

//                         if (len > 0) {
//                             for (var i = 0; i < len; i++) {

//                                     var id = response['data'][i].id;
//                                     var photo = response['data'][i].photo;




//                                     Promise.all([
//                                         faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
//                                         faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
//                                         faceapi.nets.faceRecognitionNet.loadFromUri('/models')
//                                     ]).then(start);

//                                     function start() {
//                                         // Get the image elements
//                                         const image1 = photo;
//                                         const image2 = image_two;

//                                         // Detect faces in the images
//                                         Promise.all([
//                                         faceapi.detectSingleFace(image1).withFaceLandmarks().withFaceDescriptor(),
//                                         faceapi.detectSingleFace(image2).withFaceLandmarks().withFaceDescriptor()
//                                         ]).then(([face1, face2]) => {
//                                         if (face1 && face2) {
//                                             // Compare the face descriptors
//                                             const distance = faceapi.euclideanDistance(face1.descriptor, face2.descriptor);
//                                             console.log('Face distance:', distance);

//                                             // You can set a threshold for the distance to determine if faces match
//                                             const threshold = 0.6;
//                                             if (distance < threshold) {
//                                             console.log('Faces match!');
//                                             } else {
//                                             console.log('Faces do not match.');
//                                             }
//                                         } else {
//                                             console.log('One or both faces not detected.');
//                                         }
//                                         });
//                                     }
//                             }
//                         }
//                     }
//                 });
//    });
//});
</script>
    @endsection
