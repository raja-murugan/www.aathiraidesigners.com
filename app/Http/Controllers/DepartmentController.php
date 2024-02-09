<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    public function index()
    {
        $data = Department::where('soft_delete', '!=', 1)->orderBy('id', 'DESC')->get();

        return view('page.backend.department.index', compact('data'));
    }


    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Department();

        $data->unique_key = $randomkey;
        $data->name = $request->get('name');

        $data->save();


        return redirect()->route('department.index')->with('message', 'Added !');
    }


    public function edit(Request $request, $unique_key)
    {
        $DepartmentData = Department::where('unique_key', '=', $unique_key)->first();

        $DepartmentData->name = $request->get('name');

        $DepartmentData->update();

        return redirect()->route('department.index')->with('info', 'Updated !');
    }

    public function delete($unique_key)
    {
        $data = Department::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('department.index')->with('warning', 'Deleted !');
    }
}
