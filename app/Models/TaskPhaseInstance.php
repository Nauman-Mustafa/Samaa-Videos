<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskPhaseInstance extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'phase_id',
        'status',
        'assigned_to',
        'started_at',
        'completed_at',
        'estimated_duration',
        'actual_duration',
        'notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function phase()
    {
        return $this->belongsTo(TaskPhase::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Accessors
    public function getIsOverdueAttribute()
    {
        return $this->estimated_duration && 
               $this->started_at && 
               $this->started_at->addMinutes($this->estimated_duration)->isPast() &&
               $this->status !== 'completed';
    }

    public function getDurationAttribute()
    {
        if ($this->completed_at && $this->started_at) {
            return $this->started_at->diffInMinutes($this->completed_at);
        }
        
        if ($this->started_at && $this->status === 'in_progress') {
            return $this->started_at->diffInMinutes(now());
        }
        
        return 0;
    }
} 