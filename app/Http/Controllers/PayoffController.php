<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Payoff;
use App\Models\Payoffdata;
use App\Models\Employee;
use App\Models\Attendance;

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



        $Payoff_data = [];
        $totalmins = 0;
        foreach (($monthdates) as $key => $monthdate_arr) {
            $employees = Employee::where('soft_delete', '!=', 1)->get();
            foreach ($employees as $key => $employees_arr) {

                $attendencedata = Attendance::where('employee_id', '=', $employees_arr->id)->where('date', '=', $monthdate_arr)->first();
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


                $Payoff_data[] = array(
                    'employee' => $employees_arr->name,
                    'employeeid' => $employees_arr->id,
                    'attendence_status' => $status,
                    'date' => date("d-m-Y",strtotime($monthdate_arr)),
                    'attendence_id' => $attendence_id,
                    'workinghour' => $workinghour,
                    'totalmins' => $totalmins
                );
            }
        }


        $employeesarr = Employee::where('soft_delete', '!=', 1)->get();
        $TotalData = [];
        foreach ($employeesarr as $key => $employeesarray) {
            $totalmins = 0;

            $attendencedatas = Attendance::where('employee_id', '=', $employeesarray->id)->where('month', '=', $month)->where('year', '=', $year)->get();
            foreach ($attendencedatas as $key => $attendencedatass) {

                if($attendencedatass->status == 1){
                    $status = 'P';
                    if($attendencedatass->checkout_time != ""){
                        $time1 = strtotime($attendencedatass->checkin_time);
                        $time2 = strtotime($attendencedatass->checkout_time);
                        $total_minits = ($time2 - $time1) / 60;
    
                        $totalmins += $total_minits;
                    }else {
                        $total_minits = 0;
                        $totalmins += 0;
                    }
                }else if($attendencedatass->status == 2){
                    $status = 'A';
                    $total_minits = 0;
                    $totalmins += 0;
                }
            }

            $hours = floor($totalmins / 60);
            $min = $totalmins - ($hours * 60);
            $total_time = $hours."Hours ".$min."Mins";

            $hour_salary = $employeesarray->salaray_per_hour;
            $one_min_salary = ($employeesarray->salaray_per_hour) / 60;
            $total_min_salary = $totalmins * $one_min_salary;
            $total_salary = number_format((float)$total_min_salary, 2, '.', '');


            $paidsalary = Payoff::where('employee_id', '=', $employeesarray->id)->where('month', '=', $month)->where('year', '=', $year)->first();
            if($paidsalary != ""){
                $paid_salary = $paidsalary->totalpaidsalary;
                $balanceSalaryAmount = $paidsalary->balancesalary;
            }else {
                $paid_salary = 0;
                $balanceSalaryAmount = 0;
            }


            $TotalData[] = array(
                'employeeid' => $employeesarray->id,
                'total_time' => $total_time,
                'status' => $status,
                'total_salary' => $total_salary,
                'paid_salary' => $paid_salary,
                'balanceSalaryAmount' => $balanceSalaryAmount,
                'month' => $month,
                'year' => $year,
            );
        }

        $c_month = date("M",strtotime($today));

        $Employee = Employee::where('soft_delete', '!=', 1)->get();
       
        return view('page.backend.payoff.index', compact('Payoff_data', 'today', 'timenow', 'curent_month', 'year', 'list', 'c_month', 'month', 'Employee', 'TotalData'));
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



    public function store(Request $request)
    {
        $date = $request->get('date');
        $salary_year = $request->get('salary_year');
        $salary_month = $request->get('salary_month');
        $timenow = Carbon::now()->format('H:i');



        foreach ($request->get('amountgiven') as $key => $amountgiven) {

            if($request->amountgiven[$key] != ""){

                $GetEmloyeeSalaryRow = Payoff::where('employee_id', '=', $request->employee_id[$key])->where('month', '=', $salary_month)->where('year', '=', $salary_year)->first();
                if($GetEmloyeeSalaryRow != ""){

                    $salary = $GetEmloyeeSalaryRow->salaryamount;
                    $totalpaidsalary = $GetEmloyeeSalaryRow->totalpaidsalary;

                    $newpaidsalary = $totalpaidsalary + $request->amountgiven[$key];
                    $newbalancesalary = $salary - $newpaidsalary;
                    
                    $GetEmloyeeSalaryRow->totalpaidsalary = $newpaidsalary;
                    $GetEmloyeeSalaryRow->balancesalary = $newbalancesalary;
                    $GetEmloyeeSalaryRow->save();

                    $payoff_id = $GetEmloyeeSalaryRow->id;


                    $PayoffData = new Payoffdata();
                    $PayoffData->payoff_id = $payoff_id;
                    $PayoffData->date = $request->get('date');
                    $PayoffData->time = $timenow;
                    $PayoffData->month = $request->get('salary_month');
                    $PayoffData->year = $request->get('salary_year');
                    $PayoffData->employee_id = $request->employee_id[$key];
                    $PayoffData->total_working_hour = $request->working_hours[$key];
                    $PayoffData->perhoursalary = $request->perhoursalary[$key];
                    $PayoffData->salaryamount = $request->salary_amount[$key];
                    $PayoffData->paidsalary = $request->amountgiven[$key];
                    $PayoffData->balancesalary = $newbalancesalary;
                    $PayoffData->note = $request->note[$key];
                    $PayoffData->save();

                }else{
                    error_reporting(0);

                    $balance_amount = $request->salary_amount[$key] - $request->amountgiven[$key];

                    $pdrandomkey = Str::random(5);
                    $Payoff = new Payoff();
                    $Payoff->unique_key = $pdrandomkey;
                    $Payoff->date = $date;
                    $Payoff->time = $timenow;
                    $Payoff->month = $salary_month;
                    $Payoff->year = $salary_year;
                    $Payoff->employee_id = $request->employee_id[$key];
                    $Payoff->total_working_hour = $request->working_hours[$key];
                    $Payoff->perhoursalary = $request->perhoursalary[$key];
                    $Payoff->salaryamount = $request->salary_amount[$key];
                    $Payoff->totalpaidsalary = $request->amountgiven[$key];
                    $Payoff->balancesalary = $balance_amount;
                    $Payoff->note = '';
                    $Payoff->save();
    
    
                    $payoff_id = $Payoff->id;



                    $PayoffData = new Payoffdata();
                    $PayoffData->payoff_id = $payoff_id;
                    $PayoffData->date = $request->get('date');
                    $PayoffData->time = $timenow;
                    $PayoffData->month = $request->get('salary_month');
                    $PayoffData->year = $request->get('salary_year');
                    $PayoffData->employee_id = $request->employee_id[$key];
                    $PayoffData->total_working_hour = $request->working_hours[$key];
                    $PayoffData->perhoursalary = $request->perhoursalary[$key];
                    $PayoffData->salaryamount = $request->salary_amount[$key];
                    $PayoffData->paidsalary = $request->amountgiven[$key];
                    $PayoffData->balancesalary = $balance_amount;
                    $PayoffData->note = $request->note[$key];
                    $PayoffData->save();
                }

                

            }
        }

        return redirect()->route('payoff.index')->with('message', 'Data added successfully!');
    }



    public function gettotal_salary()
    {
        $salary_month = request()->get('salary_month');
        $salary_year = request()->get('salary_year');


        $atendance_output = [];
        $Employee = Employee::where('soft_delete', '!=', 1)->get();
        foreach ($Employee as $key => $Employees_arr) {

            $totalpresent_days = Attendance::where('employee_id', '=', $Employees_arr->id)->where('month', '=', $salary_month)->where('year', '=', $salary_year)->where('status', '=', 1)->get();
            $presentdays_count = collect($totalpresent_days)->count();

            $monthdates = [];
            $maxDays = cal_days_in_month(CAL_GREGORIAN, $salary_month, $salary_year);
            for($d=1; $d<=$maxDays; $d++)
            {
                $times = mktime(12, 0, 0, $salary_month, $d, $salary_year);
                if (date('m', $times) == $salary_month)
                    $list[] = date('d', $times);
                    $monthdates[] = date('Y-m-d', $times);
            }

            $totalmins = 0;
            foreach (($monthdates) as $key => $monthdate_arr) {

                $attendencedata = Attendance::where('employee_id', '=', $Employees_arr->id)->where('date', '=', $monthdate_arr)->first();
                if($attendencedata != ""){

                    if($attendencedata->status == 1){

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
                    }
                }else {
                            $workinghour = '';
                            $total_minits = 0;
                            $totalmins += 0;
                }

            }

            $hours = floor($totalmins / 60);
            $min = $totalmins - ($hours * 60);
            $total_time = $hours."Hours ".$min."Mins";


            $hour_salary = $Employees_arr->salaray_per_hour;
            $one_min_salary = ($Employees_arr->salaray_per_hour) / 60;
            $total_min_salary = $totalmins * $one_min_salary;
            $total_salary = number_format((float)$total_min_salary, 2, '.', '');


            $paidsalary = Payoff::where('employee_id', '=', $Employees_arr->id)->where('month', '=', $salary_month)->where('year', '=', $salary_year)->first();
            if($paidsalary != ""){
                $paid_salary = $paidsalary->totalpaidsalary;
                $balanceSalaryAmount = $paidsalary->balancesalary;
            }else {
                $paid_salary = 0;
                $balanceSalaryAmount = 0;
            }


            


            if($total_salary == 0){
                $placeholder = 'Amount';
                $readonly = '';
                $noteplaceholder = 'Enter Note';
            }else {
                if($balanceSalaryAmount == 0){
                    $readonly = 'readonly';
                    $placeholder = '';
                    $noteplaceholder = '';
                }else {
                    $readonly = '';
                    $placeholder = 'Amount';
                    $noteplaceholder = 'Enter Note';
                    
                }
            }

            
                $atendance_output[] = array(
                    'employee' => $Employees_arr->name,
                    'employeeid' => $Employees_arr->id,
                    'presentdays_count' => $presentdays_count,
                    'total_time' => $total_time,
                    'total_minits' => $total_minits,
                    'total_salary' => $total_salary,
                    'paid_salary' => $paid_salary,
                    'balanceSalaryAmount' => $balanceSalaryAmount,
                    'readonly' => $readonly,
                    'placeholder' => $placeholder,
                    'noteplaceholder' => $noteplaceholder,
                    'hour_salary' => $hour_salary,
                );
            
    

           

            
        }


        echo json_encode($atendance_output);
    }
}
