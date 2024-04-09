<?php

namespace App\Http\Controllers;
use App\Models\Measurement;

use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function index()
    {
        $data = Measurement::orderBy('id', 'DESC')->get();

        return view('page.backend.measurement.index', compact('data'));
    }


    public function store(Request $request)
    {

        $data = new Measurement();
        $data->measurement = $request->get('measurement');

        $data->save();
        return redirect()->route('measurement.index')->with('message', 'Added !');
    }


    public function edit(Request $request, $id)
    {
        $MeasurementData = Measurement::where('id', '=', $id)->first();
        $MeasurementData->measurement = $request->get('measurement');

        $MeasurementData->update();

        return redirect()->route('measurement.index')->with('info', 'Updated !');
    }


    public function delete($id)
    {
        $data = Measurement::where('id', '=', $id)->first();

        $data->delete();

        return redirect()->route('measurement.index')->with('warning', 'Deleted !');
    }

}
