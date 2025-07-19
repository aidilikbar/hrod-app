<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('employee_number')->nullable()->after('id');
            $table->enum('talent_mapping', ['High Potential', 'Mediocre', 'Deadwood'])->nullable()->after('photo');
            $table->enum('status', ['Permanent', 'Contract', 'Konpro', 'Freelance'])->nullable()->after('talent_mapping');
            $table->enum('company', ['KCM', 'UB', 'AIN', 'KIN', 'VCBL', 'KMN', 'Gramedia', 'Others'])->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['employee_number', 'talent_mapping', 'status', 'company']);
        });
    }
};