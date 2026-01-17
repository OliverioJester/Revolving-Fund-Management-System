<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Supplier::query();
        
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        $supplier = $query->paginate(15);
        return view('pages.suppliers',[
            'suppliers' => $supplier,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.suppliers');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Supplier::create($validate);

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('pages.suppliers', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('pages.suppliers', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $supplier->update($validate);

        return redirect()->route('suppliers.index')->with('success', 'Supplier successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier successfully deleted!');
    }
}
