<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Attendance;
use App\Models\Billing;
use App\Models\BillingProduct;
use App\Models\BillingPayment;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');

        $Employee = Employee::where('soft_delete', '!=', 1)->get();
        $total_Employee = count(collect($Employee));


        $Product = Product::where('soft_delete', '!=', 1)->get();
        $total_Product = count(collect($Product));

        $Customer = Customer::where('soft_delete', '!=', 1)->get();
        $total_Customer = count(collect($Customer));


        $AllEmployees = Employee::where('soft_delete', '!=', 1)->get();
        $Attendance_data = [];

        foreach ($AllEmployees as $key => $AllEmployees_arr) {
            $checkindata = Attendance::where('checkin_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkindata != ""){
                if($checkindata->status == 1){
                    $checkin_time = $checkindata->checkin_time;
                }else {
                    $checkin_time = '';
                }
            }else {
                $checkin_time = '';
                $checkin_photo = '';
            }

            $checkoutdata = Attendance::where('checkout_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkoutdata != ""){
                if($checkoutdata->status == 1){
                    $checkout_time = $checkoutdata->checkout_time;
                    $total_time = $checkoutdata->working_hour;
                }else {
                    $checkout_time = '';
                    $total_time = '';
                }

            }else {
                $checkout_time = '';
                $total_time = '';
            }


            $attendance_date = Attendance::where('date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($attendance_date != ""){

                if($attendance_date->status == 1){
                    $status = 'Present';
                }else if($attendance_date->status == 2) {
                    $status = 'Absent';
                }else {
                    $status = 'Empty';
                }

            }else {
                $status = '';
            }


            $Attendance_data[] = array(
                'employee_id' => $AllEmployees_arr->id,
                'employee' => $AllEmployees_arr->name,
                'checkin_time' => $checkin_time,
                'checkout_time' => $checkout_time,
                'total_time' => $total_time,
                'status' => $status,
            );

        }



        $data = Billing::where('soft_delete', '!=', 1)->where('delivery_date', '=', $today)->orderBy('id', 'DESC')->get();
        $Billing_data = [];
        $productsarr = [];
        $billing_payment_arr = [];

        foreach ($data as $key => $datas) {

            $BillingProduct = BillingProduct::where('billing_id', '=', $datas->id)->orderBy('id', 'DESC')->get();
            foreach ($BillingProduct as $key => $BillingProducts_Arr) {

                $productarr = Product::findOrFail($BillingProducts_Arr->billing_product_id);
                $productsarr[] = array(
                    'product' => $productarr->name,
                    'billing_product_id' => $BillingProducts_Arr->billing_product_id,
                    'billing_measurement' => $BillingProducts_Arr->billing_measurement,
                    'billing_qty' => $BillingProducts_Arr->billing_qty,
                    'billing_rateperqty' => $BillingProducts_Arr->billing_rateperqty,
                    'billing_total' => $BillingProducts_Arr->billing_total,
                    'billing_id' => $BillingProducts_Arr->billing_id,
                    'id' => $BillingProducts_Arr->id,
                );
            }

            $BillingPayment = BillingPayment::where('billing_id', '=', $datas->id)->orderBy('id', 'DESC')->get();
            foreach ($BillingPayment as $key => $BillingPaymentsarr) {

                $billing_payment_arr[] = array(
                    'payment_term' => $BillingPaymentsarr->payment_term,
                    'payment_paid_date' => $BillingPaymentsarr->payment_paid_date,
                    'payment_paid_amount' => $BillingPaymentsarr->payment_paid_amount,
                    'payment_method' => $BillingPaymentsarr->payment_method,
                    'billing_id' => $BillingPaymentsarr->billing_id,
                    'id' => $BillingPaymentsarr->id,
                );
            }
            

            $customer = Customer::findOrFail($datas->customer_id);

            $Billing_data[] = array(
                'unique_key' => $datas->unique_key,
                'date' => $datas->date,
                'time' => $datas->time,
                'delivery_date' => $datas->delivery_date,
                'delivery_time' => $datas->delivery_time,
                'billno' => $datas->billno,
                'customer' => $customer->name,
                'phone_number' => $customer->phone_number,
                'customer_id' => $datas->customer_id,
                'total_amount' => $datas->total_amount,
                'discount_type' => $datas->discount_type,
                'discount' => $datas->discount,
                'note' => $datas->note,
                'total_discountamount' => $datas->total_discountamount,
                'grand_total' => $datas->grand_total,
                'total_paid_amount' => $datas->total_paid_amount,
                'total_balance_amount' => $datas->total_balance_amount,
                'status' => $datas->status,
                'id' => $datas->id,
                'productsarr' => $productsarr,
                'billing_payment_arr' => $billing_payment_arr,
            );

        }

        return view('home', compact('today', 'total_Employee', 'total_Product', 'total_Customer', 'Attendance_data', 'Billing_data'));
    }


    public function datefilter(Request $request) {

        $today = $request->get('from_date');

        $Employee = Employee::where('soft_delete', '!=', 1)->get();
        $total_Employee = count(collect($Employee));


        $Product = Product::where('soft_delete', '!=', 1)->get();
        $total_Product = count(collect($Product));


        $Customer = Customer::where('soft_delete', '!=', 1)->get();
        $total_Customer = count(collect($Customer));


        $AllEmployees = Employee::where('soft_delete', '!=', 1)->get();
        $Attendance_data = [];

        foreach ($AllEmployees as $key => $AllEmployees_arr) {
            $checkindata = Attendance::where('checkin_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkindata != ""){
                if($checkindata->status == 1){
                    $checkin_time = $checkindata->checkin_time;
                }else {
                    $checkin_time = '';
                }
            }else {
                $checkin_time = '';
                $checkin_photo = '';
            }

            $checkoutdata = Attendance::where('checkout_date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($checkoutdata != ""){
                if($checkoutdata->status == 1){
                    $checkout_time = $checkoutdata->checkout_time;
                    $total_time = $checkoutdata->working_hour;
                }else {
                    $checkout_time = '';
                    $total_time = '';
                }

            }else {
                $checkout_time = '';
                $total_time = '';
            }


            $attendance_date = Attendance::where('date', '=', $today)->where('employee_id', '=', $AllEmployees_arr->id)->first();
            if($attendance_date != ""){

                if($attendance_date->status == 1){
                    $status = 'Present';
                }else if($attendance_date->status == 2) {
                    $status = 'Absent';
                }else {
                    $status = 'Empty';
                }

            }else {
                $status = '';
            }


            $Attendance_data[] = array(
                'employee_id' => $AllEmployees_arr->id,
                'employee' => $AllEmployees_arr->name,
                'checkin_time' => $checkin_time,
                'checkout_time' => $checkout_time,
                'total_time' => $total_time,
                'status' => $status,
            );

        }



        $data = Billing::where('soft_delete', '!=', 1)->where('delivery_date', '=', $today)->orderBy('id', 'DESC')->get();
        $Billing_data = [];
        $productsarr = [];
        $billing_payment_arr = [];

        foreach ($data as $key => $datas) {

            $BillingProduct = BillingProduct::where('billing_id', '=', $datas->id)->orderBy('id', 'DESC')->get();
            foreach ($BillingProduct as $key => $BillingProducts_Arr) {

                $productarr = Product::findOrFail($BillingProducts_Arr->billing_product_id);
                $productsarr[] = array(
                    'product' => $productarr->name,
                    'billing_product_id' => $BillingProducts_Arr->billing_product_id,
                    'billing_measurement' => $BillingProducts_Arr->billing_measurement,
                    'billing_qty' => $BillingProducts_Arr->billing_qty,
                    'billing_rateperqty' => $BillingProducts_Arr->billing_rateperqty,
                    'billing_total' => $BillingProducts_Arr->billing_total,
                    'billing_id' => $BillingProducts_Arr->billing_id,
                    'id' => $BillingProducts_Arr->id,
                );
            }

            $BillingPayment = BillingPayment::where('billing_id', '=', $datas->id)->orderBy('id', 'DESC')->get();
            foreach ($BillingPayment as $key => $BillingPaymentsarr) {

                $billing_payment_arr[] = array(
                    'payment_term' => $BillingPaymentsarr->payment_term,
                    'payment_paid_date' => $BillingPaymentsarr->payment_paid_date,
                    'payment_paid_amount' => $BillingPaymentsarr->payment_paid_amount,
                    'payment_method' => $BillingPaymentsarr->payment_method,
                    'billing_id' => $BillingPaymentsarr->billing_id,
                    'id' => $BillingPaymentsarr->id,
                );
            }
            

            $customer = Customer::findOrFail($datas->customer_id);

            $Billing_data[] = array(
                'unique_key' => $datas->unique_key,
                'date' => $datas->date,
                'time' => $datas->time,
                'delivery_date' => $datas->delivery_date,
                'delivery_time' => $datas->delivery_time,
                'billno' => $datas->billno,
                'customer' => $customer->name,
                'phone_number' => $customer->phone_number,
                'customer_id' => $datas->customer_id,
                'total_amount' => $datas->total_amount,
                'discount_type' => $datas->discount_type,
                'discount' => $datas->discount,
                'note' => $datas->note,
                'total_discountamount' => $datas->total_discountamount,
                'grand_total' => $datas->grand_total,
                'total_paid_amount' => $datas->total_paid_amount,
                'total_balance_amount' => $datas->total_balance_amount,
                'status' => $datas->status,
                'id' => $datas->id,
                'productsarr' => $productsarr,
                'billing_payment_arr' => $billing_payment_arr,
            );

        }

        return view('home', compact('today', 'total_Employee', 'total_Product', 'total_Customer', 'Attendance_data', 'Billing_data'));
    }
}
