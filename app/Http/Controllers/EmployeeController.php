<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');

        $employees = Employee::select('employees.*', 'positions.title as position_title', 'departments.name as department_name')
            ->leftJoin('employee_position as ep', function ($join) {
                $join->on('employees.id', '=', 'ep.employee_id')->where('ep.is_primary', 1);
            })
            ->leftJoin('positions', 'ep.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
            ->with('positions')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('employees.name', 'like', '%' . $request->search . '%')
                      ->orWhere('employees.email', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy(
                $sortField === 'position_id' ? 'positions.title' :
                ($sortField === 'department_id' ? 'departments.name' : 'employees.' . $sortField),
                $sortDirection
            )
            ->paginate(10)
            ->appends($request->only(['search', 'sort', 'direction']));

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $positions = Position::all();
        return view('employees.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:employees',
            'employee_number' => 'nullable|string|max:255',
            'talent_mapping'  => 'nullable|in:High Potential,Mediocre,Deadwood',
            'status'          => 'nullable|in:Permanent,Contract,Konpro,Freelance',
            'company'         => 'nullable|in:KCM,UB,AIN,KIN,VCBL,KMN,Gramedia,Others',
            'photo'           => 'nullable|image|max:2048',
            'position_id'     => 'nullable|exists:positions,id',
        ]);

        $data = $request->except(['photo', 'position_id']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $employee = Employee::create($data);

        if ($request->filled('position_id')) {
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
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:employees,email,' . $employee->id,
            'employee_number' => 'nullable|string|max:255',
            'talent_mapping'  => 'nullable|in:High Potential,Mediocre,Deadwood',
            'status'          => 'nullable|in:Permanent,Contract,Konpro,Freelance',
            'company'         => 'nullable|in:KCM,UB,AIN,KIN,VCBL,KMN,Gramedia,Others',
            'photo'           => 'nullable|image|max:2048',
            'position_id'     => 'nullable|exists:positions,id',
        ]);

        $data = $request->except(['photo', 'position_id']);

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $employee->update($data);

        if ($request->filled('position_id')) {
            $employee->positions()->sync([
                $request->position_id => ['is_primary' => true]
            ]);
        }

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }

        $employee->positions()->detach();
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}