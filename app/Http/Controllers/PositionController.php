<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::with('employees')->get();
        return view('positions.index', compact('positions'));
    }

    public function create()
    {
        return view('positions.create');
    }

    public function store(Request $request)
    {
        Position::create($request->only('title'));
        return redirect()->route('positions.index');
    }

    public function edit(Position $position)
    {
        return view('positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $position->update($request->only('title'));
        return redirect()->route('positions.index');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('positions.index');
    }
}