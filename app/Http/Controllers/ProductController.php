<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
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

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::where('soft_delete', '!=', 1)->orderBy('id', 'DESC')->get();

        $Product_data = [];
        $measurementssarr = [];
        foreach ($data as $key => $datas) {


            $ProductMeasurements = ProductMeasurement::where('product_id', '=', $datas->id)->get();
            foreach ($ProductMeasurements as $key => $ProductMeasurementsarr) {

                $measurementss = Measurement::findOrFail($ProductMeasurementsarr->measurement_id);

               
                $measurementssarr[] = array(
                    'measurement_id' => $ProductMeasurementsarr->measurement_id,
                    'measurement' => $measurementss->measurement,
                    'product_id' => $ProductMeasurementsarr->product_id,
                    'id' => $ProductMeasurementsarr->id,
                );
            }

            $Product_data[] = array(
                'unique_key' => $datas->unique_key,
                'name' => $datas->name,
                'id' => $datas->id,
                'measurementssarr' => $measurementssarr,
            );

        }
        $today = Carbon::now()->format('Y-m-d');
        return view('page.backend.product.index', compact('Product_data', 'today'));
    }


    public function create()
    {
        $measurements = Measurement::All();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        return view('page.backend.product.create', compact('today', 'timenow', 'measurements'));
    }

    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Product();

        $data->unique_key = $randomkey;
        $data->name = $request->get('product');

        $data->save();

        $product_id = $data->id;

        foreach ($request->get('measurement_id') as $key => $measurement_id) {

            if($measurement_id != ""){
                $ProductMeasurement = new ProductMeasurement;
                $ProductMeasurement->product_id = $product_id;
                $ProductMeasurement->measurement_id = $request->measurement_id[$key];
                $ProductMeasurement->save();
            }
            
        }



        return redirect()->route('product.index')->with('message', 'Added !');
    }


    public function edit($unique_key)
    {

        $ProductData = Product::where('unique_key', '=', $unique_key)->first();
        $ProductMeasurements = ProductMeasurement::where('product_id', '=', $ProductData->id)->get();

        $measurements = Measurement::All();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        return view('page.backend.product.edit', compact('ProductData', 'ProductMeasurements', 'measurements', 'today', 'timenow'));
    }


    public function update(Request $request, $unique_key)
    {
        $ProductData = Product::where('unique_key', '=', $unique_key)->first();
        $ProductData->name = $request->get('product');
        $ProductData->update();

        $product_id = $ProductData->id;


        $getInserted = ProductMeasurement::where('product_id', '=', $product_id)->get();
        $purchase_products = array();
        foreach ($getInserted as $key => $getInserted_produts) {
            $purchase_products[] = $getInserted_produts->id;
        }

        $updated_products = $request->product_measurements_id;
        $updated_product_ids = array_filter($updated_products);
        $different_ids = array_merge(array_diff($purchase_products, $updated_product_ids), array_diff($updated_product_ids, $purchase_products));

        if (!empty($different_ids)) {
            foreach ($different_ids as $key => $different_id) {
                ProductMeasurement::where('id', $different_id)->delete();
            }
        }



        foreach ($request->get('product_measurements_id') as $key => $product_measurements_id) {

            if ($product_measurements_id > 0) {

                $updateData = ProductMeasurement::where('id', '=', $product_measurements_id)->first();
                $updateData->product_id = $product_id;
                $updateData->measurement_id = $request->measurement_id[$key];
                $updateData->update();

            } else if ($product_measurements_id == '') {

                if($request->measurement_id[$key] != ""){

                    $ProductMeasurement = new ProductMeasurement;
                    $ProductMeasurement->product_id = $product_id;
                    $ProductMeasurement->measurement_id = $request->measurement_id[$key];
                    $ProductMeasurement->save();
                }
            }
        }


        return redirect()->route('product.index')->with('info', 'Updated !');
    }

    public function delete($unique_key)
    {
        $data = Product::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('product.index')->with('warning', 'Deleted !');
    }

    public function checkduplicate(Request $request)
    {
        if(request()->get('query'))
        {
            $query = request()->get('query');
            $employeedata = Product::where('name', '=', $query)->first();

            $userData['data'] = $employeedata;
            echo json_encode($userData);
        }
    }


    
    public function getproducts()
    {
        $GetProduct = Product::where('soft_delete', '!=', 1)->get();
        $userData['data'] = $GetProduct;
        echo json_encode($userData);
    }


    public function getmeasurements()
    {
        $GetProduct = Measurement::All();
        $userData['data'] = $GetProduct;
        echo json_encode($userData);
    }


    public function getproduct_Mesurements($product_id)
    {
        $ProductMeasurement = ProductMeasurement::where('product_id', '=', $product_id)->get();
        $measurementssarr = [];
        foreach ($ProductMeasurement as $key => $ProductMeasurementsarr) {

            $measurementss = Measurement::findOrFail($ProductMeasurementsarr->measurement_id);

           
            $measurementssarr[] = array(
                'measurement_id' => $ProductMeasurementsarr->measurement_id,
                'measurement' => $measurementss->measurement,
                'product_id' => $ProductMeasurementsarr->product_id,
                'id' => $ProductMeasurementsarr->id,
            );
        }


        $userData['data'] = $measurementssarr;
        echo json_encode($userData);
    }

}
