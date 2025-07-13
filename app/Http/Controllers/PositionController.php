<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sort', 'title');
        $sortDirection = $request->get('direction', 'asc');

        $positions = Position::with(['department', 'parent'])
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->appends($request->only(['search', 'sort', 'direction']));

        return view('positions.index', compact('positions'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('positions.create', [
            'departments' => Department::all(),
            'positions' => Position::all(), // for parent selection
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'parent_id' => 'nullable|exists:positions,id',
        ]);

        Position::create($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Position created successfully.');
    }

    public function edit(Position $position)
    {
        $departments = Department::orderBy('name')->get();
        $availableParents = Position::where('id', '!=', $position->id)->get();

        return view('positions.edit', [
            'position' => $position,
            'departments' => Department::all(),
            'positions' => Position::all(), // for parent dropdown
        ]);
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'parent_id' => 'nullable|exists:positions,id',
        ]);

        $position->update($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Position updated successfully.');
    }

    public function destroy(Position $position)
    {
        $position->delete();

        return redirect()->route('positions.index')
            ->with('success', 'Position deleted successfully.');
    }
}