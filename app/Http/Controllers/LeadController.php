<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Employee;
use App\Models\Lead;
use Illuminate\Support\Str;
use App\Imports\ImportLead;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LeadController extends Controller
{
    public function index()
    {
        $data = Lead::where('soft_delete', '!=', 1)->orderBy('id', 'DESC')->get();

        $Lead_data = [];
        foreach ($data as $key => $datas) {

            $employee = Employee::findOrFail($datas->employee_id);

            $Lead_data[] = array(
                'name' => $datas->name,
                'phonenumber' => $datas->phonenumber,
                'source_from' => $datas->source_from,
                'id' => $datas->id,
                'employee_id' => $datas->employee_id,
                'employee' => $employee->name,
            );

        }
        $today = Carbon::now()->format('Y-m-d');
        $employee = Employee::where('soft_delete', '!=', 1)->get();
        return view('page.backend.lead.index', compact('Lead_data', 'today', 'employee'));
    }


    public function store(Request $request)
    {
        $data = new Lead();
        $data->name = $request->get('name');
        $data->phonenumber = $request->get('phonenumber');
        $data->source_from = $request->get('source_from');
        $data->employee_id = $request->get('employee_id');
        $data->save();

        return redirect()->route('lead.index')->with('message', 'Added !');
    }


    public function edit(Request $request, $id)
    {
        $LeadData = Lead::findOrFail($id);

        $LeadData->name = $request->get('name');
        $LeadData->phonenumber = $request->get('phonenumber');
        $LeadData->source_from = $request->get('source_from');
        $LeadData->employee_id = $request->get('employee_id');
        $LeadData->update();

        return redirect()->route('lead.index')->with('info', 'Updated !');
    }


    public function delete($id)
    {
        $data = Lead::findOrFail($id);

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('lead.index')->with('warning', 'Deleted !');
    }


    public function excel_import(Request $request){ 
        error_reporting(0);
        Excel::import(new ImportLead, request()->file('lead_file'));
        return redirect()->back();
    }
}
