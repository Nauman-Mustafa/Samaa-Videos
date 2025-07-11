<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskPhase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'order_index',
        'department_id',
        'color',
        'is_active',
        'is_final',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_final' => 'boolean',
    ];

    // Relationships
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function phaseInstances()
    {
        return $this->hasMany(TaskPhaseInstance::class, 'phase_id');
    }

    public function timeLogs()
    {
        return $this->hasMany(TaskTimeLog::class, 'phase_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }
} 