<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;

class OrgChartController extends Controller
{
    public function index()
    {
        // Fetch all root positions (parent_id is null)
        $roots = Position::with(['employees', 'children.children.children.employees'])
                         ->whereNull('parent_id')
                         ->get();

        if ($roots->isEmpty()) {
            return response()->json([]);
        }

        $allTrees = [];
        foreach ($roots as $root) {
            $this->flattenTree($root, null, $allTrees);
        }

        return response()->json($allTrees);
    }

    private function flattenTree($node, $parentId = null, &$result = [])
    {
        $employeeName = $node->employees->first()?->name ?? 'Unknown';

        $result[] = [
            'id' => $node->id,
            'pid' => $parentId,
            'name' => $employeeName,
            'title' => $node->title,
        ];

        foreach ($node->children as $child) {
            $this->flattenTree($child, $node->id, $result);
        }

        return $result;
    }
}