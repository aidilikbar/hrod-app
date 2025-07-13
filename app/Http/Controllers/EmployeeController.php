<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('positions')->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $positions = Position::all();
        return view('employees.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'photo' => 'nullable|string|max:255',
        ]);

        Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee)
    {
        $positions = Position::all();
        return view('employees.edit', compact('employee', 'positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'photo' => 'nullable|image',
            'position_id' => 'required|exists:positions,id',
        ]);

        $employee->update($request->only(['name', 'email']));

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $employee->photo = $path;
            $employee->save();
        }

        $employee->positions()->sync([
            $request->position_id => ['is_primary' => true]
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index');
    }
}