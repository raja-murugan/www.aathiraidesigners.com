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

            $presentdays = Attendance::where('employee_id', '=', $employeesarray->id)->where('month', '=', $month)->where('year', '=', $year)->where('status', '=', 1)->get();
            $present_dayscount = collect($presentdays)->count();



            $totalmins = 0;
            $total_ot_mins = 0;

            $attendencedatas = Attendance::where('employee_id', '=', $employeesarray->id)->where('month', '=', $month)->where('year', '=', $year)->get();
            foreach ($attendencedatas as $key => $attendencedatass) {

                if($attendencedatass->status == 1){

                    
                    $status = 'P';
                    if($attendencedatass->checkout_time != ""){
                        $time1 = strtotime($attendencedatass->checkin_time);
                        $time2 = strtotime($attendencedatass->checkout_time);
                        $total_minits = ($time2 - $time1) / 60;
    
                        $totalmins += $total_minits;
                        if($total_minits > 600){
                            $get_ot_mins = $total_minits - 600;
                            $total_ot_mins += $get_ot_mins;
                        }else {
                            $total_ot_mins += 0;
                        }
                        
                    }else {
                        $total_minits = 0;
                        $totalmins += 0;
                        $total_ot_mins += 0;
                    }
                }else if($attendencedatass->status == 2){
                    $status = 'A';
                    $total_minits = 0;
                    $totalmins += 0;
                    $total_ot_mins += 0;
                }
            }

            

            


            if($employeesarray->department_id == 1){

                $hours = floor($totalmins / 60);
                $min = $totalmins - ($hours * 60);
                $total_time = $hours."Hours ".$min."Mins";

                $hour_salary = $employeesarray->salaray_per_hour;
                $one_min_salary = ($employeesarray->salaray_per_hour) / 60;
                $total_min_salary = $totalmins * $one_min_salary;
                $total_salary = number_format((float)$total_min_salary, 2, '.', '');


            }else if($employeesarray->department_id == 2){

                $othours = floor($total_ot_mins / 60);
                $otmin = $total_ot_mins - ($othours * 60);
                $total_ot = $othours."hr ".$otmin."mins";

                $total_time = $present_dayscount."days + ".$total_ot;

                $perdaysalary = $employeesarray->salaray_per_hour;
                $day_salary = $perdaysalary * $present_dayscount;

                $sixty_minsot_salary = $employeesarray->ot_salary;
                if($sixty_minsot_salary != ""){

                    $one_minute_ot_salary = ($sixty_minsot_salary / 60) * 1;
                    $total_ot_salary = $one_minute_ot_salary * $total_ot_mins;
    
                    $emp_total_salary = $day_salary + $total_ot_salary;
                    $total_salary = number_format((float)$emp_total_salary, 2, '.', '');
                }else {

                    $one_minute_ot_salary = (0 / 60) * 1;
                    $total_ot_salary = $one_minute_ot_salary * $total_ot_mins;
    
                    $emp_total_salary = $day_salary + $total_ot_salary;
                    $total_salary = number_format((float)$emp_total_salary, 2, '.', '');
                }
                

            }


            


            $paidsalary = Payoff::where('employee_id', '=', $employeesarray->id)->where('month', '=', $month)->where('year', '=', $year)->first();
            if($paidsalary != ""){
                $paid_salary = $paidsalary->totalpaidsalary;
                $balanceSalaryAmount = $paidsalary->balancesalary;
            }else {
                $paid_salary = 0;
                $balanceSalaryAmount = $total_salary - $paid_salary;
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

            $presentdays = Attendance::where('employee_id', '=', $employeesarray->id)->where('month', '=', $month)->where('year', '=', $year)->where('status', '=', 1)->get();
            $present_dayscount = collect($presentdays)->count();



            $totalmins = 0;
            $total_ot_mins = 0;

            $attendencedatas = Attendance::where('employee_id', '=', $employeesarray->id)->where('month', '=', $month)->where('year', '=', $year)->get();
            foreach ($attendencedatas as $key => $attendencedatass) {

                if($attendencedatass->status == 1){

                    
                    $status = 'P';
                    if($attendencedatass->checkout_time != ""){
                        $time1 = strtotime($attendencedatass->checkin_time);
                        $time2 = strtotime($attendencedatass->checkout_time);
                        $total_minits = ($time2 - $time1) / 60;
    
                        $totalmins += $total_minits;

                        if($total_minits > 600){
                            $get_ot_mins = $total_minits - 600;
                            $total_ot_mins += $get_ot_mins;
                        }else {
                            $total_ot_mins += 0;
                        }
                    }else {
                        $total_minits = 0;
                        $totalmins += 0;
                        $total_ot_mins += 0;
                    }
                }else if($attendencedatass->status == 2){
                    $status = 'A';
                    $total_minits = 0;
                    $totalmins += 0;
                    $total_ot_mins += 0;
                }
            }

            $hours = floor($totalmins / 60);
            $min = $totalmins - ($hours * 60);
            $total_time = $hours."Hours ".$min."Mins";

            


            if($employeesarray->department_id == 1){

                $hour_salary = $employeesarray->salaray_per_hour;
                $one_min_salary = ($employeesarray->salaray_per_hour) / 60;
                $total_min_salary = $totalmins * $one_min_salary;
                $total_salary = number_format((float)$total_min_salary, 2, '.', '');


            }else if($employeesarray->department_id == 2){

                $othours = floor($total_ot_mins / 60);
                $otmin = $total_ot_mins - ($othours * 60);
                $total_ot = $othours."hr ".$otmin."mins";

                $perdaysalary = $employeesarray->salaray_per_hour;
                $day_salary = $perdaysalary * $present_dayscount;

                


                $sixty_minsot_salary = $employeesarray->ot_salary;
                if($sixty_minsot_salary != ""){

                    $one_minute_ot_salary = ($sixty_minsot_salary / 60) * 1;
                    $total_ot_salary = $one_minute_ot_salary * $total_ot_mins;
    
                    $emp_total_salary = $day_salary + $total_ot_salary;
                    $total_salary = number_format((float)$emp_total_salary, 2, '.', '');
                }else {

                    $one_minute_ot_salary = (0 / 60) * 1;
                    $total_ot_salary = $one_minute_ot_salary * $total_ot_mins;
    
                    $emp_total_salary = $day_salary + $total_ot_salary;
                    $total_salary = number_format((float)$emp_total_salary, 2, '.', '');
                }

            }


            


            $paidsalary = Payoff::where('employee_id', '=', $employeesarray->id)->where('month', '=', $month)->where('year', '=', $year)->first();
            if($paidsalary != ""){
                $paid_salary = $paidsalary->totalpaidsalary;
                $balanceSalaryAmount = $paidsalary->balancesalary;
            }else {
                $paid_salary = 0;
                $balanceSalaryAmount = $total_salary - $paid_salary;
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


    public function create()
    {
        
        $employee = Employee::where('soft_delete', '!=', 1)->where('department_id', '=', 1)->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $maxDays=date('t');

        $years = date('Y', strtotime($today)) - 1;
        $years_arr = array($years, $years+1, $years+2);

        $current_year = Carbon::now()->format('Y');
       
        return view('page.backend.payoff.create', compact('employee', 'today', 'timenow', 'maxDays', 'years_arr', 'current_year'));
    }


    public function daysalarycreate()
    {
        
        $employee = Employee::where('soft_delete', '!=', 1)->where('department_id', '=', 2)->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $maxDays=date('t');

        $years = date('Y', strtotime($today)) - 1;
        $years_arr = array($years, $years+1, $years+2);

        $current_year = Carbon::now()->format('Y');
       
        return view('page.backend.payoff.daysalarycreate', compact('employee', 'today', 'timenow', 'maxDays', 'years_arr', 'current_year'));
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



    public function daysalary_store(Request $request)
    {
        $date = $request->get('ds_date');
        $salary_year = $request->get('ds_salary_year');
        $salary_month = $request->get('ds_salary_month');
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
                    $PayoffData->date = $request->get('ds_date');
                    $PayoffData->time = $timenow;
                    $PayoffData->month = $request->get('ds_salary_month');
                    $PayoffData->year = $request->get('ds_salary_year');
                    $PayoffData->employee_id = $request->employee_id[$key];
                    $PayoffData->present_days = $request->present_dayscount[$key];
                    $PayoffData->total_ot = $request->total_ot[$key];
                    $PayoffData->perhoursalary = $request->perdaysalary[$key];
                    $PayoffData->salaryamount = $request->emp_salary[$key];
                    $PayoffData->paidsalary = $request->amountgiven[$key];
                    $PayoffData->balancesalary = $newbalancesalary;
                    $PayoffData->note = $request->note[$key];
                    $PayoffData->save();

                }else{
                    error_reporting(0);

                    $balance_amount = $request->emp_salary[$key] - $request->amountgiven[$key];

                    $pdrandomkey = Str::random(5);
                    $Payoff = new Payoff();
                    $Payoff->unique_key = $pdrandomkey;
                    $Payoff->date = $date;
                    $Payoff->time = $timenow;
                    $Payoff->month = $salary_month;
                    $Payoff->year = $salary_year;
                    $Payoff->employee_id = $request->employee_id[$key];
                    $Payoff->present_days = $request->present_dayscount[$key];
                    $Payoff->total_ot = $request->total_ot[$key];
                    $Payoff->perhoursalary = $request->perdaysalary[$key];
                    $Payoff->salaryamount = $request->emp_salary[$key];
                    $Payoff->totalpaidsalary = $request->amountgiven[$key];
                    $Payoff->balancesalary = $balance_amount;
                    $Payoff->note = '';
                    $Payoff->save();
    
    
                    $payoff_id = $Payoff->id;



                    $PayoffData = new Payoffdata();
                    $PayoffData->payoff_id = $payoff_id;
                    $PayoffData->date = $request->get('ds_date');
                    $PayoffData->time = $timenow;
                    $PayoffData->month = $request->get('ds_salary_month');
                    $PayoffData->year = $request->get('ds_salary_year');
                    $PayoffData->employee_id = $request->employee_id[$key];
                    $PayoffData->present_days = $request->present_dayscount[$key];
                    $PayoffData->total_ot = $request->total_ot[$key];
                    $PayoffData->perhoursalary = $request->perdaysalary[$key];
                    $PayoffData->salaryamount = $request->emp_salary[$key];
                    $PayoffData->paidsalary = $request->amountgiven[$key];
                    $PayoffData->balancesalary = $balance_amount;
                    $PayoffData->note = $request->note[$key];
                    $PayoffData->save();
                }

                

            }
        }

        return redirect()->route('payoff.index')->with('message', 'Data added successfully!');
    }


    public function edit($id, $month, $year)
    {
        $GetPayoff = Payoff::where('employee_id', '=', $id)->where('month', '=', $month)->where('year', '=', $year)->first();
        $GetPayoffData = Payoffdata::where('employee_id', '=', $id)->where('month', '=', $month)->where('year', '=', $year)->get();
        $today = Carbon::now()->format('Y-m-d');
        $employeedata = Employee::findOrFail($id);

        if($GetPayoff != ""){
            $totalsalary = $GetPayoff->salaryamount;
            $paidsalary = $GetPayoff->totalpaidsalary;
            $balancesalary = $GetPayoff->balancesalary;
        }else {
            $totalsalary = '';
            $paidsalary = '';
            $balancesalary = '';
        }
        

        return view('page.backend.payoff.edit', compact('GetPayoff', 'GetPayoffData', 'today', 'employeedata', 'id', 'month', 'year', 'totalsalary', 'paidsalary', 'balancesalary'));
    }


    public function update(Request $request, $id, $month, $year)
    {
        $GetPayoff = Payoff::where('employee_id', '=', $id)->where('month', '=', $month)->where('year', '=', $year)->first();
        $GetPayoff->totalpaidsalary = $request->get('payoffedit_totalpaid');
        $GetPayoff->balancesalary = $request->get('payoffedit_totalbal');
        $GetPayoff->update();


        $payoff_id = $GetPayoff->id;


        $getInserted = Payoffdata::where('payoff_id', '=', $payoff_id)->get();
        $purchase_products = array();
        foreach ($getInserted as $key => $getInserted_produts) {
            $purchase_products[] = $getInserted_produts->id;
        }

        $updated_products = $request->payoffdata_id;
        $updated_product_ids = array_filter($updated_products);
        $different_ids = array_merge(array_diff($purchase_products, $updated_product_ids), array_diff($updated_product_ids, $purchase_products));


        if (!empty($different_ids)) {
            foreach ($different_ids as $key => $different_id) {
                Payoffdata::where('id', $different_id)->delete();
            }
        }

        $timenow = Carbon::now()->format('H:i');

        foreach ($request->get('payoffdata_id') as $key => $payoffdata_id) {
            if ($payoffdata_id > 0) {

                $updateData = Payoffdata::where('id', '=', $payoffdata_id)->first();

                $updateData->payoff_id = $payoff_id;
                $updateData->date = $request->payoffedit_date[$key];
                $updateData->time = $timenow;
                $updateData->paidsalary = $request->payoffedit_amount[$key];
                $updateData->note = $request->payoffedit_note[$key];
                $updateData->update();

            } else if ($payoffdata_id == '') {

                    $PayoffData = new Payoffdata();
                    $PayoffData->payoff_id = $payoff_id;
                    $PayoffData->date = $request->payoffedit_date[$key];
                    $PayoffData->time = $timenow;
                    $PayoffData->month = $month;
                    $PayoffData->year = $year;
                    $PayoffData->employee_id = $id;
                    $PayoffData->total_working_hour = $GetPayoff->total_working_hour;
                    $PayoffData->perhoursalary = $GetPayoff->perhoursalary;
                    $PayoffData->salaryamount = $GetPayoff->salaryamount;
                    $PayoffData->paidsalary = $request->payoffedit_amount[$key];
                    $PayoffData->note = $request->payoffedit_note[$key];
                    $PayoffData->save();
            }
        }


        $total_paid = 0;
            $getinsertedbilingP = Payoffdata::where('payoff_id', '=', $payoff_id)->get();
            foreach ($getinsertedbilingP as $key => $getinsertedbilingPs) {
                $total_paid += $getinsertedbilingPs->paidsalary;
            }

            
            $newpayoff = Payoff::where('id', '=', $payoff_id)->first();

            $total_amount = $newpayoff->salaryamount;
            $balanceamount = $total_amount - $total_paid;

            $newpayoff->totalpaidsalary = $total_paid;
            $newpayoff->balancesalary = $balanceamount;
            $newpayoff->update();





        return redirect()->route('payoff.index')->with('update', 'Updated Payoff information has been added to your list.');


    }



    public function gettotal_salary()
    {
        $salary_month = request()->get('salary_month');
        $salary_year = request()->get('salary_year');


        $atendance_output = [];
        $Employee = Employee::where('soft_delete', '!=', 1)->where('department_id', '=', 1)->get();
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
                $balanceSalaryAmount = $total_salary - $paid_salary;
            }


            if($paid_salary == $total_salary){
                $readonly = 'readonly';
                $placeholder = '';
                $noteplaceholder = '';
            }else {
                $placeholder = 'Amount';
                $readonly = '';
                $noteplaceholder = 'Enter Note';
            }


            // if($paid_salary == $total_salary){
            //     $placeholder = 'Amount';
            //     $readonly = '';
            //     $noteplaceholder = 'Enter Note';
            // }else {
            //     if($balanceSalaryAmount == 0){
            //         $readonly = 'readonly';
            //         $placeholder = '';
            //         $noteplaceholder = '';
            //     }else {
            //         $readonly = '';
            //         $placeholder = 'Amount';
            //         $noteplaceholder = 'Enter Note';
                    
            //     }
            // }

            
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



    public function gettotal_daysalary()
    {
        $salary_month = request()->get('salary_month');
        $salary_year = request()->get('salary_year');

        $atendance_output = [];
        $Employee = Employee::where('soft_delete', '!=', 1)->where('department_id', '=', 2)->get();
        foreach ($Employee as $key => $Employees_arr) {

            $presentdays = Attendance::where('employee_id', '=', $Employees_arr->id)->where('month', '=', $salary_month)->where('year', '=', $salary_year)->where('status', '=', 1)->get();
            $present_dayscount = collect($presentdays)->count();



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
            $total_ot_mins = 0;
            foreach (($monthdates) as $key => $monthdate_arr) {

                $attendencedata = Attendance::where('employee_id', '=', $Employees_arr->id)->where('date', '=', $monthdate_arr)->first();
                if($attendencedata != ""){

                    if($attendencedata->status == 1){

                        if($attendencedata->checkout_time != ""){
                            $time1 = strtotime($attendencedata->checkin_time);
                            $time2 = strtotime($attendencedata->checkout_time);
                            $total_minits = ($time2 - $time1) / 60;
        
                            $totalmins += $total_minits;

                            if($total_minits > 600){
                                $get_ot_mins = $total_minits - 600;
                                $total_ot_mins += $get_ot_mins;
                            }else {
                                $total_ot_mins += 0;
                            }
                        }else {
                            $total_minits = 0;
                            $totalmins += 0;
                            $total_ot_mins += 0;
                        }
                    }
                }else {
                            $total_minits = 0;
                            $totalmins += 0;
                            $total_ot_mins += 0;
                }
            }


           
            $hours = floor($total_ot_mins / 60);
            $min = $total_ot_mins - ($hours * 60);
            $total_ot = $hours."hr ".$min."mins";

            $perdaysalary = $Employees_arr->salaray_per_hour;
            $day_salary = $perdaysalary * $present_dayscount;


            $ot_salary = $Employees_arr->ot_salary;
            if($ot_salary != ""){
                $sixty_minsot_salary = $ot_salary;
            }else {
                $sixty_minsot_salary = 0;
            }
            $one_minute_ot_salary = ($sixty_minsot_salary / 60) * 1;
            $total_ot_salary = $one_minute_ot_salary * $total_ot_mins;

            $emp_total_salary = $day_salary + $total_ot_salary;
            $total_salary = number_format((float)$emp_total_salary, 2, '.', '');



            $paidsalary = Payoff::where('employee_id', '=', $Employees_arr->id)->where('month', '=', $salary_month)->where('year', '=', $salary_year)->first();
            if($paidsalary != ""){
                $paid_salary = $paidsalary->totalpaidsalary;
                $balanceSalaryAmount = $paidsalary->balancesalary;
            }else {
                $paid_salary = 0;
                $balanceSalaryAmount = $total_salary - $paid_salary;
            }


            if($paid_salary == $total_salary){
                $readonly = 'readonly';
                $placeholder = '';
                $noteplaceholder = '';
            }else {
                $placeholder = 'Amount';
                $readonly = '';
                $noteplaceholder = 'Enter Note';
            }


            $atendance_output[] = array(
                'employee' => $Employees_arr->name,
                'employeeid' => $Employees_arr->id,
                'present_dayscount' => $present_dayscount,
                'total_ot' => $total_ot,
                'emp_salary' => $total_salary,
                'paid_salary' => $paid_salary,
                'balanceSalaryAmount' => $balanceSalaryAmount,
                'readonly' => $readonly,
                'placeholder' => $placeholder,
                'noteplaceholder' => $noteplaceholder,
                'perdaysalary' => $perdaysalary,
            );
        }


        echo json_encode($atendance_output);
    }



    public function getEmployeePayoffs()
    {
        $employeeID = request()->get('employeeID');
        $month = request()->get('month');
        $year = request()->get('year');

        $PayoffData = Payoffdata::where('employee_id', '=', $employeeID)->where('month', '=', $month)->where('year', '=', $year)->get();
        $Payoffs = [];
        foreach ($PayoffData as $key => $PayoffDatas) {

            $employee = Employee::findOrFail($employeeID);

            $Payoffs[] = array(
                'employee' => $employee->name,
                'employeeid' => $employee->id,
                'date' => $PayoffDatas->date,
                'paidsalary' => $PayoffDatas->paidsalary,
            );
        }


        echo json_encode($Payoffs);


    }
}
