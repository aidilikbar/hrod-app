<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\Employee;

class OrgChartController extends Controller
{
    public function index()
    {
        // Get the root node (parent_id is null)
        $root = Position::with(['employees', 'children.children.children.employees'])->whereNull('parent_id')->first();

        if (!$root) {
            return response()->json([]);
        }

        $flatTree = $this->flattenTree($root);
        return response()->json($flatTree);
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