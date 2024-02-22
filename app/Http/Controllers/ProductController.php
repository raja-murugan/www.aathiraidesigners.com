<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

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
        foreach ($data as $key => $datas) {

            $Product_data[] = array(
                'unique_key' => $datas->unique_key,
                'name' => $datas->name,
                'id' => $datas->id,
            );

        }
        $today = Carbon::now()->format('Y-m-d');
        return view('page.backend.product.index', compact('Product_data', 'today'));
    }

    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Product();

        $data->unique_key = $randomkey;
        $data->name = $request->get('name');

        $data->save();


        return redirect()->route('product.index')->with('message', 'Added !');
    }


    public function edit(Request $request, $unique_key)
    {

        $ProductData = Product::where('unique_key', '=', $unique_key)->first();
        $ProductData->name = $request->get('name');
        $ProductData->update();

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

}
