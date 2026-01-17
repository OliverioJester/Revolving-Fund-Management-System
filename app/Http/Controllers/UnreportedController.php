<?php

namespace App\Http\Controllers;

use App\Models\Consolidate;
use App\Models\Period_and_transmittal;
use Illuminate\Http\Request;

class UnreportedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $period_and_transmittals = Period_and_transmittal::all();
        $consolidates = Consolidate::all();
        $unreports = Consolidate::where('type', 'NV')->get();        
        return view('pages.unreported',[
            'period_and_transmittals' => $period_and_transmittals,
            'unreports' => $unreports,
            'consolidates' => $consolidates        
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
