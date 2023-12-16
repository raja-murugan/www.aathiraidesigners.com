<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Billing;
use App\Models\Employee;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BillingController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $data = Billing::where('soft_delete', '!=', 1)->orderBy('id', 'DESC')->get();
        $Billingdata = [];
        foreach ($data as $key => $datas) {
            
            $customer = Customer::findOrFail($datas->customer_id);
            $product = Product::findOrFail($datas->product_id);
            $employee = Employee::findOrFail($datas->employee_id);

            $Billingdata[] = array(
                'unique_key' => $datas->unique_key,
                'customer_id' => $datas->customer_id,
                'customer' => $customer->name,
                'product_id' => $datas->product_id,
                'product' => $product->name,
                'date' => $datas->date,
                'employee_id' => $datas->employee_id,
                'employee' => $employee->name,
                'starting_date' => $datas->starting_date,
                'ending_date' => $datas->ending_date,
                'remainder_date' => $datas->remainder_date,
                'id' => $datas->id
            );
        }

        $employee = Employee::where('soft_delete', '!=', 1)->get();
        $customer = Customer::where('soft_delete', '!=', 1)->get();
        $product = Product::where('soft_delete', '!=', 1)->get();
        return view('page.backend.billing.index', compact('Billingdata', 'today', 'employee', 'customer', 'product'));
    }



    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Billing();

        $data->unique_key = $randomkey;
        $data->customer_id = $request->get('customer_id');
        $data->product_id = $request->get('product_id');
        $data->date = $request->get('date');
        $data->employee_id = $request->get('employee_id');
        $data->starting_date = $request->get('starting_date');
        $data->ending_date = $request->get('ending_date');
        $data->remainder_date = $request->get('remainder_date');
        $data->save();

      
        return redirect()->route('billing.index')->with('message', 'Added !');
    }


    public function edit(Request $request, $unique_key)
    {
        $BillingData = Billing::where('unique_key', '=', $unique_key)->first();

        $BillingData->customer_id = $request->get('customer_id');
        $BillingData->product_id = $request->get('product_id');
        $BillingData->date = $request->get('date');
        $BillingData->employee_id = $request->get('employee_id');
        $BillingData->starting_date = $request->get('starting_date');
        $BillingData->ending_date = $request->get('ending_date');
        $BillingData->remainder_date = $request->get('remainder_date');
        $BillingData->update();

        return redirect()->route('billing.index')->with('info', 'Updated !');
    }


    public function delete($unique_key)
    {
        $data = Billing::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('billing.index')->with('warning', 'Deleted !');
    }
}
