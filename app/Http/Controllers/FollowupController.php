<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Followup;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class FollowupController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');
        $data = Followup::where('soft_delete', '!=', 1)->where('date', '=', $today)->orderBy('id', 'DESC')->get();
        $followupdata = [];
        foreach ($data as $key => $datas) {
            
            $customer = Customer::findOrFail($datas->customer_id);
            $employee = Employee::findOrFail($datas->employee_id);

            $followupdata[] = array(
                'unique_key' => $datas->unique_key,
                'customer_id' => $datas->customer_id,
                'customer' => $customer->name,
                'date' => $datas->date,
                'employee_id' => $datas->employee_id,
                'employee' => $employee->name,
                'time' => $datas->time,
                'description' => $datas->description,
                'next_call_date' => $datas->next_call_date,
                'id' => $datas->id
            );
        }

        $employee = Employee::where('soft_delete', '!=', 1)->get();
        $customer = Customer::where('soft_delete', '!=', 1)->get();
        return view('page.backend.followup.index', compact('followupdata', 'today', 'employee', 'customer', 'timenow'));
    }




    public function datefilter(Request $request) {

        $today = $request->get('from_date');

        $timenow = Carbon::now()->format('H:i');
        $data = Followup::where('soft_delete', '!=', 1)->where('date', '=', $today)->orderBy('id', 'DESC')->get();
        $followupdata = [];
        foreach ($data as $key => $datas) {
            
            $customer = Customer::findOrFail($datas->customer_id);
            $employee = Employee::findOrFail($datas->employee_id);

            $followupdata[] = array(
                'unique_key' => $datas->unique_key,
                'customer_id' => $datas->customer_id,
                'customer' => $customer->name,
                'date' => $datas->date,
                'employee_id' => $datas->employee_id,
                'employee' => $employee->name,
                'time' => $datas->time,
                'description' => $datas->description,
                'next_call_date' => $datas->next_call_date,
                'id' => $datas->id
            );
        }

        $employee = Employee::where('soft_delete', '!=', 1)->get();
        $customer = Customer::where('soft_delete', '!=', 1)->get();
        return view('page.backend.followup.index', compact('followupdata', 'today', 'employee', 'customer', 'timenow'));

    }


    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Followup();

        $data->unique_key = $randomkey;
        $data->customer_id = $request->get('customer_id');
        $data->date = $request->get('date');
        $data->employee_id = $request->get('employee_id');
        $data->time = $request->get('time');
        $data->description = $request->get('description');
        $data->next_call_date = $request->get('next_call_date');
        $data->save();

      
        return redirect()->route('followup.index')->with('message', 'Added !');
    }


    public function edit(Request $request, $unique_key)
    {
        $FollowupData = Followup::where('unique_key', '=', $unique_key)->first();

        $FollowupData->customer_id = $request->get('customer_id');
        $FollowupData->date = $request->get('date');
        $FollowupData->employee_id = $request->get('employee_id');
        $FollowupData->time = $request->get('time');
        $FollowupData->description = $request->get('description');
        $FollowupData->next_call_date = $request->get('next_call_date');
        $FollowupData->update();

        return redirect()->route('followup.index')->with('info', 'Updated !');
    }


    public function delete($unique_key)
    {
        $data = Followup::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('followup.index')->with('warning', 'Deleted !');
    }

}
