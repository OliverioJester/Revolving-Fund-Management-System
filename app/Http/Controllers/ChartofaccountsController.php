<?php

namespace App\Http\Controllers;

use App\Models\Chartofaccount;
use Illuminate\Http\Request;

class ChartofaccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input("search");
        $query = Chartofaccount::query();

        if ($search) {
            $query->where('account_code', 'like', "%{$search}%")
            ->orWhere('account_title', 'like', "%{$search}%");
        }
        $chartofaccount = $query->paginate(15);
        return view('pages.charts_of_accounts',[
            'chartofaccounts' => $chartofaccount,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.charts_of_accounts');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'account_code' => 'required|integer',
            'account_title' => 'required|string|max:225',
            'remarks' => 'required|string|max:225'
        ]);

        Chartofaccount::create($validate);

        return redirect()->route('chart-of-accounts.index')->with('success', 'Chart of account successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chartofaccount $chartofaccount)
    {   
        return view('pages.charts_of_accounts', compact('chartofaccount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chartofaccount $chartofaccount)
    {
        return view('pages.charts_of_accounts', compact('chartofaccount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chartofaccount $chartofaccount)
    {
        $validation = $request->validate([
            'account_code' => 'required|integer|digits:6',
            'account_title' => 'required|string|max:225',
            'remarks' => 'required|string|max:225'
        ]);

        $chartofaccount->update($validation);
        return redirect()->route('chart-of-accounts.index')->with('success', 'Charts of accounts successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chartofaccount $chartofaccount)
    {
        $chartofaccount->delete();
        return redirect()->route('chart-of-accounts.index')->with('success', 'Charts of accounts successfully update!');
    }
}
