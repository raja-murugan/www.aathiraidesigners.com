<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Hash;
use PDF;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $data = Employee::where('soft_delete', '!=', 1)->orderBy('id', 'DESC')->get();
        $department = Department::where('soft_delete', '!=', 1)->orderBy('id', 'DESC')->get();

        $Employee_data = [];
        foreach ($data as $key => $datas) {
            $departmentname = Department::findOrFail($datas->department_id);

            $Employee_data[] = array(
                'name' => $datas->name,
                'unique_key' => $datas->unique_key,
                'phone_number' => $datas->phone_number,
                'departmentname' => $departmentname->name,
                'salaray_per_hour' => $datas->salaray_per_hour,
                'ot_salary' => $datas->ot_salary,
                'department_id' => $datas->department_id,
                'address' => $datas->address,
                'aadhaar_card' => $datas->aadhaar_card,
                'photo' => $datas->photo,
                'id' => $datas->id,
            );

        }
        $today = Carbon::now()->format('Y-m-d');
        return view('page.backend.employee.index', compact('Employee_data', 'today', 'department'));
    }


    public function store(Request $request)
    {
        $randomkey = Str::random(5);
        $random_no =  rand(100,999);

        $data = new Employee();

        $data->unique_key = $randomkey;
        $data->name = $request->get('name');
        $data->phone_number = $request->get('phone_number');
        $data->department_id = $request->get('department_id');
        $data->gender = $request->get('gender');
        $data->email = $request->get('email');
        $data->salaray_per_hour = $request->get('salaray_per_hour');
        $data->address = $request->get('address');
        $data->aadhaar_card = $request->get('aadhaar_card');

        if ($request->employee_photo != "") {
            $employee_photo = $request->employee_photo;
            $folderPath = "assets/backend/emp/";
            $image_parts = explode(";base64,", $employee_photo);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $data->name . '_' . $random_no . '_' . 'employee image' . '.png';
            $employeeimgfile = $folderPath . $fileName;
            file_put_contents($employeeimgfile, $image_base64);
            $data->photo = $employeeimgfile;
        }else {
            $contactno = $request->get('phone_number');
           $get_mobno_person = Employee::where('phone_number', '=', $contactno)->latest('id')->first();
            $old_customer_photo = $get_mobno_person->photo;
            $data->photo = $old_customer_photo;
        }


        // $employee_photo = $request->employee_photo;
        // $filename_customer_photo = $data->name . '_' . $random_no . '_' . 'Photo' . '.' . $employee_photo->getClientOriginalExtension();
        // $request->employee_photo->move('assets/backend/emp/', $filename_customer_photo);
        // $data->photo = $filename_customer_photo;



        $data->save();

        $password = $request->get('password');
        $hashedPassword = Hash::make($password);

        $Userdata = new User();
        $Userdata->name = $request->get('name');
        $Userdata->email = $request->get('email');
        $Userdata->emp_id = $data->id;
        $Userdata->password = $hashedPassword;
        $Userdata->save();


        return redirect()->route('employee.index')->with('message', 'Added !');
    }


    public function edit(Request $request, $unique_key)
    {
        $random_no =  rand(100,999);

        $EmployeeData = Employee::where('unique_key', '=', $unique_key)->first();
        $EmployeeData->name = $request->get('name');
        $EmployeeData->phone_number = $request->get('phone_number');
        $EmployeeData->department_id = $request->get('department_id');
        $EmployeeData->salaray_per_hour = $request->get('salaray_per_hour');
        $EmployeeData->address = $request->get('address');
        $EmployeeData->aadhaar_card = $request->get('aadhaar_card');


        if ($request->employee_photo != "") {
            $employee_photo = $request->employee_photo;
            $folderPath = "assets/backend/emp/";
            $image_parts = explode(";base64,", $employee_photo);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $EmployeeData->name . '_' . $random_no . '_' . 'employee image' . '.png';
            $customerimgfile = $folderPath . $fileName;
            file_put_contents($customerimgfile, $image_base64);
            $EmployeeData->photo = $customerimgfile;
         }else{
           $Insertedcustomer_photo = $EmployeeData->photo;
           $EmployeeData->photo = $Insertedcustomer_photo;
         }

        //  if ($request->file('employee_photo') != "") {
        //    $employee_photo = $request->employee_photo;
        //    $filename_customer_photo = $EmployeeData->name . '_' . $random_no . '_' . 'Photo' . '.' . $employee_photo->getClientOriginalExtension();
        //    $request->employee_photo->move('assets/backend/emp/', $filename_customer_photo);
        //    $EmployeeData->photo = $filename_customer_photo;
        // } else {
        //    $Insertedproof_customer_photo = $EmployeeData->photo;
        //    $EmployeeData->photo = $Insertedproof_customer_photo;
        // }



        $EmployeeData->update();

        return redirect()->route('employee.index')->with('info', 'Updated !');
    }


    public function delete($unique_key)
    {
        $data = Employee::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('employee.index')->with('warning', 'Deleted !');
    }


    public function checkduplicate(Request $request)
    {
        if(request()->get('query'))
        {
            $query = request()->get('query');
            $employeedata = Employee::where('phone_number', '=', $query)->first();

            $userData['data'] = $employeedata;
            echo json_encode($userData);
        }
    }


    public function getemployee_photos()
    {
        $GetEmployeePhotos = Employee::where('soft_delete', '!=', 1)->get();
        $userData['data'] = $GetEmployeePhotos;
        echo json_encode($userData);
    }


    public function view($unique_key)
    {
        $Employeedata = Employee::where('unique_key', '=', $unique_key)->first();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');


        $time = strtotime($today);
        $curent_month = date("F",$time);


        $month = date("m",strtotime($today));
        $year = date("Y",strtotime($today));

        $list=array();
        $monthdates = [];
        $maxDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for($d=1; $d<=$maxDays; $d++)
        {
            $times = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $times) == $month)
                $list[] = date('d', $times);
                $monthdates[] = date('Y-m-d', $times);
        }

        $attendence_Data = [];
        $totalmins = 0;
        foreach (($monthdates) as $key => $monthdate_arr) {

            $attendencedata = Attendance::where('employee_id', '=', $Employeedata->id)->where('date', '=', $monthdate_arr)->first();
            if($attendencedata != ""){

                if($attendencedata->status == 1){
                    $status = 'P';
                    $attendence_id = $attendencedata->id;

                    if($attendencedata->checkout_time != ""){
                        $time1 = strtotime($attendencedata->checkin_time);
                        $time2 = strtotime($attendencedata->checkout_time);
                        $total_minits = ($time2 - $time1) / 60;
    
                        $workinghour = $attendencedata->working_hour;
                        $totalmins += $total_minits;
                    }else {
                        $workinghour = '';
                        $total_minits = 0;
                        $totalmins += 0;
                    }

                    

                }else if($attendencedata->status == 2){
                    $status = 'A';
                    $attendence_id = $attendencedata->id;
                    $workinghour = '';
                    $total_minits = 0;
                    $totalmins += 0;
                }
            }else {
                $attendence_id = 0;
                $status = '';
                $workinghour = '';
                $total_minits = 0;
                $totalmins += 0;
            }
            
            
            


            $attendence_Data[] = array(
                'employee' => $Employeedata->name,
                'employeeid' => $Employeedata->id,
                'attendence_status' => $status,
                'date' => date("d-m-Y",strtotime($monthdate_arr)),
                'attendence_id' => $attendence_id,
                'workinghour' => $workinghour,
                'total_minits' => $total_minits
            );
        }

        $hours = floor($totalmins / 60);
        $min = $totalmins - ($hours * 60);
        $total_time = $hours."Hours ".$min."Mins";

        $c_month = date("M",strtotime($today));



        if($Employeedata->department_id == 1){

            $hour_salary = $Employeedata->salaray_per_hour;
            $one_min_salary = ($Employeedata->salaray_per_hour) / 60;
            $total_min_salary = $totalmins * $one_min_salary;
            $total_salary = number_format((float)$total_min_salary, 2, '.', '');


        }else if($Employeedata->department_id == 2){

                $five_forty_mins = $Employeedata->salaray_per_hour;
                $one_minute = ($Employeedata->salaray_per_hour) / 540;

                $total_day_salary = $totalmins * $one_minute;
                $total_salary = number_format((float)$total_day_salary, 2, '.', '');

        }

        

        return view('page.backend.employee.view', compact('Employeedata', 'today', 'timenow', 'attendence_Data', 'list', 'year', 'month', 'curent_month', 'c_month', 'total_time', 'total_salary'));
    }


    public function datefilter(Request $request) {

        $today = $request->get('from_date');
        $unique_key = $request->get('employee_uniquekey');
        $timenow = Carbon::now()->format('H:i');

        $Employeedata = Employee::where('unique_key', '=', $unique_key)->first();


        $time = strtotime($today);
        $curent_month = date("F",$time);


        $month = date("m",strtotime($today));
        $year = date("Y",strtotime($today));

        $list=array();
        $monthdates = [];
        $maxDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for($d=1; $d<=$maxDays; $d++)
        {
            $times = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $times) == $month)
                $list[] = date('d', $times);
                $monthdates[] = date('Y-m-d', $times);
        }

        $attendence_Data = [];

        foreach (($monthdates) as $key => $monthdate_arr) {

            $attendencedata = Attendance::where('employee_id', '=', $Employeedata->id)->where('date', '=', $monthdate_arr)->first();
            if($attendencedata != ""){

                if($attendencedata->status == 1){
                    $status = 'P';
                    $attendence_id = $attendencedata->id;

                    if($attendencedata->checkout_time != ""){
                        $time1 = strtotime($attendencedata->checkin_time);
                        $time2 = strtotime($attendencedata->checkout_time);
                        $total_minits = ($time2 - $time1) / 60;
    
                        $workinghour = $attendencedata->working_hour;
                        $totalmins += $total_minits;
                    }else {
                        $workinghour = '';
                        $total_minits = 0;
                        $totalmins += 0;
                    }

                }else if($attendencedata->status == 2){
                    $status = 'A';
                    $attendence_id = $attendencedata->id;
                    $workinghour = '';
                    $total_minits = 0;
                    $totalmins += 0;
                }
            }else {
                $attendence_id = 0;
                $status = '';
                $workinghour = '';
                $total_minits = 0;
                $totalmins += 0;
            }
            
            
            


            $attendence_Data[] = array(
                'employee' => $Employeedata->name,
                'employeeid' => $Employeedata->id,
                'attendence_status' => $status,
                'date' => date("d-m-Y",strtotime($monthdate_arr)),
                'attendence_id' => $attendence_id,
                'workinghour' => $workinghour,
                'total_minits' => $total_minits
            );
        }

        $hours = floor($totalmins / 60);
        $min = $totalmins - ($hours * 60);
        $total_time = $hours."Hours ".$min."Mins";

        $c_month = date("M",strtotime($today));

        if($Employeedata->department_id == 1){

            $hour_salary = $Employeedata->salaray_per_hour;
            $one_min_salary = ($Employeedata->salaray_per_hour) / 60;
            $total_min_salary = $totalmins * $one_min_salary;
            $total_salary = number_format((float)$total_min_salary, 2, '.', '');


        }else if($Employeedata->department_id == 2){

                $five_forty_mins = $Employeedata->salaray_per_hour;
                $one_minute = ($Employeedata->salaray_per_hour) / 540;

                $total_day_salary = $totalmins * $one_minute;
                $total_salary = number_format((float)$total_day_salary, 2, '.', '');

        }

        return view('page.backend.employee.view', compact('Employeedata', 'today', 'timenow', 'attendence_Data', 'list', 'year', 'month', 'curent_month', 'c_month', 'total_time', 'total_salary'));
    }




    public function departmentupdate()
    {
        $department = Department::where('soft_delete', '!=', 1)->orderBy('id', 'ASC')->get();
        $Employee = Employee::where('soft_delete', '!=', 1)->get();

        return view('page.backend.employee.departmentupdate', compact('department', 'Employee'));
    }

    public function update_emp_department(Request $request)
    {
        foreach ($request->get('employee_id') as $key => $employee_id) {

            $department = $request->department[$employee_id];
            $employee_salary = $request->employee_salary[$key];
            if($department != ""){

                if($request->ot_salary[$key] != ""){
                    $ot_salary = $request->ot_salary[$key];
                }else {
                    $ot_salary = '';
                }

                DB::table('employees')->where('id', $employee_id)->update([
                    'department_id' => $department,  'salaray_per_hour' => $employee_salary,  'ot_salary' => $ot_salary
                ]);
            }
        }

        return redirect()->route('employee.index')->with('info', 'Updated !');
    }


}
