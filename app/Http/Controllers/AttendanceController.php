<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;
use PDF;

class AttendanceController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $current_date = Carbon::now()->format('Y-m-d');

        $Attendance_data = [];
        $AllEmployees = Employee::where('soft_delete', '!=', 1)->get();
        foreach ($AllEmployees as $key => $AllEmployees_arr) {

            $checkindata = Attendance::where('checkin_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkindata != ""){
                if($checkindata->status == 1){
                    $checkin_time = $checkindata->checkin_time;
                    $checkin_photo = $checkindata->checkin_photo;
                }else {
                    $checkin_time = '';
                    $checkin_photo = '';
                }

            }else {
                $checkin_time = '';
                $checkin_photo = '';
            }

            $checkoutdata = Attendance::where('checkout_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkoutdata != ""){
                if($checkoutdata->status == 1){
                    $checkout_time = $checkoutdata->checkout_time;
                    $checkout_photo = $checkoutdata->checkout_photo;
                    $total_time = $checkoutdata->working_hour;
                }else {
                    $checkout_time = '';
                    $checkout_photo = '';
                    $total_time = '';
                }

            }else {
                $checkout_time = '';
                $checkout_photo = '';
                $total_time = '';
            }

            $attendance_date = Attendance::where('date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($attendance_date != ""){

                $attendance_id = $attendance_date->id;

                if($attendance_date->status == 1){
                    $status = 'Present';
                }else if($attendance_date->status == 2) {
                    $status = 'Absent';
                }else {
                    $status = 'Empty';
                }

            }else {
                $attendance_id = '';
                $status = '';
            }

            $Attendance_data[] = array(
                'employee_id' => $AllEmployees_arr->id,
                'employee' => $AllEmployees_arr->name,
                'photo' => $AllEmployees_arr->photo,
                'unique_key' => $AllEmployees_arr->unique_key,
                'id' => $AllEmployees_arr->id,
                'checkin_time' => $checkin_time,
                'checkout_time' => $checkout_time,
                'checkin_photo' => $checkin_photo,
                'checkout_photo' => $checkout_photo,
                'attendance_id' => $attendance_id,
                'total_time' => $total_time,
                'status' => $status,
            );
        }
        $AllDepartment = Department::where('soft_delete', '!=', 1)->get();
        $department_name = 'Attendance';

        return view('page.backend.attendance.index', compact('Attendance_data', 'today', 'timenow', 'AllDepartment', 'department_name', 'current_date'));
    }

    public function datefilter(Request $request)
    {
        $today = $request->get('from_date');

        $current_date = Carbon::now()->format('Y-m-d');

        $timenow = Carbon::now()->format('H:i');

        $Attendance_data = [];
        $AllEmployees = Employee::where('soft_delete', '!=', 1)->get();
        foreach ($AllEmployees as $key => $AllEmployees_arr) {

            $checkindata = Attendance::where('checkin_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkindata != ""){
                if($checkindata->status == 1){
                    $checkin_time = $checkindata->checkin_time;
                    $checkin_photo = $checkindata->checkin_photo;
                }else {
                    $checkin_time = '';
                    $checkin_photo = '';
                }

            }else {
                $checkin_time = '';
                $checkin_photo = '';
            }

            $checkoutdata = Attendance::where('checkout_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkoutdata != ""){
                if($checkoutdata->status == 1){
                    $checkout_time = $checkoutdata->checkout_time;
                    $checkout_photo = $checkoutdata->checkout_photo;
                    $total_time = $checkoutdata->working_hour;
                }else {
                    $checkout_time = '';
                    $checkout_photo = '';
                    $total_time = '';
                }

            }else {
                $checkout_time = '';
                $checkout_photo = '';
                $total_time = '';
            }

            $attendance_date = Attendance::where('date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($attendance_date != ""){

                $attendance_id = $attendance_date->id;

                if($attendance_date->status == 1){
                    $status = 'Present';
                }else if($attendance_date->status == 2) {
                    $status = 'Absent';
                }else {
                    $status = 'Empty';
                }

            }else {
                $attendance_id = '';
                $status = '';
            }

            $Attendance_data[] = array(
                'employee_id' => $AllEmployees_arr->id,
                'employee' => $AllEmployees_arr->name,
                'unique_key' => $AllEmployees_arr->unique_key,
                'id' => $AllEmployees_arr->id,
                'checkin_time' => $checkin_time,
                'checkout_time' => $checkout_time,
                'checkin_photo' => $checkin_photo,
                'checkout_photo' => $checkout_photo,
                'attendance_id' => $attendance_id,
                'total_time' => $total_time,
                'status' => $status,
                'photo' => $AllEmployees_arr->photo,
            );
        }

        $AllDepartment = Department::where('soft_delete', '!=', 1)->get();
        $department_name = 'Attendance';

        return view('page.backend.attendance.index', compact('Attendance_data', 'today', 'timenow', 'AllDepartment', 'department_name', 'current_date'));

    }


    public function departmentwisefilter(Request $request)
    {
        $department_name = $request->get('department_name');

        $departmentname = Department::where('name', '=', $department_name)->first();
      
        $current_date = Carbon::now()->format('Y-m-d');
      

        $today = $request->get('date');
        $timenow = Carbon::now()->format('H:i');

        $Attendance_data = [];
        $AllEmployees = Employee::where('soft_delete', '!=', 1)->where('department_id', '=', $departmentname->id)->get();
        foreach ($AllEmployees as $key => $AllEmployees_arr) {

            $checkindata = Attendance::where('checkin_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkindata != ""){
                if($checkindata->status == 1){
                    $checkin_time = $checkindata->checkin_time;
                    $checkin_photo = $checkindata->checkin_photo;
                }else {
                    $checkin_time = '';
                    $checkin_photo = '';
                }

            }else {
                $checkin_time = '';
                $checkin_photo = '';
            }

            $checkoutdata = Attendance::where('checkout_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkoutdata != ""){
                if($checkoutdata->status == 1){
                    $checkout_time = $checkoutdata->checkout_time;
                    $checkout_photo = $checkoutdata->checkout_photo;
                    $total_time = $checkoutdata->working_hour;
                }else {
                    $checkout_time = '';
                    $checkout_photo = '';
                    $total_time = '';
                }

            }else {
                $checkout_time = '';
                $checkout_photo = '';
                $total_time = '';
            }

            $attendance_date = Attendance::where('date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($attendance_date != ""){

                $attendance_id = $attendance_date->id;

                if($attendance_date->status == 1){
                    $status = 'Present';
                }else if($attendance_date->status == 2) {
                    $status = 'Absent';
                }else {
                    $status = 'Empty';
                }

            }else {
                $attendance_id = '';
                $status = '';
            }

            $Attendance_data[] = array(
                'employee_id' => $AllEmployees_arr->id,
                'employee' => $AllEmployees_arr->name,
                'photo' => $AllEmployees_arr->photo,
                'unique_key' => $AllEmployees_arr->unique_key,
                'id' => $AllEmployees_arr->id,
                'checkin_time' => $checkin_time,
                'checkout_time' => $checkout_time,
                'checkin_photo' => $checkin_photo,
                'checkout_photo' => $checkout_photo,
                'attendance_id' => $attendance_id,
                'total_time' => $total_time,
                'status' => $status,
            );
        }
        $AllDepartment = Department::where('soft_delete', '!=', 1)->get();

        return view('page.backend.attendance.index', compact('Attendance_data', 'today', 'timenow', 'AllDepartment', 'department_name', 'current_date'));


    }

    public function checkinstore(Request $request)
    {
        if ($request->checkin_photo != "") {
            $today = Carbon::now()->format('Y-m-d');
            $timenow = Carbon::now()->format('H:i');
            $employeename = $request->get('employee');
            $employee_id = $request->get('employee_id');

            $random_no =  rand(100,999);

            $data = new Attendance();
            $data->month = date('m', strtotime($request->get('date')));
            $data->year = date('Y', strtotime($request->get('date')));
            $data->date = $request->get('date');
            $data->employee_id = $request->get('employee_id');
            $data->checkin_date = $request->get('date');
            $data->checkin_time = $request->get('time');
            $data->working_hour = '';

            $checkin_photo = $request->checkin_photo;
            $folderPath = "assets/backend/checkin/";
            $image_parts = explode(";base64,", $checkin_photo);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $employeename . '_' . $random_no . '_' . 'emploee' . '.webp';
            $customerimgfile = $folderPath . $fileName;
            file_put_contents($customerimgfile, $image_base64);
            $data->checkin_photo = $customerimgfile;

            $data->status = 1;
            $data->save();

            return redirect()->route('attendance.index')->with('message', 'Added !');
            
        }else {

            $today = Carbon::now()->format('Y-m-d');
            $timenow = Carbon::now()->format('H:i');
            $employeename = $request->get('employee');
            $employee_id = $request->get('employee_id');

            $random_no =  rand(100,999);

            $data = new Attendance();
            $data->month = date('m', strtotime($request->get('date')));
            $data->year = date('Y', strtotime($request->get('date')));
            $data->date = $request->get('date');
            $data->employee_id = $request->get('employee_id');
            $data->checkin_date = $request->get('date');
            $data->checkin_time = $request->get('time');
            $data->working_hour = '';

            $data->status = 1;
            $data->save();

            
            return redirect()->route('attendance.index')->with('warning', 'Capture Your Photo !');

        }
    }



    public function checkoutstore(Request $request)
    {
        if ($request->checkout_photo != "") {
            $today = Carbon::now()->format('Y-m-d');
            $timenow = Carbon::now()->format('H:i');

            $employeename = $request->get('employee');
            $employee_id = $request->get('employee_id');
            $random_no =  rand(100,999);

            $checkindata = Attendance::where('checkin_date', '=', $request->get('date'))->where('employee_id', '=', $employee_id)->where('status', '=', 1)->first();
            $checkindata->checkout_date = $request->get('date');
            $checkindata->checkout_time = $request->get('time');


            $checkout_photo = $request->checkout_photo;
            $folderPath = "assets/backend/checkout/";
            $image_parts = explode(";base64,", $checkout_photo);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $employeename . '_' . $random_no . '_' . 'emploee' . '.webp';
            $customerimgfile = $folderPath . $fileName;
            file_put_contents($customerimgfile, $image_base64);
            $checkindata->checkout_photo = $customerimgfile;



            $time1 = strtotime($checkindata->checkin_time);
            $time2 = strtotime($request->get('time'));
            $difference = ($time2 - $time1) / 60;

            $hours = floor($difference / 60);
            $min = $difference - ($hours * 60);
            $total_time = $hours."Hours ".$min."Mins";

            $checkindata->working_hour = $total_time;
            $checkindata->status = 1;
            $checkindata->update();

            return redirect()->route('attendance.index')->with('message', 'Added !');
        }else {


            $today = Carbon::now()->format('Y-m-d');
            $timenow = Carbon::now()->format('H:i');

            $employeename = $request->get('employee');
            $employee_id = $request->get('employee_id');
            $random_no =  rand(100,999);

            $checkindata = Attendance::where('checkin_date', '=', $request->get('date'))->where('employee_id', '=', $employee_id)->where('status', '=', 1)->first();
            $checkindata->checkout_date = $request->get('date');
            $checkindata->checkout_time = $request->get('time');

            $time1 = strtotime($checkindata->checkin_time);
            $time2 = strtotime($request->get('time'));
            $difference = ($time2 - $time1) / 60;

            $hours = floor($difference / 60);
            $min = $difference - ($hours * 60);
            $total_time = $hours."Hours ".$min."Mins";

            $checkindata->working_hour = $total_time;
            $checkindata->status = 1;
            $checkindata->update();

            return redirect()->route('attendance.index')->with('warning', 'Capture Your Photo !');

        }
    }

    public function edit(Request $request, $attendance_id)
    {
        $AttendanceData = Attendance::where('id', '=', $attendance_id)->first();
        $AttendanceData->checkin_time = $request->get('checkin_time');
        $AttendanceData->checkout_time = $request->get('checkout_time');

        $AttendanceData->checkout_date = $AttendanceData->checkin_date;

        $time1 = strtotime($request->get('checkin_time'));
        $time2 = strtotime($request->get('checkout_time'));
        $difference = ($time2 - $time1) / 60;

        $hours = floor($difference / 60);
        $min = $difference - ($hours * 60);
        $total_time = $hours."Hours ".$min."Mins";

        $AttendanceData->working_hour = $total_time;
        $AttendanceData->update();

      //  return redirect()->route('attendance.index')->with('info', 'Updated !');

        $today = $AttendanceData->checkin_date;
        $current_date = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');



        $Attendance_data = [];
        $AllEmployees = Employee::where('soft_delete', '!=', 1)->get();
        foreach ($AllEmployees as $key => $AllEmployees_arr) {

            $checkindata = Attendance::where('checkin_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkindata != ""){
                if($checkindata->status == 1){
                    $checkin_time = $checkindata->checkin_time;
                    $checkin_photo = $checkindata->checkin_photo;
                }else {
                    $checkin_time = '';
                    $checkin_photo = '';
                }

            }else {
                $checkin_time = '';
                $checkin_photo = '';
            }

            $checkoutdata = Attendance::where('checkout_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkoutdata != ""){
                if($checkoutdata->status == 1){
                    $checkout_time = $checkoutdata->checkout_time;
                    $checkout_photo = $checkoutdata->checkout_photo;
                    $total_time = $checkoutdata->working_hour;
                }else {
                    $checkout_time = '';
                    $checkout_photo = '';
                    $total_time = '';
                }

            }else {
                $checkout_time = '';
                $checkout_photo = '';
                $total_time = '';
            }

            $attendance_date = Attendance::where('date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($attendance_date != ""){

                $attendance_id = $attendance_date->id;

                if($attendance_date->status == 1){
                    $status = 'Present';
                }else if($attendance_date->status == 2) {
                    $status = 'Absent';
                }else {
                    $status = 'Empty';
                }

            }else {
                $attendance_id = '';
                $status = '';
            }

            $Attendance_data[] = array(
                'employee_id' => $AllEmployees_arr->id,
                'employee' => $AllEmployees_arr->name,
                'unique_key' => $AllEmployees_arr->unique_key,
                'id' => $AllEmployees_arr->id,
                'checkin_time' => $checkin_time,
                'checkout_time' => $checkout_time,
                'checkin_photo' => $checkin_photo,
                'checkout_photo' => $checkout_photo,
                'attendance_id' => $attendance_id,
                'total_time' => $total_time,
                'status' => $status,
                'photo' => $AllEmployees_arr->photo,
            );
        }

        $AllDepartment = Department::where('soft_delete', '!=', 1)->get();
        $department_name = 'Attendance';


        return view('page.backend.attendance.index', compact('Attendance_data', 'today', 'timenow', 'AllDepartment', 'department_name', 'current_date'));

    }


    public function dateupdate(Request $request, $date)
    {

        $time1 = strtotime($request->get('checkin_time'));
        $time2 = strtotime($request->get('checkout_time'));
        $difference = ($time2 - $time1) / 60;

        $hours = floor($difference / 60);
        $min = $difference - ($hours * 60);
        $total_time = $hours."Hours ".$min."Mins";

        $attendance_date = Attendance::where('date', '=', $date)->where('employee_id', '=', $request->get('employee_id'))->first();
        if($attendance_date != ""){

            $attendance_date->checkin_date = $date;
            $attendance_date->checkin_time = $request->get('checkin_time');
            $attendance_date->checkout_date = $date;
            $attendance_date->checkout_time = $request->get('checkout_time');
            $attendance_date->working_hour = $total_time;
            $attendance_date->status = 1;
            $attendance_date->update();




        }else {
            $data = new Attendance();
            $data->month = date('m', strtotime($date));
            $data->year = date('Y', strtotime($date));
            $data->date = $date;
            $data->employee_id = $request->get('employee_id');
            $data->checkin_date = $date;
            $data->checkin_time = $request->get('checkin_time');
            $data->checkout_date = $date;
            $data->checkout_time = $request->get('checkout_time');
            $data->working_hour = $total_time;
            $data->status = 1;
            $data->save();


            
        }


        


        $today = $date;

        $current_date = Carbon::now()->format('Y-m-d');

        $timenow = Carbon::now()->format('H:i');

        $Attendance_data = [];
        $AllEmployees = Employee::where('soft_delete', '!=', 1)->get();
        foreach ($AllEmployees as $key => $AllEmployees_arr) {

            $checkindata = Attendance::where('checkin_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkindata != ""){
                if($checkindata->status == 1){
                    $checkin_time = $checkindata->checkin_time;
                    $checkin_photo = $checkindata->checkin_photo;
                }else {
                    $checkin_time = '';
                    $checkin_photo = '';
                }

            }else {
                $checkin_time = '';
                $checkin_photo = '';
            }

            $checkoutdata = Attendance::where('checkout_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkoutdata != ""){
                if($checkoutdata->status == 1){
                    $checkout_time = $checkoutdata->checkout_time;
                    $checkout_photo = $checkoutdata->checkout_photo;
                    $total_time = $checkoutdata->working_hour;
                }else {
                    $checkout_time = '';
                    $checkout_photo = '';
                    $total_time = '';
                }

            }else {
                $checkout_time = '';
                $checkout_photo = '';
                $total_time = '';
            }

            $attendance_date = Attendance::where('date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($attendance_date != ""){

                $attendance_id = $attendance_date->id;

                if($attendance_date->status == 1){
                    $status = 'Present';
                }else if($attendance_date->status == 2) {
                    $status = 'Absent';
                }else {
                    $status = 'Empty';
                }

            }else {
                $attendance_id = '';
                $status = '';
            }

            $Attendance_data[] = array(
                'employee_id' => $AllEmployees_arr->id,
                'employee' => $AllEmployees_arr->name,
                'unique_key' => $AllEmployees_arr->unique_key,
                'id' => $AllEmployees_arr->id,
                'checkin_time' => $checkin_time,
                'checkout_time' => $checkout_time,
                'checkin_photo' => $checkin_photo,
                'checkout_photo' => $checkout_photo,
                'attendance_id' => $attendance_id,
                'total_time' => $total_time,
                'status' => $status,
                'photo' => $AllEmployees_arr->photo,
            );
        }

        $AllDepartment = Department::where('soft_delete', '!=', 1)->get();
        $department_name = 'Attendance';

        return view('page.backend.attendance.index', compact('Attendance_data', 'today', 'timenow', 'AllDepartment', 'department_name', 'current_date'));
    }

    public function leaveupdate(Request $request, $id)
    {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $data = new Attendance();
        $data->month = date('m', strtotime($request->get('date')));
        $data->year = date('Y', strtotime($request->get('date')));
        $data->date = $request->get('date');
        $data->employee_id = $id;
        $data->status = 2;
        $data->save();

        return redirect()->route('attendance.index')->with('info', 'Updated !');
    }






    public function admin_index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $Attendance_data = [];
        $AllEmployees = Employee::where('soft_delete', '!=', 1)->get();
        foreach ($AllEmployees as $key => $AllEmployees_arr) {

            $checkindata = Attendance::where('checkin_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkindata != ""){
                if($checkindata->status == 1){
                    $checkin_time = $checkindata->checkin_time;
                    $checkin_photo = $checkindata->checkin_photo;
                }else {
                    $checkin_time = '';
                    $checkin_photo = '';
                }

            }else {
                $checkin_time = '';
                $checkin_photo = '';
            }

            $checkoutdata = Attendance::where('checkout_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkoutdata != ""){
                if($checkoutdata->status == 1){
                    $checkout_time = $checkoutdata->checkout_time;
                    $checkout_photo = $checkoutdata->checkout_photo;
                    $total_time = $checkoutdata->working_hour;
                }else {
                    $checkout_time = '';
                    $checkout_photo = '';
                    $total_time = '';
                }

            }else {
                $checkout_time = '';
                $checkout_photo = '';
                $total_time = '';
            }

            $attendance_date = Attendance::where('date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($attendance_date != ""){

                $attendance_id = $attendance_date->id;

                if($attendance_date->status == 1){
                    $status = 'Present';
                }else if($attendance_date->status == 2) {
                    $status = 'Absent';
                }else {
                    $status = 'Empty';
                }

            }else {
                $attendance_id = '';
                $status = '';
            }

            $Attendance_data[] = array(
                'employee_id' => $AllEmployees_arr->id,
                'employee' => $AllEmployees_arr->name,
                'photo' => $AllEmployees_arr->photo,
                'unique_key' => $AllEmployees_arr->unique_key,
                'id' => $AllEmployees_arr->id,
                'checkin_time' => $checkin_time,
                'checkout_time' => $checkout_time,
                'checkin_photo' => $checkin_photo,
                'checkout_photo' => $checkout_photo,
                'attendance_id' => $attendance_id,
                'total_time' => $total_time,
                'status' => $status,
            );
        }

        $AllDepartment = Department::where('soft_delete', '!=', 1)->get();
        $department_name = 'Attendance';

        return view('page.backend.admin_attendance.admin_index', compact('Attendance_data', 'today', 'timenow', 'AllDepartment', 'department_name'));
    }

    public function admin_departmentwisefilter(Request $request)
    {
        $department_name = $request->get('department_name');

        $departmentname = Department::where('name', '=', $department_name)->first();
      

      

        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $Attendance_data = [];
        $AllEmployees = Employee::where('soft_delete', '!=', 1)->where('department_id', '=', $departmentname->id)->get();
        foreach ($AllEmployees as $key => $AllEmployees_arr) {

            $checkindata = Attendance::where('checkin_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkindata != ""){
                if($checkindata->status == 1){
                    $checkin_time = $checkindata->checkin_time;
                    $checkin_photo = $checkindata->checkin_photo;
                }else {
                    $checkin_time = '';
                    $checkin_photo = '';
                }

            }else {
                $checkin_time = '';
                $checkin_photo = '';
            }

            $checkoutdata = Attendance::where('checkout_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkoutdata != ""){
                if($checkoutdata->status == 1){
                    $checkout_time = $checkoutdata->checkout_time;
                    $checkout_photo = $checkoutdata->checkout_photo;
                    $total_time = $checkoutdata->working_hour;
                }else {
                    $checkout_time = '';
                    $checkout_photo = '';
                    $total_time = '';
                }

            }else {
                $checkout_time = '';
                $checkout_photo = '';
                $total_time = '';
            }

            $attendance_date = Attendance::where('date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($attendance_date != ""){

                $attendance_id = $attendance_date->id;

                if($attendance_date->status == 1){
                    $status = 'Present';
                }else if($attendance_date->status == 2) {
                    $status = 'Absent';
                }else {
                    $status = 'Empty';
                }

            }else {
                $attendance_id = '';
                $status = '';
            }

            $Attendance_data[] = array(
                'employee_id' => $AllEmployees_arr->id,
                'employee' => $AllEmployees_arr->name,
                'photo' => $AllEmployees_arr->photo,
                'unique_key' => $AllEmployees_arr->unique_key,
                'id' => $AllEmployees_arr->id,
                'checkin_time' => $checkin_time,
                'checkout_time' => $checkout_time,
                'checkin_photo' => $checkin_photo,
                'checkout_photo' => $checkout_photo,
                'attendance_id' => $attendance_id,
                'total_time' => $total_time,
                'status' => $status,
            );
        }
        $AllDepartment = Department::where('soft_delete', '!=', 1)->get();

        return view('page.backend.admin_attendance.admin_index', compact('Attendance_data', 'today', 'timenow', 'AllDepartment', 'department_name'));


    }

    public function admin_datefilter(Request $request)
    {
        $today = $request->get('from_date');

        $timenow = Carbon::now()->format('H:i');

        $Attendance_data = [];
        $AllEmployees = Employee::where('soft_delete', '!=', 1)->get();
        foreach ($AllEmployees as $key => $AllEmployees_arr) {

            $checkindata = Attendance::where('checkin_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkindata != ""){
                if($checkindata->status == 1){
                    $checkin_time = $checkindata->checkin_time;
                    $checkin_photo = $checkindata->checkin_photo;
                }else {
                    $checkin_time = '';
                    $checkin_photo = '';
                }

            }else {
                $checkin_time = '';
                $checkin_photo = '';
            }

            $checkoutdata = Attendance::where('checkout_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkoutdata != ""){
                if($checkoutdata->status == 1){
                    $checkout_time = $checkoutdata->checkout_time;
                    $checkout_photo = $checkoutdata->checkout_photo;
                    $total_time = $checkoutdata->working_hour;
                }else {
                    $checkout_time = '';
                    $checkout_photo = '';
                    $total_time = '';
                }

            }else {
                $checkout_time = '';
                $checkout_photo = '';
                $total_time = '';
            }

            $attendance_date = Attendance::where('date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($attendance_date != ""){

                $attendance_id = $attendance_date->id;

                if($attendance_date->status == 1){
                    $status = 'Present';
                }else if($attendance_date->status == 2) {
                    $status = 'Absent';
                }else {
                    $status = 'Empty';
                }

            }else {
                $attendance_id = '';
                $status = '';
            }

            $Attendance_data[] = array(
                'employee_id' => $AllEmployees_arr->id,
                'employee' => $AllEmployees_arr->name,
                'unique_key' => $AllEmployees_arr->unique_key,
                'id' => $AllEmployees_arr->id,
                'checkin_time' => $checkin_time,
                'checkout_time' => $checkout_time,
                'checkin_photo' => $checkin_photo,
                'checkout_photo' => $checkout_photo,
                'attendance_id' => $attendance_id,
                'total_time' => $total_time,
                'status' => $status,
            );
        }
        return view('page.backend.admin_attendance.admin_index', compact('Attendance_data', 'today', 'timenow'));
    }

    public function admin_checkinstore(Request $request)
    {
        if ($request->checkin_photo != "") {
            $today = Carbon::now()->format('Y-m-d');
            $timenow = Carbon::now()->format('H:i');
            $employeename = $request->get('employee');
            $employee_id = $request->get('employee_id');

            $random_no =  rand(100,999);

            $data = new Attendance();
            $data->month = date('m', strtotime($request->get('date')));
            $data->year = date('Y', strtotime($request->get('date')));
            $data->date = $request->get('date');
            $data->employee_id = $request->get('employee_id');
            $data->checkin_date = $request->get('date');
            $data->checkin_time = $request->get('time');
            $data->working_hour = '';


        //  dd($request->checkin_photo);

                $checkin_photo = $request->checkin_photo;
                $folderPath = "assets/backend/checkin/";
                $image_parts = explode(";base64,", $checkin_photo);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = $employeename . '_' . $random_no . '_' . 'emploee' . '.webp';
                $customerimgfile = $folderPath . $fileName;
                file_put_contents($customerimgfile, $image_base64);
                $data->checkin_photo = $customerimgfile;

            $data->status = 1;
            $data->save();

            return redirect()->route('admin_attendance.admin_index')->with('message', 'Added !');
        }else {
            return redirect()->route('admin_attendance.admin_index')->with('warning', 'Capture Your Photo !');
        }
    }



    public function admin_checkoutstore(Request $request)
    {
        if ($request->checkout_photo != "") {
            $today = Carbon::now()->format('Y-m-d');
            $timenow = Carbon::now()->format('H:i');

            $employeename = $request->get('employee');
            $employee_id = $request->get('employee_id');
            $random_no =  rand(100,999);

            $checkindata = Attendance::where('checkin_date', '=', $today)->where('employee_id', '=', $employee_id)->where('status', '=', 1)->first();
            $checkindata->checkout_date = $request->get('date');
            $checkindata->checkout_time = $request->get('time');

        //  dd($request->checkout_photo);

                $checkout_photo = $request->checkout_photo;
                $folderPath = "assets/backend/checkout/";
                $image_parts = explode(";base64,", $checkout_photo);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = $employeename . '_' . $random_no . '_' . 'emploee' . '.webp';
                $customerimgfile = $folderPath . $fileName;
                file_put_contents($customerimgfile, $image_base64);
                $checkindata->checkout_photo = $customerimgfile;



            $time1 = strtotime($checkindata->checkin_time);
            $time2 = strtotime($request->get('time'));
            $difference = ($time2 - $time1) / 60;

            $hours = floor($difference / 60);
            $min = $difference - ($hours * 60);
            $total_time = $hours."Hours ".$min."Mins";

            $checkindata->working_hour = $total_time;
            $checkindata->status = 1;
            $checkindata->update();

            return redirect()->route('admin_attendance.admin_index')->with('message', 'Added !');
        }else {
            return redirect()->route('admin_attendance.admin_index')->with('warning', 'Capture Your Photo !');
        }
    }

    public function admin_edit(Request $request, $attendance_id)
    {
        $AttendanceData = Attendance::where('id', '=', $attendance_id)->first();
        $AttendanceData->checkin_time = $request->get('checkin_time');
        $AttendanceData->checkout_time = $request->get('checkout_time');

        $time1 = strtotime($request->get('checkin_time'));
        $time2 = strtotime($request->get('checkout_time'));
        $difference = ($time2 - $time1) / 60;

        $hours = floor($difference / 60);
        $min = $difference - ($hours * 60);
        $total_time = $hours."Hours ".$min."Mins";

        $AttendanceData->working_hour = $total_time;
        $AttendanceData->update();

        return redirect()->route('admin_attendance.admin_index')->with('info', 'Updated !');
    }

    public function admin_leaveupdate($id)
    {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $data = new Attendance();
        $data->month = date('m', strtotime($today));
        $data->year = date('Y', strtotime($today));
        $data->date = $today;
        $data->employee_id = $id;
        $data->status = 2;
        $data->save();

        return redirect()->route('admin_attendance.admin_index')->with('info', 'Updated !');
    }
}
