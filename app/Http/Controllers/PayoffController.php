<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Payoff;
use App\Models\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Hash;
use PDF;


class PayoffController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $data = Payoff::where('soft_delete', '!=', 1)->where('date', '=', $today)->orderBy('id', 'DESC')->get();

        $Payoff_data = [];
        foreach ($data as $key => $datas) {
            

            $employee = Employee::findOrFail($datas->employee_id);

            $Payoff_data[] = array(
                'unique_key' => $datas->unique_key,
                'date' => $datas->date,
                'time' => $datas->time,
                'month' => $datas->month,
                'year' => $datas->year,
                'employee_id' => $datas->employee_id,
                'employee' => $employee->name,
                'total_working_hour' => $datas->total_working_hour,
                'perhoursalary' => $datas->perhoursalary,
                'salaryamount' => $datas->salaryamount,
                'totalpaidsalary' => $datas->totalpaidsalary,
                'balancesalary' => $datas->balancesalary,
                'note' => $datas->note,
                'id' => $datas->id,
            );

        }
       
        return view('page.backend.payoff.index', compact('Payoff_data', 'today', 'timenow'));
    }

    public function datefilter(Request $request)
    {
        $today = $request->get('from_date');
        $timenow = Carbon::now()->format('H:i');

        $data = Payoff::where('soft_delete', '!=', 1)->where('date', '=', $today)->orderBy('id', 'DESC')->get();

        $Payoff_data = [];
        foreach ($data as $key => $datas) {
            

            $employee = Employee::findOrFail($datas->employee_id);

            $Payoff_data[] = array(
                'unique_key' => $datas->unique_key,
                'date' => $datas->date,
                'time' => $datas->time,
                'month' => $datas->month,
                'year' => $datas->year,
                'employee_id' => $datas->employee_id,
                'employee' => $employee->name,
                'total_working_hour' => $datas->total_working_hour,
                'perhoursalary' => $datas->perhoursalary,
                'salaryamount' => $datas->salaryamount,
                'totalpaidsalary' => $datas->totalpaidsalary,
                'balancesalary' => $datas->balancesalary,
                'note' => $datas->note,
                'id' => $datas->id,
            );

        }
       
        return view('page.backend.payoff.index', compact('Payoff_data', 'today', 'timenow'));

    }


    public function create()
    {
        
        $employee = Employee::where('soft_delete', '!=', 1)->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $maxDays=date('t');

        $years = date('Y', strtotime($today)) - 1;
        $years_arr = array($years, $years+1, $years+2);

        $current_year = Carbon::now()->format('Y');
       
        return view('page.backend.payoff.create', compact('employee', 'today', 'timenow', 'maxDays', 'years_arr', 'current_year'));
    }
}
