<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Income;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Hash;
use PDF;


class IncomeController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');
        $data = Income::where('soft_delete', '!=', 1)->where('date', '=', $today)->orderBy('id', 'DESC')->get();

        return view('page.backend.income.index', compact('data', 'today', 'timenow'));
    }

    public function datefilter(Request $request)
    {
        $today = $request->get('from_date');
        $timenow = Carbon::now()->format('H:i');
        $data = Income::where('soft_delete', '!=', 1)->where('date', '=', $today)->orderBy('id', 'DESC')->get();

        return view('page.backend.income.index', compact('data', 'today', 'timenow'));

    }


    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Income();

        $data->unique_key = $randomkey;
        $data->date = $request->get('date');
        $data->time = $request->get('time');
        $data->amount = $request->get('amount');
        $data->description = $request->get('description');

        $data->save();


        return redirect()->route('income.index')->with('message', 'Added !');
    }


    public function edit(Request $request, $unique_key)
    {
        $IncomeData = Income::where('unique_key', '=', $unique_key)->first();
        $IncomeData->date = $request->get('date');
        $IncomeData->time = $request->get('time');
        $IncomeData->amount = $request->get('amount');
        $IncomeData->description = $request->get('description');

        $IncomeData->update();

        return redirect()->route('income.index')->with('info', 'Updated !');
    }


    public function delete($unique_key)
    {
        $data = Income::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('income.index')->with('warning', 'Deleted !');
    }
}
