<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Department::insert([
            ['name' => 'Executive'],
            ['name' => 'Human Resources'],
            ['name' => 'Engineering'],
            ['name' => 'Finance'],
        ]);
    }
}
