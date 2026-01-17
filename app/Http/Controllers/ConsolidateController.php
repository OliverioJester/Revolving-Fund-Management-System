<?php

namespace App\Http\Controllers;

use App\Models\Areacustomer;
use App\Models\Consolidate;
use App\Models\Employee;
use App\Models\Expensescategory;
use App\Models\Nonexpensescategory;
use App\Models\Period_and_transmittal;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ConsolidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->input('search');
        $query = Consolidate::query();
        $allEmployeeDatas = Employee::all();   
        $allAreacustomers = Areacustomer::all();
        $allSuppliers = Supplier::all();
        $allExpensesCategories = Expensescategory::all();
        $allNonexpensesCategories = Nonexpensescategory::all();
        $period_and_transmittals = Period_and_transmittal::all();
     

        if ($search) {
            $query->where('pcv', 'like', "%{$search}%")
                        ->orWhere('date_consolidate', 'like', "{$search}")
                            ->orWhereHas('employee', function ($q) use ($search){
                                $q->where('name','like', "%{$search}%");
                            });
        }

        $consolidates = $query->paginate(15);

        $expenses = Consolidate::with('expensescategory')
            ->get()
            ->pluck('expensescategory.expenses')
            ->unique()
            ->values();

        $nonexpenses = Consolidate::with('nonexpensescategory')
            ->get()
            ->pluck('nonexpensescategory.nonexpenses')
            ->unique()
            ->values();
                    
        return view('pages.consolidates', [
            'consolidates' => $consolidates,
            'search' => $search,
            'allEmployeeDatas' => $allEmployeeDatas,
            'allAreacustomers' => $allAreacustomers,
            'allSuppliers' => $allSuppliers,
            'allExpensesCategories' => $allExpensesCategories,
            'allNonexpensesCategories' => $allNonexpensesCategories,
            'expenses' => $expenses, 
            'nonexpenses' => $nonexpenses,
            'period_and_transmittals' => $period_and_transmittals
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.consolidates');
    }

    public function storePeriodandTransmittal(Request $request)
    {
        $validated = $request->validate([
            'first_period' => 'required',
            'second_period' => 'required',
            'transmittal' => 'required|string|max:255',
            'revolving_report' => 'required|string|max:255'
        ]);

        Period_and_transmittal::create($validated);
        return redirect()->route('consolidates.index')->with('success', 'Period and Transmittal slip successfully created!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_consolidate' => 'required',
            'pvc' => 'required|integer',
            'employee_id' => 'required|exists:employees,id',
            'areacustomer_id' => 'required|exists:areacustomers,id',
            'reported_and_unreported' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'date_receipt' => 'nullable',
            'receipt_invoice' => 'nullable|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'address' => 'nullable|string|max:255',
            'tin' => 'nullable|string|max:255',
            'expensescategory_id' => 'nullable|exists:expensescategories,id',
            'nonexpensescategory_id' => 'nullable|exists:nonexpensescategories,id',
            'net_vat' => 'nullable|numeric',
            'input_vat' => 'nullable|numeric',
            'non_vat'=> 'nullable|numeric',
            'ewt' => 'nullable|numeric',
        ]);

        $validated['net_vat'] = $validated['net_vat'] ?? 0;
        $validated['input_vat'] = $validated['input_vat'] ?? 0;
        $validated['non_vat'] = $validated['non_vat'] ?? 0;
        $validated['ewt'] = $validated['ewt'] ?? 0;
        $validated['type'] = ($request->net_vat > 0) ? 'VAT' : 'NV';

        Consolidate::create($validated);
        return redirect()->route('consolidates.index')->with('success', 'Consolidate successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Consolidate $consolidate)
    {
        return view('pages.consolidates', compact('consolidate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consolidate $consolidate) //the model name(Consolidate) was in the props because it automatically find the id of the routes if we used the resource in the web.php
    {
        return view('pages.consolidates', compact('consolidated'));
    }

    public function updatePeriodandTransmittal(Request $request, Period_and_transmittal $period_and_transmittal)
    {
        $validated = $request->validate([
            'first_period' => 'required',
            'second_period' => 'required',
            'transmittal' => 'required|string|max:255',
            'revolving_report' => 'required|string|max:255'
        ]);

        $period_and_transmittal ->update($validated);
        return redirect()->route('consolidates.index')->with('success', 'Period and Transmittal slip successfully created!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consolidate $consolidate)
    {
        $validated = $request->validate([
            'date_consolidate' => 'required',
            'pvc' => 'required|integer',
            'employee_id' => 'required|exists:employees,id',
            'areacustomer_id' => 'required|exists:areacustomers,id',
            'reported_and_unreported' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'date_receipt' => 'nullable',
            'receipt_invoice' => 'nullable|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'address' => 'nullable|string|max:255',
            'tin' => 'nullable|string|max:255',
            'expensescategory_id' => 'nullable|exists:expensescategories,id',
            'nonexpensescategory_id' => 'nullable|exists:nonexpensescategories,id',
            'net_vat' => 'nullable|numeric',
            'input_vat' => 'nullable|numeric',
            'non_vat'=> 'nullable|numeric',
            'ewt' => 'nullable|numeric',
        ]);

        $consolidate->update($validated);
        return redirect()->route('consolidates.index')->with('success', 'Consolidate successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consolidate $consolidate)
    {
        $consolidate->delete();
        return redirect()->route('consolidates.index')->with('success', 'Consolidate successfully deleted!');
    }

    public function bulkDelete()
    {
        $allConsolidateData = Consolidate::query();
        $allPeriod_and_transmittalsData = Period_and_transmittal::query();
        $allConsolidateData->delete();
        $allPeriod_and_transmittalsData->delete();
        

        return redirect()->route('consolidates.index')->with('success', 'All consolidated deleted successfully!');
    }
        
}
