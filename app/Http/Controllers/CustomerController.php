<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customer;
use App\Models\CustomerFamily;
use App\Models\Employee;
use App\Imports\ImportCustomer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::where('soft_delete', '!=', 1)->orderBy('id', 'DESC')->get();

        $Customer_data = [];
        $families = [];
        foreach ($data as $key => $datas) {

            $CustomerFamilys = CustomerFamily::where('customer_id', '=', $datas->id)->orderBy('id', 'DESC')->get();
            foreach ($CustomerFamilys as $key => $CustomerFamilysarr) {

                $families[] = array(
                    'family_name' => $CustomerFamilysarr->family_name,
                    'family_relationship' => $CustomerFamilysarr->family_relationship,
                    'family_dob' => $CustomerFamilysarr->family_dob,
                    'family_weddingdate' => $CustomerFamilysarr->family_weddingdate,
                    'customer_id' => $CustomerFamilysarr->customer_id,
                );
            }

            
            if($datas->employee_id != 0){
                $employee = Employee::findOrFail($datas->employee_id);
                $employeename = $employee->name;
            }else if($datas->employee_id == 0){
                $employeename = '';
            }

            $Customer_data[] = array(
                'name' => $datas->name,
                'phonenumber' => $datas->phonenumber,
                'alter_phonenumber' => $datas->alter_phonenumber,
                'email_id' => $datas->email_id,
                'address' => $datas->address,
                'source_from' => $datas->source_from,
                'customer_photo' => $datas->customer_photo,
                'birth_date' => $datas->birth_date,
                'wedding_date' => $datas->wedding_date,
                'unique_key' => $datas->unique_key,
                'id' => $datas->id,
                'customer_photo' => $datas->customer_photo,
                'employee_id' => $datas->employee_id,
                'employee' => $employeename,
                'families' => $families,
            );

        }
        $today = Carbon::now()->format('Y-m-d');
        return view('page.backend.customer.index', compact('Customer_data', 'today'));
    }


    public function create()
    {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');
        $employee = Employee::where('soft_delete', '!=', 1)->get();

        return view('page.backend.customer.create', compact('today', 'timenow', 'employee'));
    }


    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Customer();
        $random_no =  rand(100,999);

        $data->unique_key = $randomkey;
        $data->name = $request->get('name');
        $data->phonenumber = $request->get('phonenumber');
        $data->alter_phonenumber = $request->get('alter_phonenumber');
        $data->email_id = $request->get('email_id');
        $data->address = $request->get('address');
        $data->source_from = $request->get('source_from');
        $data->birth_date = $request->get('birth_date');
        $data->wedding_date = $request->get('wedding_date');
        $data->employee_id = $request->get('employee_id');


        $customer_photo = $request->customer_photo;
        $filename_customer_photo = $data->name . '_' . $random_no . '_' . 'Photo' . '.' . $customer_photo->getClientOriginalExtension();
        $request->customer_photo->move('assets/customer_photo', $filename_customer_photo);
        $data->customer_photo = $filename_customer_photo;
        $data->save();


        $customerid = $data->id;
        
        
            foreach ($request->get('family_name') as $key => $family_name) {
                $CustomerFamilydata = new CustomerFamily();

                $CustomerFamilydata->customer_id = $customerid;
                $CustomerFamilydata->family_name = $family_name;
                $CustomerFamilydata->family_relationship = $request->family_relationship[$key];
                $CustomerFamilydata->family_dob = $request->family_dob[$key];
                $CustomerFamilydata->family_weddingdate = $request->family_weddingdate[$key];
                $CustomerFamilydata->save();
            }

        return redirect()->route('customer.index')->with('message', 'Added !');
    }



    public function edit($id)
    {
        $CustomerData = Customer::findOrFail($id);
        $CustomerFamily = CustomerFamily::where('customer_id', '=', $CustomerData->id)->get();
        $employee = Employee::where('soft_delete', '!=', 1)->get();

        return view('page.backend.customer.edit', compact('CustomerData', 'CustomerFamily', 'employee'));
    }



    public function update(Request $request, $id)
    {
        $random_no =  rand(100,999);

        $CustomerData = Customer::findOrFail($id);
        $CustomerData->name = $request->get('name');
        $CustomerData->phonenumber = $request->get('phonenumber');
        $CustomerData->alter_phonenumber = $request->get('alter_phonenumber');
        $CustomerData->email_id = $request->get('email_id');
        $CustomerData->address = $request->get('address');
        $CustomerData->source_from = $request->get('source_from');
        $CustomerData->birth_date = $request->get('birth_date');
        $CustomerData->wedding_date = $request->get('wedding_date');
        $CustomerData->employee_id = $request->get('employee_id');

        if ($request->file('customer_photo') != "") {
           $customer_photo = $request->customer_photo;
           $filename_customer_photo = $CustomerData->name . '_' . $random_no . '_' . 'Photo' . '.' . $customer_photo->getClientOriginalExtension();
           $request->customer_photo->move('assets/customer_photo', $filename_customer_photo);
           $CustomerData->customer_photo = $filename_customer_photo;
        } else {
           $Insertedproof_customer_photo = $CustomerData->customer_photo;
           $CustomerData->customer_photo = $Insertedproof_customer_photo;
        }


        $CustomerData->update();
        $customer_id = $CustomerData->id;





        $getInserted = CustomerFamily::where('customer_id', '=', $customer_id)->get();
        $purchase_products = array();
        foreach ($getInserted as $key => $getInserted_produts) {
            $purchase_products[] = $getInserted_produts->id;
        }

        $updated_products = $request->family_id;
        $updated_product_ids = array_filter($updated_products);
        $different_ids = array_merge(array_diff($purchase_products, $updated_product_ids), array_diff($updated_product_ids, $purchase_products));

        if (!empty($different_ids)) {
            foreach ($different_ids as $key => $different_id) {
                CustomerFamily::where('id', $different_id)->delete();
            }
        }

        foreach ($request->get('family_id') as $key => $family_id) {
            if ($family_id > 0) {


                $ids = $family_id;
                $family_name = $request->family_name[$key];
                $family_relationship = $request->family_relationship[$key];
                $family_dob = $request->family_dob[$key];
                $family_weddingdate = $request->family_weddingdate[$key];

                DB::table('customer_families')->where('id', $ids)->update([
                    'customer_id' => $customer_id, 'family_name' => $family_name, 'family_relationship' => $family_relationship, 'family_dob' => $family_dob, 'family_weddingdate' => $family_weddingdate
                ]);

            } else if ($family_id == '') {
                $CustomerFamilydata = new CustomerFamily();
                $CustomerFamilydata->customer_id = $customer_id;
                $CustomerFamilydata->family_name = $request->family_name[$key];
                $CustomerFamilydata->family_relationship = $request->family_relationship[$key];
                $CustomerFamilydata->family_dob = $request->family_dob[$key];
                $CustomerFamilydata->family_weddingdate = $request->family_weddingdate[$key];
                $CustomerFamilydata->save();
            }
        }

        return redirect()->route('customer.index')->with('info', 'Updated !');
    }



    public function delete($id)
    {
        $data = Customer::findOrFail($id);

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('customer.index')->with('warning', 'Deleted !');
    }



    public function checkduplicate(Request $request)
    {
        if(request()->get('query'))
        {
            $query = request()->get('query');
            $customerdata = Customer::where('phonenumber', '=', $query)->first();

            $userData['data'] = $customerdata;
            echo json_encode($userData);
        }
    }


    public function excel_import(Request $request){ 
        error_reporting(0);
        Excel::import(new ImportCustomer, request()->file('file'));
        return redirect()->back();
    }
}
