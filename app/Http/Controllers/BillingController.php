<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Product;
use App\Models\CustomerProduct;
use App\Models\Billing;
use App\Models\BillingProduct;
use App\Models\BillingPayment;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Hash;
use PDF;

class BillingController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $data = Billing::where('soft_delete', '!=', 1)->where('date', '=', $today)->orderBy('id', 'DESC')->get();

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
       
        return view('page.backend.billing.index', compact('Billing_data', 'today', 'timenow'));
    }


    public function datefilter(Request $request)
    {
        $today = $request->get('from_date');

        $timenow = Carbon::now()->format('H:i');

        $data = Billing::where('soft_delete', '!=', 1)->where('date', '=', $today)->orderBy('id', 'DESC')->get();

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
       
        return view('page.backend.billing.index', compact('Billing_data', 'today', 'timenow'));
    }



    public function create()
    {
        $products = Product::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $customers = Customer::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $last_billing = Billing::where('soft_delete', '!=', 1)->latest('id')->first();
        $initialno = 1;

        if($last_billing != ''){
            $added_billno = substr ($last_billing->billno, -3);
            $billno = '#AD00' . ($added_billno) + 1;
        }else {
            $billno = '#AD00'.$initialno;
        }

        return view('page.backend.billing.create', compact('products', 'customers', 'today', 'timenow', 'billno'));
    }



    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Billing();

        $data->unique_key = $randomkey;
        $data->date = $request->get('date');
        $data->time = $request->get('time');
        $data->delivery_date = $request->get('delivery_date');
        $data->delivery_time = $request->get('delivery_time');
        $data->billno = $request->get('billno');
        $data->customer_id = $request->get('customer_id');
        $data->total_amount = $request->get('total_amount');
        $data->discount_type = $request->get('billingdiscount_type');
        $data->discount = $request->get('discount');
        $data->note = $request->get('billing_note');
        $data->total_discountamount = $request->get('billing_discountamount');
        $data->grand_total = $request->get('billing_grandtotalamount');
        $data->total_paid_amount = $request->get('billing_paidamount');
        $data->total_balance_amount = $request->get('billing_balanceamount');

        $data->save();

        $billing_id = $data->id;

        foreach ($request->get('billing_product_id') as $key => $billing_product_id) {

            if($billing_product_id > 0){


                    $BillingProduct = new BillingProduct;
                    $BillingProduct->billing_id = $billing_id;
                    $BillingProduct->billing_product_id = $billing_product_id;
                    $BillingProduct->billing_qty = $request->billing_qty[$key];
                    $BillingProduct->billing_rateperqty = $request->billing_rateperqty[$key];
                    $BillingProduct->billing_total = $request->billing_total[$key];
                    $BillingProduct->customer_id = $request->get('customer_id');
                    $BillingProduct->save();



                $CustomerProducts = CustomerProduct::where('customer_id', '=', $request->get('customer_id'))
                                                ->where('product_id', '=', $billing_product_id)->first();

                if($CustomerProducts != ""){

                    $CustomerProducts->customer_id = $request->get('customer_id');
                    $CustomerProducts->product_id = $billing_product_id;
                    $CustomerProducts->update();

                }else {
                    $CustomerProduct = new CustomerProduct;
                    $CustomerProduct->customer_id = $request->get('customer_id');
                    $CustomerProduct->product_id = $billing_product_id;
                    $CustomerProduct->save();

                  
                }
            }
            
        }


        if($request->get('billing_paidamount') != ""){

            $BillingPayment = new BillingPayment;
            $BillingPayment->billing_id = $billing_id;
            $BillingPayment->payment_term = $request->get('payment_term');
            $BillingPayment->payment_paid_date = $request->get('date');
            $BillingPayment->payment_paid_amount = $request->get('billing_paidamount');
            $BillingPayment->payment_method = $request->get('payment_method');
            $BillingPayment->save();
        }

        


        return redirect()->route('billing.index')->with('message', 'Added !');
    }



    public function edit($unique_key)
    {
        $BillingData = Billing::where('unique_key', '=', $unique_key)->first();
        $BillingProducts = BillingProduct::where('billing_id', '=', $BillingData->id)->get();
        $BillingPayments = BillingPayment::where('billing_id', '=', $BillingData->id)->get();


            $customerproducts = CustomerProduct::where('customer_id', '=', $BillingData->customer_id)->get();
            if($customerproducts != ""){

                $Customer_data = [];
                foreach ($customerproducts as $key => $CustomerProducts_arr) {
        
                    $productarr = Product::findOrFail($CustomerProducts_arr->product_id);
        
                    $Customer_data[] = array(
                        'id' => $productarr->id,
                        'name' => $productarr->name,
                    );
                }
            }


        $customers = Customer::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        return view('page.backend.billing.edit', compact('BillingData', 'BillingProducts', 'BillingPayments', 'Customer_data', 'customers', 'today', 'timenow'));
    }



    public function update(Request $request, $unique_key)
    {

        $BillingData = Billing::where('unique_key', '=', $unique_key)->first();
        $BillingData->date = $request->get('date');
        $BillingData->time = $request->get('time');
        $BillingData->delivery_date = $request->get('delivery_date');
        $BillingData->delivery_time = $request->get('delivery_time');
        $BillingData->billno = $request->get('billno');
        $BillingData->customer_id = $BillingData->customer_id;
        $BillingData->total_amount = $request->get('total_amount');
        $BillingData->discount_type = $request->get('billingdiscount_type');
        $BillingData->discount = $request->get('discount');
        $BillingData->note = $request->get('billing_note');
        $BillingData->total_discountamount = $request->get('billing_discountamount');
        $BillingData->grand_total = $request->get('billing_grandtotalamount');
        $BillingData->total_paid_amount = $request->get('billing_paidamount');
        $BillingData->total_balance_amount = $request->get('billing_balanceamount');
        $BillingData->update();

        $billing_id = $BillingData->id;


        $getInserted = BillingProduct::where('billing_id', '=', $billing_id)->get();
        $purchase_products = array();
        foreach ($getInserted as $key => $getInserted_produts) {
            $purchase_products[] = $getInserted_produts->id;
        }

        $updated_products = $request->billingproducts_id;
        $updated_product_ids = array_filter($updated_products);
        $different_ids = array_merge(array_diff($purchase_products, $updated_product_ids), array_diff($updated_product_ids, $purchase_products));

       


        if (!empty($different_ids)) {
            foreach ($different_ids as $key => $different_id) {
                BillingProduct::where('id', $different_id)->delete();
            }
        }



            foreach ($request->get('billingproducts_id') as $key => $billingproducts_id) {

                if ($billingproducts_id > 0) {

                    $updateData = BillingProduct::where('id', '=', $billingproducts_id)->first();
                    $updateData->billing_id = $billing_id;
                    $updateData->billing_product_id = $request->billing_product_id[$key];
                    $updateData->billing_qty = $request->billing_qty[$key];
                    $updateData->billing_rateperqty = $request->billing_rateperqty[$key];
                    $updateData->billing_total = $request->billing_total[$key];
                    $updateData->update();



                } else if ($billingproducts_id == '') {

                    if($request->billing_product_id[$key] != ""){

                        $BillingProduct = new BillingProduct;
                        $BillingProduct->billing_id = $billing_id;
                        $BillingProduct->billing_product_id = $request->billing_product_id[$key];
                        $BillingProduct->billing_qty = $request->billing_qty[$key];
                        $BillingProduct->billing_rateperqty = $request->billing_rateperqty[$key];
                        $BillingProduct->billing_total = $request->billing_total[$key];
                        $BillingProduct->save();
                    }
                }
            }




            foreach ($request->get('payment_id') as $key => $payment_id) {
                if ($payment_id > 0) {

                    $updatePaymentData = BillingPayment::where('id', '=', $payment_id)->first();
                    $updatePaymentData->billing_id = $billing_id;
                    $updatePaymentData->payment_term = $request->payment_term[$key];
                    $updatePaymentData->payment_paid_amount = $request->payable_amount[$key];
                    $updatePaymentData->payment_method = $request->payment_method[$key];
                    $updatePaymentData->update();

                } else if ($payment_id == '') {


                    $BillingPayment = new BillingPayment;
                    $BillingPayment->billing_id = $billing_id;
                    $BillingPayment->payment_term = $request->payment_term[$key];
                    $BillingPayment->payment_paid_amount = $request->payable_amount[$key];
                    $BillingPayment->payment_method = $request->payment_method[$key];
                    $BillingPayment->save();


                }
            }

            $total_paid = 0;
            $getinsertedbilingP = BillingPayment::where('billing_id', '=', $billing_id)->get();
            foreach ($getinsertedbilingP as $key => $getinsertedbilingPs) {
                $total_paid += $getinsertedbilingPs->payment_paid_amount;
            }

            
            $newBillingData = Billing::where('unique_key', '=', $unique_key)->first();

            $total_amount = $newBillingData->grand_total;
            $balanceamount = $total_amount - $total_paid;

            $newBillingData->total_paid_amount = $total_paid;
            $newBillingData->total_balance_amount = $balanceamount;
            $newBillingData->update();

        

            return redirect()->route('billing.index')->with('update', 'Updated Billing information has been added to your list.');
    }



    public function delete($unique_key)
    {
        $data = Billing::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('billing.index')->with('warning', 'Deleted !');
    }


    public function paybalance(Request $request, $id)
    {
        $data = Billing::findOrFail($id);

        if($request->get('pb_paidamount') != ""){

            $BillingPayment = new BillingPayment;
            $BillingPayment->billing_id = $id;
            $BillingPayment->payment_term = $request->get('pb_term');
            $BillingPayment->payment_paid_date = $request->get('pb_date');
            $BillingPayment->payment_paid_amount = $request->get('pb_paidamount');
            $BillingPayment->payment_method = $request->get('pb_paymentmethod');
            $BillingPayment->save();


            $payableAmount = $request->get('pb_paidamount');

            $total_paid_amount = $data->total_paid_amount + $payableAmount;
            $balance = $data->grand_total - $total_paid_amount;

            $data->total_paid_amount = $total_paid_amount;
            $data->total_balance_amount = $balance;
            $data->update();
        }

        return redirect()->route('billing.index')->with('update', 'Updated Billing payment information has been added to your list.');

    }


    public function updatedelivery($unique_key)
    {
        $data = Billing::where('unique_key', '=', $unique_key)->first();

        $data->status = 1;

        $data->update();

        return redirect()->route('billing.index')->with('message', 'Delivered !');
    }

}
