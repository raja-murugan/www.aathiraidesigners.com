<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Product;
use App\Models\CustomerProduct;
use App\Models\BillingProduct;
use App\Models\Billing;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Hash;
use PDF;

class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::where('soft_delete', '!=', 1)->orderBy('id', 'DESC')->get();

        $Customer_data = [];
        $productsarr = [];
        foreach ($data as $key => $datas) {


            $CustomerProduct = CustomerProduct::where('customer_id', '=', $datas->id)->orderBy('id', 'DESC')->get();
            foreach ($CustomerProduct as $key => $CustomerProducts_arr) {

                $productarr = Product::findOrFail($CustomerProducts_arr->product_id);

                $billing_product = BillingProduct::where('billing_product_id', '=', $CustomerProducts_arr->product_id)->where('customer_id', '=', $datas->id)->first();
                if($billing_product != ""){
                    $quantity = $billing_product->billing_qty;
                    $rate = $billing_product->billing_rateperqty;
                    $billingid = $billing_product->billing_id;

                    $GetBilling_status = Billing::findOrFail($billingid);
                    $billingstatus = $GetBilling_status->status;
                }else {
                    $quantity = '';
                    $rate = '';
                    $billingstatus = '';
                }
                $productsarr[] = array(
                    'product' => $productarr->name,
                    'measurements' => $CustomerProducts_arr->measurements,
                    'product_id' => $CustomerProducts_arr->product_id,
                    'customer_id' => $CustomerProducts_arr->customer_id,
                    'id' => $CustomerProducts_arr->id,
                    'status' => '',
                    'quantity' => $quantity,
                    'rate' => $rate,
                    'billingstatus' => $billingstatus,
                );
            }

            $total_products = CustomerProduct::where('customer_id', '=', $datas->id)->count();
            $delivered_products = CustomerProduct::where('customer_id', '=', $datas->id)->where('status', '=', 2)->count();

            $Customer_data[] = array(
                'unique_key' => $datas->unique_key,
                'name' => $datas->name,
                'phone_number' => $datas->phone_number,
                'id' => $datas->id,
                'productsarr' => $productsarr,
                'total_products' => $total_products,
                'delivered_products' => $delivered_products,
            );

        }
        $today = Carbon::now()->format('Y-m-d');
        return view('page.backend.customer.index', compact('Customer_data', 'today'));
    }


    public function create()
    {
        $products = Product::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        return view('page.backend.customer.create', compact('products', 'today', 'timenow'));
    }

    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Customer();

        $data->unique_key = $randomkey;
        $data->name = $request->get('name');
        $data->phone_number = $request->get('phone_number');

        $data->save();

        $customer_id = $data->id;

        foreach ($request->get('product_id') as $key => $product_id) {

            if($product_id != ""){
                $CustomerProduct = new CustomerProduct;
                $CustomerProduct->customer_id = $customer_id;
                $CustomerProduct->product_id = $product_id;
                $CustomerProduct->measurements = $request->measurements[$key];
                $CustomerProduct->save();
            }
            
        }


        return redirect()->route('customer.index')->with('message', 'Added !');
    }


    public function edit($unique_key)
    {
        $CustomerData = Customer::where('unique_key', '=', $unique_key)->first();
        $CustomerProducts = CustomerProduct::where('customer_id', '=', $CustomerData->id)->get();

        $products = Product::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        return view('page.backend.customer.edit', compact('CustomerData', 'CustomerProducts', 'products', 'today', 'timenow'));
    }



    public function update(Request $request, $unique_key)
    {

        $CustomerData = Customer::where('unique_key', '=', $unique_key)->first();
        $CustomerData->name = $request->get('name');
        $CustomerData->phone_number = $request->get('phone_number');
        $CustomerData->update();

        $customer_id = $CustomerData->id;


        $getInserted = CustomerProduct::where('customer_id', '=', $customer_id)->get();
        $purchase_products = array();
        foreach ($getInserted as $key => $getInserted_produts) {
            $purchase_products[] = $getInserted_produts->id;
        }

        $updated_products = $request->customer_products_id;
        $updated_product_ids = array_filter($updated_products);
        $different_ids = array_merge(array_diff($purchase_products, $updated_product_ids), array_diff($updated_product_ids, $purchase_products));

        if (!empty($different_ids)) {
            foreach ($different_ids as $key => $different_id) {
                CustomerProduct::where('id', $different_id)->delete();
            }
        }



        foreach ($request->get('customer_products_id') as $key => $customer_products_id) {

            if ($customer_products_id > 0) {

                $updateData = CustomerProduct::where('id', '=', $customer_products_id)->first();
                $updateData->product_id = $request->product_id[$key];
                $updateData->measurements = $request->measurements[$key];
                $updateData->update();

            } else if ($customer_products_id == '') {

                if($request->product_id[$key] != ""){

                    $CustomerProduct = new CustomerProduct;
                    $CustomerProduct->customer_id = $customer_id;
                    $CustomerProduct->product_id = $request->product_id[$key];
                    $CustomerProduct->measurements = $request->measurements[$key];
                    $CustomerProduct->save();
                }
            }
        }

        return redirect()->route('customer.index')->with('info', 'Updated !');
    }

    public function delete($unique_key)
    {
        $data = Customer::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('customer.index')->with('warning', 'Deleted !');
    }


    public function checkduplicate(Request $request)
    {
        if(request()->get('query'))
        {
            $query = request()->get('query');
            $employeedata = Customer::where('phone_number', '=', $query)->first();

            $userData['data'] = $employeedata;
            echo json_encode($userData);
        }
    }




    // public function getCustomerProducts()
    // {
    //     $customer_id = request()->get('customer_id');

    //     $customerproducts = CustomerProduct::where('customer_id', '=', $customer_id)->where('status', '=', 1)->get();
        
    //     if (isset($customerproducts) & !empty($customerproducts)) {
    //         echo json_encode($customerproducts);
    //     }else{
    //         echo json_encode(
    //             array('status' => 'false')
    //         );
    //     }
    // }


    public function getcustomerwiseproducts()
    {
        $customer_id = request()->get('billing_customerid');

        $customerproducts = CustomerProduct::where('customer_id', '=', $customer_id)->get();
        if($customerproducts != ""){

            $Customer_data = [];
            foreach ($customerproducts as $key => $CustomerProducts_arr) {
    
                $productarr = Product::findOrFail($CustomerProducts_arr->product_id);
    
                $Customer_data[] = array(
                    'id' => $productarr->id,
                    'name' => $productarr->name,
                );
            }
            $userData['data'] = $Customer_data;
            echo json_encode($userData);

        }else {
            $GetProduct = Product::where('soft_delete', '!=', 1)->get();
            $userData['data'] = $GetProduct;
            echo json_encode($userData);

        }
    }


    public function getmeasurementforproduct()
    {
        $customer_id = request()->get('billing_customerid');
        $billing_product_id = request()->get('billing_product_id');

        $Getmeasurement = CustomerProduct::where('customer_id', '=', $customer_id)->where('product_id', '=', $billing_product_id)->first();
        $userData['data'] = $Getmeasurement->measurements;
        echo json_encode($userData);
    }


}
