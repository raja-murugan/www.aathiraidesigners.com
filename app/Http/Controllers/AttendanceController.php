<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
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

        $Attendance_data = [];
        $AllEmployees = Employee::where('soft_delete', '!=', 1)->get();
        foreach ($AllEmployees as $key => $AllEmployees_arr) {


            $Attendance_data[] = array(
                'employee_id' => $AllEmployees_arr->id,
                'employee' => $AllEmployees_arr->name,
                'unique_key' => $AllEmployees_arr->unique_key,
                'id' => $AllEmployees_arr->id,
            );
        }
        return view('page.backend.attendance.index', compact('Attendance_data', 'today', 'timenow'));
    }

    public function datefilter(Request $request)
    {
        $today = $request->get('from_date');

        return view('page.backend.attendance.index', compact('today', 'timenow'));
    }

    public function checkinstore(Request $request)
    {
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


        dd($request->checkin_photo . $employee_id);
        if ($request->checkin_photo . $employee_id != "") {
            $checkin_photo = $request->checkin_photo . $employee_id;
            $folderPath = "assets/backend/checkin";
            $image_parts = explode(";base64,", $checkin_photo);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $employeename . '_' . $random_no . '_' . 'emploee' . '.png';
            $customerimgfile = $folderPath . $fileName;
            file_put_contents($customerimgfile, $image_base64);
            $data->checkin_photo = $customerimgfile;
        }
        $data->status = 1;
        //$data->save();

        //return redirect()->route('attendance.index')->with('message', 'Added !');
    }
}
