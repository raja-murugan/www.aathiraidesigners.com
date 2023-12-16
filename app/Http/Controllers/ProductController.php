<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $data = Product::where('soft_delete', '!=', 1)->orderBy('id', 'DESC')->get();

        return view('page.backend.product.index', compact('data', 'today'));
    }

    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Product();
        $random_no =  rand(100,999);

        $data->unique_key = $randomkey;
        $data->name = $request->get('name');
        $data->description = $request->get('description');


        $product_image = $request->product_image;
        $filename_photo = $data->name . '_' . $random_no . '_' . 'Photo' . '.' . $product_image->getClientOriginalExtension();
        $request->product_image->move('assets/product_image', $filename_photo);
        $data->image = $filename_photo;
        $data->save();

        return redirect()->route('product.index')->with('message', 'Added !');
    }


    public function edit(Request $request, $unique_key)
    {
        $ProductData = Product::where('unique_key', '=', $unique_key)->first();

        $random_no =  rand(100,999);

        $ProductData->name = $request->get('name');
        $ProductData->description = $request->get('description');

        if ($request->file('product_image') != "") {
            $product_image = $request->product_image;
            $filename_photo = $ProductData->name . '_' . $random_no . '_' . 'Photo' . '.' . $product_image->getClientOriginalExtension();
            $request->product_image->move('assets/product_image', $filename_photo);
            $ProductData->image = $filename_photo;
         } else {
            $Insertedproof_photo = $ProductData->image;
            $ProductData->image = $Insertedproof_photo;
         }


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
}
