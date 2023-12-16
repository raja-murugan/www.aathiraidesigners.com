<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $data = Employee::where('soft_delete', '!=', 1)->orderBy('id', 'DESC')->get();

        return view('page.backend.employee.index', compact('data', 'today'));
    }


    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Employee();

        $data->unique_key = $randomkey;
        $data->name = $request->get('name');
        $data->phonenumber = $request->get('phonenumber');
        $data->alter_phonenumber = $request->get('alter_phonenumber');
        $data->email_id = $request->get('email_id');
        $data->address = $request->get('address');
        $data->role = $request->get('role');
        $data->password = $request->get('password');

        $data->save();
        
        $password = $request->get('password');
        $hashedPassword = Hash::make($password);

        $Userdata = new User();
        $Userdata->name = $request->get('name');
        $Userdata->email = $request->get('email_id');
        $Userdata->emp_id = $data->id;
        $Userdata->role = $request->get('role');
        $Userdata->password = $hashedPassword;
        $Userdata->save();

        return redirect()->route('employee.index')->with('message', 'Added !');
    }


    public function edit(Request $request, $unique_key)
    {
        $EmployeeData = Employee::where('unique_key', '=', $unique_key)->first();

        $EmployeeData->name = $request->get('name');
        $EmployeeData->phonenumber = $request->get('phonenumber');
        $EmployeeData->alter_phonenumber = $request->get('alter_phonenumber');
        $EmployeeData->email_id = $request->get('email_id');
        $EmployeeData->address = $request->get('address');
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
            $customerdata = Customer::where('phonenumber', '=', $query)->first();

            $userData['data'] = $customerdata;
            echo json_encode($userData);
        }
    }
}
