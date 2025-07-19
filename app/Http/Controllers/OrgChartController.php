<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrgChartController extends Controller
{
    public function index()
    {
        $nodes = DB::table('employees as e')
            ->join('employee_position as ep', function ($join) {
                $join->on('e.id', '=', 'ep.employee_id')
                     ->where('ep.is_primary', 1);
            })
            ->join('positions as p', 'ep.position_id', '=', 'p.id')
            ->select('e.id', 'e.name', 'p.title', 'p.parent_id as pid')
            ->get();

        return view('orgchart', compact('nodes'));
    }

    public function api()
    {
        $nodes = DB::table('employees as e')
            ->join('employee_position as ep', function ($join) {
                $join->on('e.id', '=', 'ep.employee_id')
                     ->where('ep.is_primary', 1);
            })
            ->join('positions as p', 'ep.position_id', '=', 'p.id')
            ->select('e.id', 'e.name', 'p.title', 'p.parent_id as pid')
            ->get();

        return response()->json($nodes);
    }
}