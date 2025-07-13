<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');

        $employees = Employee::select('employees.*', 'positions.title as position_title', 'departments.name as department_name')
            ->leftJoin('employee_position as ep', function ($join) {
                $join->on('employees.id', '=', 'ep.employee_id')
                    ->where('ep.is_primary', 1);
            })
            ->leftJoin('positions', 'ep.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('employees.name', 'like', '%' . $request->search . '%')
                        ->orWhere('employees.email', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy(
                $sortField === 'position_title' ? 'positions.title' :
                ($sortField === 'department_name' ? 'departments.name' : "employees.$sortField"),
                $sortDirection
            )
            ->paginate(10)
            ->appends($request->only(['search', 'sort', 'direction']));

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $positions = Position::with('department')->get();
        return view('employees.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'position_id' => 'nullable|exists:positions,id',
            'photo' => 'nullable|image|max:2048',
        ]);

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $employee->photo = $path;
        }

        $employee->save();

        // 👇 Attach the selected position as primary
        if ($request->position_id) {
            $employee->positions()->attach($request->position_id, ['is_primary' => true]);
        }

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