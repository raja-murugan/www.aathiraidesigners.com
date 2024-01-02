<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\AttendanceParent;
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
        

        $Attendance_data = [];
        

        $AttendanceParent = AttendanceParent::where('soft_delete', '!=', 1)->where('date', '=', $today)->get();
        foreach ($AttendanceParent as $key => $AttendanceParents) {

            $employee = Employee::findOrFail($AttendanceParents->employee_id);

            $hours = floor($AttendanceParents->working_hour / 60);
            $min = $AttendanceParents->working_hour - ($hours * 60);

            $Attendance_data[] = array(
                'employee_id' => $employee->id,
                'employee' => $employee->name,
                'date' => $AttendanceParents->date,
                'hour' => $hours."Hour ".$min."Mins",
                'status' => $AttendanceParents->status,
                
            );
        }
        return view('page.backend.attendance.index', compact('Attendance_data', 'today'));
    }


    public function create()
    {
        
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $attendance = [];
        $Employee = Employee::where('soft_delete', '!=', 1)->get();
        foreach ($Employee as $key => $Employees) {

            $latestcheckinout = Attendance::where('employee_id', '=', $Employees->id)
                                            ->where('soft_delete', '!=', 1)
                                            ->where('date', '=', $today)
                                            ->latest('id')->first();
            if($latestcheckinout != ""){
                if($latestcheckinout->status == 1){
                    $status = 1;
                }if($latestcheckinout->status == 2){
                    $status = 2;
                }if($latestcheckinout->status == 0){
                    $status = 0;
                }
            }else {
                $status = '';
            }


            $attendance[] = array(
                'employee_id' => $Employees->id,
                'employee' => $Employees->name,
                'status' => $status,
            );

        }

        

        return view('page.backend.attendance.create', compact('attendance', 'today', 'timenow'));
    }


    public function store(Request $request)
    {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');
        

        foreach ($request->get('employee_id') as $key => $employee_id) {
            error_reporting(0);

            $Attendance = new Attendance;
            $Attendance->month = date('m', strtotime($request->get('date')));
            $Attendance->year = date('Y', strtotime($request->get('date')));
            $Attendance->date = $request->get('date');
            $Attendance->employee_id = $employee_id;
            

            if($request->attendance[$employee_id] != ''){

                if($request->attendance[$employee_id] == 1){

                    $Attendance->checkin_date = $request->get('date');
                    $Attendance->checkin_time = $request->get('time');
                    $Attendance->checkout_date = '';
                    $Attendance->checkout_time = '';
                    $Attendance->status = 1;




                }else if($request->attendance[$employee_id] == 2){

                    $Attendance->checkin_date = '';
                    $Attendance->checkin_time = '';
                    $Attendance->checkout_date = $request->get('date');
                    $Attendance->checkout_time = $request->get('time');
                    $Attendance->status = 2;

                    $latesthour = Attendance::where('employee_id', '=', $employee_id)
                    ->where('soft_delete', '!=', 1)
                    ->where('date', '=', $request->get('date'))
                    ->latest('id')->first();


                        $time1 = strtotime($latesthour->checkin_time);
                        $time2 = strtotime($request->get('time'));
                        $difference = ($time2 - $time1) / 60;
                        $Attendance->working_hour = $difference;

                }else if($request->attendance[$employee_id] == 0){

                    $Attendance->checkin_date = '';
                    $Attendance->checkin_time = '';
                    $Attendance->checkout_date = '';
                    $Attendance->checkout_time = '';
                    $Attendance->status = 0;
                }
            }else {
                $latestcheckinout = Attendance::where('employee_id', '=', $employee_id)
                                            ->where('soft_delete', '!=', 1)
                                            ->where('date', '=', $today)
                                            ->latest('id')->first();

                $Attendance->status = $latestcheckinout->status;
                $Attendance->checkin_date = $latestcheckinout->checkin_date;
                $Attendance->checkin_time = $latestcheckinout->checkin_time;
                $Attendance->checkout_date = $latestcheckinout->checkout_date;
                $Attendance->checkout_time = $latestcheckinout->checkout_time;
            }
            $Attendance->save();




            $dateatend = AttendanceParent::where('date', '=', $request->get('date'))->where('employee_id', '=', $employee_id)->first();
            if($dateatend == ''){

                if($request->attendance[$employee_id] == 1){
                    $Status = 'PRESENT';
                }else if($request->attendance[$employee_id] == 0){
                    $Status = 'ABSENT';
                }

                $data = new AttendanceParent();
                $data->month = date('m', strtotime($request->get('date')));
                $data->year = date('Y', strtotime($request->get('date')));
                $data->date = $request->get('date');
                $data->employee_id = $employee_id;
                $data->working_hour = '';
                $data->status = $Status;
                $data->save();
            }else {
                $latesthourdata = Attendance::where('employee_id', '=', $employee_id)
                    ->where('soft_delete', '!=', 1)
                    ->where('date', '=', $request->get('date'))
                    ->get();
                    $totalhour = 0;
                    foreach ($latesthourdata as $key => $latesthourdatas) {
                        $totalhour += $latesthourdatas->working_hour;
                    }   
                    $dateatend->working_hour = $totalhour;
                    $dateatend->update();
            }
        }

        return redirect()->route('attendance.index')->with('message', 'Added !');
    }
}
