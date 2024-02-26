<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Expense;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Hash;
use PDF;

class ExpenseController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');
        $data = Expense::where('soft_delete', '!=', 1)->where('date', '=', $today)->orderBy('id', 'DESC')->get();

        return view('page.backend.expense.index', compact('data', 'today', 'timenow'));
    }

    public function datefilter(Request $request)
    {
        $today = $request->get('from_date');
        $timenow = Carbon::now()->format('H:i');
        $data = Expense::where('soft_delete', '!=', 1)->where('date', '=', $today)->orderBy('id', 'DESC')->get();

        return view('page.backend.expense.index', compact('data', 'today', 'timenow'));

    }


    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Expense();

        $data->unique_key = $randomkey;
        $data->date = $request->get('date');
        $data->time = $request->get('time');
        $data->amount = $request->get('amount');
        $data->description = $request->get('description');

        $data->save();


        return redirect()->route('expense.index')->with('message', 'Added !');
    }


    public function edit(Request $request, $unique_key)
    {
        $ExpenseData = Expense::where('unique_key', '=', $unique_key)->first();
        $ExpenseData->date = $request->get('date');
        $ExpenseData->time = $request->get('time');
        $ExpenseData->amount = $request->get('amount');
        $ExpenseData->description = $request->get('description');

        $ExpenseData->update();

        return redirect()->route('expense.index')->with('info', 'Updated !');
    }


    public function delete($unique_key)
    {
        $data = Expense::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('expense.index')->with('warning', 'Deleted !');
    }
}
