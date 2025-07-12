<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $ceo = \App\Models\Position::where('title', 'Chief Executive Officer')->first();
        $cto = \App\Models\Position::where('title', 'Chief Technology Officer')->first();
        $devLead = \App\Models\Position::where('title', 'Lead Developer')->first();
        $hrManager = \App\Models\Position::where('title', 'HR Manager')->first();

        $john = \App\Models\Employee::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $jane = \App\Models\Employee::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
        ]);

        $david = \App\Models\Employee::create([
            'name' => 'David Miller',
            'email' => 'david@example.com',
        ]);

        // Assign positions
        $john->positions()->attach($ceo->id, ['is_primary' => true]);
        $jane->positions()->attach($cto->id, ['is_primary' => true]);
        $jane->positions()->attach($hrManager->id, ['is_primary' => false]); // acting
        $david->positions()->attach($devLead->id, ['is_primary' => true]);
    }
}
