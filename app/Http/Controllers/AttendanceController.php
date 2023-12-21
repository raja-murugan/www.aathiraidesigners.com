<?php

namespace App\Http\Controllers;
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
        $data = Attendance::where('soft_delete', '!=', 1)->where('checkin_date', '=', $today)->orderBy('id', 'DESC')->get();

        $Attendance_data = [];
        foreach ($data as $key => $datas) {
            $employee = Employee::findOrFail($datas->employee_id);

            $Attendance_data[] = array(
                'month' => $datas->month,
                'year' => $datas->year,
                'checkin_date' => $datas->checkin_date,
                'checkin_time' => $datas->checkin_time,
                'employee_id' => $datas->employee_id,
                'employee' => $employee->name,
                'checkout_date' => $datas->checkout_date,
                'checkout_time' => $datas->checkout_time,
                'working_hour' => $datas->working_hour,
                'status' => $datas->status,
                'id' => $datas->id,
            );

        }
        return view('page.backend.attendance.index', compact('Attendance_data', 'today'));
    }


    public function create()
    {
        $Employee = Employee::where('soft_delete', '!=', 1)->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        return view('page.backend.attendance.create', compact('Employee', 'today', 'timenow'));
    }
}
