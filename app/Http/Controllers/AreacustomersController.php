<?php

namespace App\Http\Controllers;

use App\Models\Areacustomer;
use Illuminate\Http\Request;

class AreacustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Areacustomer::query();

        if ($search) {
            $query->where('area', 'like', "%{$search}%");
        }

        $areacustomers = $query->paginate(15);
        return view('pages.area_of_customers',[
            'search' => $search,
            'areacustomers' => $areacustomers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('pages.area_of_customers');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'area' => 'required|string|max:255'
        ]);

        Areacustomer::create($validated);
        return redirect()->route('area-of-customers.index')->with('success', 'Area of customers successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Areacustomer $area_of_customer)
    {
        return view('pages.area_of_customers', compact('area_of_customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Areacustomer $area_of_customer)
    {
        return view('pages.area_of_customers', compact('area_of_customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Areacustomer $area_of_customer)
    {
        $validated = $request->validate([
            'area' => 'required|string|max:255'
        ]);

        $area_of_customer->update($validated);
        return redirect()->route('area-of-customers.index')->with('success', 'Area of customers successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Areacustomer $area_of_customer)
    {
        $area_of_customer->delete();
        return redirect()->route('area-of-customers.index')->with('success', 'Area of customers successfully deleted!');
    }
}
