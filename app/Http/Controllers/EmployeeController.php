<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
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

        $Employee_data = [];
        foreach ($data as $key => $datas) {

            $Employee_data[] = array(
                'name' => $datas->name,
                'unique_key' => $datas->unique_key,
                'phone_number' => $datas->phone_number,
                'salaray_per_hour' => $datas->salaray_per_hour,
                'address' => $datas->address,
                'aadhaar_card' => $datas->aadhaar_card,
                'photo' => $datas->photo,
                'id' => $datas->id,
            );

        }
        $today = Carbon::now()->format('Y-m-d');
        return view('page.backend.employee.index', compact('Employee_data', 'today'));
    }


    public function store(Request $request)
    {
        $randomkey = Str::random(5);
        $random_no =  rand(100,999);

        $data = new Employee();

        $data->unique_key = $randomkey;
        $data->name = $request->get('name');
        $data->phone_number = $request->get('phone_number');
        $data->gender = $request->get('gender');
        $data->email = $request->get('email');
        $data->salaray_per_hour = $request->get('salaray_per_hour');
        $data->address = $request->get('address');
        $data->aadhaar_card = $request->get('aadhaar_card');

        if ($request->employee_photo != "") {
            $employee_photo = $request->employee_photo;
            $folderPath = "assets/photo";
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
        // $request->employee_photo->move('assets/photo', $filename_customer_photo);
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
        $EmployeeData->salaray_per_hour = $request->get('salaray_per_hour');
        $EmployeeData->address = $request->get('address');
        $EmployeeData->aadhaar_card = $request->get('aadhaar_card');


        if ($request->employee_photo != "") {
            $employee_photo = $request->employee_photo;
            $folderPath = "assets/photo";
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
        //    $request->employee_photo->move('assets/photo', $filename_customer_photo);
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
            $employeedata = Customer::where('phone_number', '=', $query)->first();

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
}
