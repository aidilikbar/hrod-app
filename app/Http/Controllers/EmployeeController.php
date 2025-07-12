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
        $employee = Employee::create($request->only('name'));
        $employee->positions()->attach($request->position_id, ['is_primary' => $request->is_primary ?? 1]);

        return redirect()->route('employees.index');
    }

    public function edit(Employee $employee)
    {
        $positions = Position::all();
        $employee->load('positions');
        return view('employees.edit', compact('employee', 'positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        $employee->update($request->only('name'));
        $employee->positions()->sync([$request->position_id => ['is_primary' => $request->is_primary ?? 1]]);

        return redirect()->route('employees.index');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index');
    }
}