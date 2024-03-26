<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\CustomerProduct;
use App\Models\CustomerProductMeasurement;
use App\Models\Product;
use App\Models\ProductMeasurement;
use App\Models\Measurement;

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

            $measurementssarr = [];
            $CustomerProduct = CustomerProduct::where('customer_id', '=', $datas->id)->orderBy('id', 'DESC')->get();
            foreach ($CustomerProduct as $key => $CustomerProducts_arr) {

                $productarr = Product::findOrFail($CustomerProducts_arr->product_id);

               
                     


                        $CPM = CustomerProductMeasurement::where('customer_product_id', '=', $CustomerProducts_arr->id)->get();
                        foreach ($CPM as $key => $CPMs) {
                            
                            if($CPMs->measurement_no != ""){
                                $measurementss = Measurement::findOrFail($CPMs->measurement_id);

                        
                                $measurementssarr[] = array(
                                    'measurement_id' => $CPMs->measurement_id,
                                    'measurement' => $measurementss->measurement,
                                    'measurement_no' => $CPMs->measurement_no,
                                    'product_id' => $CPMs->product_id,
                                    'id' => $CPMs->id,
                                );
                            }

                            
                        }


                $productsarr[] = array(
                    'product' => $productarr->name,
                    'measurements' => $CustomerProducts_arr->measurements,
                    'product_id' => $CustomerProducts_arr->product_id,
                    'customer_id' => $CustomerProducts_arr->customer_id,
                    'id' => $CustomerProducts_arr->id,
                    'measurementssarr' => $measurementssarr,
                );
            }

            

            $Customer_data[] = array(
                'unique_key' => $datas->unique_key,
                'name' => $datas->name,
                'phone_number' => $datas->phone_number,
                'id' => $datas->id,
                'productsarr' => $productsarr,
            );

        }
        $today = Carbon::now()->format('Y-m-d');
        return view('page.backend.customer.index', compact('Customer_data', 'today'));
    }


    public function create()
    {
        $products = Product::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $measurements = Measurement::All();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        return view('page.backend.customer.create', compact('products', 'today', 'timenow', 'measurements'));
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
        error_reporting(0);
        foreach ($request->get('measurement_no') as $key => $measurement_no) {


            $CP = CustomerProduct::where('customer_id', '=', $customer_id)
                            ->where('product_id', '=', $request->productid[$key])
                            ->first();

            if($CP == ''){
                $CustomerProduct = new CustomerProduct;
                $CustomerProduct->customer_id = $customer_id;
                $CustomerProduct->product_id = $request->productid[$key];
                $CustomerProduct->save();

                $CustomerProduct_id = $CustomerProduct->id;
            }else if($CP != ''){
                $CustomerProduct = new CustomerProduct;
                $CustomerProduct->customer_id = $customer_id;
                $CustomerProduct->product_id = $request->productid[$key];
                $CustomerProduct->update();

                $CustomerProduct_id = $CP->id;
            }
                

                

                            $CustomerProductMeasurement = new CustomerProductMeasurement;
                            $CustomerProductMeasurement->customer_id = $customer_id;
                            $CustomerProductMeasurement->customer_product_id = $CustomerProduct_id;
                            $CustomerProductMeasurement->product_id = $CustomerProduct->product_id;
                            $CustomerProductMeasurement->measurement_id = $request->measurement_id[$key];
                            $CustomerProductMeasurement->measurement_name = $request->measurement_name[$key];
                            $CustomerProductMeasurement->measurement_no = $measurement_no;
                            $CustomerProductMeasurement->save();
            
        }


        return redirect()->route('customer.index')->with('message', 'Added !');
    }


    public function edit($unique_key)
    {
        $CustomerData = Customer::where('unique_key', '=', $unique_key)->first();
        $CustomerProducts = CustomerProduct::where('customer_id', '=', $CustomerData->id)->get();
        $CustomerProductMeasurements = CustomerProductMeasurement::where('customer_id', '=', $CustomerData->id)->get();

        $products = Product::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        return view('page.backend.customer.edit', compact('CustomerData', 'CustomerProducts', 'products', 'today', 'timenow', 'CustomerProductMeasurements'));
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
                CustomerProductMeasurement::where('customer_product_id', $different_id)->delete();
            }


        }


        foreach ($request->get('product_customer_mesasurementid') as $key => $product_customer_mesasurementid) {


            $CP = CustomerProduct::where('customer_id', '=', $customer_id)
                            ->where('product_id', '=', $request->productid[$key])
                            ->first();

            if($CP == ''){
                $CustomerProduct = new CustomerProduct;
                $CustomerProduct->customer_id = $customer_id;
                $CustomerProduct->product_id = $request->productid[$key];
                $CustomerProduct->save();

                $CustomerProduct_id = $CustomerProduct->id;
            }else if($CP != ''){
                $CustomerProduct = new CustomerProduct;
                $CustomerProduct->customer_id = $customer_id;
                $CustomerProduct->product_id = $request->productid[$key];
                $CustomerProduct->update();

                $CustomerProduct_id = $CP->id;
            }

            
            if ($product_customer_mesasurementid > 0) {

                $updateData = CustomerProductMeasurement::where('id', '=', $product_customer_mesasurementid)->first();
                $updateData->customer_id = $customer_id;
                $updateData->customer_product_id = $CustomerProduct_id;
                $updateData->product_id = $CustomerProduct->product_id;
                $updateData->measurement_id = $request->measurement_id[$key];
                $updateData->measurement_name = $request->measurement_name[$key];
                $updateData->measurement_no = $request->measurement_no[$key];
                $updateData->update();

            }else {

                $CustomerProductMeasurement = new CustomerProductMeasurement;
                $CustomerProductMeasurement->customer_id = $customer_id;
                $CustomerProductMeasurement->customer_product_id = $CustomerProduct_id;
                $CustomerProductMeasurement->product_id = $CustomerProduct->product_id;
                $CustomerProductMeasurement->measurement_id = $request->measurement_id[$key];
                $CustomerProductMeasurement->measurement_name = $request->measurement_name[$key];
                $CustomerProductMeasurement->measurement_no = $request->measurement_no[$key];
                $CustomerProductMeasurement->save();
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
