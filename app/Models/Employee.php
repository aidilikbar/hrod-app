<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'photo'];

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