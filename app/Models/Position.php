<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'department_id', 'parent_id'];
    protected $appends = ['employee_names'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function parent()
    {
        return $this->belongsTo(Position::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Position::class, 'parent_id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_position')
                    ->withPivot('is_primary')
                    ->withTimestamps();
    }

    public function getEmployeeNamesAttribute()
    {
        return $this->employees->pluck('name');
    }
}