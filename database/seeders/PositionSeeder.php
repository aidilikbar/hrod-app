<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $executive = \App\Models\Department::where('name', 'Executive')->first();
        $hr = \App\Models\Department::where('name', 'Human Resources')->first();
        $eng = \App\Models\Department::where('name', 'Engineering')->first();

        // Top-level position
        $ceo = \App\Models\Position::create([
            'title' => 'Chief Executive Officer',
            'department_id' => $executive->id,
            'parent_id' => null,
        ]);

        // HR positions
        $hrManager = \App\Models\Position::create([
            'title' => 'HR Manager',
            'department_id' => $hr->id,
            'parent_id' => $ceo->id,
        ]);

        \App\Models\Position::create([
            'title' => 'HR Officer',
            'department_id' => $hr->id,
            'parent_id' => $hrManager->id,
        ]);

        // Engineering positions
        $cto = \App\Models\Position::create([
            'title' => 'Chief Technology Officer',
            'department_id' => $eng->id,
            'parent_id' => $ceo->id,
        ]);

        $devLead = \App\Models\Position::create([
            'title' => 'Lead Developer',
            'department_id' => $eng->id,
            'parent_id' => $cto->id,
        ]);

        \App\Models\Position::create([
            'title' => 'Junior Developer',
            'department_id' => $eng->id,
            'parent_id' => $devLead->id,
        ]);
    }
}
