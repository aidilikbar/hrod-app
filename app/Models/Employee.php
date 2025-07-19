<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'photo',
        'employee_number',
        'talent_mapping',
        'status',
        'company',
    ];

    protected $casts = [
        'talent_mapping' => 'string',
        'status' => 'string',
        'company' => 'string',
    ];

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'employee_position')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    public function primaryPositions()
    {
        return $this->positions()->wherePivot('is_primary', true);
    }

    public function actingPositions()
    {
        return $this->positions()->wherePivot('is_primary', false);
    }
}