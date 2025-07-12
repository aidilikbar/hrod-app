<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class OrgChartController extends Controller
{
    // 1. Fetch org chart as a tree
    public function index()
    {
        $tree = Position::with(['children', 'employees'])
            ->whereNull('parent_id')
            ->get();

        return response()->json($tree);
    }

    // 2. Store new position
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'parent_id' => 'nullable|exists:positions,id',
        ]);

        $position = Position::create($request->only('title', 'department_id', 'parent_id'));

        return response()->json($position, 201);
    }

    // 3. Update position
    public function update(Request $request, $id)
    {
        $position = Position::findOrFail($id);

        $position->update($request->only('title', 'department_id', 'parent_id'));

        return response()->json($position);
    }

    // 4. Delete position
    public function destroy($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();

        return response()->json(['message' => 'Position deleted']);
    }
}