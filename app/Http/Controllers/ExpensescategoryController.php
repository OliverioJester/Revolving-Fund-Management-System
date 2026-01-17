<?php

namespace App\Http\Controllers;

use App\Models\Expensescategory;
use App\Models\Nonexpensescategory;
use Illuminate\Http\Request;

class ExpensescategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // expenses
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch both tables
        $expenses = Expensescategory::query()
            ->when($search, fn($q) => $q->where('expenses', 'like', "%{$search}%"))
            ->paginate(10, ['*'], 'expenses-page');

        $nonexpenses = Nonexpensescategory::query()
            ->when($search, fn($q) => $q->where('nonexpense', 'like', "%{$search}%"))
            ->paginate(10, ['*'], 'nonexpenses-page');

        // Return one single view
        return view('pages.list', [
            'expenses' => $expenses,
            'nonexpenses' => $nonexpenses,
            'search' => $search
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page.list');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'expenses' => 'required|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);

        Expensescategory::create($validated);

        return redirect()->route('list.index')->with('success', 'Expense categories successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expensescategory $list)
    {   
        return view('page.list', compact('list'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expensescategory $list)
    {   
        return view('page.list', compact('list')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expensescategory $list)
    {
        $validated = $request->validate([
            'expenses' => 'required|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);

        $list->update($validated);
        return redirect()->route('list.index')->with('success', 'Expense category successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expensescategory $list)
    {
        $list->delete();
        return redirect()->route('list.index')->with('success', 'Expense category successfully deleted!');
    }

// non-expenses

    public function createNonexpenses()
    {
        return view('pages.list');
    }

    public function storenonindex(Request $request)
    {
        $validated = $request->validate([
            'nonexpenses' => 'required|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);

        Nonexpensescategory::create($validated);
        return redirect()->route('list.index')->with('success', 'Non-categories successfully created!');
    }
    
    public function showNonexpenses(Nonexpensescategory $list)
    {
        return view('pages.list', compact('list'));
    } 
    
    public function editNonexpenses(Nonexpensescategory $list)
    {
        return view('pages.list', compact('list'));
    }

    public function updateNonexpenses(Request $request, Nonexpensescategory $list)
    {
        $validated = $request->validate([
            'nonexpenses' => 'required|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);

        $list->update($validated);
        return redirect()->route('list.index')->with('success', 'Non-expenses updated successfully!');
    }

    public function destroyNonexpenses(Nonexpensescategory $list)
    {
        $list->delete();
        return redirect()->route('list.index')->with('success', 'Non-expenses deleted successfully!');
    }
}
