<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query= Employee::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        $employee = $query->paginate(15);
        return view('pages.employees',[
            'employees' => $employee,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        view('pages.employees');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:225',
        ]);

        Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('pages.employees', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('pages.employees', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:225',
        ]);
        
        $employee->update($validate);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
}
