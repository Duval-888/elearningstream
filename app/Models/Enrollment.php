<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'progress',
        'completed_at',
        'is_active'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the enrollment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course that owns the enrollment
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Check if enrollment is completed
     */
    public function isCompleted()
    {
        return !is_null($this->completed_at);
    }

    /**
     * Mark enrollment as completed
     */
    public function markAsCompleted()
    {
        $this->update([
            'progress' => 100,
            'completed_at' => now()
        ]);
    }

    /**
     * Update progress
     */
    public function updateProgress($progress)
    {
        $this->update(['progress' => min(100, max(0, $progress))]);
        
        if ($progress >= 100) {
            $this->markAsCompleted();
        }
    }
}